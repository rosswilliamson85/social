<?php 

if($session->has('username'))
{
    session_destroy();
    $request->redirect('/login');
}

?>