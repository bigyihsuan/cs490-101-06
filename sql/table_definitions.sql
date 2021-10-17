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

CREATE TABLE Exam {
    exam_id INT UNIQUE NOT NULL AUTO_INCREMENT,
    exam_title VARCHAR(255) NOT NULL,
    PRIMARY KEY (exam_id)
};

CREATE TABLE ExamToQuestions {
    exam_id INT NOT NULL,
    question_id INT NOT NULL,
    question_number INT NOT NULL,
    question_max_value FLOAT NOT NULL,
    FOREIGN KEY (exam_id) REFERENCES Exam(exam_id),
    FOREIGN KEY (question_id) REFERENCES Questions(question_id),
    PRIMARY KEY (exam_id, question_id)
};

CREATE TABLE Result {
    result_id INT UNIQUE NOT NULL AUTO_INCREMENT,
    exam_id INT NOT NULL,
    student_id INT NOT NULL,
    FOREIGN KEY (exam_id) REFERENCES Exam(exam_id),
    FOREIGN KEY (student_id) REFERENCES User(user_id),
    PRIMARY KEY (result_id, exam_id, student_id)
};

CREATE TABLE ResultToQuestions {
    result_id INT NOT NULL,
    question_id INT NOT NULL,
    FOREIGN KEY (result_id) REFERENCES Result(result_id)
    FOREIGN KEY (question_id) REFERENCES Question(question_id)
}