<?php

# server name 
$sName = "localhost";

# user name 
$uName = "root";

# password

$pass = "";

# database name
$db_name = "bookstore_db";


/** 
 creating database connection 
 using the php data object (PDO)
 **/

 try {
     $conn = new PDO("mysql:host=$sName;dbname=$db_name",
     	             $uName, $pass);
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::
             ERRMODE_EXCEPTION);

   }catch(PDOException $e){
      echo "connection failed :". $e->getMessage();
     }





?>