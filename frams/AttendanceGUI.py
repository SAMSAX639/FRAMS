from tkinter import *
from tkinter import messagebox
from PIL import Image,ImageTk
import urllib.request as ur
import cv2
import numpy as np
import time
import os
import xlwt
from pymysql import *
import pandas.io.sql as sql

class attendance:
	def __init__(self,root):
		self.root = root
		self.root.title("Facial Recognized Attendance System")
		self.root.geometry("800x500+500+100")
		self.root.resizable(0,0)

		title = Label(self.root,text="Government College of Engineering, Jalgaon",font=("times new roman",24,"bold"),bg="#2c3e50",fg="#dcdde1",bd=2,relief=GROOVE)
		title.place(x=0,y=0,relwidth=1)

		Info_frame = Frame(self.root,background="white",width=550,height=300,relief=GROOVE)
		Info_frame.place(x=100,y=150)
		userlbl = Label(self.root,text="Facial Recognized Attendance System",font=("times new roman",22,"bold"),bg="white",fg="black",bd=2,relief=GROOVE).place(x=0,y=55,relwidth=1)
		currentDate = time.strftime("%d/%m/%y")
		currentTime = time.strftime("%H:%M")
		userlbl = Label(self.root,text="Date - "+currentDate+"\tTime - "+currentTime,font=("times new roman",18,"bold"),bg="white",fg="blue",bd=2,relief=GROOVE).place(x=0,y=100,relwidth=1)
		btn_log = Button(Info_frame,text="Record Attendance",width=20,command=self.attendance,font=("times new roman",14,"bold"),bg="#2c3e50",fg="#dcdde1").grid(row=6,column=0,padx=20,pady=10)
		btn_ext = Button(Info_frame,text="Generate Report",width=20,command=self.report,font=("times new roman",14,"bold"),bg="#2c3e50",fg="#dcdde1").grid(row=6,column=1,padx=20,pady=10)
		btn_ext = Button(Info_frame,text="EXIT",width=20,command=self.exitlogin,font=("times new roman",14,"bold"),bg="#2c3e50",fg="#dcdde1").grid(row=7,column=0,columnspan=2,padx=20,pady=10)
		userlbl = Label(Info_frame,text="Press Spacebar to take Picture",font=("times new roman",18,"bold"),bg="white",fg="blue",bd=2,relief=GROOVE).grid(row=8,column=0,columnspan=2)

		self.bg_icon = ImageTk.PhotoImage(file="Pictures/gcoej1.jpg")
		self.logo = Label(Info_frame,image=self.bg_icon,width=124,height=156)
		self.logo.grid(row=1,columnspan=2,padx=5,pady=5)

	def attendance(self):
		url='http://192.168.43.1:8080/shot.jpg'
		img_name = "test.png"
		while(True):
			imgResp = ur.urlopen(url)
			imgNp = np.array(bytearray(imgResp.read()),dtype=np.uint8)
			img = cv2.imdecode(imgNp,-1)
			cv2.imshow('IPWebcam',cv2.resize(img, (600,400)))
			k = cv2.waitKey(1)
			if k%256 == 32:                            # SPACE PRESSED
				cv2.imwrite(img_name, img)
				print("{} written!".format(img_name))
				break
		cv2.destroyAllWindows()
		os.system("python3 detect.py {}".format(img_name))
		os.system("python identify.py")

	def exitlogin(self):
		self.root.destroy()

	def report(self):
		con = connect(host="localhost",user="user",password="user123@FRAMS",database="frams")
		data = sql.read_sql('select * from Students',con)
		data.to_excel('report.xls')

root = Tk()
attendance(root)
root.mainloop()
