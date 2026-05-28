CREATE DATABASE IF NOT EXISTS eval_php_adv1
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE eval_php_adv1;

DROP TABLE IF EXISTS student_sport;
DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS sports;
DROP TABLE IF EXISTS schools;

CREATE TABLE schools (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE sports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(100) NOT NULL,
    lastname VARCHAR(100) NOT NULL,
    school_id INT NOT NULL,
    CONSTRAINT fk_students_school
        FOREIGN KEY (school_id)
        REFERENCES schools(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE student_sport (
    student_id INT NOT NULL,
    sport_id INT NOT NULL,
    PRIMARY KEY (student_id, sport_id),
    CONSTRAINT fk_student_sport_student
        FOREIGN KEY (student_id)
        REFERENCES students(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_student_sport_sport
        FOREIGN KEY (sport_id)
        REFERENCES sports(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;
