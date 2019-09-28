CREATE SCHEMA LIBRARY;
USE LIBRARY;

CREATE TABLE BOOK
(
  ISBN CHAR(13) NOT NULL,
  Title VARCHAR(50) NOT NULL,
  Price FLOAT NOT NULL,
  PRIMARY KEY (ISBN)
)ENGINE=INNODB;

CREATE TABLE STORAGE
(
  BookID INT NOT NULL AUTO_INCREMENT,
  ISBN VARCHAR(50) NOT NULL,
  Availability boolean NOT NULL Default 1,
  PRIMARY KEY (BookID),
  FOREIGN KEY (ISBN) REFERENCES BOOK(ISBN)
)ENGINE=INNODB;

CREATE TABLE CLASS
(
  ClassID INT NOT NULL AUTO_INCREMENT,
  Course_Title VARCHAR(50) NOT NULL,
  PRIMARY KEY (ClassID)
)ENGINE=INNODB;

CREATE TABLE TEACHER
(
  TeacherID INT NOT NULL,
  Fname VARCHAR(30) NOT NULL,
  Lname VARCHAR(30) NOT NULL,
  Gender CHAR(1) NOT NULL,
  DateOfBirth DATE NOT NULL,
  username varchar(50) default null,
  PRIMARY KEY (TeacherID)
)ENGINE=INNODB;

CREATE TABLE ADMIN
(
  AdminID INT NOT NULL,
  FName VARCHAR(30) NOT NULL,
  LName VARCHAR(30) NOT NULL,
  Gender CHAR(1) NOT NULL,
  DateOfBirth DATE NOT NULL,
  username varchar(50) default null,
  PRIMARY KEY (AdminID)
)ENGINE=INNODB;

CREATE TABLE Teaching
(
  ClassID INT NOT NULL,
  TeacherID INT NOT NULL,
  PRIMARY KEY (ClassID, TeacherID),
  FOREIGN KEY (ClassID) REFERENCES CLASS(ClassID)
	on delete cascade on update cascade,
  FOREIGN KEY (TeacherID) REFERENCES TEACHER(TeacherID)
	on delete cascade on update cascade
)ENGINE=INNODB;

CREATE TABLE TEACHER_PhoneNumber
(
  PhoneNumber VARCHAR(20) NOT NULL,
  TeacherID INT NOT NULL,
  PRIMARY KEY (PhoneNumber),
  FOREIGN KEY (TeacherID) REFERENCES TEACHER(TeacherID)
	on delete cascade on update cascade
)ENGINE=INNODB;

CREATE TABLE ADMIN_PhoneNumber
(
  PhoneNumber VARCHAR(20) NOT NULL,
  AdminID INT NOT NULL,
  PRIMARY KEY (PhoneNumber, AdminID),
  FOREIGN KEY (AdminID) REFERENCES ADMIN(AdminID)
	on delete cascade on update cascade
)ENGINE=INNODB;

CREATE TABLE TEXTBOOK
(
  ISBN CHAR(13) NOT NULL,
  ClassID INT NOT NULL,
  PRIMARY KEY (ISBN, ClassID),
  FOREIGN KEY (ISBN) REFERENCES BOOK(ISBN)
	on delete cascade on update cascade,
  FOREIGN KEY (ClassID) REFERENCES CLASS(ClassID)
	on delete cascade on update cascade
)ENGINE=INNODB;

CREATE TABLE STUDENT
(
  StudentID INT NOT NULL,
  FName VARCHAR(30) NOT NULL,
  LName VARCHAR(30) NOT NULL,
  Gender CHAR(1) NOT NULL,
  DateOfBirth DATE NOT NULL,
  AdvisorID INT NOT NULL,
  username varchar(50) default null,
  PRIMARY KEY (StudentID),
  FOREIGN KEY (AdvisorID) REFERENCES TEACHER(TeacherID)
	on delete restrict on update cascade
)ENGINE=INNODB;

CREATE TABLE PARENT
(
  Fname VARCHAR(30) NOT NULL,
  Lname VARCHAR(30) NOT NULL,
  Relationship VARCHAR(10) NOT NULL,
  StudentID INT NOT NULL,
  PRIMARY KEY (Relationship, StudentID),
  FOREIGN KEY (StudentID) REFERENCES STUDENT(StudentID)
	on delete cascade on update cascade
)ENGINE=INNODB;

