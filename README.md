#BLOGPOST PROJECT

----------------------------------------------------------
Project number 5 of OpenClassrooms "Developpeur d'application PHP / Symfony" cursus.

The objective of this project is to create a blogpost without using a framework.

## Architecture

An experiment where I was able to try my hand at the DDD Domain-Driven design.
 There are three bounded contexts: blogpost, comment, user.

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
1. Download or clone the repository git
2. Download dependencies

from /
```
composer install
````
From /public directory
```
yarn install
```

3. Change database and mail configuration

From /configs/application.ini file 
[configuration](https://github.com/sebastien-chomy/oc_blog/blob/master/configs/application.ini)
 
4. Run
```
PHP -S localhost:8080
```







