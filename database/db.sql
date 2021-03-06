-- Create database

CREATE DATABASE library;
USE library;

-- Create tables
CREATE TABLE `administrator` (
  `Barcode` varchar(256) NOT NULL,
  `Firstname` varchar(256) NOT NULL,
  `Lastname` varchar(256) NOT NULL,
  PRIMARY KEY (`Barcode`)
);


CREATE TABLE `book` (
  `ISBN` varchar(256) NOT NULL,
  `Title` varchar(512) NOT NULL,
  `Type` varchar(64) NOT NULL,
  `Category` varchar(256) NOT NULL,
  `Edition` varchar(256) DEFAULT NULL,
  `Rack` varchar(64) NOT NULL,
  `Author` varchar(256) NOT NULL,
  PRIMARY KEY (`ISBN`)
);



CREATE TABLE `bookcopy` (
  `Inv` varchar(256) NOT NULL,
  `ISBN` varchar(256) NOT NULL,
  FOREIGN KEY (`ISBN`) REFERENCES `book` (`ISBN`),
  PRIMARY KEY (`Inv`)
);

CREATE TABLE `borrower` (
  `Barcode` varchar(256) NOT NULL,
  `CIN` varchar(20) NOT NULL,
  `Firstname` varchar(256) NOT NULL,
  `Lastname` varchar(256) NOT NULL,
  `Program` varchar(256) NOT NULL,
  PRIMARY KEY (`Barcode`)
);

CREATE TABLE `borrowing` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `BorrowingDate` date DEFAULT CURRENT_DATE,
  `DueDate` date DEFAULT (CURRENT_DATE + interval 2 day),
  `ReturnedDate` date DEFAULT NULL,
  `IsReturned` boolean DEFAULT false,
  `Inv` varchar(256) NOT NULL,
  `BorrowerBarcode` varchar(256) NOT NULL,
  FOREIGN KEY (`BorrowerBarcode`) REFERENCES `borrower` (`Barcode`),
  FOREIGN KEY (`Inv`) REFERENCES `bookcopy` (`Inv`),
  PRIMARY KEY (`Id`)
);

CREATE TABLE `reservation` (
  `BorrowerBarcode` varchar(156) NOT NULL,
  `ISBN` varchar(156) NOT NULL,
  `Date` date DEFAULT CURRENT_DATE,
  FOREIGN KEY (`ISBN`) REFERENCES `book` (`ISBN`),
  FOREIGN KEY (`BorrowerBarcode`) REFERENCES `borrower` (`Barcode`),
  PRIMARY KEY (`BorrowerBarcode`,`ISBN`)
);

CREATE TABLE `sanction` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `EndDate` date NOT NULL,
  `Note` varchar(1024) DEFAULT NULL,
  `BorrowerBarcode` varchar(256) NOT NULL,
  PRIMARY KEY (`Id`),
  FOREIGN KEY (`BorrowerBarcode`) REFERENCES `borrower` (`Barcode`)
);


-- Triggers

-- -- for `borrowing`
DELIMITER $$
CREATE TRIGGER `cancel_brrowing` BEFORE INSERT ON `borrowing` FOR EACH ROW BEGIN
IF (EXISTS (SELECT * FROM sanction WHERE BorrowerBarcode = NEW.BorrowerBarcode)) THEN SIGNAL SQLSTATE '45001' set message_text = "Borrower is blocked !";
END IF;
-- ----Prevent borrowing the same bookcopy at the same time----- 
IF (EXISTS (SELECT * FROM borrowing WHERE inv = NEW.inv AND IsReturned = false)) THEN SIGNAL SQLSTATE '45001' set message_text = "This book copy is already borrowed !";
END IF;
END
$$
DELIMITER ;
-- -----------
DELIMITER $$
CREATE TRIGGER `delete_reservation` AFTER INSERT ON `borrowing` FOR EACH ROW BEGIN
DELETE FROM reservation WHERE BorrowerBarcode = NEW.BorrowerBarcode;
END
$$
DELIMITER ;

-- -- for`reservation`
DELIMITER $$
CREATE TRIGGER `cancel_reservation` BEFORE INSERT ON `reservation` FOR EACH ROW BEGIN IF (EXISTS (SELECT * FROM sanction WHERE BorrowerBarcode = NEW.BorrowerBarcode AND EndDate > CURRENT_DATE)) THEN SIGNAL SQLSTATE '45001' set message_text = "You are blocked ! Please contact the administrator!"; END IF; END
$$
DELIMITER ;

-- -- for`book`
DELIMITER $$
CREATE TRIGGER `cancel_adding` BEFORE INSERT ON `book` FOR EACH ROW BEGIN IF (EXISTS (SELECT * FROM book WHERE ISBN = NEW.ISBN)) THEN SIGNAL SQLSTATE '45001' set message_text = "This book was already added!"; END IF; END
$$
DELIMITER ;

-- Views

CREATE VIEW availablebooks as SELECT *, 'Available' AS `Status` FROM book WHERE ISBN IN (SELECT ISBN FROM bookcopy WHERE Inv NOT IN (SELECT Inv FROM borrowing));

CREATE VIEW outofstockbooks as SELECT *, 'Out of stock' AS `Status` FROM book WHERE ISBN NOT IN (SELECT ISBN FROM availablebooks);

