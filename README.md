🌟 HealthPal+ — Cloud-Based Health Symptom Tracker
<img width="2348" height="1742" alt="healthpal+_cloud_architecture" src="https://github.com/user-attachments/assets/96c91434-3b1f-44f3-8f5f-621b132dceff" />

HealthPal+ is a modern, web-based health tracking application designed to help users monitor their symptoms, calculate BMI, upload health reports, and generate downloadable PDF assessments. It’s built using PHP and MySQL and fully deployed on a scalable AWS cloud environment using best practices — including custom VPC setup, RDS (Aurora), security groups, and EC2 hosting.

🧠 What Does HealthPal+ Do?

🔐 Lets users securely register and log in using email credentials

📋 Allows logging of daily symptoms and health status

⚖️ Automatically calculates BMI based on user data (height, weight, age, gender)

🖼️ Lets users upload health-related images (like sugar test or BP reports)

📄 Generates professional PDF health reports combining symptoms, BMI, and images

📚 Allows users to view their past assessments for tracking trends

🌐 Entire application runs in the cloud (AWS)

⚙️ Technologies & AWS Services Used

🧰 Application Stack:

Frontend: HTML5, CSS3, JS

Backend: PHP 8

Database: MySQL (hosted in Amazon Aurora/RDS)

PDF: Generated via FPDF library in PHP

☁️ Cloud Infrastructure (Fully Manual Setup by You):

✅ EC2 Instance for running the web server (Apache + PHP)

✅ Custom VPC with public/private subnets for clean network segregation

✅ Security Groups to allow only port 22 (SSH) and port 80 (HTTP) for access

✅ Amazon RDS (Aurora MySQL) for hosting the application's database

✅ Elastic IP or Domain Name to access the HealthPal+ app via browser

🧱 Everything created manually, no prebuilt templates — making it easier to learn!

🪜 How to Set Up HealthPal+ for Yourself

1) Launch and Configure Your EC2 Instance

2) Create a new EC2 Ubuntu 20.04 instance

3) Allocate an Elastic IP so your app is always reachable

4) Attach it to your custom VPC and subnet with public access enabled

5)Open port 80 (HTTP) and port 22 (SSH) in your security group

Install the LAMP Stack (Linux, Apache, MySQL, PHP)

Run these commands on your EC2 after connecting via SSH:

>>sudo apt update
>>sudo apt install apache2 php libapache2-mod-php php-mysql unzip php-gd php-zip php-curl php-mbstring php-dom -y
>>sudo systemctl start apache2

Set Up the Database in Amazon RDS (Aurora):

Go to RDS → Create Aurora MySQL-Compatible Database

Use a private subnet in your VPC for security

Make sure to:

Enable public access if you want to connect directly

Allow EC2 to connect by adding the EC2's security group to the DB SG

Create a "healthpal" database

Note the endpoint, username, and password

Connect the App to Aurora DB

Clone your project into EC2:

git clone https://github.com/YOUR_USERNAME/HealthPalPlus.git

Copy files to web root:

sudo cp -r HealthPalPlus/* /var/www/html/

Update the db.php file with your RDS DB details:

$host = "your-rds-endpoint";
$username = "your-rds-username";
$password = "your-password";
$database = "healthpal";

Set Permissions for Uploads and PDFs

sudo mkdir /var/www/html/uploads
sudo chmod 755 /var/www/html/uploads

Set Up PDF Functionality

Make sure the fpdf or tcpdf folder is included in your project.

HealthPal+ will use this to generate downloadable PDF reports from form data + uploaded images.

Access Your App from Browser:

Visit:
http://your-ec2-public-ip/

You’ll see the HealthPal+ login screen. Register and test the full workflow.

🧩 How Each Feature Works (Behind the Scenes)

🔐 Login System

→ Uses PHP sessions and stores user data in the RDS database
→ Only logged-in users can upload, log symptoms, and generate PDFs

📋 Symptom Logging & BMI Calculation

→ The form asks for symptoms, age, gender, height, weight
→ It calculates BMI using a PHP formula and suggests health tips
→ Data is stored in the database, linked to the logged-in user

🖼️ Image Upload

→ Image gets uploaded to /uploads/ folder
→ Validations are done for size and file type (PNG, JPG)
→ Image path is saved in the database for use in reports

📄 PDF Generation

→ Clicking “Generate Report” triggers generate_pdf.php
→ It fetches symptom + BMI data and embedded image
→ Creates a neat, downloadable PDF file

📚 Past Assessments

→ On dashboard, previous entries from the DB are shown
→ Users can download any report again

📌 Future Integration Ideas (Optional)

✉️ Email the Reports

→ You can integrate Amazon SES or PHPMailer to send PDFs via email

📊 Show BMI Trends as Chart

→ Add Chart.js or Google Charts to visualize assessment history

🔐 Use HTTPS

→ Use an SSL certificate or Amazon ACM for secure access

🤖 CI/CD (Optional)

→ Jenkins or GitHub Actions can automate updates to EC2 from GitHub

✅ Who Should Use This?

🔰 Beginner AWS cloud developers

👨‍💻 PHP/MySQL learners

🎓 Students building academic health-related projects

🧪 Anyone who wants a cloud-hosted personal health tracker

🤝 Contribution & Credits

This project was built fully by hand using AWS EC2, custom VPC networking, RDS (Aurora), and PHP.
You’re free to fork, modify, and improve it.

Pull requests are welcome!
