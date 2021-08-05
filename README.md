## مكتبتي 
## Bookstore, enjoy reading :)

### Running the App =>

`composer install`
 
Create a database and add it to your .env file

After that execute this command

`php artisan storage:link`

Generate a key using this command

`php artisan key:generate`

Run the db migration command with the seed option

`php artisan migrate:fresh --seed`

Now run your app using the serve command

`php artisan serve`
