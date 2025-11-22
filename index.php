<?php
session_start();

 #database connection files
include "db_conn.php";

#book helper function
include "php/func-book.php";
$books = get_all_books($conn);
# author helper function
include "php/func-author.php";
$authors = get_all_author($conn);
# category helper function
include "php/func-category.php";
$categories = get_all_categories($conn);

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Omsinternationalbookstores</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
      <link rel="stylesheet"  href="css/style.css">
</head>
<body>
  <div class="container">
  <nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">omsinternayional book </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" 
          aria-current="page" href="#">Store</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" 
          href="about.php">About-us</a>
        </li>
         <li class="nav-item">
          <a class="nav-link"
           href="contact.php">contact</a>
        </li>
         <li class="nav-item">
          <?php  if (isset($_SESSION['user_id'])){
            ?>
          <a class="nav-link" 
          href="admin.php">Admin</a>
          <?php }else{ ?>
          <a class="nav-link" 
          href="login.php">login</a>
        <?php } ?>
        </li>
      </form>
    </div>
  </div>
</nav>
<br>

<form action=" Search.php" method="get"style="max-width:30rem; width: 100%;">
  <div class="input-group my-5"> 
    <input type="text" class= "form-control" name="key" placeholder="Search Book..." aria-label = "Search Book..." aria-describedly = "basic-addon2">
    <button class="input-group-text btn btn-primary" id="basic-addon2">Search</button>
  </div>
</form>

<div class="d-flex pt-3">
  <?php if ($books == 0) { ?>

     <div class="alert alert-warning p-5 text-center" role="alert">
              There is no book ON Database
            </div>
  <?php }else{ ?>
<div class="pdf-list  d-flex flex-wrap">
  <?php foreach ($books as $book) { ?>
  <div class="card m-1">
    <img src="uploads/cover/<?=$book['cover']?>" class="card-image-top">
    <div class="card-body">
      <h5 class="card-title"><?=$book['title']?></h5>
      <p class="card-text">
        <i><b>By
        <?php foreach ($authors as $author) {
        if ($author['id']== $book['author_id']) {
           echo $author['name'];
           break;
         }
          ?>
    
       <?php  }  ?>
        
     <br>   </b></i>
        <?=$book['description']?>
      <br>  <i><b>Category:
        <?php foreach ($categories as $category) {
        if ($category['id']== $book['category_id']) {
           echo $category['name'];
           break;
         }
          ?>
    
       <?php  }  ?>
        
     <br></b></i>
   </p>
        <a href="uploads/files/<?=$book['file']?>" class="btn btn-success">Open</a>
        <a href="uploads/files/<?=$book['file']?>" class="btn btn-primary" download="<?=$book['title']?>">Download</a>
    </div>
</div>
<?php } ?>
  </div>
<?php } ?>
<div class="Category">
  <!-- list of category -->
  <div class="list-group">
    <?php if ($categories == 0) { 
     # do nothiong

      }else{ ?>
    
    <a href="" class="list-group-item list-group-item-action active">
    Category</a>
    <?php foreach ($categories as $category) { ?>
    <a href="category.php?id=<?=$category['id']?>" class="list-group-item list-group-item-action"><?=$category['name']?></a>
      <?php } } ?>
  </div>

  <!-- list of authoras-->
   <div class="list-group mt-5">
    <?php if ($authors == 0) { 
     # do nothiong

      }else{ ?>
    
    <a href="" class="list-group-item list-group-item-action active">
    Author</a>
    <?php foreach ($authors as $author) { ?>
    <a href="" class="list-group-item list-group-item-action"><?=$author['name']?></a>
      <?php } } ?>
  </div>
</div>
</div>
</div>
</body>
</html>