CREATE DATABASE m152;
USE m152;
CREATE TABLE users (
	user_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
	username VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL
);

CREATE TABLE posts (
    post_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    link VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    postlike INT,
    postdislike INT,
    license VARCHAR(255),
    user_id INT
);

INSERT INTO users (username, password) VALUES ( 'test', 'test');