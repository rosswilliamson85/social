<?php 

namespace request;

use database\DatabaseConnection;
use sessions\session;


class Request
{  
      private $session;
      private $db;

      public function __construct(session $session)
      {
           $this->session = $session;
           $this->db =  DatabaseConnection::getInstance()->getConnection();
      }

      private function protectForm($form)
      {
         $form = htmlspecialchars($form);
         $form = strip_tags($form);

         if (filter_var($form, FILTER_VALIDATE_EMAIL)) {
            $form = filter_var($form, FILTER_SANITIZE_EMAIL);
            
        }else{
       
         $form = trim(htmlspecialchars($form, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
      
        }

         
         
         return $form;
         

         
      }
      public function post($var)
      {   

         if($_SERVER['REQUEST_METHOD'] === "POST"){
              
               if(isset($_POST[$var])){
                  
                 
                  return $this->protectForm($_POST[$var]);
               }
         }
         
      }

   
         public function redirect($url = "" ,$statusCode = 302)
         {  
            if(!empty($url)){

               header('location:'.$url,true,$statusCode);
            }else{

               header('Location: ' . $this->back());
            }
          
            return $this;
           
         }

         public function back()
         {
            return $_SERVER['HTTP_REFERER'];
         }

        
         public function nonAuthorisedPage()
         {  
             if($this->session->has('username'))
             {
                 die('you must be logged out to view this page ');
            
             }
            
         }

         public function authorisedPage()
         {    
               if(!$this->session->has('username'))
               {
                   die('you must be logged in to view this page ');
               }

            
            
            
         }

         public function url()
         {

            $uri = $_SERVER['REQUEST_URI'];
            $uri = strtolower($uri);
            $uri = rtrim($uri);
            $uri = filter_var($uri,FILTER_SANITIZE_URL);
            return $uri;

         }


         public function Params($param)
         {  
            
            $queryString = parse_url($this->url(), PHP_URL_QUERY);
            if($queryString !== null){
            parse_str($queryString, $params);
            }

            if(empty($params))
            {   
               
              $params['code'] = "";
            }  
           return  $resetcode = $params[$param];
         }
         
         private function user($var,$part)
         {
          
           
           $param = $this->url();
           $param = explode('/',$param);
           
           $statement = $this->db->prepare("SELECT id,firstname,lastname,username,email,created_at FROM users WHERE username = :param");
           $statement->bindParam(":param",$param[$part]);
           $statement->execute();

           if($statement->rowCount() > 0)
           {
              $user = $statement->fetch(\PDO::FETCH_OBJ);
              return $user->$var;
           }

           return "Page not found";

         
         
      }


      public function userJoinedDate()
      {
         return date('jS F',strtotime($this->user('created_at',2)));
      }

      public function userUsername()
      {
         return $this->user('username',2);
      }

      public function userFirstName()
      {
         return $this->user('firstname',2);
      }

      public function userLastName()
      {
         return $this->user('lastname',2);
      }


      


      public function mostRecentUsers()
      {
         $statement = $this->db->query("SELECT users.username,profile_image.image FROM users 
         JOIN profile_image ON users.id = profile_image.user_id ORDER BY profile_image.user_id DESC");

         $statement->execute();

         if($statement->rowCount() > 0){

            return $statement->fetchAll(\PDO::FETCH_OBJ);
             
           

         }

         exit();

   
      }

      



     
    
    

}