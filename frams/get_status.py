import cognitive_face as CF
from global_variables import personGroupId

Key = '90d36f0b36ec4d0aa2242729fb9c82ba'
CF.Key.set(Key)
ENDPOINT = 'https://centralindia.api.cognitive.microsoft.com/face/v1.0/'
CF.BaseUrl.set(ENDPOINT)

res = CF.person_group.get_status(personGroupId)
for i in res.keys():
	print("{} : {}".format(i,res[i]))
