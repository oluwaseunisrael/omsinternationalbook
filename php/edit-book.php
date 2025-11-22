<?php
session_start();
#if the admin isd login 
if(isset($_SESSION['user_id']) &&
isset($_SESSION['user_email'])) {

  #database connection files
include "../db_conn.php";
#validation helper function
include "func-validation.php";
# file upload  helper function
include "func-file-upload.php";

/** check if c name is submitted
 **/

if  (isset($_POST['book_id']) &&
     isset($_POST['book_title'])      &&
     isset($_POST['book_description']) &&
     isset($_POST['book_author'])&&
     isset($_POST['book_category'])  &&
     isset($_FILES['book_cover'])   &&
     isset($_FILES['file'])  &&
     isset($_POST['current_cover']) &&
     isset($_POST['current_file'])) {
  /** get the data post request and store it in var**/
  /** get the data post request and store it in var**/
  $id         =    $_POST['book_id'];
  $title      = $_POST['book_title'];
  $description = $_POST['book_description'];
  $author      = $_POST['book_author'];
  $category      = $_POST['book_category'];
  /** get current cover & current file from  post request  and store 
   **/
  $current_cover = $_POST['current_cover'];
  $current_file = $_POST['current_file'];
  
    #simple validation
  $text = 'book title';
  $location = "../edit-book.php";
  $ms = "id = $id&error";
  is_empty($title, $text, $location, $ms , "");

  $text = 'book description';
  $location = "../edit-book.php";
  $ms = "id = $id&error";
   is_empty($description, $text, $location, $ms , "");

   $text = 'book author';
  $location = "../edit-book.php";
  $ms = "id = $id&error";

  is_empty($author, $text, $location, $ms , "");

  $text = 'book category';
  $location = "../edit-book.php";
  $ms = "id = $id&error";
  is_empty($category, $text, $location, $ms ,"");

/**
 if the admin try to update book cover
 **/
 if (!empty($_FILES['book_cover']['name'])) {
   /** if the admin try to update both 
    **/
   if (!empty($_FILES['file']['name'])) {
    #update both here
    # book cover uploading 
    $allowed_image_exs = array("jpg", "jpeg","png");
    $path = "cover";
    $book_cover = upload_file($_FILES['book_cover'], 
    $allowed_image_exs, $path);
     # book file uploading 
    $allowed_file_exs = array("pdf", "docx","pptx");
    $path = "files";
    $file = upload_file($_FILES['file'], 
    $allowed_file_exs, $path);

      /** if error occured while uploading
   **/
  if ($book_cover['status'] == "error"  || 
      $file['status'] == "error" ) {
     $em = $book_cover['data'];
     /** redirect to edit-book.php' and passsing error message &
      **/

      header("Location: ../edit-book.php?error=$em&id=$id");
      exit;
  }else{
     #currrent book_cover path
    $c_p_book_cover="../uploads/cover/$current_cover";
         #currrent file path
    $c_p_file="../uploads/files/$current_file";
    # delete from server 
    unlink($c_p_book_cover);
    unlink($c_p_file);
    /**
     getting the new filename and
     the new book cover name
     **/
     $file_URL=$file['data'];
     $book_cover_URL=$book_cover['data'];
           #update just the data
  $sql = "UPDATE books SET title=?, author_id=? ,
  description=?,
  category_id=?,
  cover=?,
  file=?
  WHERE id=? ";
  $stmt = $conn->prepare($sql);
  $res  = $stmt->execute([$title, $author, $description,$category,$book_cover_URL,$file_URL,$id]);


  /** IF THERE IS NO ERROR WHILE updating THE DATA 
     **/
    if ($res) {
            #successful message
      $sm = "The book successfully created";
     header("Location: ../edit-book.php?success=$sm&id=$id");
     exit;
    }else{
      #error message
      $em = "Unknown error occurred";
     header("Location: ../edit-book.php?error=$em&id=$id");
     exit;
    }
     
   }
     }else{
         # update just the book cover
      #book uploading

       $allowed_image_exs = array("jpeg", "jpeg","png");
    $path = "cover";
    $book_cover = upload_file($_FILES['book_cover'], 
    $allowed_image_exs, $path);
     
      /** if error occured while uploading
   **/
  if ($book_cover['status'] == "error") {
     $em = $book_cover['data'];
     /** redirect to edit-book.php' and passsing error message &
      **/

      header("Location: ../edit-book.php?error=$em&id=$id");
      exit;
  }else{
     #currrent book_cover path
    $c_p_book_cover="../uploads/cover/$current_cover";
         #currrent file path
    # delete from server 
    unlink($c_p_book_cover);
    /**
     getting the new filename and
     the new book cover name
     **/
     $book_cover_URL = $book_cover['data'];
           #update just the data
  $sql = "UPDATE books SET title=?, author_id=? ,
  description=?,
  category_id=?,
  cover=?
  WHERE id=? ";
  $stmt = $conn->prepare($sql);
  $res  = $stmt->execute([$title, $author, $description,$category,$book_cover_URL,$id]);


  /** IF THERE IS NO ERROR WHILE updating THE DATA 
     **/
    if ($res) {
            #successful message
      $sm = "The book successfully created";
     header("Location: ../edit-book.php?success=$sm&id=$id");
     exit;
    }else{
      #error message
      $em = "Unknown error occurred";
     header("Location: ../edit-book.php?error=$em&id=$id");
     exit;
    }
     
   }

   }
 }
 
 /** if the admin try to update just the file
  **/
 else if (!empty($_FILES['file']['name'])) {
   # update just the file
            # update just the book cover
      #book uploading

       $allowed_file_exs = array("docx", "pdf","pptx");
    $path = "files";
    $file = upload_file($_FILES['file'], 
    $allowed_file_exs, $path);
     
      /** if error occured while uploading
   **/
  if ($file['status'] == "error") {
     $em = $file['data'];
     /** redirect to edit-book.php' and passsing error message &
      **/

      header("Location: ../edit-book.php?error=$em&id=$id");
      exit;
  }else{
     #currrent book_cover path
    $c_p_file="../uploads/file/$current_file";
         #currrent file path
    # delete from server 
    unlink($c_p_file);
    /**
     getting the new filename and
     the new file name
     **/
     $file_URL = $file['data'];
           #update just the data
  $sql = "UPDATE books SET title=?, author_id=? ,
  description=?,
  category_id=?,
  file=?
  WHERE id=? ";
  $stmt = $conn->prepare($sql);
  $res  = $stmt->execute([$title, $author, $description,$category,$file_URL,$id]);


  /** IF THERE IS NO ERROR WHILE updating THE DATA 
     **/
    if ($res) {
            #successful message
      $sm = "The book successfully created";
     header("Location: ../edit-book.php?success=$sm&id=$id");
     exit;
    }else{
      #error message
      $em = "Unknown error occurred";
     header("Location: ../edit-book.php?error=$em&id=$id");
     exit;
    }
     
   }


 }else{
      #update just the data
  $sql = "UPDATE books SET title=?, author_id=? ,
  description=?,
  category_id=?HY
  WHERE id=? ";
  $stmt = $conn->prepare($sql);
  $res  = $stmt->execute([$title, $author, $description,$category, $id]);


  /** IF THERE IS NO ERROR WHILE updating THE DATA 
     **/
    if ($res) {
            #successful message
      $sm = "The book successfully created";
     header("Location: ../edit-book.php?success=$sm&id=$id");
     exit;
    }else{
      #error message
      $em = "Unknown error occurred";
     header("Location: ../edit-book.php?error=$em&id=$id");
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