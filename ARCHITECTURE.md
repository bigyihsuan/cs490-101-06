# ARCHITECTURE.md

## Front-End
Kyaw

Handles end-user input.
User input will be sanitized and hashed as needed here.

## Back-End
Yi-Hsuan

PHP scripts and Apache.
Manages data requests coming in, and data responses coming out.

## Database
Pablito

MySQL and the data it holds.

### Tables
Alpha:

* users(name VARCHAR, pass CHAR, access ENUM)
* * name = username
* * pass = SHA256 password
* * access = ADMIN or USER