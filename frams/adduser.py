from tkinter import *
from tkinter import messagebox
from PIL import Image,ImageTk
import os

class add_user:
	def __init__(self,root):
		self.root = root
		self.root.title("Adding User")
		self.root.geometry("800x600+500+100")
		self.root.resizable(0,0)
		self.prn = StringVar()
		self.name = StringVar()
		self.email = StringVar()
		self.pwd  = StringVar()

		title = Label(self.root,text="Facial Recognized Attendance System",font=("times new roman",24,"bold"),bg="#2c3e50",fg="#dcdde1",bd=2,relief=GROOVE)
		title.place(x=0,y=0,relwidth=1)

		Info_frame = Frame(self.root,background="white",width=550,height=300,relief=GROOVE)
		Info_frame.place(x=120,y=120)
		userlbl = Label(self.root,text="Add User Information",font=("times new roman",22,"bold"),bg="white",fg="black",bd=2,relief=GROOVE).place(x=0,y=60,relwidth=1)
		lblname = Label(Info_frame,text="PRN",compound=RIGHT,font=("times new roman",15,"bold"),bg="white",fg="black").grid(row=2,column=0,padx=20,pady=10)
		txtname = Entry(Info_frame,bd=2,textvariable=self.prn,relief=SUNKEN,font=("times new roman",15)).grid(row=2,column=1,padx=20)
		lblemail = Label(Info_frame,text="Name",compound=RIGHT,font=("times new roman",15,"bold"),bg="white",fg="black").grid(row=3,column=0,padx=20,pady=10)
		txtemail = Entry(Info_frame,bd=2,textvariable=self.name,relief=SUNKEN,font=("times new roman",15)).grid(row=3,column=1,padx=20)
		lblmob = Label(Info_frame,text="Email",compound=RIGHT,font=("times new roman",15,"bold"),bg="white",fg="black").grid(row=4,column=0,padx=20,pady=10)
		txtmob = Entry(Info_frame,bd=2,textvariable=self.email,relief=SUNKEN,font=("times new roman",15)).grid(row=4,column=1,padx=20)
		lbluid = Label(Info_frame,text="Password",compound=RIGHT,font=("times new roman",15,"bold"),bg="white",fg="black").grid(row=5,column=0,padx=20,pady=10)
		txtuid = Entry(Info_frame,bd=2,show="*",textvariable=self.pwd,relief=SUNKEN,font=("times new roman",15)).grid(row=5,column=1,padx=20)

		btn_log = Button(Info_frame,text="SUBMIT",width=15,command=self.addinfo,font=("times new roman",14,"bold"),bg="#2c3e50",fg="#dcdde1").grid(row=6,column=1,padx=20,pady=10)
		btn_ext = Button(Info_frame,text="EXIT",width=15,command=self.exitlogin,font=("times new roman",14,"bold"),bg="#2c3e50",fg="#dcdde1").grid(row=6,column=0,padx=20,pady=10)

		self.bg_icon = ImageTk.PhotoImage(file="Pictures/user.jpg")
		self.logo = Label(Info_frame,image=self.bg_icon,width=160,height=145,relief=SUNKEN)
		self.logo.grid(row=1,columnspan=2,padx=50,pady=20)

	def addinfo(self):
		prn = self.prn.get().strip()
		name = self.name.get().strip()
		email = self.email.get().strip()
		pwd = self.pwd.get().strip()

		if prn != "" and name != "" and email != "" and pwd != "":
			if prn.isdigit() and len(prn) == 7 and email.find("@") != -1 and email.find(".") != -1 and email.count("@")==1:
				os.system("python3 add_student.py {} {} {} {}".format(prn,name,email,pwd))
				os.system("python create_person.py {}".format(prn))
				os.system("python add_person_faces.py user{}".format(prn))
				os.system("python train.py")
				os.system("python get_status.py")
			else:
				messagebox.showerror("Error","Provide Valid Customer Details !!")
		else:
			messagebox.showerror("Error","All User Details Are Required !!")

	def exitlogin(self):
		self.root.destroy()

root = Tk()
add_user(root)
root.mainloop()
