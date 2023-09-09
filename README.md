## Account manager

- This project is made to work in a standalone way on your machine.

This projects allow you to simulate your situation as a self-employed in Belgium (as main activity).

You can

- Record emitted Bill
- Record paid Expenses and associate to some category.
- Record forecasted expense and bill in the future 
- Get an overview of your account balance
- Get an overview of your yearly accountability (Gross income, expenses, net, social contribution and tax to pay)
- Get an overview combining the real entry and the forecast.

## Configuration

You should check the config/calculator.php file.

This include the value for the social contribution and taxes for 2023 based on official source. 
The forecast for 2024 would use the same, when the number for 2024 will be known, this will had to be updated.

The deductibility rate can be updated as well in this config file, mostly the car & house deductibility.

As a reminder, you can deduct only the % of professional usage on the car (eg. 300km made for professional purpose over 1000 km = 30% deductibility).
For the house, it's the ratio between your office area and your house (you can use the "cadastre" value for that).

## Starting the project (on your machine)

- sail up -d
- sail artisan menu

Run `sail` to see all available command.

As this is a beta version, it doesn't include a proper UI yet.

## Native 

In the future, I'd like to serve this project as a native app with a proper UI. Do you feel interested? Reach me to provide me feedback.

php artisan native:serve
