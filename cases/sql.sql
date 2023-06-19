CREATE TABLE reports (
  id INT PRIMARY KEY AUTO_INCREMENT,
  reporter_name VARCHAR(255),
  victim_name VARCHAR(255),
  village VARCHAR(255),
  sub_county VARCHAR(255),
  district VARCHAR(255),
  gender ENUM('male', 'female', 'other'),
  age INT,
  religion VARCHAR(255),
  photo VARCHAR(255),
  phone_number VARCHAR(20),
  email VARCHAR(255),
  description TEXT NOT NULL,
  consent ENUM('yes', 'no')
);
