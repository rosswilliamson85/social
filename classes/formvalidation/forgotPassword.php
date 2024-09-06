<?php 

namespace formvalidation;

use database\DatabaseConnection;
use request\Request;
use sessions\session;
class forgotPassword extends RegistrationFormCheck
{  

    private $db;
    private $password;
    private $request;
    public $errors = [];
    
    private $session;
    private $code;
    
    public function __construct(request $request,session $session)
    {
      $this->request = $request;
      $this->session = $session;
      $this->code = $this->request->Params('code');
      $this->db = DatabaseConnection::getInstance()->getConnection();
      $this->password = $this->request->post('password');
      
      
    }
    public function checkIfQueryStringMatchesDatabase()
    {
        $statement = $this->db->prepare("SELECT password_reset FROM users WHERE password_reset=:query_string");
        $statement->bindParam(':query_string',$this->code);
        $statement->execute();

        if($statement->rowCount() < 1){
            
           
            require_once('../pages/404/404.php');
            die();
             
            
        }
        
     
       
        
        

    }

    

    public function changePassword()
    {
         if(isset($_POST['change_password']))
         {
            parent::password($this->password);

            if(empty($this->errors)){
                
                $code = $this->request->post('reset-code');
                $password = password_hash($this->password,PASSWORD_BCRYPT);
                $nothing = null;
                $statement = $this->db->prepare("UPDATE users SET password = :password,password_reset=:nothing WHERE password_reset=:code");
                $statement->bindParam(":password",$password);
                $statement->bindParam(":code",$code);
                $statement->bindParam(":nothing",$nothing);
                $statement->execute();
                

                if($statement->rowCount() > 0){
                   
                   $this->session->set("passwordChangedSuccessMessage","Your password has been changed you may now log in!");
                   $this->request->redirect('/login');
                }
                
            }else{
                $this->session->set('password_error',$this->errors['password']);
                header('location:'.$_SERVER['HTTP_REFERER']);
            }

         }
    }

   

   


    
}

?>