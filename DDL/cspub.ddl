CREATE TABLE User(
	userName VARCHAR(30) NOT NULL,
	firstName VARCHAR(30) NOT NULL,
	lastName VARCHAR(30) NOT NULL,
	email VARCHAR(30) NOT NULL,
	password TEXT NOT NULL,
	salt TEXT NOT NULL,
	PRIMARY KEY(userName)
);

CREATE TABLE Student(
	userName VARCHAR(30) NOT NULL,
	studentNum VARCHAR(8) NOT NULL,
	school VARCHAR(255),
	major VARCHAR(30),
	PRIMARY KEY(userName,studentNum),
	FOREIGN KEY(userName) REFERENCES User(userName)
);

CREATE TABLE Professor(
	userName VARCHAR(30) NOT NULL,
	faculty VARCHAR(30) NOT NULL,
	school VARCHAR(255),
	PRIMARY KEY(userName, faculty),
	FOREIGN KEY(userName) REFERENCES User(userName)
);

CREATE TABLE Project(
	projectId INT AUTO_INCREMENT PRIMARY KEY,
	projectTitle VARCHAR(255),
	projDesc MEDIUMTEXT,
	demoUrl VARCHAR(255),
	date DATETIME,
	projType VARCHAR(50),
	logoImage MEDIUMBLOB,
	author VARCHAR(30)
);

CREATE TABLE Files(
	projectId INT NOT NULL,
	fileName VARCHAR(255),
	file MEDIUMBLOB NOT NULL,
	fileType VARCHAR(30),
	PRIMARY KEY(projectId,fileName),
	FOREIGN KEY(projectId) REFERENCES Project(projectId)
);

CREATE TABLE Published(
	userName VARCHAR(30) NOT NULL,
	projectId INT NOT NULL,
	PRIMARY KEY(userName, projectId),
	FOREIGN KEY(userName) REFERENCES Student(userName),
	FOREIGN KEY(projectId) REFERENCES Project(projectId)
);

