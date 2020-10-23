# OC_P6

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/cfd2fb852d284554b54558d31c5d08f1)](https://app.codacy.com/manual/Sp4tz7/OC_P6?utm_source=github.com&utm_medium=referral&utm_content=Sp4tz7/OC_P6&utm_campaign=Badge_Grade_Settings)

This project is part of the 6th course of my OpenClassRooms course
-  Use the Symfony framework
-  Create associated UML files
-  Use Twig templating

## Features

-  Homepage with trick list
-  Trick page with images, videos, description and comments
-  Login/register area 
-  Administration page

You can also:
-  Add comments for each trick or reply to an existing comment
-  Become an administrator if authorized

### Requirements

In order to use this framework, the following points must be respected

-  PHP version >=7.2.5
-  PHP [Imagick](http://pecl.php.net/package/imagick/3.4.4/windows) lib installed according to your PHP version

### Installation

This _Website_ project requires [PHP](https://php.net/) 7.2.5+ and [Composer](https://getcomposer.org/) to run.

Install the whole project from Github and run Composer vendors dependencies.

#### File
```sh
git clone https://github.com/Sp4tz7/OC_P6.git
cd OC_P6
composer install
```

### Configuration

Before running this framework, you have to setup the database and the email SMTP data.
1.  Copy the .env file to a .env.local file and edit the DB, SMTP and the other requested data.
2.  Point your virtual host to the **Public** directory.
3.  Login to your admin account using username **SuperAdmin** and password **superadmin123456789** and change your personal data.

#### Install database

```
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load --append
```

[Link to the project web example](https://snowtricks.siker.ch)

**Free Software, Hell Yeah!**
