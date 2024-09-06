<?php 

namespace formvalidation;
use database\DatabaseConnection;
use request\Request;
use PHPMailer\PHPMailer;





class ResetPassword extends RegistrationFormErrorMessages
{
    private $db;
    private $request;
    private $phpMailer;
    public $errors = [];

    private $email;

    public $confirmationMessage;


  

    public function  __construct(Request $request,PHPMailer $phpMailer)
    {
        $this->request = $request;
        $this->phpMailer = $phpMailer;
        
    }

    public function sendResetEmail($email)
    {
        $this->db = DatabaseConnection::getInstance()->getConnection();
      
        
        if(isset($_POST['reset_button'])){
            
           
            $this->email = $this->request->post($email);
      
            $this->email();

            if($this->checkIfUserExistsInDatabase()){

            if($this->insertVerificationCodeIntoDatabase() == 1){
               
                $this->sendEmailIfNoErrors();
                $this->confirmationMessage = "Please check your inbox";
            }
        }else{
            $this->confirmationMessage = "Email dont exist";
        }

        }
        
        $this->request->redirect('/forgot-password');


       
        
        


        
    }


    private function checkIfUserExistsInDatabase()
    {
        $statement = $this->db->prepare("SELECT email from users WHERE email=:email");
        $statement->bindParam(":email",$this->email);
        $statement->execute();

        if($statement->rowCount() > 0)
        {
            return true;
        }

        return false;
    }


    private function email()
    {

        if(empty($this->email)){
                 
            return $this->errors['email'][] =  parent::$emailNameEmpty;

         }

        if(!filter_var($this->email,FILTER_VALIDATE_EMAIL)){

            return $this->errors['email'][] = parent::$emailValidation;
        }
         
    }


    private function sendEmailIfNoErrors()
    {
        if(empty($this->errors))
        {       

                   $code = $this->resetCode();
                    
                   $this->phpMailer->setFrom('ross@rosswilliamson.dev', 'Im social');
                    $this->phpMailer->addAddress($this->email, 'ross');
                    $this->phpMailer->Subject = 'Request to reset your password';
                    $this->phpMailer->Body = "

                
                    
                     
                     <a href=https://social.rosswilliamson.dev/reset-password?code=$code> Click here to reset your password </a>
                    
                    
                    ";

                     
                    

                    try {
                        $this->phpMailer->send();
                         
                    } catch (\Exception $e) {
                        echo 'Email could not be sent. Error: ' . $this->phpMailer->ErrorInfo;
                    }
            
        }
    }


    private function insertVerificationCodeIntoDatabase()
    {  
       $reset_password = bin2hex(random_bytes(16));
       $statement =  $this->db->prepare("UPDATE users SET password_reset = :reset_password WHERE email = :email");
       $statement->bindParam(":email",$this->email);
       $statement->bindParam(":reset_password",$reset_password);
       return $statement->execute();
        
    }


    public function resetCode()
    {
       $statement =  $this->db->prepare("SELECT password_reset FROM users WHERE email = :email");
       $statement->bindParam(":email",$this->email);
       $statement->execute();

       if($statement->rowCount() > 0)
       {
           $row = $statement->fetch(\PDO::FETCH_OBJ);
           return $row->password_reset;
       }
    }



   
}



?>