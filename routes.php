<?php
   
   if($_SERVER['REQUEST_METHOD'] === "POST"):
   
    switch($request->url()){
    
        case '/login/user':
            $request->nonAuthorisedPage();
            $validateLoginCredentials->validate();
        break;

        case '/upload/profile/pic':
            $request->authorisedPage();
            $uploads->uploadProfilePic();
        break;

        case '/register/user':
            $request->nonAuthorisedPage();
            $registrationFormCheck->validateFormFields();
        break;

        case '/posts':
            $request->authorisedPage();
            $posts->checkPostForm();
        break;

        case '/reset/password':
            $request->nonAuthorisedPage();
            $resetPassword->sendResetEmail('email'); 

            break;

            case '/change/password':
                $request->nonAuthorisedPage();
                $forgotPassword->changePassword();
               
    
                break;
    

        case '/delete/post':
            $request->authorisedPage();
            $posts->deletePostById();
        break;

        case '/search':
         $search->results();
         break;

         default;
         require_once("../pages/404/404.php");
        
    }


   endif;

    if($_SERVER['REQUEST_METHOD'] === "GET"):
  
      
        switch($request->url()){
        case '/login':
        $request->nonAuthorisedPage();
        require_once("../pages/main/login.php");
        
        break;

        case '/register':
            $request->nonAuthorisedPage();
            require_once("../pages/main/register.php");
        break;

        

        case '/forgot-password':
            $request->nonAuthorisedPage();
            require_once("../pages/main/forgot-password.php");
        break;

      
        
      

        case '/email-verifi?code='.$request->params('code'):
            $request->nonAuthorisedPage();
            require_once("../pages/main/email-verifi.php");
        break;

        case '/reset-password?code='.$request->params('code');
            $request->nonAuthorisedPage();
            require_once("../pages/main/reset-password.php");
        break;

        case "/profile/".$request->userUsername();
        
        require_once("../pages/auth/profile.php");
    break;

        case '/logout':
            $request->authorisedPage();
            require_once("../pages/main/logout.php");
        break;

        case '/':
            
            require_once("../pages/front_page/front.php");
        break;

        default;
        require_once("../pages/404/404.php");
    }

endif;