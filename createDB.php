<?php
try {
	require 'dbConfig.php';
	$conn = new PDO("mysql:host=$servername", $username, $password);
	$sql = "CREATE DATABASE $dbname";
	$conn->exec($sql);
//    echo "<p>database created seccessfully</p>";

} catch (PDOException $e) {
	$sql . $e->getMessage();
}
$conn = null;
try {                                                                      //create table posts
	require 'dbConfig.php';
	$sql = "CREATE TABLE posts(
            id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            postId INT (11) NOT NULL,
            title VARCHAR (100) NOT NULL,
            body VARCHAR (500) NOT NULL )";
	$conn->exec($sql);
//    echo "<p>table posts created seccessfully</p>";
} catch (PDOException $e) {
	$sql . $e->getMessage();
}
$conn = null;

try {
	require 'dbConfig.php';                                                //create table comments
	$sql = "CREATE TABLE comments(                                          
            id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            postId INT (11) NOT NULL,
            name VARCHAR (500) NOT NULL,
            email VARCHAR (500) NOT NULL,
            body VARCHAR (500) NOT NULL )";
	$conn->exec($sql);
//    echo "<p>table comments seccessfully</p>";
} catch (PDOException $e) {
	$sql . $e->getMessage();
}
$conn = null;
?>