-- =============================================================================================
-- Query Description:
-- Add tables for storing users info, questions, replies and question categories.
-- Howtos: Run query once on either XAMPP to begin local dev or AWS mysql for global to create tables. 
-- Ming Tao Yu 2018-01-20, adapted from open source license @ code.tutsplus.com Evert Padje
-- =============================================================================================

-- Table users will not be used for spring 2, as no sign in is currently required. (TODO for sprint 3)
DROP TABLE IF EXISTS users;
CREATE TABLE users (
user_id INT(32) NOT NULL AUTO_INCREMENT,
user_name VARCHAR(50) NOT NULL,
user_pass VARCHAR(255) NOT NULL, -- NOTE: Never store raw password. Must be one way crypto hashed first.
user_email VARCHAR(255) NOT NULL,
user_date DATETIME NOT NULL,
user_level INT(16) NOT NULL,
user_karma_score INT(32) NOT NULL, -- Reddit-like point system
user_type INT(3), 
user_answers_count INT(16), -- keep track of the user's contribution
user_questions_count INT (16),
user_profile_description_short VARCHAR(300),
user_profile_description_long VARCHAR(2000),
UNIQUE INDEX user_name_unique (user_name),
PRIMARY KEY (user_id)
) ENGINE=INNODB;


DROP TABLE IF EXISTS categories;
CREATE TABLE categories ( -- What type of question this is. Optional. May be removed later
cat_id INT(16) NOT NULL AUTO_INCREMENT,
cat_name VARCHAR(255),
cat_description VARCHAR(255),
UNIQUE INDEX cat_name_unique (cat_name),
PRIMARY KEY (cat_id)
) ENGINE=INNODB;

DROP TABLE IF EXISTS questions;
CREATE TABLE questions (
question_id INT(16) NOT NULL AUTO_INCREMENT,
question_title VARCHAR(255),
question_date DATETIME,
question_cat INT(16), -- foreign key to cat_id in table categories
question_by INT(32),-- foreign key to users_id
question_upvote INT(16),
question_keyword_tag VARCHAR(500), -- we can add tags to the question later
PRIMARY KEY (question_id)
) ENGINE=INNODB;

DROP TABLE IF EXISTS answers;
CREATE TABLE answers(
answers_id INT(16) NOT NULL AUTO_INCREMENT,
answers_content VARCHAR(5000),
answers_date DATETIME,
reply_questions INT(16) NOT NULL, -- which question is this answer addressed to. foreign key to question_id in table questions
reply_by INT(32), -- foreign key to users_id in table user
answers_upvotes INT(8),
answer_state INT(1) DEFAULT 1, -- State 2= accepted, state 1 = pending, state 0= refused. Whether the answer has been refused or accepted
PRIMARY KEY (answers_id)
)ENGINE=INNODB;


-- ALTER TABLE answers ADD FOREIGN KEY(reply_questions) REFERENCES questions(question_id) ON DELETE RESTRICT ON UPDATE CASCADE;
-- ALTER TABLE answers ADD FOREIGN KEY(reply_by) REFERENCES user(user_id) ON DELETE RESTRICT ON UPDATE CASCADE;
-- ALTER TABLE questions ADD FOREIGN KEY(question_by) REFERENCES user(user_id) ON DELETE RESTRICT ON UPDATE CASCADE;

-- ALTER TABLE questions ADD FOREIGN KEY(question_cat) REFERENCES categories(cat_id) ON DELETE RESTRICT ON UPDATE CASCADE;

