<?php
declare(strict_types=1);

session_start();

unset($_SESSION['cart']);

header('Location: index.php');
exit;