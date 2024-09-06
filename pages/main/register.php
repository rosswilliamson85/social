<?php require_once("../includes/header.php");  ?>

<section class="registration-section">
     



    <form action="/register/user" method="POST">

    <?php if($session->has('emailSuccessMessage')):?>
         
            <p><?php echo $session->get('emailSuccessMessage')?></p>
            <?php $session->remove('emailSuccessMessage'); ?>
            <?php endif; ?>

        

        <?php if($session->has('firstname_error')):?>
            <?php foreach($session->get('firstname_error') as  $firstNameErrors):  ?>
            <p><?php echo $firstNameErrors;?></p>
            <?php $session->remove('firstname_error'); ?>
            <?php endforeach; ?>
        <?php endif; ?>



        <input type="text" name="fname" placeholder="First Name">

           <?php if($session->has('lastname_error')):?>
            <?php foreach ($session->get('lastname_error') as $lastNameErrors):  ?>
            <p><?php echo $lastNameErrors;?></p>
            <?php $session->remove('lastname_error'); ?>
            <?php endforeach; ?>
        <?php endif; ?>




        <input type="text" name="lname" placeholder="Last Name">

        <?php if($session->has('username_error')):?>

            
            <?php foreach($session->get('username_error') as $userNameErrors):  ?>
            <p><?php echo $userNameErrors;?></p>
            <?php $session->remove('username_error'); ?>
            <?php endforeach; ?>
        <?php endif; ?>


        <input type="text" name="username" placeholder="Username">
        
        <?php if($session->has('password_error')):?>
            
            <?php foreach($session->get('password_error') as $passwordNameErrors):  ?>
            <p><?php echo $passwordNameErrors;?></p>
            <?php $session->remove('password_error'); ?>
            <?php endforeach; ?>
        <?php endif; ?>


        <input type="password" name="password" placeholder="password">


        <?php if($session->has('email_error')):?>
            <?php foreach($session->get('email_error')  as $emailNameErrors):  ?>
            <p><?php echo $emailNameErrors;?></p>
            <?php $session->remove('email_error'); ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <input type="email" name="email" placeholder="Enter your email">
        <input type="hidden" name="form_token" value="<?php echo $session->get('token');  ?>">
        


        <button type="submit" name="rbutton">Sign Up</button>
        <a href="/login"> back to login </a>

    </form>

</section>

<?php require_once("../includes/footer.php");  ?>