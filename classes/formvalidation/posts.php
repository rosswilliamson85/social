<?php 

namespace formvalidation;
use database\DatabaseConnection;
use request\Request;
use sessions\session;

class posts
{
    private $db;
    private $session;
    private $request;
    public function __construct(session $session,request $request)
    {
       $this->db = DatabaseConnection::getInstance()->getConnection();
       $this->session = $session;
       $this->request = $request;
    }
    public function checkPostForm()
    {    
         $content = $this->request->post('content');
         $user_id = $this->session->get('user_id');

         $statement = $this->db->prepare("INSERT INTO posts (user_id,content) VALUES(:user_id,:content)");
         $statement->bindParam(":user_id",$user_id);
         $statement->bindParam(":content",$content);
         $statement->execute();

         if($statement->rowCount() > 0){

            $this->getPosts($this->request->post('username'));
         }
         
         
        
        
    }


    public function getPosts($username)
    {   
        $statement = $this->db->prepare("SELECT posts.user_id,posts.id,users.username,posts.content,posts.created_at FROM posts
        JOIN users ON posts.user_id = users.id WHERE users.username= :username ORDER BY posts.id DESC");
        $statement->bindParam(":username",$username);
        $statement->execute();
        $token = $this->session->get('token');

        if($statement->rowCount() > 0){

            $row = $statement->fetchAll(\PDO::FETCH_OBJ);
            foreach($row as $rows) {
                $created_at = $this->formatdateTime($rows->created_at);
                
                $content = html_entity_decode($rows->content);

                echo "
                <div class='display_post$rows->id'>
                    <h3>$rows->username <span>$created_at</span></h3>
                    <p> $content </p>
                    <input type='hidden' class='delete-btn-id' value='$rows->id'>
                    <input type='hidden' name='form_token' value='$token'>
                    
                    
                ";
                
           
                if($this->session->has('user_id') && $this->session->get('user_id') === $rows->user_id){
                    echo "<button id='delete-post-btn$rows->id'>delete</button>";
                    
                }
                
                echo "</div>";
               
               
            }
            
        }
    }


    

    public function deletePostById()
    {   
       $button_id = $this->request->post('button_id');
       $statement = $this->db->prepare("DELETE FROM posts WHERE id = :button_id");
       $statement->bindParam(":button_id",$button_id);
       $statement->execute();

    }

    private function formatdateTime($timeStamp)
    { 
      return date('jS F \a\t g:i a', strtotime($timeStamp));
    }


}   