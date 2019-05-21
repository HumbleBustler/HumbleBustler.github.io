

CREATE DATABASE test;
  USE test;

  CREATE TABLE users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    credit  INT UNSIGNED,
    DATE TIMESTAMP
  );
  
  CREATE TABLE transactions (
    id1 INT(11),
    id2 INT(11),
    transfer_amount INT UNSIGNED,
    DATE TIMESTAMP
  );