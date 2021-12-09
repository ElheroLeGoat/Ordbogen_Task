<?php

namespace models;

use controllers\crud;

require_once __DIR__ . '/../collector.php';

class user extends crud
{
    function __construct($db_session, $id = 0)
    {
        $this->db_session = $db_session;
        $this->table = 'users';
               
        if (isset($_SESSION["userlogin"]) && $id !== 0)
        {
            $id = $_SESSION["userlogin"]["id"];
            
            if (!$this->validate_session())
            {
                // session is not allowed and will therefore be nulled.
                unset($_SESSION["userlogin"]);
                $id = 0;
            }
        }
        
        parent::__construct($id, 'users');
    }
    
    public function login($username, $password)
    {
        /**
         * Used to login a user.
         * 
         * This method will securely login a user and generate a session token.
         * 
         * @param string $username - the username
         * @param string $password - the password
         * 
         * @since 1.0.1
         * @return Boolean
         */
        if (!$this->read(array("username"=>$username)) || !password_verify($password, $this->password))
        {
            return False;
        }
        
        $this->generate_token();
                   
        $_SESSION["userlogin"] = array("id"=>$this->id, "token"=>$this->token);
        return True;
    }
    public function logout()
    {
        unset($_SESSION['userlogin']);
    }
    
    public function register($username, $password, $email)
    {
        /**
         * Registration method.
         * 
         * Used to register new users to the site, validates and ensures everything
         * is correct before writing the user to the database
         * 
         * @param string $username - The users username.
         * @param string $password - The users password.
         * @param string $email    - The users email address.
         * 
         * @since 1.0.1
         * @return array - (bool) status, (mixed) *reason, (array) *params.
         * reason: (string) the reason why it failed or Null
         * params: check models\user->validate_string()
         */
        $username_validation = $this->validate_string(array("maxlen"=>64, "minlen"=>5), $username);
        $password_validation = $this->validate_string(array("maxlen"=>64, "minlen"=>8,
            "require_case"=>True,
            "require_int"=>True,
            "require_special"=>True), $password);
        $email_validation = $this->validate_string(array("email"=>True), $email);
        
        if (!$username_validation["status"] || !$password_validation["status"] || !$email_validation["status"])
        {
            return array("status"=>False, 
                         "reason"=>Null, 
                         "params"=>array('Username' => $username_validation, "Password" => $password_validation, "Email" => $email_validation));
        }
        if ($this->read(array('username'=>$username), False) || $this->read(array('email'=>$email), False))
        {
            return array("status"=>False, "reason"=>"Username or email does already exist");
        }
        
        $this->username = $username;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $this->email = $email;
        
        if (!$this->create())
        {
            return array("status"=>False, "reason"=>"Unable to register user, please contact the support.");
        }
        return array("status"=>True);
    }
    
    public function validate_session()
    {
        /**
         * Used to validate an session
         * 
         * Upon login a token is saved to the id, this method will check the token & id to make sure they match
         * before granting access to anything.
         * 
         * @return boolean
         */
        $id    = $_SESSION["userlogin"]["id"];
        $token = $_SESSION["userlogin"]["token"];
        
        return !$this->read(array('id'=>$id, 'token'=>$token)) ? False : True;
    }
        
    private function validate_string(array $params, $string)
    {
        /**
         * A string validation function.
         * 
         * This validator will check a bunch of parameters and return individual results in an array.
         * This is done so a proper list of failed items can be displayed if needed.
         * 
         * @param array $params  - The params to look for possible:
         * maxlen, minlen, require_case, require_int, require_special, email
         * @param string $string - The string to validate.
         * 
         * @since 1.0.1
         * @return $returnval - Returns an array containing (bool) Status and (bool) where in the validation it failed: 
         * maxlen, minlen, case, int, special, email
         */
        
        $returnval = array("status"=> True);
        
        // Character length Validation
        if (isset($params["maxlen"]) && strlen($string) > $params["maxlen"])
        {
            $returnval["status"] = False;
            $returnval["maxlen"] = '_string_ Must be below ' . $params["maxlen"] . ' characters';
        }
        if (isset($params["minlen"]) && strlen($string) < $params["minlen"])
        {
            $returnval["status"] = False;
            $returnval["minlen"] = '_string_ Must be above ' . $params["minlen"] . ' characters';
        }
        
        // Character Requirements
        if (isset($params["require_case"]) && $params["require_case"] && 
            !preg_match('/(?=.*?[A-Z])(?=.*?[a-z])/', $string))
        {
            $returnval["status"] = False;
            $returnval["case"]   = '_string_ must contain both upper and lowercase letters';
        }
        if (isset($params["require_int"]) && $params["require_int"] &&
            !preg_match('/(?=.*?[0-9])/', $string))
        {
            $returnval["status"] = False;
            $returnval["int"]   = '_string_ must contain numbers';
        }
        if (isset($params["require_special"]) && $params["require_special"] &&
            !preg_match('/(?=.*?[!@#$%*])/', $string))
        {
            $returnval["status"] = False;
            $returnval["special"] = '_string_ must contain atleast one of the following: !@#$%*';
        }
        
        // Email Validation
        if (isset($params["email"]) && $params["email"] && !filter_var($string, FILTER_VALIDATE_EMAIL))
        {
            $returnval["status"] = False;
            $returnval["email"] = 'Invalid email format.';
        }
        
        return $returnval;    
    }
    
    private function generate_token()
    {
        /**
         * Generates a pseudo random string and hashes it.
         * 
         * Used to generate a Token for the current login session.
         * 
         * @since 1.1.0
         * @return Boolean
         */
        $this->token = md5(bin2hex(openssl_random_pseudo_bytes(32)));
        
        if ($this->read(array("token"=>$this->token), False))
        {
            $this->generate_token();
        }
        
        return $this->update();
    }
}
