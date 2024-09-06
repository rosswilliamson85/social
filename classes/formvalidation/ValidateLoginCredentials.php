<?php 

namespace formvalidation;

use database\DatabaseConnection;

use request\Request;
use sessions\session;
class ValidateLoginCredentials
{
    
    private $db;
    private $request;
    private $session;

    private $username;

    private $password;


    public function __construct(request $request, session $session)
    {
       $this->request = $request;
       $this->session = $session;
    }
     
     public function validate()
     {  
        if(isset($_POST['lbutton'])){
           
            $this->db = DatabaseConnection::getInstance()->getConnection();
            $this->username = $this->request->post('username');
            $this->password = $this->request->post('password');
            
         
          $this->request->redirect('/login');
        $statement = $this->db->prepare("SELECT id,username,password,email_verified FROM users WHERE username=:username");
        $statement->bindParam(":username",$this->username);
        $statement->execute();
        

        if($statement->rowCount()  > 0)
        {
            $database = $statement->fetch(\PDO::FETCH_OBJ);
            
            
            
            if($this->username == $database->username && $this->password == password_verify($this->password,$database->password))
            {   
                if($database->email_verified == 1){

                    $this->session->set('username',$database->username);
                    $this->session->set('user_id',$database->id);
                    $this->request->redirect('/');
                }else{
                     
                    
                     return $this->session->set('emailNotVerifiedMessage','Please verifi your email before logging in');
                     
                }
               

            }else{
                
               return $this->session->set('passwordFailedErrorMessage','Incorrect username or password');
                
            }
        }else{
            
            if(!empty($this->username) && !empty($this->password)){
                return $this->session->set('UserDontExist','That user dont exist');
             }
           
        }

        
    }

     
     }

    
}