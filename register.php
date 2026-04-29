<?php 
 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);
 
 include_once 'User.php';
 include_once 'Database.php';

   $error_message = '';
   
   if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
    try {
        $db = new Database();
        $conn = $db->getConnection();
        $user = new User($conn);

        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $dateofbirth = isset($_POST['dateofbirth']) ? $_POST['dateofbirth'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        if (empty($username) || empty($email) || empty($password)) {
            $error_message = "Please fill in all required fields.";
        } else {
            if ($user->register($username, $email, $password)) {
                header('Location: login.php');
                exit();
            } else {
                $error_message = "Registration failed. Please try again. Check if the users table exists.";
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
    <link rel="stylesheet" href="register.css">
    <title>Register</title>
</head>
<body>
    <button id="button-exit" onclick="location.href='index.php'">X</button>
    <div class="Register-div">
        <div class="register-form">
            <h1 id="h1">Register</h1>
            <?php if (!empty($error_message)): ?>
                <div style="color: red; margin-bottom: 10px; padding: 10px; background: #ffe6e6; border: 1px solid red; border-radius: 5px;">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
            <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
                <div style="color: blue; margin-bottom: 10px; padding: 10px; background: #e6f3ff; border: 1px solid blue; border-radius: 5px;">
                    <strong>Debug:</strong> Form was submitted. POST data received.
                </div>
            <?php endif; ?>
            <form id="register-form" method="POST" action="">
                <input type="text" name="username" placeholder="username" id="username">
                <br>
                <input type="email" name="email" placeholder="Email" id="email">
                <br>
                <input type="date" name="dateofbirth" placeholder="Date Of Birth" id="dateofbirth">
                <br>
                <input type="password" name="password" placeholder="Password" id="password">
                <br>
                <input type="password" placeholder="Confirm Password" id="passwordconfirm">
                <br>
                <button id="Register-button" type="submit">Register</button>
            </form>
        </div>
    </div>
    <script src="register.js"></script>
</body>
</html>