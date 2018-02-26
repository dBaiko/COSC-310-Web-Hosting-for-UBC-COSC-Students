CREATE TABLE User(
	userName VARCHAR(30) NOT NULL,
	firstName VARCHAR(30) NOT NULL,
	lastName VARCHAR(30) NOT NULL,
	email VARCHAR(30) NOT NULL,
	password VARCHAR(30),
	PRIMARY KEY(userName)
);

CREATE TABLE Student(
	userName VARCHAR(30) NOT NULL,
	studentNum VARCHAR(8) NOT NULL,
	school VARCHAR(30),
	major VARCHAR(30),
	PRIMARY KEY(userName,studentNum),
	FOREIGN KEY(userName) REFERENCES User(userName)
);

CREATE TABLE Professor(
	userName VARCHAR(30) NOT NULL,
	faculty VARCHAR(30) NOT NULL,
	school VARCHAR(30),
	PRIMARY KEY(userName, faculty),
	FOREIGN KEY(userName) REFERENCES User(userName)
);

CREATE TABLE Project(
	projectId INT AUTO_INCREMENT PRIMARY KEY,
	projectTitle VARCHAR(255),
	projDesc LONGTEXT,
	demoUrl VARCHAR(255),
	date DATETIME
);

CREATE TABLE Files(
	projectId INT NOT NULL,
	fileName VARCHAR(255),
	file LONGBLOB NOT NULL,
	fileType VARCHAR(30),
	PRIMARY KEY(projectId, fileName),
	FOREIGN KEY(projectId) REFERENCES Project(projectId)
);

CREATE TABLE Published(
	userName VARCHAR(30) NOT NULL,
	studentNum VARCHAR(8) NOT NULL,
	projectId INT NOT NULL,
	responsibility VARCHAR(30),
	PRIMARY KEY(userName, studentNum, projectId),
	FOREIGN KEY(userName, studentNum) REFERENCES Student(userName, studentNum),
	FOREIGN KEY(projectId) REFERENCES Project(projectId)
);

