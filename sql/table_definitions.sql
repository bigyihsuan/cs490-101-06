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
    difficulty ENUM('Easy', 'Medium', 'Hard') NOT NULL,
    category ENUM('none', 'recursion', 'forloop', 'whileloop', 'conditional', 'indexing') NOT NULL,
    PRIMARY KEY (id)
);
-- a test case for a question
CREATE TABLE TestCase (
    id INT UNIQUE NOT NULL AUTO_INCREMENT,
    input VARCHAR(255),
    output VARCHAR(255),
    PRIMARY KEY (id)
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
    CONSTRAINT examquestion_exam_fk FOREIGN KEY (exam) REFERENCES Exam(id) ON DELETE CASCADE,
    CONSTRAINT examquestion_question_fk FOREIGN KEY (question) REFERENCES Question(id) ON DELETE CASCADE,
    PRIMARY KEY (id, exam, question)
);
-- a student's result of taking an exam
CREATE TABLE Result (
    id INT NOT NULL UNIQUE AUTO_INCREMENT,
    student INT NOT NULL,
    exam_question INT NOT NULL,
    score INT NOT NULL,
    comment TEXT,
    CONSTRAINT result_student_fk FOREIGN KEY (student) REFERENCES User(id) ON DELETE CASCADE,
    CONSTRAINT result_examquestion_fk FOREIGN KEY (exam_question) REFERENCES ExamQuestion(id) ON DELETE CASCADE,
    PRIMARY KEY (id, student, exam_question)
);

-- JOINER TABLES
CREATE TABLE QuestionTestCase (
    question INT NOT NULL,
    test_case INT NOT NULL,
    CONSTRAINT questiontestcase_question_fk FOREIGN KEY (question) REFERENCES Question(id) ON DELETE CASCADE,
    CONSTRAINT questiontestcase_testcase_fk FOREIGN KEY (test_case) REFERENCES TestCase(id) ON DELETE CASCADE,
    PRIMARY KEY (question, test_case)
);