<?php require_once("../includes/header.php");  ?>

<section class="registration-section">
    <form action="/reset/password" method="POST">

        
        <p><?php echo $resetPassword->confirmationMessage; ?></p>
        
        <?php if(!empty($resetPassword->errors['email'])): ?>
        <?php foreach($resetPassword->errors['email'] as $emailErrors ):  ?>
        <p> <?php echo $emailErrors; ?> </p>
        <?php endforeach; ?>
        <?php endif; ?>
        <input type="email" name="email" placeholder="Enter your email">
        <input type="hidden" name="form_token" value = "<?php echo $session->get('token')?>">
        <button type="submit" name="reset_button">Reset</button>

        

    </form>

</section>





<?php require_once("../includes/footer.php");  ?>