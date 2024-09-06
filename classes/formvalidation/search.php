<?php 

    namespace formvalidation;
    use database\DatabaseConnection;
    use request\Request;
    use sessions\session;

    class search
    {
        private $request;
        private $session;
        private $db;
        public function __construct(session $session,request $request)
        { 
          $this->db = DatabaseConnection::getInstance()->getConnection();
          $this->request = $request;
          $this->session = $session;
        }


        public function results()
        {    
             $search_term = $this->request->post('search')."%";
             $verified = 1;

             $statement = $this->db->prepare("SELECT users.username,profile_image.image FROM users
             JOIN profile_image ON profile_image.user_id = users.id WHERE users.username LIKE :search_term AND users.email_verified = :verified");
             $statement->bindParam(':search_term',$search_term);
             $statement->bindParam(":verified",$verified);
             $statement->execute();

             if($statement->rowCount() > 0){

                 $rows= $statement->fetchAll(\PDO::FETCH_OBJ);

                 foreach($rows as $row){
                    
                    
                    echo "
                    <h3>$row->username </h3>
                    <a href='/profile/$row->username'>
                    <img src=../uploads/$row->image>
                    </a>
                    ";
                    
                 }
             }
        }
    }

?>