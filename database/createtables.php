<?php

$path=$_SERVER['DOCUMENT_ROOT'];
require_once $path."/attendanceapp/database/database.php";
function clearTable($dbo,$tabName)
{
    $c="delete from :tabname";
    $s=$dbo->conn->prepare($c);
    try{
    $s->execute([":tabname"=>$tabName]);
    }
    catch(PDOException $oo)
    {

    }
}
$dbo=new Database(); 
$c="create table student_details
(
    id int auto_increment primary key,
    roll_no varchar(20) unique,
    name varchar(50)
)";
$s=$dbo->conn->prepare($c);
try {
$s->execute();
echo("<br>student_details created");
} 
catch(PDOException $o)
{
    echo("<br>student_details not created");
}

$c="create table course_details
(
    id int auto_increment primary key,
    code varchar(20) unique,
    title varchar(50),
    credit int
)";
$s=$dbo->conn->prepare($c);
try {
$s->execute();
echo("<br>course_details created");
} 
catch(PDOException $o)
{
    echo("<br>course_details not created");
}


$c="create table faculty_details
(
    id int auto_increment primary key,
    user_name varchar(20) unique,
    name varchar(100),
    password varchar(50)
)";
$s=$dbo->conn->prepare($c);
try {
$s->execute();
echo("<br>faculty_details created");
} 
catch(PDOException $o)
{
    echo("<br>faculty_details not created");
}


$c="create table session_details
(
    id int auto_increment primary key,
    year int,
    term varchar(50),
    unique (year,term)
)";
$s=$dbo->conn->prepare($c);
try {
$s->execute();
echo("<br>session_details created");
} 
catch(PDOException $o)
{
    echo("<br>session_details not created");
}



$c="create table course_registration
(
    student_id int,
    course_id int,
    session_id int,
    primary key(student_id,course_id,session_id)
)";
$s=$dbo->conn->prepare($c);
try {
$s->execute();
echo("<br>course_registration created");
} 
catch(PDOException $o)
{
    echo("<br>course_registration not created");
}

$c="create table course_allotment
(
    faculty_id int,
    course_id int,
    session_id int,
    primary key(faculty_id,course_id,session_id)
)";
$s=$dbo->conn->prepare($c);
try {
$s->execute();
echo("<br>course_allotment created");
} 
catch(PDOException $o)
{
    echo("<br>course_allotment not created");
}

$c="create table attendance_details
(
    faculty_id int,
    course_id int,
    session_id int,
    student_id int,
    on_date date,
    status varchar(10),
    primary key(faculty_id,course_id,session_id,student_id,on_date)
)";
$s=$dbo->conn->prepare($c);
try {
$s->execute();
echo("<br>attendance_details created");
} 
catch(PDOException $o)
{
    echo("<br>attendance_details not created");
}

$c="insert into student_details
(id,roll_no,name)
values
(1,'22ai010','Chethan'),
(2,'22ai014','Harshavardhan'),
(3,'22ai022','Manu'),
(4,'22ai026','Nandish'),
(5,'22ai066','Vinayaka'),
(6,'22ai005','Chandan'),
(7,'22ai023','Prem'),
(8,'22ai099','Chinmai'),
(9,'22cs128','Viswas'),
(10,'22ai123','Sandeep')";
$s=$dbo->conn->prepare($c);
try {
    $s->execute();
    echo("<br>s_d updated");
} 
catch(PDOException $o)
{
    echo("<br>s_d duplicate entry");
}


$c="insert into faculty_details
(id,user_name,password,name)
values
(1,'vb','123','Vandana B'),
(2,'RK','123','Raviprabha K'),
(3,'MR','123','Mega Rani'),
(4,'PR','123','Prakash Rao'),
(5,'VR','123','Vinay Rao'),
(6,'CR','123','Chethana Rao'),
(7,'VJR','123','Vijay Rao'),
(8,'AB','123','Abhi'),
(9,'GA','123','Ganesh'),
(10,'SR','123','sarvesh Rao')";
$s=$dbo->conn->prepare($c);
try {
    $s->execute();
    echo("<br>f_d updated");
} 
catch(PDOException $e)
{
    echo("<br>f_d duplicate entry");
}

$c="insert into session_details
(id,year,term)
values
(1,2023,'SPRING SEMESTER'),
(2,2023,'AUTUMN SEMESTER')";
$s=$dbo->conn->prepare($c);
try {
    $s->execute();
    echo("<br>se_d updated");
} 
catch(PDOException $o)
{
    echo("<br>Se_d duplicate entry");
}

$c="insert into course_details
(id,title,code,credit)
values
(1,'Database Management Lab','DB123',2),
(2,'Artificial Intelligency Lab','AI23',3),
(3,'Operating System Lab','OS123',4),
(4,'Data Structure Lab','DS123',6),
(5,'Database Algorithm Lab','DBA123',3),
(6,'Computer Management Lab','CS123',1)";
$s=$dbo->conn->prepare($c);
try {
    $s->execute();
    echo("<br>c_d updated");
} 
catch(PDOException $o)
{
    echo("<br>c_d duplicate entry");
}

//if any record already there in the table delete them
clearTable($dbo,"course_registration");
$c="insert into course_registration
(student_id,course_id,session_id)
values
(:sid,:cid,:sessid)";
$s=$dbo->conn->prepare($c);
//iterate over all the 10 students 
//for each of them chose max 3 random courses, from 1 to 6

for($i=1;$i<=10;$i++)
{
    for($j=0;$j<3;$j++)
    {
        $cid=rand(1,6);
        //insert the selected course into course_registration table for
        //session 1 and student_id $i
        try{
            $s->execute([":sid"=>$i,":cid"=>$cid,":sessid"=>1]);
        }
        catch(PDOException $pe)
        {

        }

        //repeat for session 2
        $cid=rand(1,6);
        //insert the selected course into course_registration table for
        //session 2 and student_id $i
        try{
            $s->execute([":sid"=>$i,":cid"=>$cid,":sessid"=>2]);
        }
        catch(PDOException $pe)
        {

        }
    }
}


//if any record already there in the table delete them
clearTable($dbo,"course_allotment");
$c="insert into course_allotment
(faculty_id,course_id,session_id)
values
(:fid,:cid,:sessid)";
$s=$dbo->conn->prepare($c);
//iterate over all the 6 teachers
//for each them chose max 2 random courses, from 1 to 6

for($i=1;$i<=6;$i++)
{
    for($j=0;$j<2;$j++)
    {
        $cid=rand(1,6);
        //insert the selected course into course_allotment table for 
        //session 1 and fac_id $i
        try {
            $s->execute([":fid"=>$i,":cid"=>$cid,":sessid"=>1]);
        }
        catch(PDOException $pe)
        {

        }

        //repeat for session 2
        $cid=rand(1,6);
        //insert the selected course into course_allotment table for 
        //session 2 and fac_id $i
        try {
            $s->execute([":fid"=>$i,":cid"=>$cid,":sessid"=>2]);
        }
        catch(PDOException $pe)
        {

        }

    }
}





