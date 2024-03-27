CREATE TABLE users (username varchar(255) PRIMARY KEY, name varchar(255), password varchar(255));
CREATE TABLE memes (id int AUTO_INCREMENT PRIMARY KEY, top_text text, bottom_text text, text_size int, url text, original_file_url text, username varchar(255), FOREIGN KEY (username) REFERENCES users(username));