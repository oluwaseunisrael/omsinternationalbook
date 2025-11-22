<?php
#get all books function(){
	function get_all_books($con){

   $sql = "SELECT * FROM books ORDER BY id DESC";
   $stmt =  $con->prepare($sql);
   $stmt->execute();
   if ($stmt->rowCount() > 0) {
   	$books =  $stmt->fetchALL();
   }else{
   	  $books = 0;

   }
   return $books;
}




#get  book by id function(){
    function get_book($con, $id){

   $sql = "SELECT * FROM books WHERE id=?";
   $stmt =  $con->prepare($sql);
   $stmt->execute([$id]);
   if ($stmt->rowCount() > 0) {
    $book =  $stmt->fetch();
   }else{
      $book = 0;

   }
   return $book;
}



#search all books function(){
    function search_books($con, $key){
   #creating simple saerch algorithm
        $key = "%{$key}%";
   $sql = "SELECT * FROM books WHERE title LIKE ? OR description LIKE ?";
   $stmt =  $con->prepare($sql);
   $stmt->execute([$key, $key]);
   if ($stmt->rowCount() > 0) {
    $books =  $stmt->fetchALL();
   }else{
      $books = 0;

   }
   return $books;
}


# get book by category
    function get_books_by_category($con, $id){

   $sql = "SELECT * FROM books WHERE category_id=?";
   $stmt =  $con->prepare($sql);
   $stmt->execute([$id]);
   if ($stmt->rowCount() > 0) {
    $books =  $stmt->fetchAll();
   }else{
      $books = 0;

   }
   return $books;
}


?>