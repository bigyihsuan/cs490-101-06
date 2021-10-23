-- hold a user, be it student or teacher
CREATE TABLE User (
    id INT UNIQUE NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    pass VARCHAR(255) NOT NULL, 
    access ENUM('TEACHER', 'STUDENT') NOT NULL,
    PRIMARY KEY (id)
);
-- a question in an exam
CREATE TABLE Question (
    id INT UNIQUE NOT NULL AUTO_INCREMENT,
    prompt TEXT NOT NULL,
    solution TEXT NOT NULL,
    difficulty ENUM('Easy', 'Medium', 'Hard') NOT NULL,
    category ENUM('none', 'recursion', 'forloop', 'whileloop', 'conditional', 'indexing') NOT NULL,
    PRIMARY KEY (id)
);
-- a test case for a question
CREATE TABLE TestCase (
    id INT UNIQUE NOT NULL AUTO_INCREMENT,
    question INT NOT NULL,
    input VARCHAR(255),
    output VARCHAR(255),
    PRIMARY KEY (id),
    FOREIGN KEY (question) REFERENCES Question(id)
);
-- an exam
CREATE TABLE Exam (
    id INT UNIQUE NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);
-- a question in an exam
CREATE TABLE ExamQuestion (
    id INT UNIQUE NOT NULL AUTO_INCREMENT,
    exam INT NOT NULL,
    question INT NOT NULL,
    max_score INT NOT NULL, 
    FOREIGN KEY (exam) REFERENCES Exam(id),
    FOREIGN KEY (question) REFERENCES Question(id),
    PRIMARY KEY (id, exam, question)
);
-- a student's result of taking an exam
CREATE TABLE Result (
    id INT NOT NULL UNIQUE AUTO_INCREMENT,
    student INT NOT NULL,
    exam_question INT NOT NULL,
    score INT NOT NULL,
    comment TEXT,
    FOREIGN KEY (student) REFERENCES User(id),
    FOREIGN KEY (exam_question) REFERENCES ExamQuestion(id),
    PRIMARY KEY (id, student, exam_question)
);