<?php 

namespace  formvalidation;

class RegistrationFormErrorMessages{
    
    // firstName Errors

    public static $firstNameEmpty = 'Please enter your first name';
    public static $firstNameStrLenGreater = 'Your first name is to long, between(3,20 characters)';
    public static $firstNameStrLess = 'Your first name is to short,(must be longer then 3 characters)';
    public static $firstNameAlpha = 'Your first name should only contain letters';
    // End FirstName Errors


    // LastName Errors

    public static $lastNameEmpty = 'Please enter your last name';
    public static $lastNameStrLenGreater = 'Your last name is to long, between(5,30 characters)';
    public static $lastNameStrLess = 'Your last name is to short,(must be longer then 4 characters)';
    public static $lastNameAlpha = 'Your last name should only contain letters';

    // End LastName Errors
  

    //Username Errors
    
    public static $userNameEmpty = 'Please enter a username';
    public static $userNameStrLenGreater = 'Your username is to long, between(5,30 characters)';
    public static $userNameStrLess = 'Your username is to short,(must be longer then 7 characters)';
    public static $userNameValidation = "Your username can only contain numbers and letters, the numbers should come after the letters
    and be no more then 2 numbers";
    public static $userNameTaken = "That username is in use";

    public static $userNameDuplication = "That username has already been registered";
    // End Username Errors
    

   // password Errors
    
    public static $passwordNameEmpty = 'Please enter a password';
    public static $passwordStrLenGreater = 'Your password should be between 8 - 20 characters in length';

   // End Password Errors


   
   // Email Errors
   
   public static $emailNameEmpty = 'Please enter a email';
   public static $emailValidation = 'That is not a valid email';
   public static $emailDuplication = "That email has already been registered";
   // End Email Errors






        

}


?>
