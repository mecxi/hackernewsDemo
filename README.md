// HackerNews Demo Project

The clone project is written in LARAVEL PHP framework with the latest version.
An initial framework setup is required in order to run the project successfully.
- To clone the git repository - run this command where installation_path_directory shouldn't exist
	$ git clone https://github.com/mecxi/hackernewsDemo installation_path_directory

## Setup & installation

# Installing dependencies
Project dependencies are managed by composer and defined in composer.lock file located at the project's root.
An initial Composer installation is required in order to run the install command. For more details https://getcomposer.org/doc/00-intro.md
	$ composer install

# Set the entry point of the application or the APACHE DOCUMENT_ROOT
This has to be set at the web-server configuration. On LAMP stack with APACHE running virtual host something that goes like.
	 DocumentRoot directory_path/public

# Edit the APP environment file located at directory_path/.env-example
	- First make a backup of sample file .env-example and rename it to .env
	$ cp directory_path/.env-example directory_path/.env

	- Set these env variables to your local environment. Set the DB_DATABASE your database name defined locally.
		APP_NAME=
		APP_ENV=local
		APP_DEBUG=true
		APP_URL=
		DB_DATABASE=
		DB_USERNAME=
		DB_PASSWORD=

	- Generate the APP_KEY by running this command
		$ php artisan key:generate

# Grant read and write permissions to APACHE to these folders and files in your project_directory_path/
	directory_path/bootstrap directory_path/storage directory_path/.env

	On a LAMP stack Ubuntu, something that goes like this, running the command at the root directory
	$ sudo chown -R www-data:www-data bootstrap/ storage/ .env

# For the project database structure, you can either make the SQL dump files which already contain database data or run migration provided by the framework.
Make sure you have set your local database connection settings in .env file at the root of your project directory.
Running the command below will create the database structure required by the application. Make sure the command is run at the root folder
	$ php artisan migrate

# Seed or populate database data for the application via the command line.  Either this can be populated using the SQL dump files or running these commands
One thing, seeding data from the hackernews API by running the command below will take sometimes to complete but you can already view results by opening the application on the browser.
	- Seed story_type data to the table with this command.
	$ php artisan db:seed --class=StoryTypeSeeder

	- Seed or fetch data from the hackernews API by running this command
	$ php artisan update:story


# You're done! You can view news updating by reloading the frontpage.
	- Please check the demo running on my live Webserver at this address http://172.105.88.127:1307