## Aspire Assignment

Mini Aspire API for mobile applications:

### Application Details
The application allows to authenticate and get a loan of max 10,000 and a maximum tenure of 3 weeks.

The application contains total of 8 APIs.
1.  Register
2.  Login
3.  Create Loan: To get the and create repayment schedule
4.  Approve Loan : Admin can approve the loan
5.  View Loan Detail: Get the loan and re payment details of a particular loan.
6.  Loan Pay: Make a payment for a loan based on the schedule repayment date.

> A POSTMAN collection is included in the repository in the root folder for accessing all the APIs.

### Setting up the Projects

- Clone the Repository.
- Switch to Repo folder
    `cd aspire-assignment`
- Install the requred dependencies
     `composer install`
- Copy the example env file
    <br>`cp .env.example .env`
- Edit the followings in .env file
  - **APP_NAME** - Example(APP_NAME="Aspire Assignment")
  - **APP_ENV** - Example(APP_ENV=local)
  - **APP_URL** - Example(APP_URL=https://localhost:8000)
  - **DB_DATABASE** - Example(DB_DATABASE=aspire_assignment) - Create a blank database and use the same database name here.
  - **DB_USERNAME** - Example(DB_USERNAME=root)
  - **DB_PASSWORD** - Your MySQL Password
- Generate a new application key<br>
    `php artisan key:generate`
- Run database migrations<br>
     `php artisan migrate`
- Start the local development server<br>
     `php artisan serve`
- You can now access the server at http://localhost:8000
- Run the Tests<br>
     `php artisan test`
