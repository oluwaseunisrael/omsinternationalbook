<?php
#get all categories  function
	function get_all_categories($con){

   $sql = "SELECT * FROM categories";
   $stmt =  $con->prepare($sql);
   $stmt->execute();
   if ($stmt->rowCount() > 0) {
   	$categories =  $stmt->fetchALL();
   }else{
   	  $categories = 0;

   }
   return $categories;
}

# get category by id
 function get_category($con, $id){

   $sql = "SELECT * FROM categories WHERE id=?";
   $stmt =  $con->prepare($sql);
   $stmt->execute([$id]);
   if ($stmt->rowCount() > 0) {
    $category =  $stmt->fetch();
   }else{
      $category = 0;

   }
   return $category;
}
?>
