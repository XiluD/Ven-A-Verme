
<h1  class="code-line"  data-line-start=0  data-line-end=1  ><a  id="Dillinger_0"></a>Ven A Verme <g-emoji  class="g-emoji"  alias="airplane"  fallback-src="https://github.githubassets.com/images/icons/emoji/unicode/2708.png">🏞️</h1>

<h2  class="code-line"  data-line-start=1  data-line-end=2  ><a  id="_The_Last_Markdown_Editor_Ever__1"></a><em>Your travel and housing application in Spain that supports the recovery "La España Vacía". </em></h2>

## About the project


## Team members

<table width="1000">
  <tr>
      <td valign="center">
	    <p>Gonzalo Alcaide</p>
	    <a href="https://github.com/10GGGGGGGGGG"  target="_blank">
		    <img src="https://avatars.githubusercontent.com/u/47125167?v=4"  width="200"/>
	    </a>
    </td>
        <td valign="center">
	    <p>Manuel Salvador</p>
	    <a href="https://github.com/ManuelSalvador3"  target="_blank">
		    <img src="https://avatars.githubusercontent.com/u/27558633?v=4"  width="200"/>
	    </a>
    </td>
    <td valign="center">
	    <p>Diego ViVi</p>
	    <a  href="https://github.com/XiluD"  target="_blank">
		    <img src="https://avatars.githubusercontent.com/u/47109009?v=4"  width="200"/>
	    </a>
    </td>
  </tr>
</table>

## Frameworks involved

 <table width="1000">
  <tr>
    <td valign="top">
	    <p>Front-end:</p>
	    <a  href="https://es.reactjs.org/"  target="_blank">
	    <img src="https://www.vectorlogo.zone/logos/reactjs/reactjs-ar21.svg" width="300"></a>
    </td>
    <td valign="top">
	    <p>Back-end:</p>
		<a  href="https://laravel.com"  target="_blank">
		<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg"  width="400">
		</a>
    </td>
</tr>
</table>
  

## Getting Started

### Prerequisites


First of all you'll need to have installed:

  

*  [NodeJS](https://nodejs.org/en/) + [Composer](https://getcomposer.org/) + [Python 3.7.9](https://www.python.org/downloads/release/python-379/)

  

* Laravel installer

```sh

composer global require "laravel/installer"

```

  

### Installation


1. Download or clone the repo from the master branch

```sh

git clone https://github.com/XiluD/Ven-A-Verme.git

```


#### Inside the proyect, open a terminal and:


2. Install Composer packages

```sh

composer install

```

3. Install NPM packages

```sh

npm install

```

4. Install Python packages

```sh

pip3 install -r pyrequirements.txt

```


#### Download SQL Database and import into PHPMyAdmin:

5. Download from the database-files branch the SQL File including the database of the application (you can also download the image with the logical desing to understand in deep the structure of the database).

6. Load the database in your system by importing the mysql file into your favourite MySQL service (PHPMyAdmin). [Importing database into PHPMyadmin](https://help.dreamhost.com/hc/en-us/articles/214395768-phpMyAdmin-How-to-import-or-restore-a-database-or-table).

  

#### Configure the environment:

7. Configure the environment in `.env (rename 'env.example' to 'env')`

```sh

DB_CONNECTION=mysql

DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=venavermedb

DB_USERNAME=root

DB_PASSWORD=

```

8. Set your own application encryption key

```sh

php artisan key:generate

```
  
### How to run it

1. Compile JavaScript files for React

```sh

npm run watch

```

2. Launch the App

```sh

php artisan serve

```

## Usage


Once you have launch the application, you will be able to use it.



This is an academic project and therefore will never be used for profit, take care of how you use it. Thank you!

## Contact us

  

Gonzalo Alcaide Agundez - [@10GGGGGGGGGG](https://github.com/10GGGGGGGGGG) - gonzalo.alcaide10@gmail.com

  

Manuel Salvador García-Galán - [@ManuelSalvador3](https://github.com/ManuelSalvador3) - manusalvadorg@gmail.com

  

Diego Vicente Vila - [@XiluD](https://github.com/XiluD) - dvicentevila@gmail.com
  

## License

Distributed under the MIT License. See <a  href="https://opensource.org/licenses/MIT"  target="_blank">`LICENSE`</a> for more information.
