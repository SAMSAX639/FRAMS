import os

print("Updating your System.....")
os.system("sudo apt update")
print("Updated Successfully")

print("Installing MySQL client and server....")
os.system("sudo apt install mysql-server mysql-client")
print("MySQL client and server installed successfully....")

print("Installing apache2....")
os.system("sudo apt install apache2")
print("Apache2 installed successfully....")

print("Changing permission of /var/www/html....")
os.system("sudo chmod o+w /var/www/html")
print("Permission of /var/www/html changed successfully....")

print("Updating your System.....")
os.system("sudo apt update")
print("Updated Successfully")

print("Installing php....")
os.system("sudo apt-get install php php-cgi libapache2-mod-php php-common php-pear php-mbstring")
print("php installed successfully")

print("Reloading apache2 service....")
os.system("sudo systemctl reload apache2.service")
print("Apache2 service reloaded successfully....")

print("Restarting apache2 service....")
os.system("sudo systemctl restart apache2")
print("Apache2 service restarted successfully....")


