<?php
session_start();
#if the admin isd login 
if(isset($_SESSION['user_id']) &&
isset($_SESSION['user_email'])) {

  #database connection files
include "../db_conn.php";
/** check if book is set
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
       $sql2 = "SELECT * FROM books
    WHERE id=?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->execute([$id]);
    $the_book = $stmt2->fetch();

   if($stmt2->rowCount() > 0 ){
      
      #DELETE THE BOOK FROM Database
    $sql = "DELETE FROM books
    WHERE id=?";
    $stmt = $conn->prepare($sql);
    $res  = $stmt->execute([$id]);
    /** IF THERE IS NO ERROR WHILE DELETING THE DATA 
     **/
    if ($res) {
      # delete the current book_cover and the file
             $cover = $the_book['cover'];
             $file = $the_book['file'];
             $c_b_c = "../uploads/cover/$cover";
             $c_f = "../uploads/files/$cover";


             unlink($c_b_c);
             unlink($c_f);
            #successful message
      $sm = "successfully Removed!";
     header("Location: ../admin.php?success=$sm");
     exit;
    }else{
      #error message
      $em = "Unknown error occurred";
     header("Location: ../admin.php?error=$em");
     exit;
    }

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