# 📁 Arquivo DMS

### 📄 License & Usage Terms

This system is provided **as-is** for academic use only by the next researchers. The following terms apply:

#### ✅ Allowed:

* Use database migrations and models for integration
* Run the system locally for development
* Modify code only if necessary for integration

#### ❌ Not Allowed:

* Reusing code for other projects or purposes outside this capstone
* Sharing, reselling, or publishing the code
* Claiming ownership of the original system


# 🛠️ How to Setup Local Dev

#### 1. Install Ubuntu 22 on Microsoft Store

Search for **Ubuntu 22.04 LTS** in the Microsoft Store and install it.



#### 2. Update Packages
Open Ubuntu, enter username and password, then

```bash
sudo apt update && sudo apt upgrade -y
```



#### 3. Install Node.js

```bash
curl -fsSL https://deb.nodesource.com/setup_22.x | sudo -E bash -
sudo apt-get install nodejs -y
```



#### 4. Install PHP 8.3

```bash
/bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.3)"
```



#### 5. Close and open Ubuntu again to reflect PHP installation


#### 6. Clone the Repo

```
git clone https://github.com/dev-johnalfred/arquivo-main
```

#### 7. Go to repo folder

```bash
cd arquivo-main
```


#### 8. Install Backend and Frontend Dependencies

```bash
composer update
npm install
```



#### 9. Setup MYSQL server
```bash
sudo apt install mysql-server -y

# All yes to prompt and 1 = Medium strength password
sudo mysql_secure_installation

# When prompted to input password, just press enter
# No need password
sudo mysql -u root -p
```

```sql
CREATE DATABASE arquivo;
CREATE USER 'arquivo'@'localhost' IDENTIFIED BY 'Password123!';
GRANT ALL PRIVILEGES ON arquivo.* TO 'arquivo'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### 10. Setup Environment File

```bash
cp .env.example .env
nano .env
```

Uncomment the database credentials.


#### 11. Run Migrations, Key and Link Storage

```bash
php artisan migrate:fresh --seed
php artisan storage:link
php artisan key:generate
```



#### 12. Run the Project

```bash
# Will run the php laravel and react frontend in concurrently
npm run start
```



#### 13. Open another Ubuntu and run

```bash
code arquivo-main
```
to open VS Code
> 💡 Make sure the **WSL extension** is installed in VS Code.
