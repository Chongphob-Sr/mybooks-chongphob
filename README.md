Link >> web from AWS Colud =  http://54.179.78.130/ 

# CT519-Chongphob > mybooks-chongphob
Structure architecture
1.หลักการออกแบบ
แยกระบบออกเป็นหน้าบ้านและหลังบ้าน โดยใช้หน้าบ้านเป็น html+css+bootstrap และหลังบ้านเป็น php และฐานข้อมูลเป็น mysql ที่เป็น relation database และใช้ cloud Aws docker แบ่งเป็น frontend และ backend แยก container กัน ส่วน cloud ที่ใช้ deploy นั้นจะเป็น aws ec2

Description
Canonical, Ubuntu, 22.04 LTS, arm64 jammy image build on 2023-05-16 

สถาปัตยกรรม (Architecture) = 64-bit(Arm) 
AMI ID = ami-0666798135ce10443

Instance type = t4g.small (2 vCPU 2 GiB Memory)

topology ของระบบ
1.frontend(html+css+bootstrap+javascript) connects to backend(php) method Post and get 2.backend connects to mysql 3.each container connects to each other by docker network

การออกแบบฐานข้อมูล
ใช้ mysql สร้าง database mybook and create table list column id / ชื่อ / คำอธิบาย / รูป โดยแต่ละแบบจะมีการเก็บ data type ต่างกันไป เช่น ชื่อกับคำอธิบายจะเก็บเป็น STRING รูปจะ บันทึก path และ อัพโหลดรูปขึ้น db


------------- รายละเอียดของ แตกล่ะ WEB PAGE -------------
index.htmlhp หน้านี้จะใช้ method get ดึงข้อมูลจาก sql มาแสดงเป็น card โดยใช้ boostrap
mybooks.php หน้านี้จะใช้ method get ดึงข้อมูลจาก sql มาแสดงเป็น table โดยใช้ boostrap และมีปุ่ม add_book เพื่อไปหน้า addbook.php
|- table จะมี column action มีสองปุ่มคือ edit,del
|--edit หน้านี้จะใช้ method get ดึงข้อมูลจาก sql มาแสดง form เพื่อรับข้อมูลจาก form พอกด submit จะแก้ update table list
|--delete หน้านี้จะใช้ method get ดึงข้อมูลจาก sql มาลบพอลบเสร็จจะกลับไปหน้าเดิม
about.html จะเป็นหน้าเพจแบบใช้ html css bootstrap  อย่างเดียว
research.html จะเป็นหน้าเพจแบบใช้ html css bootstrap อย่างเดียว

การเตรียมการระบบ Cloud
เป็นการใช้ ec2 โดยใช้ aws linux ในการทำ และ install docker environment รวมถึง git เพืื่อ clone data มาเพื่อ deploy

version: '3.3' # เป็นการระบุว่าเราจะใช้ Compose file เวอร์ชั่นไหน services: # เป็นการระบุ container ที่จะต้องใช้ มี 2 container 
web and db web: build: #สั่งให้ใช้ image ที่สร้างจาก Dockerfile 
context: ./php #path ไปที่ folder php dockerfile: Dockerfile # เรียกใช้ Dockerfile container_name: mybooks-webapp # กำหนดชื่อ container ports: - "8085:80" #map port 8085 จาก ec2 ไป 80 docker volumes: 

db: #เป็นการระบุ container ที่จะต้องใช้ container 
db image: mysql:5.7 #สั่งให้ใช้ image ที่ชื่อ msql:5.7 
container_name: mariadb #ตั้งชื่อ container ว่า mybooks-db environment: 
MYSQL_ROOT_PASSWORD: #root กำหนด superuser คือ root MYSQL_DATABASE: mybooks-db # กำหนด database name MYSQL_USER: admin # กำหนด database uses คือ admin 
MYSQL_PASSWORD:  # กำหนด database password คือ sm@rt 
volumes: - ./php/mysql/init.sql:/docker-entrypoint-initdb.d/init.sql  # กำหนดให้ใช้สภาพแวดล้อมใน 

การ deploy ตัว code มาทำงาน
1.สร้างเว็บและ sql ให้เรียบร้อย พร้อมทั้ง dockerfile และ docker-compose.yaml
2.เตรียม git ให้พร้อม
3.สร้าง repositories mybooks-chongphob
4.อัพโหลด 1 ขึ้น repositories mybooks-chongphob
5.ใน Aws install docker engine 
6.ใน Aws install docker compose 
7.ใน command line git clone https://github.com/Chongphob-Sr/mybooks-chongphob.git
8.cd mybooks-chongphob
9.chmod -R 777 all file and folder
10.docker-compose up -d --build
-------------------- กรณีทำผิดพลาดให้กลับไปแก้
1.sudo docker stop $(sudo docker ps -aq)
2.sudo docker rm $(sudo docker ps -aq)
