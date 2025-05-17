https://346568.mywebcommunity.org/



SQL queries:

create database WebProject;

use WebProject;

create table contact(
    Fname varchar(32),
    Email varchar(254),
    Subject text,
    Message text
);

create table quiz2_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45),
    score INT,
    submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);