CREATE TABLE BOOK_CHECKOUT
(
  CheckOutDate DATE NOT NULL,
  DueDate DATE NOT NULL,
  StudentID INT NOT NULL,
  AdminID INT NOT NULL,
  BookID INT NOT NULL,
  PRIMARY KEY (BookID),
  FOREIGN KEY (StudentID) REFERENCES STUDENT(StudentID)
	on delete restrict on update cascade,
  FOREIGN KEY (AdminID) REFERENCES ADMIN(AdminID)
	on delete restrict on update cascade,
  FOREIGN KEY (BookID) REFERENCES Storage(BookID)
	on delete cascade on update cascade
)ENGINE=INNODB;

CREATE TABLE Registration
(
  ClassID INT NOT NULL,
  StudentID INT NOT NULL,
  PRIMARY KEY (ClassID, StudentID),
  FOREIGN KEY (ClassID) REFERENCES CLASS(ClassID)
	on delete cascade on update cascade,
  FOREIGN KEY (StudentID) REFERENCES STUDENT(StudentID)
	on delete cascade on update cascade
)ENGINE=INNODB;

CREATE TABLE STUDENT_PhoneNumber
(
  PhoneNumber VARCHAR(20) NOT NULL,
  StudentID INT NOT NULL,
  PRIMARY KEY (PhoneNumber, StudentID),
  FOREIGN KEY (StudentID) REFERENCES STUDENT(StudentID)
	on delete cascade on update cascade
)ENGINE=INNODB;

CREATE TABLE PARENT_PhoneNumber
(
  PhoneNumber VARCHAR(20) NOT NULL,
  Relationship VARCHAR(10) NOT NULL,
  StudentID INT NOT NULL,
  PRIMARY KEY (PhoneNumber, Relationship, StudentID),
  FOREIGN KEY (Relationship, StudentID) REFERENCES PARENT(Relationship, StudentID)
	on delete cascade on update cascade
)ENGINE=INNODB;

CREATE TRIGGER NOT_Avail after insert on BOOK_CHECKOUT
For each row
UPDATE storage
set Availability=0 where BookID=new.BookID
ENGINE=INNODB;

CREATE TRIGGER Avail_again before delete on BOOK_CHECKOUT
for each row
UPDATE storage
set Availability=1 where BookID=old.bookID;

Delimiter //
CREATE TRIGGER Checkout_limit before insert on book_checkout
for each row
if (select count(*) from book_checkout where studentid=new.studentid)=
	(select count(*) from registration where studentid=new.studentid)
then
begin
	signal sqlstate '45000' set message_text='This student has reached checkout limit';
end;
end if; //
Delimiter ;

create view book_avail as
select * from book natural join
(select ISBN,sum(availability) as total_available
 from storage
 group by ISBN) as b_avail;
 
create view access_level as
(select username,"student" as access_level from student where username is not null)
union
(select username,"teacher" as access_level from teacher where username is not null)
union
(select username,"admin" as access_level from admin where username is not null);

create view student_complete_info as
select s.studentid,s.FName,s.LName,sp.phonenumber,p.FName parent_FName,p.LName parent_LName,p.Relationship,amount_due
from student s left join parent p on s.studentid=p.studentid
left join student_phonenumber sp on s.studentid=sp.studentid
left join (select studentid,count(*) as amount_due from book_checkout group by studentid) c on s.studentid=c.studentid;

create view checkout_info as
select bookid,title,course_title,concat(FName,' ',LName) as Instructor,studentid,checkoutdate,duedate from book_checkout natural join storage natural join book natural join textbook natural join class natural join teaching natural join teacher order by bookid;

create view teaching_info as
select c.ClassID,Course_Title,TeacherID,Title Textbook_Title,ISBN
from (teacher natural join teaching natural join class c)
	 left outer join 
	 (textbook t natural join book) 
	 on c.classid=t.classid
order by c.ClassID;

create view registration_info as
select studentid,classid,course_title,textbook_title,ISBN
from student natural join registration natural join teaching_info;