<?php
session_start(); // Start the session to track user login status

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include 'connect.php';

  // Retrieve and sanitize form data
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  // Validate input
  if (empty($email) || empty($password)) {
    $errorMessage = "Both fields are required.";
  } else {
    // Prepare the SQL statement to prevent SQL injection
    $sql = "SELECT * FROM registration WHERE email = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();
      
      // Verify the password
      if (password_verify($password, $row['password'])) {
        // Password is correct, create session variables
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_email'] = $row['email'];

        // Redirect to the welcome page
        header("Location: welcome.php");
        exit();
      } else {
        $errorMessage = "Incorrect password.";
      }
    } else {
      $errorMessage = "Email not found.";
    }
  }
}
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
      .custom-container {
        max-width: 600px;
        margin: 0 auto;
      }
    </style>
  </head>
  <body>
    <div class="container mt-5 custom-container">
      <h2 class="my-4 text-center">Login</h2>

      <!-- Display success or error messages -->
      <?php if (isset($errorMessage)): ?>
        <div class="alert alert-danger" role="alert">
          <?php echo $errorMessage; ?>
        </div>
      <?php endif; ?>

      <form action="login.php" method="post">
        <div class="mb-3">
          <label for="email" class="form-label">Email:</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password:</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
      </form>
      <div class="mt-3">
        <p>Don't have an account? <a href="sign.php">Sign up here</a>.</p>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-wIYHlrqNp0mv1wB1aTbWxqfXlyc3d6dq8IH8V3nbbqeC1G/+GEu5zVfnzAOQ6w1Y" crossorigin="anonymous"></script>
  </body>
</html>
