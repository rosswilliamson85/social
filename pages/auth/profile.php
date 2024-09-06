<?php require_once("../includes/header.php");  ?>


<div id="profile-grid">


<section id="profile-left">
<?php if($session->has('username')): ?>
<?php if($request->userUsername() == $session->get('username')): ?>

<textarea id="content" placeholder="whats up?"></textarea>
<input type="hidden" id="username" value="<?php echo $request->userUsername(); ?>">
<input type="hidden" id="form_token" value="<?php echo $session->get('token');  ?>">
<button id="post-btn">Post</button>

<style>
section#profile-left{
    background-color:#fff;
    border:2px solid #000;
   
}
</style>



<?php endif; ?>
<?php endif; ?>


<div class="post_data" id="post_content">

<?php 
$posts->getPosts($request->userUsername());

?>

</div>
</section>








<section id="profile-right">

<div id="image">
<label for = "upload_file">
<img id="" class="img-thumbnail w-50" title="Upload" src="../uploads/<?php echo $uploads->showProfileImage()?>">
</label>
</div>

<div id="upload_form">
<?php if($session->has('username')): ?>
<?php if($session->get('username') === $request->userUsername()): ?>

<form action="/upload/profile/pic"  id="upload" method="POST" enctype="multipart/form-data">
<input type="file" name="upload_file"id="upload_file" accept="image/jpeg, image/png" required>
<input type="hidden" name="form_token" value = "<?php echo $session->get('token')?>">
<?php if(!$uploads->hasProfileImage() ) :  ?>
<button name="upload-btn" class="upload-btn">  Upload </button>
<?php else: ?>
    <button name="upload-btn" class="upload-btn">  Change Picture </button>
<?php endif ?>

</form>
<?php endif; ?>
<?php endif; ?>
</div>


<div class="profile-names"> 
<h3> Joined On <?php echo $request->userJoinedDate();  ?>  </h3>
</div>

<div class="profile-names">
<h3> First name: <span> <?php echo $request->userFirstName(); ?>  </span> </h3>


<h3>Last name: <span> <?php echo $request->userLastName(); ?>  </span></h3>

<h3>Username: <span> <?php echo $request->userUsername(); ?>  </span></h3>

</div>

</section>

</div>



<div class="post_data" id="post_content_mobile">

<?php 
$posts->getPosts($request->userUsername());

?>

</div>


<?php require_once("../includes/footer.php");  ?>


