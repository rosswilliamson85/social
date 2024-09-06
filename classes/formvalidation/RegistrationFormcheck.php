<?php 

namespace formvalidation;

use database\DatabaseConnection;
use sessions\session;
use request\Request;
use PHPMailer\PHPMailer;





    class RegistrationFormCheck extends RegistrationFormErrorMessages
    {
        
        
        public $errors = [];
        private $db;

        private $fname;
        private $lname;
        private $username;
        private $password;
        private $email;

        private $session;

        private $request;
        private $phpMailer;

        private $email_verified_code;

      

        public function __construct(session $session,request $request,phpMailer $phpMailer)
        {
             $this->session = $session;
             $this->request = $request;
             $this->phpMailer = $phpMailer;
        }

      

        
          public function validateFormFields(){
               
             if(isset($_POST['rbutton'])){

                $this->db = DatabaseConnection::getInstance()->getConnection();
                
               
                
                $this->fname  = $this->request->post('fname');
                $this->lname = $this->request->post('lname');
                $this->username = $this->request->post('username');
                $this->password = $this->request->post('password');
                $this->email  = $this->request->post('email');
                

                
               



                $this->firstName($this->fname);
                $this->lastName($this->lname);
                $this->userName($this->username);
                $this->password($this->password);
                $this->email($this->email);

                $this->checkForErrors();
                $this->request->redirect('/register');

               

                
                
                
                
                
             }
            
          

           
             
                
          }

        


          private function firstName($firstname){

        
  
             if(empty($firstname)){
                 
                return $this->errors['firstname'][] =  parent::$firstNameEmpty;

             }

             
             if(!ctype_alpha($firstname)){
                 
                return $this->errors['firstname'][] =  parent::$firstNameAlpha;
             
              }

              if(strlen($firstname) < 3){
                
                  
                  return $this->errors['firstname'][] =  parent::$firstNameStrLess;
               }

              if(strlen($firstname) > 20){
                 
                  return $this->errors['firstname'][] =  parent::$firstNameStrLenGreater;
              }

            

              
          }


          private function lastName($lastname){

            if(empty($lastname)){

             
                 
                return $this->errors['lastname'][] =  parent::$lastNameEmpty;

             }

             
            if(!ctype_alpha($lastname)){
               
               
                return $this->errors['lastname'][] =  parent::$lastNameAlpha;
             }
              
            if(strlen($lastname) < 5){
                
                return $this->errors['lastname'][] = parent::$lastNameStrLess;
            }

            if(strlen($lastname) > 20){
               
                return $this->errors['lastname'][] =  parent::$lastNameStrLenGreater;
            }



            
        }


        private function userName($username){

            if(empty($username)){
                 
           
                return $this->errors['username'][] =  parent::$userNameEmpty;

             }

             
             if (!preg_match('/^(?![0-9])[a-zA-Z]+[0-9]{0,2}$/', $username)) {
                return $this->errors['username'][] = parent::$userNameValidation;
              }
            
            if(strlen($username) < 5){
                
                return $this->errors['username'][] = parent::$userNameStrLess;
            }

            if(strlen($username) > 20){
               
                return $this->errors['username'][] =  parent::$userNameStrLenGreater;
            }

            if($this->duplicateEntryInDatabase('username','username',$this->username)){

                return $this->errors['username'][] = parent::$userNameDuplication;
            }

            



            
        }

        private function duplicateEntryInDatabase($formfield,$selectField,$postFormField){
             
           $statement =  $this->db->prepare("SELECT $selectField FROM users WHERE $selectField = :value");
           $statement->bindParam(":value",$postFormField);
           $statement->execute();
           
           if($statement->rowCount() > 0){

            $fetchFormField = $statement->fetchObject();
            return $fetchFormField->$formfield;
           }
          

          

        
           


        }


        protected function password($password){

            if(empty($password)){
                 
                return $this->errors['password'][] =  parent::$passwordNameEmpty;

             }
             
            if(strlen($password) < 8 || strlen($password) > 20){

               return $this->errors['password'][] = parent::$passwordStrLenGreater;
            }

            
        }


        private function email($email){

            if(empty($email)){
                 
                return $this->errors['email'][] =  parent::$emailNameEmpty;

             }

            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){

                return $this->errors['email'][] = parent::$emailValidation;
            }


            if($this->duplicateEntryInDatabase('email','email',$email)){

                return $this->errors['email'][] = parent::$emailDuplication;
            }
        }

    
   

        private function checkForErrors(){

            if(empty($this->errors)){
                
                
                $this->insertUserIntoDatabase();
            }else{
                $this->session->set('firstname_error',$this->errors['firstname']);
                $this->session->set('lastname_error',$this->errors['lastname']);
                $this->session->set('username_error',$this->errors['username']);
                $this->session->set('password_error',$this->errors['password']);
                $this->session->set('email_error',$this->errors['email']);
               
            }
        }

        private function sendEmail()
        {
            $code = $this->verfiedCode();
                    
            $this->phpMailer->setFrom('rosswilliamson85@outlook.com', 'Im social');
            $this->phpMailer->addAddress($this->email, 'Im social');
            $this->phpMailer->Subject = 'Verify your email';
            $this->phpMailer->Body = "

            <a href=http://localhost:4000/email-verifi?code=$code> Click here to verifi your email </a>
            
            
            ";

            try {
                if ($this->phpMailer->send()) {
                    return true;
                }
            } catch (\Exception $e) {
                echo 'Email could not be sent. Error: ' . $this->phpMailer->ErrorInfo;
            }
        
            return false;
              

             
            

        }
        private function insertUserIntoDatabase(){

          
            $this->password = password_hash($this->password,PASSWORD_BCRYPT);
            $this->email_verified_code = bin2hex(random_bytes(16));
        
           $statement = $this->db->prepare("INSERT INTO users (firstname, lastname, username, password, email,email_verified_code) VALUES (:firstname, :lastname,
            :username, :password, :email,:email_verified_code)");
           
            $statement->bindParam(":firstname",$this->fname);
            $statement->bindParam(":lastname",$this->lname);
            $statement->bindParam(":username",$this->username);
            $statement->bindParam(":password",$this->password);
            $statement->bindParam(":email",$this->email);
            $statement->bindParam(':email_verified_code',$this->email_verified_code);

            $statement->execute();

            if($statement->rowCount() > 0){

                $statement_select = $this->db->prepare("SELECT id FROM users WHERE username = :username");
                $statement_select->bindParam(":username",$this->username);
                $statement_select->execute();

                if($statement_select->rowCount() > 0){

                   $row = $statement_select->fetch(\PDO::FETCH_OBJ);
                    $image = "redx.png";
                    $user_id = $row->id;
                    
                    $statement_insert = $this->db->prepare("INSERT INTO profile_image (user_id,image) VALUES(:user_id,:image)");
                    $statement_insert->bindParam(":image",$image);
                    $statement_insert->bindParam(":user_id",$user_id);
                    $statement_insert->execute();

                    
                   

                }

                
                
           
               if($this->sendEmail() == true)
               {
                  $this->session->set('emailSuccessMessage','Please check your inbox to verifi your email');
               }

               
              

               
            }


           
        }

        
        public function checkIfQueryStringMatchesDatabase()
        {

         
            $this->db = DatabaseConnection::getInstance()->getConnection();
    
            $this->password = $this->request->post('password');
    
            $code = $this->request->Params('code');
    
            $statement = $this->db->prepare("SELECT email_verified_code FROM users WHERE email_verified_code=:query_string");
            $statement->bindParam(':query_string',$code);
            $statement->execute();
    
            if($statement->rowCount() < 1){
                
               
                require_once('../pages/404/404.php');
                die();
                 
                
            }else{
               
                $email_verified = 1;
               
                $statement = $this->db->prepare("UPDATE users SET email_verified = :email_verified WHERE email_verified_code = :email_verified_code");
                $statement->bindParam(":email_verified",$email_verified);
                $statement->bindParam(":email_verified_code",$code);
                $statement->execute();

                if($statement->rowCount() > 0){
                    $nothing = "";
                    $statement = $this->db->prepare("UPDATE users SET email_verified_code = :nothing WHERE email_verified_code = :code");
                    $statement->bindParam(":nothing",$nothing);
                    $statement->bindParam(":code",$code);
                    $statement->execute();
                    $this->session->set("verifiedMessage", "Your email has been verified you may now <a href='/login'>log in</a>");
                   
                }
                
            }
            
            
            
            
    
        }

        private function verfiedCode()
        {
            $statement =  $this->db->prepare("SELECT email_verified_code FROM users WHERE email = :email");
            $statement->bindParam(":email",$this->email);
            $statement->execute();

                if($statement->rowCount() > 0)
                {
                    $row = $statement->fetch(\PDO::FETCH_OBJ);
                    return $row->email_verified_code;
                }
       }
}





?>