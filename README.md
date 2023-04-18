# **E-Shop**

The **E-Shop** project is demo of a e-shop application that I develop in order to practice the web developement langagues and increse my knowledge.

## **Setup**

- HTML 5
- CSS 3
- JavaScript ECMAScript 2020
- PHP 8
- Symfony 6
- MariaDB Version 15.1 Distribution 10.11.2

To use the projet you have to follow this steps :

- Git clone the `dev` branch of the repository
- Set Up your `.env.local` file with the help on the informations located in the `.env` file
- Run the command `php bin/console doctrine:database:create`
- Run the command `php bin/console make:migration`
- Run the command `php bin/console doctrine:migrations:migrate` or `php bin/console doctrine:schema:update --force`
- Run the command `php bin/console doctrine:fixtures:load`
- Run the command `php -S localhost:8080 -t public`
- Open you browser and go the URL `http://localhost:8080/`

## Glimpse

https://aimerickferal.com/projects/e-shop
