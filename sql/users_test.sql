CREATE TABLE Users_test (
    user_id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    pass VARCHAR(255) NOT NULL, 
    access ENUM('ADMIN', 'USER'),
    PRIMARY KEY (user_id)
);

-- test users
INSERT INTO Users_test (name, pass, access)
VALUES
    ('bob', '$2y$10$58u.dF0qeP2Js6/hP/bkZuA.zDAHH.og8bHD0TGguzJjQEdnMDaw6', 'USER'),
    ('doug', '$2y$10$EnO1EejAYPqYcDjRVRD7I.AZ6/wemVz5B/bzT9QWkyPu5VCSDzU0e', 'USER'),
    ('charlie', '$2y$10$s89v4ict9vY3Cq1q2WnEqOFc6Ui/SNqHMcOWVeWma9PiK5LXV6AeK', 'USER'),
    ('alice', '$2y$10$GcYoSoEPr0q618Vt/xSztu6B.EZyWkzlE3DEhMKjaE2mY6ifWgDx.', 'ADMIN'),
    ('ernie', '$2y$10$ywz.PpNarifLeq3BFaqhYuXBJiP9Htw.JFudHHxPKU54X5MTHrtLC', 'USER');
-- VALUES ('bob', 'are', 'USER'), ('doug', 'an', 'USER'), ('charlie', 'idiot', 'USER'), ('alice', 'you', 'ADMIN'), ('ernie', 'haha', 'USER');
