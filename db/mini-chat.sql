

CREATE TABLE users(
  num INT NOT NULL AUTO_INCREMENT,
  user_name CHAR(20) NOT NULL,
  password CHAR(50) NOT NULL,
  PRIMARY KEY(num)
);

CREATE TABLE chat(
  num INT NOT NULL REFERENCES users(num),
  pseudo CHAR(20) NOT NULL,
  msg CHAR(200),
  timestamp INT,
  PRIMARY KEY(num,pseudo,msg,timestamp)
);
