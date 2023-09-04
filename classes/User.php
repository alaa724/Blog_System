<?php
class User {

     private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
   
    public function register($user , $email , $password)
    {
        
          // Validate the form data
            $errors = array();
            
            
            if (empty($user)) {
                $errors[] = "Please enter a user.";
            }
            if (empty($email)) {
                $errors[] = "Please enter an email address.";
            }
            if (empty($password)) {
                $errors[] = "Please enter a password.";
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Please enter a valid email address.";
            }

            

           // Check if the user or email address is already in use
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE user = :user OR email = :email");
            
            $stmt->execute(array(':user' => $user, ':email' => $email));
     
            
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $errors[] = "user or email address already in use.";
            }
                        // If there are no errors, insert the user into the database

              if (empty($errors)) {
                  
                $hash = password_hash($password, PASSWORD_DEFAULT);

                
                $stmt = $this->pdo->prepare("INSERT INTO users (user, email, password) VALUES (:user, :email, :password)");
                
                $stmt->execute(array(':user' => $user, ':email' => $email, ':password' => $hash));

                return true;
            } else {
                return $errors;
            }
            
            
    }



    public function login( $email , $password)
    {
                
            

           // Check if the user or email address is already in use
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE  email = :email");
            
        $stmt->execute(array( ':email' => $email));  

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // ['id'=>'1' , 'user'=>''ahmed_tahoon','email'=>'dsfsdf' ,'password'=>''1213]
      
        if ($user && password_verify($password, $user['password'])) {
        
            // The user and password are correct, so set the session variables and redirect to the home

            $_SESSION['user_id']=$user['id'];
            $_SESSION['user']=$user['user'];
            $_SESSION['email']=$user['email'];
            
            header('Location: home.php');
            return true;
            exit;
        } else {
            // The user or password is incorrect
            return "The email or password is incorrect";
        }
        
            
    }

    
}
?>