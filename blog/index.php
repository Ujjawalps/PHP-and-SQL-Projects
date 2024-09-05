<?php
// Include the database connection file
include 'includes/db.php';

// Fetch posts from the database
$query = "SELECT posts.*, users.username FROM posts 
          JOIN users ON posts.author_id = users.id 
          ORDER BY posts.created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Homepage</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <h1>Latest Blog Posts</h1>
        <?php while ($post = mysqli_fetch_assoc($result)): ?>
            <div class="post">
                <h2><a href="post.php?id=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a></h2>
                <p>by <?php echo $post['username']; ?> on <?php echo date('F j, Y', strtotime($post['created_at'])); ?></p>
                <p><?php echo substr($post['content'], 0, 100) . '...'; ?></p>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
