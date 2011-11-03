PHP-EasyAuth
=======================
EasyAuth uses phpass as its hashing mechanism, details can be found here:
[http://www.openwall.com/phpass/](http://www.openwall.com/phpass/)

Setup
=======================
SQL for creating the test table is under sql/testing_db.sql

Registration
=======================
All fields validate on blur events. Username and Email make ajax calls for validation and a check against the existing user database. For security, password is only validated in direct javascript on the client side. 
All fields are re-validated server-side after the POST.
