# ARCHITECTURE.md

## Front-End
Handles end-user input.

User input will be sanitized and hashed as needed here.

## Middle-End

## Back-End
Yi-Hsuan

Includes MySQL and associated PHP scripts, Apache.
Manages data requests coming in, and data responses coming out.

### Tables
Alpha:

* users(name VARCHAR, pass CHAR, access ENUM)
* * name = username
* * pass = SHA256 password
* * access = ADMIN or USER