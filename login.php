<?php 
  session_start();
    include_once 'User.php';
    include_once 'Database.php';
  
    $error_message = '';
  
    if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
     try {
         $db = new Database();
         $conn = $db->getConnection();
         $user = new User($conn);
     
         $email = isset($_POST['email']) ? $_POST['email'] : '';
         $password = isset($_POST['password']) ? $_POST['password'] : '';
     
         if (empty($email) || empty($password)) {
             $error_message = "Please fill in all fields.";
         } else {
             if ($user->login($email, $password)) {
                 header('Location: index.php');
                 exit();
             } else {
                 $error_message = "Login failed. Please check your credentials.";
             }
         }
     } catch (Exception $e) {
         $error_message = "Error: " . $e->getMessage();
     }
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>login</title>
</head>
<body >
       <button  id="button-exit" onclick="location.href='index.php'" >x</button>
    <div class="Login-div">
    <div class="login-form">
    <h1 id="h1"> Login</h1>
   
    <form id="login-form" method="POST" action="">
        <input type="email" name="email" placeholder="Email" id="email" required>
        <br>
        <input type="password" name="password" placeholder="Password" id="password" required>
        <br>
        <button id="Login-button" type="submit">Login</button>
    </form>
    </div>
    </div>
</body>
</html>