<?php
session_start();
#if the admin isd login 
if(isset($_SESSION['user_id']) &&
isset($_SESSION['user_email'])) {

	#database connection files
include "../db_conn.php";
/** check if category name is submitted
 **/

if (isset($_POST['category_name'])) {
	/** get the data post request and store it in var**/
	$name = $_POST['category_name'];
	#simple validation
	if (empty($name)) {
		$em = "The category name is required";
     header("Location: ../add-category.php?error=$em");
     exit;
   }else{
   	#insert Into Database
   	$sql = "INSERT INTO categories (name)
   	VALUES (?)";
   	$stmt = $conn->prepare($sql);
   	$res  = $stmt->execute([$name]);
   	/** IF THERE IS NO ERROR WHILE INSERTING THE DATA 
   	 **/
   	if ($res) {
   	        #successful message
   		$sm = "successfully created";
     header("Location: ../add-category.php?success=$sm");
     exit;
   	}else{
   		#error message
   		$em = "Unknown error occurred";
     header("Location: ../add-category.php?error=$em");
     exit;
   	}
   }
	
}else{
    header("Location: ../admin.php");
}

 }else{
  header("Location: login.php");

  exit;
}