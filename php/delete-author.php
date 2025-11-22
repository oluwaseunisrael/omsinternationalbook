<?php
session_start();
#if the admin isd login 
if(isset($_SESSION['user_id']) &&
isset($_SESSION['user_email'])) {

  #database connection files
include "../db_conn.php";
/** check if category is set
 **/

if (isset($_GET['id'])){
  /** get the data GET request and store it in var**/
  $id = $_GET['id'];
  #simple validation
  if (empty($id)) {
    $em = "Error occured";
     header("Location: ../admin.php?error=$em");
     exit;
   }else{
    
      
      #DELETE THE category FROM Database
    $sql = "DELETE FROM authors
    WHERE id=?";
    $stmt = $conn->prepare($sql);
    $res  = $stmt->execute([$id]);
    /** IF THERE IS NO ERROR WHILE DELETING THE DATA 
     **/
    if ($res) {
      
            #successful message
      $sm = "successfully Removed!";
     header("Location: ../admin.php?success=$sm");
     exit;

   }else{
    $em = "Error occured";
     header("Location: ../admin.php?error=$em");
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