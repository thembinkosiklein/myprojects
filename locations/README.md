[phpFlickr](https://github.com/thembinkosiklein/myprojects)
=====================================================
by [Rodney Ncane](thembinkosi.klein@gmail.com)

This Project is done in PHP 5.4 and MySQL 5.6

Installation / Setup
====================

1.  Copy the files from the installation/project package into a folder on your
    server.  They need to be readable by your web server.
    
2.  All you need to do is to create a new database, locate db.sql file 
    inside the project folder, and then import db.sql into your new database.

3.  Configure the project by adding YOU OWN configuration settings to
    "constants.php" file inside the "inc" folder in the project folder.

    The constants.php file has the following constants variable that need to
    be assigned values/keys:

    1.  DATABASE VARIABLES:
        The project requires connection to the database, and needs these settings
        to connect for all database processes.

        DB_HOST - This is the Database server/host, where you db.sql was imported
        DB_USER - This is the Database username
        DB_PASS - The password for your database
        DB_NAME - The name of your database

    2.  FLICKR API SETTINGS:

        FLICKR_API_KEY - This is the API key given to you by flickr.com. This 
        variable is required and you can get an API Key at:
        https://www.flickr.com/services/api/keys/

    3.  FOURSQUARE API SETTINGS:

        FOURSQUARE_API_KEY - This is the API key given to you by foursquare.com. This 
        variable is required and you can get an API Key at:
        https://foursquare.com/developers/apps/
        
    2.  FOURSQUARE_API_SECRET - The "secret" is also required to 
        make unauthenticated API calls. You 
        will get one assigned alongside your api key.
        
3.  All of the API methods that have been implemented in my project can 
    be seen here for a full list and documentation: 
    Flickr - http://www.flickr.com/services/api/
    Foursquare - https://developer.foursquare.com/docs/
    

 
