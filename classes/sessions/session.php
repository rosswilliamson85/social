<?php 

namespace sessions;


class session
{   
     public function has($sessionName)
     {
         return isset($_SESSION[$sessionName]);
     }

   
  
  
     public function set($sessionName,$sessionValue)
     {
        return $_SESSION[$sessionName] = $sessionValue;
     }

     public function get($sessionName)
   {
      return $_SESSION[$sessionName];
   }

     public function remove($sessionName)
     {
        unset($_SESSION[$sessionName]);
     }
}