CREATE VIEW allbooks AS
SELECT * FROM outofstockbooks 
UNION 
SELECT * FROM availablebooks;

CREATE VIEW blockedborrowers as 
SELECT Barcode, CIN, Firstname, Lastname, Program, 'Blocked' as 'Status', COUNT(bg.BorrowerBarcode) AS 'Borrowings',  COUNT(s.BorrowerBarcode) AS 'Sanctions'  FROM borrowing bg RIGHT JOIN borrower b ON bg.BorrowerBarcode = b.Barcode  LEFT JOIN sanction s on s.BorrowerBarcode = b.Barcode WHERE Barcode IN (SELECT BorrowerBarcode FROM `sanction` WHERE EndDate > CURRENT_DATE)  GROUP BY (Barcode);

CREATE VIEW activeborrowers AS
SELECT Barcode, CIN, Firstname, Lastname, Program, 'Active' as 'Status', COUNT(bg.BorrowerBarcode) AS 'Borrowings',  COUNT(s.BorrowerBarcode) AS 'Sanctions'  FROM borrowing bg RIGHT JOIN borrower b ON bg.BorrowerBarcode = b.Barcode  LEFT JOIN sanction s on s.BorrowerBarcode = b.Barcode WHERE Barcode NOT IN (SELECT Barcode FROM  blockedborrowers)  GROUP BY (Barcode);

CREATE VIEW allborrowers as
SELECT * FROM blockedborrowers
UNION
SELECT * FROM activeborrowers ;

-- -- statistics
CREATE VIEW mostborrowedbooks AS SELECT ab.ISBN, Title, Type, Category, Edition, Rack, Author, Status, COUNT(b.Id) as 'Borrowings' FROM allbooks ab JOIN bookcopy bc ON ab.ISBN = bc.ISBN LEFT JOIN borrowing b ON bc.Inv = b.Inv GROUP BY (ab.ISBN) ORDER BY Borrowings DESC;

CREATE VIEW borrowingsnumber AS SELECT BorrowingDate, COUNT(*) AS 'Number' FROM borrowing GROUP BY BorrowingDate ORDER BY BorrowingDate DESC;

-- Insert test
INSERT INTO `administrator` (`Barcode`, `Firstname`, `Lastname`) VALUES
('446541749', 'Ahmadi', 'Jamal'),
('821741368', 'Asmaa', 'Mohamed');

INSERT INTO `book` (`ISBN`, `Title`, `Type`, `Category`, `Edition`, `Rack`, `Author`) VALUES
('3454313235412', 'The test book', 'test', 'test', 'first', 'swd', 'me'),
('5745455466210', 'Superfreakonomics', 'Novel', 'economics', 'fifth', 'DMU', 'Dubner'),
('6475121554783', 'Data Scientists at Work', 'Self-Help', 'data science', 'first', 'JUI', 'Sebastian'),
('7341796452811', 'Integration of the Indian States', 'Story', 'history', 'third', 'WQi', 'Menon'),
('9783161484100', "The Ultimate Hitchhiker's Guide", 'Self-Help', 'science', 'fourth', 'SMD', 'Douglas Adams');

INSERT INTO `bookcopy` (`Inv`, `ISBN`) VALUES
('542321', '3454313235412'),
('45511', '5745455466210'),
('45512', '5745455466210'),
('45513', '5745455466210'),
('45514', '5745455466210'),
('24517', '6475121554783'),
('94751', '7341796452811'),
('94752', '7341796452811'),
('94753', '7341796452811'),
('51420', '9783161484100'),
('51421', '9783161484100'),
('51422', '9783161484100'),
('51423', '9783161484100'),
('51424', '9783161484100');

INSERT INTO `borrower` (`Barcode`, `CIN`, `Firstname`, `Lastname`, `Program`) VALUES
('k14454147', 'M245182', 'salah', 'amjad', 'SVT'),
('k24454175', 'M245144', 'hamza', 'olami', 'SMI'),
('k24454928', 'M725131', 'achraf', 'khaliss', 'SMPC'),
('k34459198', 'M665197', 'hoda', 'taki', 'SVT'),
('k73454121', 'M845144', 'tibari', 'sanabil', 'SVT'),
('k84456173', 'M734111', 'sara', 'hamdoun', 'SMI'),
('k95454144', 'M654117', 'naoufel', 'kilass', 'SMPC'),
('k98554175', 'M855132', 'diaa', 'morabit', 'SMI');


INSERT INTO `reservation` (`BorrowerBarcode`, `ISBN`, `Date`) VALUES
('k14454147', '3454313235412', '2021-05-06'),
('k24454928', '7341796452811', '2021-05-05');

INSERT INTO `borrowing` (`Id`, `BorrowingDate`, `DueDate`, `ReturnedDate`, `IsReturned`, `Inv`, `BorrowerBarcode`) VALUES
(1, '2021-04-22', '2021-04-24', NULL, false, '51424', 'k34459198'),
(2, '2021-04-30', '2021-05-02', NULL, false, '45512', 'k24454175'),
(3, '2021-04-30', '2021-05-02', NULL, false, '24517', 'k98554175');

INSERT INTO `sanction` (`Id`, `EndDate`, `Note`, `BorrowerBarcode`) VALUES
(1, '2021-05-08', NULL, 'k73454121'),
(2, '2020-01-04', NULL, 'k73454121');