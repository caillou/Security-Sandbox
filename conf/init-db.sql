CREATE TABLE `user` (
  `username` VARCHAR( 255 ) NOT NULL ,
  `pass` VARCHAR( 32 ) NOT NULL COMMENT 'md5 hash of the password',
  `group` ENUM( 'admin', 'user' ) NOT NULL
);

ALTER TABLE `user` ADD PRIMARY KEY(`username`);

INSERT INTO `user` (`username`, `pass`, `group`) VALUES 
( 'user', MD5( 'user' ), 'user'), 
( 'admin', MD5( 'admin' ), 'admin');

CREATE TABLE `tweets` (
`username` VARCHAR( 255 ) NOT NULL ,
`message` TEXT NOT NULL ,
`creation_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);