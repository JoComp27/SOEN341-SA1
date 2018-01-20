-- Ming Tao Yu 2018-01-20, adapted from open source license @ code.tutsplus.com Evert Padje

CREATE TABLE users (
user_id INT(32) NOT NULL AUTO_INCREMENT,
user_name VARCHAR(50) NOT NULL,
user_pass VARCHAR(255) NOT NULL,
user_email VARCHAR(255) NOT NULL,
user_date DATETIME NOT NULL,
user_level INT(16) NOT NULL,
user_karma_score INT(32) NOT NULL,
user_type INT(3),
user_post_count INT(16),
user_profile_description_short VARCHAR(300),
user_profile_description_long VARCHAR(2000),
UNIQUE INDEX user_name_unique (user_name),
PRIMARY KEY (user_id)
) ENGINE=INNODB;

CREATE TABLE categories (
cat_id INT(16) NOT NULL AUTO_INCREMENT,
cat_name VARCHAR(255) NOT NULL,
cat_description VARCHAR(255) NOT NULL,
UNIQUE INDEX cat_name_unique (cat_name),
PRIMARY KEY (cat_id)
) ENGINE=INNODB;

CREATE TABLE questions (
question_id INT(16) NOT NULL AUTO_INCREMENT,
question_title VARCHAR(255) NOT NULL,
question_date DATETIME NOT NULL,
question_cat INT(16) NOT NULL,
question_by INT(32) NOT NULL,
question_upvote INT(16) NOT NULL,
PRIMARY KEY (question_id)
) ENGINE=INNODB;


CREATE TABLE answers(
answers_id INT(16) NOT NULL AUTO_INCREMENT,
answers_content VARCHAR(5000),
answers_date DATETIME NOT NULL,
reply_question INT(16) NOT NULL,
reply_by INT(32) NOT NULL,
answers_upvotes INT(8),
PRIMARY KEY (answers_id)
)ENGINE=INNODB;