import cv2
import dlib
import os
import shutil
import sys
from datetime import datetime

#cam = cv2.VideoCapture(1)
detector = dlib.get_frontal_face_detector()
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
filename = "IMG{}_{}{}_{}{}".format(date,hr1,mm,hr2,mm)

if len(sys.argv) is not 1:
	img = cv2.imread(str(sys.argv[1]))
	if not os.path.exists('./pics'):
		os.makedirs('./pics')
	cv2.imwrite('./pics/' + filename + '.jpg', img)
	dets = detector(img, 1)
	if os.path.exists('./Cropped_faces'):
		shutil.rmtree('./Cropped_faces')
	os.makedirs('./Cropped_faces')
	print("detected = " + str(len(dets)))
	for i, d in enumerate(dets):
   		cv2.imwrite('./Cropped_faces/face' + str(i + 1) + '.jpg', img[d.top():d.bottom(), d.left():d.right()])
