<?php
session_start();
#if the admin isd login 
if(isset($_SESSION['user_id']) &&
isset($_SESSION['user_email'])) {
  
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Category </title>
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
          <a class="nav-link active"
           href="add-category.php">Add category</a>
        </li>
        <li class="nav-item">
          <a class="nav-link"
           href="add-author.php">Add author</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" 
          href="logout.php">logout</a>
        </li>
      </form>
    </div>
  </div>
</nav>
<form action="php/add-category.php" method="post" class="shadow p-4 rounded mt-5" style="max-width:50rem; width:90%;">
   <h1 class="text-center pb-5 display-4 fs-3">Add New Category</h1> 
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
    class="form-label">Category Name</label>
    <input type="text" 
    class="form-control"
    name="category_name" >
  </div>
  <button type="submit" 
  class="btn btn-primary">Add Category</button>
</form>
</div>
</body>
</html>
<?php }else{
  header("Location: login.php");

  exit;
}