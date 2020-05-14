import sys
import cognitive_face as CF
from global_variables import personGroupId
import mysql.connector
import os
import urllib3

KEY = '90d36f0b36ec4d0aa2242729fb9c82ba'
ENDPOINT = 'https://centralindia.api.cognitive.microsoft.com/face/v1.0/'
CF.Key.set(KEY)
CF.BaseUrl.set(ENDPOINT)
if len(sys.argv) is not 1:
	res = CF.person.create(personGroupId, str(sys.argv[1]))
	extractId = str(sys.argv[1])
	try:
		mydb = mysql.connector.connect(host="localhost",user="user",passwd="user123@FRAMS",database="frams")
		mycursor = mydb.cursor()
		cmd = """SELECT * FROM Students WHERE PRN = {}""".format(extractId)
		mycursor.execute(cmd)
		records = mycursor.fetchall()
		isRecordExist = 0
		for row in records:                                                          # checking wheather the Person exist or not
			isRecordExist = 1
		if isRecordExist == 1:                                                      # updating PersonID
			cmd = """UPDATE Students SET PersonID = '{}' WHERE PRN = {}""".format(res['personId'], extractId)
			mycursor.execute(cmd)
			mydb.commit()                                                            # commiting into the database
			print("PersonID Successfully Added to the Database...")

	except mysql.connector.Error as error:
		print("Failed to update records to database: {}".format(error))

	finally:
		if (mydb.is_connected()):
			mycursor.close()                                                                     # closing the connection
			mydb.close()
			print("MySQL connection is closed")
