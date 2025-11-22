<?php
session_start();
#if the admin isd login 
if(isset($_SESSION['user_id']) &&
isset($_SESSION['user_email'])) {

	#database connection files
include "../db_conn.php";
#VALIDATION HELPER FUNCTION
include "func-validation.php";
# file upload  helper function
include "func-file-upload.php";

#validation  helper function
/** if fille all input field are filled
 **/

if (isset($_POST['book_title'])      &&
   isset($_POST['book_description']) &&
   isset($_POST['book_author'])&&
   isset($_POST['book_category'])  &&
   isset($_FILES['book_cover'])   &&
    isset($_FILES['file'])) {





	/** get the data post request and store it in var**/
	$title       = $_POST['book_title'];
  $description = $_POST['book_description'];
  $author      = $_POST['book_author'];
  $category      = $_POST['book_category'];


  # making url data format
  $user_input = 'title='.$title.'&category_id='.$category.'&desc='.$description.'&author_id='.$author;
	#simple validation
  $text = 'book title';
  $location = "../add-book.php";
  $ms = "error";
	is_empty($title, $text, $location, $ms , $user_input);

  $text = 'book description';
  $location = "../add-book.php";
  $ms = "error";
   is_empty($description, $text, $location, $ms , $user_input);

   $text = 'book author';
  $location = "../add-book.php";
  $ms = "error";

  is_empty($author, $text, $location, $ms , $user_input);

  $text = 'book category';
  $location = "../add-book.php";
  $ms = "error";
  is_empty($category, $text, $location, $ms , $user_input);
  
  # book cover uploading 
  $allowed_image_exs = array("jpeg", "jpg","png");
  $path = "cover";
  $book_cover = upload_file($_FILES['book_cover'], 
    $allowed_image_exs, $path);

  /** if error occured while uploading the book cover
   **/
  if ($book_cover['status'] == "error") {
     $em = $book_cover['data'];
     /** redirect to add-book.php' and passsing error message &
      user_input**/

      header("Location: ../add-book.php?error=$em&$user_input");
      exit;
  }else{
     # file uploading 
  $allowed_file_exs = array("pdf", "docx","pptx");
  $path = "files";
  $file= upload_file($_FILES['file'], 
    $allowed_file_exs, $path);
/** 
  if error occurred while 
  uploading the file
  **/


if ($file['status'] == "error") {
     $em = $file['data'];
     /** redirect to add-book.php' and passsing error message &
      user_input**/

      header("Location: ../add-book.php?error=$em&$user_input");
      exit;
  }else{ 
    /**
     getting the new file name and book cover name
     **/

     $file_URL = $file['data'];
     $book_cover_URL = $book_cover['data'];

     #insert  the data into database
     $sql = "INSERT INTO books (title,author_id,description,category_id, cover, file) VALUES(?,?,?,?,?,?)";


        $stmt = $conn->prepare($sql);
    $res  = $stmt->execute([$title, $author, $description,$category,$book_cover_URL,
      $file_URL]);
    /** IF THERE IS NO ERROR WHILE INSERTING THE DATA 
     **/
    if ($res) {
            #successful message
      $sm = "The book successfully created";
     header("Location: ../add-book.php?success=$sm");
     exit;
    }else{
      #error message
      $em = "Unknown error occurred";
     header("Location: ../add-book.php?error=$em");
     exit;
    }
   }
  }
}else{
    header("Location: ../admin.php");
}

 }else{
  header("Location: login.php");

  exit;
}