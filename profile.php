<?php
declare(strict_types=1);

require 'auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
</head>
<body>

<h1>Profile Page</h1>

<p>
    Logged in as:
    <?= htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8') ?>
</p>

<p><a href="dashboard.php">Dashboard</a></p>
<p><a href="logout.php">Logout</a></p>

</body>
</html>
