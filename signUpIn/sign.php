<?php
$successMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include 'connect.php';

  // Retrieve form data
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Check if email already exists in the database
  $checkEmailQuery = "SELECT * FROM registration WHERE email='$email'";
  $result = mysqli_query($con, $checkEmailQuery);

  if (mysqli_num_rows($result) > 0) {
    // Email already exists
    $successMessage = "Email Already Exists...";
  } else {
    // Insert new record
    $sql = "INSERT INTO registration (name, email, password) VALUES ('$name', '$email', '$password')";
    $insertResult = mysqli_query($con, $sql);

    if ($insertResult) {
      // Set success message
      $successMessage = "Data inserted successfully";

      // Optionally redirect to the same page to clear form data
      header("Location: sign.php?success=true");
      exit();
    } else {
      die(mysqli_error($con));
    }
  }
}

// If redirected with success, show the message
if (isset($_GET['success'])) {
  $successMessage = "Data inserted successfully";
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="container" style="max-width: 600px;">
      <h2 class="my-4 text-center">Sign Up</h2>

      <!-- Display success message if it exists -->
      <?php if ($successMessage): ?>
        <div id="success-message" class="alert alert-success" role="alert">
          <?php echo $successMessage; ?>
        </div>

        <!-- JavaScript to delay redirection after 5 seconds -->
        <script>
          setTimeout(function() {
            window.location.href = 'sign.php'; // Redirect to sign.php after 5 seconds
          }, 5000); // 5000 milliseconds = 5 seconds
        </script>
      <?php endif; ?>

      <form action="sign.php" method="post">
        <div class="mb-3">
          <label for="name" class="form-label">Name:</label>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email:</label>
          <input type="email" class="form-control" id="email" name="email" required>
          <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password:</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Sign Up</button>
      </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-wIYHlrqNp0mv1wB1aTbWxqfXlyc3d6dq8IH8V3nbbqeC1G/+GEu5zVfnzAOQ6w1Y" crossorigin="anonymous"></script>
    
    <!-- JavaScript to hide the success message after 5 seconds -->
    <script>
      setTimeout(function() {
        var successMessage = document.getElementById('success-message');
        if (successMessage) {
          successMessage.style.display = 'none';
        }
      }, 5000); // 5000 milliseconds = 5 seconds
    </script>
  </body>
</html>
