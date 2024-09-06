<?php require_once("../includes/header.php");  ?>

<section id = "most-recent-users">

<div class="jumbotron jumbotron-fluid text-white text-center" style="background-color: #333333;">
  <div class="container">
    <h1 class="display-6">New Users</h1>
  
  </div>
</div>



<div id="user-image-grid">



<?php foreach($request->mostRecentUsers() as $users): ?>
   

    
    <a href="/profile/<?php echo $users->username ?>">
    <img src="uploads/<?php echo $users->image?>" title="<?php echo $users->username ?>">
    </a>
   
    

<?php endforeach ?>

</div>
</section>

<?php require_once("../includes/footer.php");  ?>