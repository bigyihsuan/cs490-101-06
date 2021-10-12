CREATE TABLE User (
    user_id INT UNIQUE NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    pass VARCHAR(255) NOT NULL, 
    access ENUM('TEACHER', 'STUDENT') NOT NULL,
    PRIMARY KEY (user_id)
);

CREATE TABLE Question (
    question_id INT UNIQUE NOT NULL AUTO_INCREMENT,
    question_text VARCHAR(255) NOT NULL,
    difficulty ENUM('EASY', 'MEDIUM', 'HARD') NOT NULL,
    PRIMARY KEY (question_id)
    -- test cases
    -- category
);

CREATE TABLE QuestionToCategory ( -- questions can have multiple categories
    question_id INT NOT NULL,
    category_id INT NOT NULL,
    FOREIGN KEY (question_id) REFERENCES Questions(question_id),
    FOREIGN KEY (category) REFERENCES Category(category_id),
    PRIMARY KEY (question_id, category_id)
);

CREATE TABLE Category (
    category_id INT UNIQUE NOT NULL AUTO_INCREMENT,
    category_type VARCHAR(255) NOT NULL,
    PRIMARY KEY (category_id)
);

CREATE TABLE QuestionToTestCase ( -- questions can have multiple test cases
    question_id INT NOT NULL,
    test_case_id INT NOT NULL,
    FOREIGN KEY (question_id) REFERENCES Questions(question_id),
    FOREIGN KEY (test_case_id) REFERENCES TestCase(test_case_id),
    PRIMARY KEY (question_id, test_case_id)
);

CREATE TABLE TestCase (
    test_case_id INT UNIQUE NOT NULL AUTO_INCREMENT,
    test_input VARCHAR(255), -- can be empty for no args
    test_output VARCHAR(255) NOT NULL, -- must have some sort of output
    PRIMARY KEY (test_case_id)
);

