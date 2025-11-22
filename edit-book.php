<?php
session_start();
#if the admin isd login 
if(isset($_SESSION['user_id']) &&
isset($_SESSION['user_email'])) {
  # if BOOK id is not set
  if (!isset($_GET['id'])) {
    #redirect to admin  php page
    header("Location: admin.php");
    exit;
  }

  $id = $_GET['id'];
  #database connection files
include "db_conn.php";
#get all book helper function
include "php/func-book.php";
$book = get_book($conn,$id);
# if the id is invalid
  if ($book == 0) {
     #redirect to admin  php page
    header("Location: admin.php");
    exit;
  }

#get all category helper function
include "php/func-category.php";
$categories = get_all_categories($conn);
# author helper function
include "php/func-author.php";
$authors = get_all_author($conn);



?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Book </title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</head>
<body>
  <div class="container">
  <nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="admin.php">Admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" 
          aria-current="page" href="idex.php">Store</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" 
          href="add-book.php">Add book</a>
        </li>
         <li class="nav-item">
          <a class="nav-link"
           href="add-category.php">Add category</a>
        </li>
        <li class="nav-item">
          <a class="nav-link"
           href="add-author.php" >Add author</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" 
          href="logout.php">logout</a>
        </li>
      </form>
    </div>
  </div>
</nav>
<form action="php/edit-book.php" method="post" enctype="multipart/form-data" class="shadow p-4 rounded mt-5" style="max-width:50rem; width:90%;">
   <h1 class="text-center pb-5 display-4 fs-3">Edit Book</h1> 
   <?php if (isset($_GET['error'])) { ?>

      <div class="alert alert-danger" role="alert">
              <?=htmlspecialchars($_GET['error']); ?>
            </div>
        <?php } ?>

        <?php if (isset($_GET['success'])) { ?>

      <div class="alert alert-success" role="alert">
              <?=htmlspecialchars($_GET['success']); ?>
            </div>
        <?php } ?>
    <div class="mb-3">
    <label  
    class="form-label">Book title</label>
    <input type="text" 
    hidden
    value="<?=$book['id']?>" 
    name="book_id" >

    <input type="text" 
    class="form-control"
    value="<?=$book['title']?>" 
    name="book_title" >
  </div>
   <div class="mb-3">
    <label  
    class="form-label">Book Descriptions</label>
    <input type="text" 
    class="form-control"
  value="<?=$book['description']?>"
    name="book_description" >
  </div>
   <div class="mb-3">
    <label  
    class="form-label">Book Author</label>
     <select name="book_author" class="form-control">
      <option value="0">
        Select author
      </option>
      <?php 
     if ($authors==0) {
       #do nothing
     }else{

      foreach ($authors as $author) { 
         if ($book['author_id'] == $author['id'] ) {
        ?>
           <option  selected 
           value="<?=$author['id']?>">
           <?=$author['name']?>
      </option>
    <?php  }else{ ?>
       <option  
           value="<?=$author['id']?>">
           <?=$author['name']?>
      </option>
   <?php }}  } ?>
    </select>
    <label 
    class="form-label">Book Category</label>
    <select name="book_category" class="form-control">
      <option value="0">
        Select Category
      </option>
      <?php 
     if ($categories==0) {
       #do nothing
     }else{

     foreach ($categories as $category) { 
         if ($book['category_id'] == $category['id'] ) {
        ?>
           <option  selected 
           value="<?=$category['id']?>">
           <?=$category['name']?>
      </option>
    <?php  }else{ ?>
       <option  
           value="<?=$category['id']?>">
           <?=$category['name']?>
      </option>
   <?php }}  } ?>
    </select>
  </div>

   <div class="mb-3">
    <label  
    class="form-label">Book cover</label>
    <input type="file" 
    class="form-control"
    name="book_cover" >
    <input type="text" 
    hidden
    value="<?=$book['cover']?>" 
    name="current_cover" >
    <a href="uploads/cover/<?=$book['cover']?>" class="link-dark">Current Cover</a>
  </div>
   <div class="mb-3">
    <label  
    class="form-label">File</label>
    <input type="file" 
    class="form-control"
    name="file" >
    <input type="text" 
    hidden
    value="<?=$book['file']?>" 
    name="current_file" >
    <a href="uploads/files/<?=$book['file']?>" class="link-dark">Current File</a>
  </div>

  <button type="submit" 
  class="btn btn-primary">Update</button>
</form>
</div>
</body>
</html>
<?php }else{
  header("Location: login.php");

  exit;
}