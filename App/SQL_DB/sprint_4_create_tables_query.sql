
-- ======================================================================================================================================
-- Query Description:
--       - Additions for Sprint 4 
--       - Added additional tables (notification, notification_user) to support user notification feature
--       - Added additional columns (x_deleted) to support delete answer/question feature
--       - Deleted table categories and replaced it with tags
-- Howtos: Run query once on either XAMPP to begin local dev, under database name = website_db, or AWS mysql for global to create tables. 
-- Ming Tao Yu 2018-02-22, adapted from open source license @ code.tutsplus.com Evert Padje
-- Modifications:
--              By:               Detail:                 										Date:
--				Eric Kokmanian 		Added question_subscription and user_subscription			03/19/2018	
--      Jonathan Cournoyer  Made fixes for the table row; Added question_likes,   03/22/2018
--                          question_disliked, answers_likes, answers_dislikes
--             
-- =======================================================================================================================================

DROP TABLE IF EXISTS categories;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
user_id INT(32) NOT NULL AUTO_INCREMENT,
user_name VARCHAR(50) NOT NULL,
user_pass VARCHAR(255) NOT NULL, -- NOTE: Never store raw password. Must be one way crypto hashed first.
user_email VARCHAR(255) NOT NULL,
user_date DATETIME NOT NULL,
user_birthDate DATE NOT NULL,
user_gender CHAR(1) NOT NULL,
user_level INT(16),
user_karma_score INT(32) DEFAULT 0, -- Reddit-like point system
user_type INT(3), 
user_answers_count INT(16) DEFAULT 0, -- keep track of the user's contribution
user_questions_count INT (16) DEFAULT 0,
user_followers_count INT(16),
user_profile_description_short VARCHAR(300),
user_profile_description_long VARCHAR(2000),
user_email_notification_on INT (1) DEFAULT 1, -- If 1: notifications will also be forwarded via email to user
user_deleted INT(1) DEFAULT 0, -- If 0: user is active. If 1, user has deleted his account
user_answer1 VARCHAR(255) NOT NULL,
user_answer2 VARCHAR(255) NOT NULL,
user_answer3 VARCHAR(255) NOT NULL,
UNIQUE INDEX user_name_unique (user_name),
PRIMARY KEY (user_id)
) ENGINE=INNODB;


DROP TABLE IF EXISTS loggedin;
CREATE TABLE loggedin(
user_id INT(32),
logged_in DATETIME DEFAULT CURRENT_TIMESTAMP,
logged_out DATETIME,
active INT(1)
) ENGINE=INNODB;

DROP TABLE IF EXISTS questions;
CREATE TABLE questions (
question_id INT(16) NOT NULL AUTO_INCREMENT,
question_title VARCHAR(255),
question_date DATETIME,
question_cat INT(16), -- foreign key to cat_id in table categories
question_by INT(32),-- foreign key to users_id
question_by_user VARCHAR(50), -- Minimize processing time/reducing inner join calls
question_upvotes INT(16) DEFAULT 0,
question_downvotes INT(16) DEFAULT 0,
question_description VARCHAR(1000),
question_view_count INT(16) DEFAULT 0,
question_deleted INT(1) DEFAULT 0, -- If 0: question is up. If 1, user has deleted the question
PRIMARY KEY (question_id)
) ENGINE=INNODB;

DROP TABLE IF EXISTS answers;
CREATE TABLE answers(
answers_id INT(16) NOT NULL AUTO_INCREMENT,
answers_content VARCHAR(5000),
answers_date DATETIME,
reply_questions INT(16) NOT NULL, -- which question is this answer addressed to. foreign key to question_id in table questions
reply_by INT(32), -- foreign key to users_id in table user
answers_by_user VARCHAR(50), -- Minimize processing time/reducing inner join calls
answers_upvotes INT(8) DEFAULT 0,
answers_downvotes INT(8) DEFAULT 0,
answer_state INT(1) DEFAULT 1, -- State 2= accepted, state 1 = pending, state 0= refused. Whether the answer has been refused or accepted
answer_deleted INT(1) DEFAULT 0, -- If 0: answer is up. If 1, user has deleted the answer
PRIMARY KEY (answers_id)
)ENGINE=INNODB;

DROP TABLE IF EXISTS user_subscription; -- allows users to subscribe to each other
CREATE TABLE user_subscription (
subscriber_id INT(16),
subscribee_username INT(16),
subscribee_id INT(16),
PRIMARY KEY (subscriber_id, subscribee_id) -- uncertain
) ENGINE=INNODB;

DROP TABLE IF EXISTS question_subscription; -- allows users to subscribe to questions
CREATE TABLE question_subscription (
subscriber_id INT(16),
question_id INT(16),
PRIMARY KEY (subscriber_id, question_id) -- uncertain
) ENGINE=INNODB;

