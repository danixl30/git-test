<?php
    session_start();

    if (isset($_SESSION['user_id'])) {
      header('Location: /home.php');
    }
    
    require 'database.php';

    $message = "";
    
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
      $records = $conn->prepare('SELECT id, email, password FROM users WHERE email = :email');
      $records->bindParam(':email', $_POST['email']);
      $records->execute();
      $results = $records->fetch(PDO::FETCH_ASSOC);

      $Password_very = hash('sha256', $_POST['password']);
      
  
      if (count($results) > 0 && $Password_very == $results['password']) {
        $_SESSION['user_id'] = $results['id'];
        header("Location: home.php");        
      } else {
        $message = 'Sorry, those credentials do not match';
      }
    }
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <h3>Insert your Credentials</h3>
    <span>Or <a href="signup.php">SignUp</a></span>

    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

    <form action="login.php" method="POST">
      <input name="email" type="text" placeholder="Enter your email">
      <input name="password" type="password" placeholder="Enter your Password">
      <input type="submit" value="Submit">
    </form>
</body>
</html>