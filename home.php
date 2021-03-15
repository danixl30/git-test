<?php
  session_start();

  require 'database.php';  

  $user = null;

  if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT id, username, email, password FROM users WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);    

    if (count($results) > 0) {
      $user = $results;
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
<?php if(empty($user)): ?>
      error
<?php else: ?>
    <br> Welcome. <?= $user['username']; ?>
    <br>You are Successfully Logged In
    <a href="logout.php">Logout</a>    
<?php endif; ?>
      
</body>
</html>