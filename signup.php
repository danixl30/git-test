<?php
  require "database.php";

  $message1 = '';
  $message2 = '';
  $message3 = '';  

  if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['email']) && !empty($_POST['confirm_password'])) {
    if ($_POST['password'] == $_POST['confirm_password']){
      $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':username', $_POST['username']);
      $stmt->bindParam(':email', $_POST['email']);
      $passwordcrypt = hash('sha256', $_POST['password']);
      $stmt->bindParam(':password', $passwordcrypt);

      if ($stmt->execute()) {
        $message1 = 'Successfully created new user';
      } else {
        $message1 = 'Sorry there must have been an issue creating your account';
      }
    }else{
      $message3 = 'The passwords are not the same';
    }    
  }else{
    $message2 = 'The boxes are empty';
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
</head>
<body>
    <h1>SignUp</h1>
    <h3>Credentials</h3>

    <?php if(!empty($message1)): ?>
      <p> <?= $message1 ?></p>
    <?php endif; ?>

    <form action="signup.php" method="POST">

    <?php if(!empty($message2)): ?>
      <p> <?= $message2 ?></p>
    <?php endif; ?>

      <input name="username" type="text" placeholder="Please enter your Username"><br>
      <input name="email" type="text" placeholder="Please enter your email"><br>
      <input name="password" type="password" placeholder="Enter your Password"><br>
      <input name="confirm_password" type="password" placeholder="Confirm your Password"><br>
      
      <?php if(!empty($message3)): ?>
      <p> <?= $message3 ?></p>
    <?php endif; ?>

      <input type="submit" value="Submit"><br>
    </form>
</body>
</html>