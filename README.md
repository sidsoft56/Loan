

## About 'Mini Aspire API Project'

'It is an app that allows authenticated users to go through a loan application. It doesn’t have to contain too many fields, but at least “amount
required” and “loan term.” All the loans will be assumed to have a “weekly” repayment frequency.
After the loan is approved, the user must be able to submit the weekly loan repayments. It can be a simplified repay functionality, which won’t
need to check if the dates are correct but will just set the weekly amount to be repaid.:
1) Customer create a loan:
Customer submit a loan request defining amount and term
example:
Request amount of 10.000 $ with term 3 on date 7th Feb 2022
he will generate 3 scheduled repayments:
14th Feb 2022 with amount 3.333,33 $
21st Feb 2022 with amount 3.333,33 $
28th Feb 2022 with amount 3.333,34 $
the loan and scheduled repayments will have state PENDING
2) Admin approve the loan:
Admin change the pending loans to state APPROVED
3) Customer can view loan belong to him:
Add a policy check to make sure that the customers can view them own loan only.
4) Customer add a repayments:
Customer add a repayment with amount greater or equal to the scheduled repayment
The scheduled repayment change the status to PAID
If all the scheduled repayments connected to a loan are PAID automatically also the loan become PAID




## Inital Setup 
1) Clone git repo
2) Go on root directory and run 'Composer install' on terminal
3) In .env file change the database credentails
4) Setup database 
5) Import given sql file 
6) Go on root directory and run 'PHP artisan serve' on terminal
7) To test api on postman import the 'Aspire.postman_collection.json' collection file on postman


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
