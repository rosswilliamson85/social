<?php require_once("../includes/header.php");  ?>

<?php 
$forgotPassword->checkIfQueryStringMatchesDatabase();
$code = $request->Params('code');

?>
<section class="registration-section">


    <form action="/change/password" method="POST">
        
    
         
        <?php if($session->has('password_error')):?>
            <?php foreach($session->get('password_error') as $passwordNameErrors):  ?>
            <p><?php echo $passwordNameErrors;?></p>
            <?php $session->remove('password_error'); ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <input type="password" name="password" placeholder="New Password">
        <input type="hidden" name="form_token" value = "<?php echo $session->get('token')?>">
        <input type = "hidden" name="reset-code" value="<?php echo $code; ?>">
        <button type="submit" name="change_password">Change Password</button>

    </form>

</section>

<?php require_once("../includes/footer.php");  ?>