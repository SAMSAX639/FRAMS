import mysql.connector

try:

	mydb = mysql.connector.connect(host="localhost",user="user",passwd="user123@FRAMS")
	mycursor = mydb.cursor()
	cmd = """CREATE DATABASE frams"""
	mycursor.execute(cmd)
	mydb.commit()
	cmd = """USE frams"""
	mycursor.execute(cmd)
	cmd="""CREATE TABLE admin(id int PRIMARY KEY, Username varchar(255), Password varchar(255))"""
	mycursor.execute(cmd)
	mydb.commit()
	cmd="""CREATE TABLE Students(PRN int UNIQUE KEY, Name varchar(50), Email varchar(50), Password varchar(50), id int PRIMARY KEY, PersonID varchar(50))"""
	mycursor.execute(cmd)
	mydb.commit()
	cmd="""CREATE TABLE timetable(time int UNIQUE KEY, subject varchar(50) UNIQUE KEY)"""
	mycursor.execute(cmd)
	mydb.commit()
	cmd="""INSERT INTO admin VALUES(1,'admin','admin')"""
	mycursor.execute(cmd)
	mydb.commit()


except mysql.connector.Error as error:
	print("Failed to update records to database: {}".format(error))

finally:
	if (mydb.is_connected()):
		mycursor.close()
		mydb.close()
		print("Sucessful : MySQL connection is closed")

