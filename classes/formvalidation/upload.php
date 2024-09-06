<?php 

namespace formvalidation;
use database\DatabaseConnection;
use sessions\session;
use request\Request;
class Upload
{
    private $db;
    private $session;

    private $uniqueFileName;
    private $request;

    public function  __construct(session $session,request $request)
    {
        
        $this->session = $session;
        $this->request = $request;
        $this->db =  DatabaseConnection::getInstance()->getConnection();
    }
     public function uploadProfilePic()
     {  
        
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' AND isset($_POST['upload-btn'])) {
            
            
            $fileName = $_FILES['upload_file']['name'];
            $fileType = $_FILES['upload_file']['type'];
            $fileSize = $_FILES['upload_file']['size'];
            $fileTmp = $_FILES['upload_file']['tmp_name'];
            $fileError = $_FILES['upload_file']['error'];
            $this->uniqueFileName = uniqid() . '_' . $fileName;

            if ($fileError !== UPLOAD_ERR_OK) {
                echo 'An error occurred while uploading the file.';
                // You can handle specific error codes here
                exit;
            }

            if (!in_array($fileType, $this->filesThatAreAllowedonUpload())) {
                echo 'Invalid file type. Only JPEG and PNG files are allowed.';
                exit;
            }

            if ($fileSize > $this->maxFilesizeSet()) {
                echo 'File size exceeds the maximum limit of 5MB.';
                exit;
            }
             
           if( $this->moveUploadedFile($fileTmp,$fileName))
           {  
             
              $user_id = $this->session->get("user_id");
              $statement = $this->db->prepare("UPDATE profile_image SET image = :image WHERE user_id = :user_id");
              
            //   $file = $this->showProfileImage();
            //   unlink("../public/uploads/$file");
            

              $statement->bindParam(":user_id",$user_id);
              $statement->bindParam(":image",$this->uniqueFileName);
              $statement->execute();

              if($statement->rowCount() > 0)
              {  
               
                 $this->showProfileImage();
                 $this->request->redirect()->back();
                
                 
                 
              }
           

            
        


        }
    }

}
   
  
    
    public function showProfileImage()
    {   
        $url = $this->request->userUsername();
        $statement = $this->db->prepare("SELECT image FROM profile_image
        JOIN users ON profile_image.user_id = users.id WHERE users.username = :username");
        $statement->bindParam(":username",$url);

        $statement->execute();

        

        if($statement->rowCount() > 0){

           $row = $statement->fetch(\PDO::FETCH_OBJ);
            
            return $row->image;
           
        }
   }
    public function hasProfileImage()
    {
        $url = $this->request->userUsername();
        $redx = "redx.png";

        $statement = $this->db->prepare("SELECT image FROM profile_image
        JOIN users ON profile_image.user_id = users.id WHERE users.username = :username AND profile_image.image !=:redx");
        $statement->bindParam(":username",$url);
        $statement->bindParam(":redx",$redx);

        $statement->execute();

        if($statement->rowCount() > 0)
        {
            return true;
        }

        return false;

        

       

    }

   private function filesThatAreAllowedonUpload()
   {
      return['image/jpeg', 'image/png'];
   }

   private function maxFilesizeSet()
   {
      return  5 * 1024 * 1024;
   }

   private function uploadDirectory($fileName)
   {  
      return '../public/uploads/' . $this->uniqueFileName;
           
   }

   private function moveUploadedFile($fileTmp,$fileName)
   {
        return move_uploaded_file($fileTmp, $this->uploadDirectory($fileName));
            
        
   }
}

?>