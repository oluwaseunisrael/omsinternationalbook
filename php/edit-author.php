<?php
session_start();
#if the admin isd login 
if(isset($_SESSION['user_id']) &&
isset($_SESSION['user_email'])) {

  #database connection files
include "../db_conn.php";
/** check if authors name is submitted
 **/

if (isset($_POST['author_name']) &&
    isset($_POST['author_id']) ) {
  /** get the data post request and store it in var**/
  $name = $_POST['author_name'];
  $id = $_POST['author_id'];
  #simple validation
  if (empty($name)) {
    $em = "The author name is required";
     header("Location: ../edit-author.php?error=$em&id=$id");
     exit;
   }else{
    #update Into Database
    $sql = "UPDATE authors SET name =?
    WHERE id=?";
    $stmt = $conn->prepare($sql);
    $res  = $stmt->execute([$name, $id]);
    /** IF THERE IS NO ERROR WHILE INSERTING THE DATA 
     **/
    if ($res) {
            #successful message
      $sm = "successfully update";
     header("Location: ../edit-author.php?success=$sm&id=$id");
     exit;
    }else{
      #error message
      $em = "Unknown error occurred";
     header("Location: ../edit-author.php?error=$em&id=$id");
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