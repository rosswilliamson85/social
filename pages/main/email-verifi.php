<?php 

$registrationFormCheck->checkIfQueryStringMatchesDatabase();

?>

<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
  <h1 style="font-size: 2rem;">

   <?php  
   if($session->has('verifiedMessage')){
     
       echo $session->get('verifiedMessage');
   }
   ?>
   </h1>
</div>
