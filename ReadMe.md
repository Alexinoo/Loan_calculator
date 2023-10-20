# Loan Calculator

- Two of the leading financial institutions have two ways of computing the loan interest for their customer, Flat Rate and on Reducing balance.

  - The rates are as follows
    - Bank A: Flat rate of 20% p.a., Reducing Balance Rate of 22% p.a.
    - Bank B: Flat rate of 18% p.a., Reducing Balance Rate of 25% p.a.
  - The loan product also attracts some other fees as follows

    - 3% Processing Fees
    - Excise Duty 20% of the processing fees
    - Legal Fees KES 10,000

  - Note the fee above are same for the two institutions

## Requirements

- Come up with an authenticated server-side processing jQuery data-table page that can print the instalments to be paid for a given period using either of the two interest computation options. The user should be able to compare the rates computed between the two institutions. The web page should capture the following information

  - Amount to borrow
  - Payment frequency i.e., Annually, Quarterly, Monthly or Every 6 Months
  - Loan period
  - Start date
  - Interest Type i.e., Reducing balance or Flat Rate

  In the page show the breakdown of all the charges and the take home amount.

- Allow the customer to either download the instalments as a pdf file or email it to the specified email address.
- Create an API that can expose the functionality to an external party
- The web application and the API should not be in the same project.
- Use any language of your choice.
- Add any other creative feature to this solution.

## Solution

- Language/ Technologies Used :
  - Backend (API)- PHP Framework (Laravel 10 )
  - Frontend - HTML/JQuery
  - PHPMailer - Library for Sending Email
  - XAMPP Web Server

## Project Installation

- Download Project From Github 'https://github.com/Alexinoo/Loan_calculator'
- Copy the project to htdocs 'C:\xampp\htdocs\'
- Start Xampp Web Server
- Start Backend application from either integrated terminal or Git bash - (folder-api)

  - Navigate to api folder first

    ```
    cd C:\xampp\htdocs\Loan_calculator\api
    ```

  - Start Laravel server

    ```
    php artisan serve
    ```

- Below info from the terminal shows that the server has been started successfully

  ```
    INFO  Server running on [http://127.0.0.1:8000].

    Press Ctrl+C to stop the server
  ```

- Open Browser (Chrome/Mozilla) and run the project

  ```
  http://localhost/loan_calculator/

  ```

## Project Guide/Steps

- Basic validations - to validate all the inputs such as Dates and Empty FIelds

- Enter

  - Loan Amount
  - Select Payment Frequency from the dropdown
  - Select Loan Tenure/Period **(In Years)**
  - Choose Start Date from the calendar
  - Select Interest Type from the dropdown

- Click **Calculate** button to generate the Loan summary and the Amortization schedule

- Use export buttons to download in CSV/Excel/CSV

- Click **New calculation** to start another calculation
