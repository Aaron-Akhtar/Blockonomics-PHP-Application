# Blockonomics PHP Application
This is a web application developed in PHP that utilizes blockonomics.co's api to automate bitcoin payments.


Please follow these instructions for your merchant setup (Setting the callback URL):
```
1. Head over to https://www.blockonomics.co/ and login to your merchant account.
2. Navigate to https://www.blockonomics.co/merchants#/page3 and set the 'Account' property to the target wallet.
3. Set the 'HTTP Callback URL' to `domain.com/bitcoin/check.php?secret=your_secret_code`, replace `DOMAIN.COM` with your domain or ip address and replace `your_secret_code` with your unique secret code.
4. Press `Save Changes` and you are set.
```

Make sure to import the `database.sql` file into your database.
https://www.blockonomics.co/views/api.html
