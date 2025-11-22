<?php
session_start();
if (isset($_POST['email']) &&
    isset($_POST['password'])) {
    # database connection file

	include "../db_conn.php";

	# validation helper function
    include "func-validation.php";

	/**
	  get data from post request
	  and store the,m in var
	  **/
	  $email = $_POST['email'];
	  $password = $_POST['password'];

	  #simple form validation

	  $text = "Email";
	  $location = "../login.php";
	  $ms = "error";
	  is_empty($email, $text, $location, $ms, "");


	  $text = "password";
	  $location = "../login.php";
	  $ms = "error";
	  is_empty($password, $text, $location, $ms, "");
       #search for the email
	  $sql =  "SELECT * FROM admin 
	              WHERE email=?";
	   $stmt = $conn->prepare($sql);
       $stmt->execute([$email]);

       # if the email exist 
       if ($stmt->rowCount() === 1) {
       	 $user =  $stmt->fetch();

       	 $user_id = $user['id'];
       	 $user_email = $user['email'];
       	 $user_password = $user['password'];
       	 if ($email === $user_email) {
       	  if (password_verify($password, $user_password)) {
       	  	$_SESSION['user_id'] = $user_id;
       	  	$_SESSION['user_email'] = $user_email;
       	  	header("Location: ../admin.php");

       	  }else{
       	  	    $em = "incorrect user name or password";
            	header("Location: ../login.php?error=$em");
       	  }
       	 }else{
         $em = "incorrect user name or password";
       	 header("Location: ../login.php?error=$em");
       	 }


       }else{
       	$em = "incorrect user name or password";
       	header("Location: ../login.php?error=$em");
       }

}else{
    #redirect to "./login.php"
	header("Location: ../login.php");
}

?>