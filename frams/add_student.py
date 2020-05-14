import cv2                                                                      # openCV
import urllib.request as ur
import numpy as np                                                              # for numpy arrays
import mysql.connector
import dlib
import os
import sys
import time

url='http://192.168.43.1:8080/shot.jpg'
img_counter = 0
detector = dlib.get_frontal_face_detector()

def insertOrUpdate(PRN, Name, Email, Pwd):
	try:                                            # this function is for database
		mydb = mysql.connector.connect(host="localhost",user="user",passwd="user123@FRAMS",database="frams")
		mycursor = mydb.cursor()                                                           # connecting to the database
		cmd = "SELECT * FROM Students WHERE PRN = {}".format(PRN)                          # selecting the row of an id into consideration
		mycursor.execute(cmd)
		records = mycursor.fetchall()
		isRecordExist = 0
		for row in records:                                                          # checking wheather the id exist or not
			isRecordExist = 1
		if isRecordExist == 1:                                                      # updating records
			cmd = """UPDATE Students SET Name = '{}', Email = '{}', Password = '{}' WHERE PRN = {}""".format(Name,Email,Pwd,PRN)
			mycursor.execute(cmd)
			mydb.commit()
			print("Record Updated Successfully...")
		else:
			cmd = """INSERT INTO Students(PRN,Name,Email,Password) VALUES({},'{}','{}','{}')""".format(PRN,Name,Email,Pwd)            # insering a new student data
			mycursor.execute(cmd)
			mydb.commit()
			print("Record For {} Added Successfully...".format(PRN))

	except mysql.connector.Error as error:
		print("Failed to update records to database: {}".format(error))

	finally:
		if (mydb.is_connected()):
			mycursor.close()                                                                     # closing the connection
			mydb.close()
			print("MySQL connection is closed")

insertOrUpdate(sys.argv[1], str(sys.argv[2]), str(sys.argv[3]), str(sys.argv[4]))              # calling the mysql database
if not os.path.exists('./dataset'):
	os.makedirs('./dataset')
folderName = "user" + str(sys.argv[1])                                                        # creating the person or user folder
folderPath = os.path.join(os.path.dirname(os.path.realpath(__file__)), "dataset/"+folderName)
if not os.path.exists(folderPath):
	os.makedirs(folderPath)

sampleNum = 0
Id = str(sys.argv[1])
while(True):
	imgResp = ur.urlopen(url)                                                       # reading the camera input
	imgNp = np.array(bytearray(imgResp.read()),dtype=np.uint8)
	img = cv2.imdecode(imgNp,-1)                               # Converting to GrayScale
	dets = detector(img, 1)
	for i, d in enumerate(dets):                                                # loop will run for each face detected
		sampleNum += 1
		cv2.imwrite(folderPath + "/User." + Id + "." + str(sampleNum) + ".jpg",img[d.top():d.bottom(), d.left():d.right()])                            # Saving the faces
		cv2.rectangle(img, (d.left(), d.top())  ,(d.right(), d.bottom()),(0,255,0) ,2) # Forming the rectangle
		cv2.waitKey(200)                                                        # waiting time of 200 milisecond
	cv2.imshow('frame',cv2.resize(img, (600,400)))                                                    # showing the video input from camera on window
	cv2.waitKey(1)
	if(sampleNum >= 20):                                                        # will take 20 faces
		break
print("Faces Added Sucessfully...")
cv2.destroyAllWindows()                                                         # Closing all the opened windows
