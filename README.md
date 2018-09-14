blogdapp5
=========

A Symfony project created on November 18, 2017, 11:40 am.


Requirements
------------

* PHP 7.0 or higher
* Symfony >= 3.4 && < 4.0

Installation
------------

Execute this command to install the symfony project

```
$ composer create-project symfony/framework-standard-edition blogdapp5 "3.4.*"
```

Execute this command to clone the Github repository

````
$ git clone https://github.com/dhrider/Blog_DAP_P5
````

Execute this command to install the project's dependencies into vendor/

````
$ composer install

# now Composer will ask you for the values of any undefiened parameter
$ ...
````

Execute this command to create the database and the schema

````
# creation of the database
$ php bin/console doctrine:database:create

# after database is created
$ php bin/console doctrine:schema:update
````

Execute this command to load the fixtures

````
$ php bin/console doctrine:fixtures:load
````
