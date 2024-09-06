<?php require_once("../includes/header.php");  ?>

<section class="registration-section">
    <form action="/login/user" method="POST">

   
    <?php if($session->has('passwordChangedSuccessMessage')):?>
        <p> <?php echo $session->get('passwordChangedSuccessMessage')  ?> </p>

         <?php $session->remove('passwordChangedSuccessMessage'); ?>
        <?php endif;  ?>
      
       <?php if($session->has('emailNotVerifiedMessage')): ?>
      <p> <?php echo $session->get('emailNotVerifiedMessage');  ?></p>
      <?php $session->remove('emailNotVerifiedMessage'); ?>
      <?php endif; ?>

      <?php if($session->has('UserDontExist')): ?>
      <p> <?php echo $session->get('UserDontExist');  ?></p>
      <?php $session->remove('UserDontExist'); ?>
      <?php endif; ?>

      <?php if($session->has('passwordFailedErrorMessage')): ?>
      <p> <?php echo $session->get('passwordFailedErrorMessage');  ?></p>
      <?php $session->remove('passwordFailedErrorMessage'); ?>
      <?php endif; ?>


       <?php if($session->has('account_created')):?>
        <p> <?php echo $session->get('account_created')  ?> </p>

         <?php $session->remove('account_created'); ?>
        <?php endif;  ?>
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="password">
        <input type="hidden" name="form_token" value = "<?php echo $session->get('token')?>">
        <button type="submit" name="lbutton">Sign in</button>

        <p>Dont have an account? <a href="/register">Register here  </a></p>
        <p>Forgot your password? <a href="/forgot-password">Reset here  </a></p>

        

    </form>

</section>

<?php require_once("../includes/footer.php");  ?>