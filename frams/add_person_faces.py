import sys
import os, time
import cognitive_face as CF
from global_variables import personGroupId
import urllib
import mysql.connector

Key = '90d36f0b36ec4d0aa2242729fb9c82ba'
CF.Key.set(Key)
ENDPOINT = 'https://centralindia.api.cognitive.microsoft.com/face/v1.0/'
CF.BaseUrl.set(ENDPOINT)

def get_person_id():
	person_id = ''
	extractId = str(sys.argv[1])[4:]
	try:
		mydb = mysql.connector.connect(host="localhost",user="user",passwd="user123@FRAMS",database="frams")
		mycursor = mydb.cursor()
		cmd = """SELECT * FROM Students WHERE PRN = {}""".format(extractId)
		mycursor.execute(cmd)
		row = mycursor.fetchone()
		person_id = row[5]

	except mysql.connector.Error as error:
		print("Failed to update records to database: {}".format(error))
	finally:
		if (mydb.is_connected()):
			mycursor.close()
			mydb.close()
			print("MySQL connection is closed")
	return person_id

if len(sys.argv) is not 1:
	currentDir = os.path.dirname(os.path.abspath(__file__))
	imageFolder = os.path.join(currentDir, "dataset/" + str(sys.argv[1]))
	person_id = get_person_id()
	for filename in os.listdir(imageFolder):
		if filename.endswith(".jpg"):
			print(filename)
			imgurl = urllib.pathname2url(os.path.join(imageFolder, filename))
			res = CF.face.detect(imgurl)
			if len(res) != 1:
				print "No face detected in image"
			else:
				res = CF.person.add_face(imgurl, personGroupId, person_id)
				print(res)
			time.sleep(6)
