# BLOGPOST PROJECT

----------------------------------------------------------
Project number 5 of OpenClassrooms "Developpeur d'application PHP / Symfony" cursus.

The objective of this project is to create a blogpost without using a framework.

## Code quality

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/dbf1585253c74ab1b78f6d051ae929de)](https://www.codacy.com/app/sebastien.chomy/oc_blog?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=sebastien-chomy/oc_blog&amp;utm_campaign=Badge_Grade)

## Architecture

An experiment where I was able to try my hand at the DDD Domain-Driven Design.

There are three bounded contexts:
- blogpost
- comment
- user

Each BC (Bounded Context) follows this way:
- **Domain** layer: contains the actual business logic and domain models.
- **Infrastructure** layer: binds the business logic implementation to infrastrucure, suchs as for specific persistence tasks or provide application services.
- **Presentation** layer: is responsible for presenting a user interface, allowing users to make use of the business logic. 

### Domain
- **Model** This directory includes Plain Old PHP Object(POPO). These objects contain only data and business logic, no persistence logic. It is about "Persistence Ignorance".
- **Repository** Includes interfaces related to one of the main principles of "Persistence Ignorence" for a DDD project implementing the design pattern "Repository".
- **ValueObject** Includes Value Object UUID ID's
### Infrastructure
- **Persitence/CQRS**
- **Repository**
- **Service**
### Presentation
- **Controller** 
- **View** 

## Installation

### 1 - Download or clone the repository git
```
git clone https://github.com/sebastien-chomy/oc_blog.git my_project
```

### 2 - Download dependencies
from **/my_project/**
```
composer install
````
Before you start using Composer, you must first install it on your system.
https://getcomposer.org/

### 4 - Download dependencies for frontend
From **/my_project/public/**
```
yarn install
```
Before you start using Yarn, you must first install it on your system.
https://yarnpkg.com/fr/docs/install

### 5 - Create database
To use **/my_project/documents/architecture/schema.sql** copy script file 
[schema.sql](https://github.com/sebastien-chomy/oc_blog/blob/master/documents/architecture/schema.sql)
and excuse it in your DBMS

### 6 - Change database configuration
From **/my_project/configs/application.ini** file 
[application.ini](https://github.com/sebastien-chomy/oc_blog/blob/master/configs/application.ini)
````
; application config
[DB]
host = 'localhost'
port = '3306'
dbname = 'blogpost'
username = 'root'
password = ''
````
### 7 - Change mail configuration
To use the contact form

From **/my_project/configs/application.ini** file 
[application.ini](https://github.com/sebastien-chomy/oc_blog/blob/master/configs/application.ini)
````
[MAILER]
mailer_transport = 'smtp'
mailer_host = 'smtp.domaine'
mailer_port = 25
mailer_user = 'john.doe@domain'
mailer_password = '******'
mailer_delivery_addresses = 'john.doe@domain'
mailer_sender_email = 'john.doe@domain'
mailer_sender_name = 'webmaster'
````

### 8 - Run
From **/my_project/**
```
PHP -S localhost:8080
```

### Backoffice
To access the backoffice from your browser, you must be logged in.
````
http://localhost:8080/login
- username: admin
- password: password
````
Then
````
http://localhost:8080/admin
````

### Change environment
You can change environment variable from **/my_project/configs/.env** file
[env.](https://github.com/sebastien-chomy/oc_blog/blob/master/configs/.env) 
```
ENV=prod
or
ENV=dev
```






