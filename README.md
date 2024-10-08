## Important Note

This software is provided as a demonstration, will not be maintained and is not intended to be deployed into production. No pull requests or issues will be accepted.


## Simple Helpdesk Demo

This example project implements Laravel, basic auth, forms & validation.

Complete the following steps in order to get it working:

- After cloning the project into a local folder, rename the .env.example to .env being sure to update your MySQL database details, App Name and App URL details if required.
Keep Application's APP_ENV set to `local` to allow Seeding to occur.
- Run the command-line command: `composer install` to pull in all the dependencies. 
- An APP_KEY can be generated by running `php artisan key:generate` 
- Run `php artisan migrate --seed` to both run the migrations and populate the helpdesk software with dummy data.
- Run the command-line command: `npm install`
- Run the command-line command: `npm run build` to process the apps CSS/Js build.

- Three user profiles are included as part of the test data **user@example.com** / **user2@example.com** and **admin@example.com**. The passwords for all three users is: **password**

- There is a test-suite for Tickets, this can be run through the command-line command: `php .\vendor\bin\phpunit .\tests\Feature`

## License

This software is licensed under the [MIT license](https://opensource.org/licenses/MIT).
