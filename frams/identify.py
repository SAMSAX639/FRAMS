import cognitive_face as CF
from global_variables import personGroupId
import os, urllib
import mysql.connector
from datetime import datetime
import time

Key = '90d36f0b36ec4d0aa2242729fb9c82ba'
CF.Key.set(Key)
ENDPOINT = 'https://centralindia.api.cognitive.microsoft.com/face/v1.0/'
CF.BaseUrl.set(ENDPOINT)

now = datetime.now()
date = now.strftime("%d_%m_%y")
hr = int(now.strftime("%H"))
mm = int(now.strftime("%M"))
if(mm>30):
	hr1 = hr
	hr2 = hr + 1
	mm = 30
else:
	hr1 = hr - 1
	hr2 = hr
	mm = 30
newcol = "_{}_{}{}_{}{}".format(date,hr1,mm,hr2,mm)

currentDir = os.path.dirname(os.path.abspath(__file__))
directory = os.path.join(currentDir, 'Cropped_faces')
folder=os.listdir(directory)
folder.sort()

try:
	mydb = mysql.connector.connect(host="localhost",user="user",passwd="user123@FRAMS",database="frams")
	mycursor = mydb.cursor()
	cmd = """DESC Students"""
	mycursor.execute(cmd)
	record = mycursor.fetchall()
	colnames = [fields[0] for fields in record]
	if newcol not in colnames:
		addcol = """ALTER TABLE Students ADD COLUMN {} INT DEFAULT 0""".format(newcol)
		mycursor.execute(addcol)
		mydb.commit()
		print("Column {} Added Successfully...".format(newcol))
	else:
		print("Column {} Already Existed...".format(newcol))

	if len(folder)==0:
		print("No one Recognized")
		cmd = """UPDATE Students SET {} = 0""".format(newcol)
		mycursor.execute(cmd)
		mydb.commit()
		print("Attendance Marked Successfully...")
	else:
		for filename in folder:
			if filename.endswith(".jpg"):
				imgurl = urllib.pathname2url(os.path.join(directory, filename))
				res = CF.face.detect(imgurl)
				if len(res) != 1:
					print("No face detected.")
					continue
	
				faceIds = []
				for face in res:
					faceIds.append(face['faceId'])
	
				res = CF.face.identify(faceIds, personGroupId)
				print(filename)
				for face  in res:
					if not face['candidates']:
						print("Unknown")
					else:						
						personId = face['candidates'][0]['personId']
						cmd = """SELECT * FROM Students WHERE PersonID = '{}'""".format(personId)
						mycursor.execute(cmd)
						record = mycursor.fetchall()
						if len(record) >= 1:
							print(record[0][1] + " Recognized")
							cmd = """UPDATE Students SET {} = 1 WHERE PRN = {}""".format(newcol,record[0][0])
							mycursor.execute(cmd)
							mydb.commit()
							print("Attendance of {} Marked Successfully...".format(record[0][0]))
				time.sleep(6)
	

except mysql.connector.Error as error:
	print("Failed to update records to database: {}".format(error))

finally:
	if (mydb.is_connected()):
		mycursor.close()
		mydb.close()
		print("MySQL connection is closed")
