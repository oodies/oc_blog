# BLOGPOST PROJECT

----------------------------------------------------------
Project number 5 of OpenClassrooms "Developpeur d'application PHP / Symfony" cursus.

The objective of this project is to create a blogpost without using a framework.

## Code quality

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/dbf1585253c74ab1b78f6d051ae929de)](https://www.codacy.com/app/sebastien.chomy/oc_blog?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=sebastien-chomy/oc_blog&amp;utm_campaign=Badge_Grade)
## Demonstration

Preview example : [http://blogoc.oodie.fr](http://blogoc.oodie.fr)
## Architecture

See diagrams from **documents/architecture/** folder.

### 1 - Layered architecture

An experiment where I was able to try my hand at the DDD Domain-Driven Design.
It is important to give explanations on this package diagram of a context. First, a context consists of three layers.

There are three bounded contexts:
- blogpost
- comment
- user

Each BC (Bounded Context) follows this way:

- **Presentation layer**: This layer is responsible for presenting an HTML user interface, allowing users to use business logic. The presentation layer contains all the resources involved in creating a server-side rendered user interface for the end user.

- **Domain layer**: This layer contains information about the business domain of the context. This is the heart of the business logic. The status of the business objects is contained here. The persistence of business objects and perhaps also their condition is delegated to the infrastructure layer.

- **Infrastructure layer**: This layer acts as a support library for all other layers. It provides communication between layers, implements the persistence of business objects.

### 2 - Domain layer

This layer contains information about the business domain, consisting of three subfolders.

- **Model** The folder of business logic classes only. The suffixed classes "Aggregate" play the role of business object aggregator but are not persistent.

- **Repository** This folder contains all interface classes that define how business domain objects and data sources should communicate. Our domain layer does not need to know which data source is implemented and how it is implemented, that's the role of the infrastructure layer. The domain layer must define its interfaces.

- **ValueObject** The folder of classes only playing the role of unique identifier (UUID) between business object of the Model folder.  Indeed, we want to generate a unique link between business objects without external coordination. The interest is that we are not waiting for a unique identifier of primary key type of the database, since our UUIDs are generated on the application side.

### 3 - Presentation layer
This layer is responsible for presenting a user interface based on HTML, so it is quite natural to find controllers **Controller** and views **View**. In our case we follow the "Model-View-Controller" design pattern. The **Model** is delegated to the infrastructure layer.

### 4 - Infrastructure layer
This layer contains the mechanism for consulting and persisting data sources of our business objects in the domain layer. It is composed of four sub-folders.

- **Persitence**: We wanted to define a logic of the ignorance persistence of the data source that allows the domain layer code to remain indifferent to the technology used for persistence. On this logic, all classes in this folder will implement interfaces defined in the domain layer (Domain\Repository). We would also like to provide for a repository. The repository can be defined by its persistence mechanism in memory, file or traditionally in a database. For our code, the constructor of a persistence class waits for the chosen repository as an argument. The advantage is that we are therefore not dependent on the final choice of how the data sources are stored.

- **Repository**: In terms of persistence, we wanted to delay the choice of our deposit. Our final choice of storage mode is a relational database.
 Here we follow a design pattern called Data mapper [https://martinfowler.com/eaaCatalog/dataMapper.html](https://martinfowler.com/eaaCatalog/dataMapper.html). The business objects of the domain layer and our database have different mechanisms to structure the data. Many parts of an object, such as collections and inheritance, are not present in relational databases. The Data Mapper will transfer data between the object structure schema and the relational schema. In addition, the classes will have to implement the interfaces defined in our domain layer _BoundedContext_\Domain\Repository to respect the communication contract between these two layers.

- **Repository\TableGateway**
This folder contains all classes of objects that use a design pattern called Table Data Gateway. [https://martinfowler.com/eaaCatalog/tableDataGateway.html](https://martinfowler.com/eaaCatalog/tableDataGateway.html). This pattern acts as a bridge between a database table and a class. Each class contains all the SQL code through its methods that provides a simple way to perform operations on the table in question.
SQL operations such as _insert_ and _update_, have a generalized behavior for all tables. For this reason we use an abstract class \Lib\Db\AbstractTableGateway including such a method.

- **Service**
This folder contains all classes of service. A service is the visible part of the structure layer. It also simplifies the complexity of the structure of this layer. These service classes are essentially used by the presentation layer or another service in the same context.

## Installation

### 1 - Download or clone the repository git
```
git clone https://github.com/sebastien-chomy/oc_blog.git my_project
```

### 2 - Download dependencies
from **/my_project/**
```
composer install
```
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
