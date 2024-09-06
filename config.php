<?php 

// Set the default time zone to UK
ini_set('date.timezone', 'Europe/London');



// global namespace set up

$phpMailer = new PHPMailer\PHPMailer;
$session = new sessions\session;
$request = new request\Request($session);
$registrationFormCheck = new formvalidation\RegistrationFormCheck($session,$request,$phpMailer);
$validateLoginCredentials = new formvalidation\ValidateLoginCredentials($request,$session);
$resetPassword = new formvalidation\ResetPassword($request,$phpMailer);
$forgotPassword = new formvalidation\forgotPassword($request,$session);
$posts = new formvalidation\posts($session,$request);
$uploads = new formvalidation\Upload($session,$request);
$search= new formvalidation\search($session,$request);


// csrf checking very important for security



if(!$session->has('token')){

    $session->set('token',bin2hex(random_bytes(16)));

}


if($_SERVER['REQUEST_METHOD'] === "POST")
{    
    if ($request->post('form_token')){
        
        $formToken = $request->post('form_token');
        
        if ($formToken !== $_SESSION['token']) {
            throw new \Exception("CSRF token validation failed.");
        }

       

       unset($_SESSION['form_token']);
    }else{
        die('Csrf error');
    }  


}

// End csrf check







// setting up phpMailer

$phpMailer->isSMTP();
$phpMailer->Host = 'smtp.office365.com'; // Outlook's SMTP server
$phpMailer->SMTPAuth = true;
$phpMailer->Username = 'rosswilliamson85@outlook.com'; // Your Outlook email address
$phpMailer->Password = 'Romford802'; // Your Outlook email password
$phpMailer->SMTPSecure = 'tls'; // Use TLS encryption
$phpMailer->Port = 587; // Port for TLS
$phpMailer->isHTML(true);


// end phpMailer set up

// set up routing

require_once("routes.php");

// end routing


?>