DROP TABLE IF EXISTS notification;
CREATE TABLE notification (
notification_id INT(16) NOT NULL AUTO_INCREMENT, -- foreign key to table notification_user
notification_content VARCHAR(1000),
notification_date DATETIME,
notification_title VARCHAR(50), 
PRIMARY KEY (notification_id)
) ENGINE=INNODB;

DROP TABLE IF EXISTS notification_user;
CREATE TABLE notification_user (
notification_id INT(16) NOT NULL, -- foreign key to table notification_user. use scope_identity to pair this field with the correct id in table notification
user_id INT(16), -- foreign key to table users user_id
notification_status INT(1) DEFAULT 0, -- 1 == read, 0 == unread
PRIMARY KEY (notification_id, user_id)
) ENGINE=INNODB;

DROP TABLE IF EXISTS tags;
CREATE TABLE tags (
  tag_id INT(16) NOT NULL AUTO_INCREMENT, -- foreign key to table question_tags.
  tag_name VARCHAR(255) NOT NULL,
  UNIQUE INDEX tag_name_unique (tag_name),
  PRIMARY KEY (tag_id)
) ENGINE=INNODB;

DROP TABLE IF EXISTS question_tags;
CREATE TABLE question_tags (
  question_id INT(16) NOT NULL, -- foreign key from table questions
  tag_id INT(16) NOT NULL,      -- foreign key from table tag
--  FOREIGN KEY (question_id) REFERENCES questions(question_id) ON DELETE RESTRICT ON UPDATE CASCADE,
--  FOREIGN KEY (tag_id) REFERENCES tags(tag_id) ON DELETE RESTRICT ON UPDATE CASCADE,
  PRIMARY KEY (question_id, tag_id)
) ENGINE=INNODB;

DROP TABLE IF EXISTS question_userlikes;
CREATE TABLE question_userlikes (
  question_id INT(16) NOT NULL,
  user_id INT(16) NOT NULL,
  -- FOREIGN KEY (question_id) REFERENCES questions(question_id) ON DELETE RESTRICT ON UPDATE CASCADE,
  -- FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE RESTRICT ON UPDATE CASCADE,
  PRIMARY KEY (question_id, user_id)
) ENGINE=INNODB;

DROP TABLE IF EXISTS question_userdislikes;
CREATE TABLE question_userdislikes (
  question_id INT(16) NOT NULL,
  user_id INT(16) NOT NULL,
  -- FOREIGN KEY (question_id) REFERENCES questions(question_id) ON DELETE RESTRICT ON UPDATE CASCADE,
  -- FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE RESTRICT ON UPDATE CASCADE,
  PRIMARY KEY (question_id, user_id)
) ENGINE=INNODB;

DROP TABLE IF EXISTS answers_userlikes;
CREATE TABLE answers_userlikes (
  answer_id INT(16) NOT NULL,
  user_id INT(16) NOT NULL,
  -- FOREIGN KEY (question_id) REFERENCES answers(answers_id) ON DELETE RESTRICT ON UPDATE CASCADE,
  -- FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE RESTRICT ON UPDATE CASCADE,
  PRIMARY KEY (answer_id, user_id)
) ENGINE=INNODB;

DROP TABLE IF EXISTS answers_userdislikes;
CREATE TABLE answers_userdislikes (
  answer_id INT(16) NOT NULL,
  user_id INT(16) NOT NULL,
  -- FOREIGN KEY (question_id) REFERENCES answers(answers_id) ON DELETE RESTRICT ON UPDATE CASCADE,
  -- FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE RESTRICT ON UPDATE CASCADE,
  PRIMARY KEY (answer_id, user_id)
) ENGINE=INNODB;

-- ALTER TABLE answers ADD FOREIGN KEY(reply_questions) REFERENCES questions(question_id) ON DELETE RESTRICT ON UPDATE CASCADE;
-- ALTER TABLE answers ADD FOREIGN KEY(reply_by) REFERENCES user(user_id) ON DELETE RESTRICT ON UPDATE CASCADE;
-- ALTER TABLE questions ADD FOREIGN KEY(question_by) REFERENCES user(user_id) ON DELETE RESTRICT ON UPDATE CASCADE;

-- ALTER TABLE questions ADD FOREIGN KEY(question_cat) REFERENCES categories(cat_id) ON DELETE RESTRICT ON UPDATE CASCADE;

INSERT INTO `users` (user_name, user_pass, user_email, user_birthDate, user_gender, user_date) VALUES ('Administrator', md5('qwerty1'), 'Administrator@Okapi.ca', '01-01-2000', 'M', now())