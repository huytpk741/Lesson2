CREATE DATABASE IF NOT EXISTS testing;
USE testing;

CREATE TABLE IF NOT EXISTS categories (
	id int auto_increment primary key,
    name varchar(30) NOT NULL,
    parent int,
    FOREIGN KEY (parent) REFERENCES categories(id)
)

INSERT INTO categories (`id`,`name`,`parent`) VALUES (1,'1',NULL);
INSERT INTO categories (`id`,`name`,`parent`) VALUES (2,'2',NULL);
INSERT INTO categories (`id`,`name`,`parent`) VALUES (3,'3',NULL);
INSERT INTO categories (`id`,`name`,`parent`) VALUES (4,'4',NULL);
INSERT INTO categories (`id`,`name`,`parent`) VALUES (5,'5',NULL);
INSERT INTO categories (`id`,`name`,`parent`) VALUES (6,'11',1);
INSERT INTO categories (`id`,`name`,`parent`) VALUES (7,'111',6);
INSERT INTO categories (`id`,`name`,`parent`) VALUES (8,'1111',7);
INSERT INTO categories (`id`,`name`,`parent`) VALUES (9,'31',3);
INSERT INTO categories (`id`,`name`,`parent`) VALUES (10,'12',1);
INSERT INTO categories (`id`,`name`,`parent`) VALUES (11,'51',5);
INSERT INTO categories (`id`,`name`,`parent`) VALUES (12,'52',5);
INSERT INTO categories (`id`,`name`,`parent`) VALUES (13,'521',12);
