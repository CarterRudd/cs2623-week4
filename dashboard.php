<?php
declare(strict_types=1);

require 'auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>

<h1>
    Welcome,
    <?= htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8') ?>
</h1>

<p>
    Logged in at:
    <?= date('g:i A', $_SESSION['login_at']) ?>
</p>

<p><a href="profile.php">Profile</a></p>
<p><a href="logout.php">Logout</a></p>

</body>
</html>