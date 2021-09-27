CREATE TABLE Users (
    user_id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    pass CHAR(64) NOT NULL, 
    access ENUM('ADMIN', 'USER'),
    PRIMARY KEY (user_id)
);

-- test users
INSERT INTO Users (name, pass, access)
VALUES ('ernie', 'an', 'USER'), ('charlie', 'idiot', 'USER'), ('doug', 'you', 'ADMIN'), ('alice', 'haha', 'USER'), ('bob', 'are', 'USER');

-- mysql -h us-cdbr-east-04.cleardb.com -u b9960caeae98e0 -p
-- 5ee5fe3e