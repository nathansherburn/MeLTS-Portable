<?php
// Written by Nathan Sherburn
// Created 29 October 2013
// Makes student user accounts based on IP

// Connect to mySQL
include('connections.php');

$ip = $_SERVER['REMOTE_ADDR'];
$stud_name = 'demo'.$ip[10].$ip[11].$ip[12];

mysql_select_db('main_database',$dbcon) or die("Cannot select main database!");

$exist_check = mysql_query("SELECT * FROM account WHERE username = '$stud_name'");

// If error in selecting table
if(!$exist_check) {
	$err=mysql_error();
	print $err;
	exit();
}

// If student not registered
if(mysql_affected_rows()==0){
	mysql_query("INSERT INTO account(username, nickname, password, first_name, last_name, status, email) VALUES('$stud_name', 'anonymous', '12345', 'demo', 'student', 'S', 'demo@student.com')")  or die("Account not created! Check that your username has less than 20 characters.");
	mysql_query("INSERT INTO students(username, unit1, unit2, unit3, unit4, unit5) VALUES('$stud_name', 'DEMO','','','','')")  or die("Account not created!");
	mysql_select_db('DEMO',$dbcon) or die("Cannot select demo database!");
	mysql_query("INSERT INTO student_list(username, first_name, last_name, u_scale) VALUES('$stud_name' ,'demo', 'student', '0')")  or die("Student cannot be added!");
}

// Start a new session
session_start();

//Store the variables in the session variable
$_SESSION['uname'] = $stud_name;
$_SESSION['pswd'] = '12345';
$_SESSION['unit_chosen'] = 'DEMO';
$_SESSION['lec_uname'] = 'nathan';
$_SESSION['status'] = 'S';
$_SESSION['fname'] = 'demo';
$_SESSION['LOGGEDIN'] = 1;

// Close connection to mySOL
mysql_close($dbcon);
?>