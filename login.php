<?php
declare(strict_types=1);

session_start();

$_SESSION['attempts'] ??= 0;
$_SESSION['attempts'] = 0;

$users = [
    'admin' => password_hash('secret123', PASSWORD_DEFAULT),
    'jsmith' => password_hash('php4life!', PASSWORD_DEFAULT)
];

$error = '';

if ($_SESSION['attempts'] >= 3) {
    $error = 'Account locked after 3 failed attempts.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && $_SESSION['attempts'] < 3) {

    $username =
        filter_input(
            INPUT_POST,
            'username',
            FILTER_SANITIZE_SPECIAL_CHARS
        ) ?? '';

    $password =
        filter_input(
            INPUT_POST,
            'password'
        ) ?? '';

    if (
        isset($users[$username]) &&
        password_verify($password, $users[$username])
    ) {

        session_regenerate_id(true);

        $_SESSION['user'] = $username;
        $_SESSION['login_at'] = time();
        $_SESSION['attempts'] = 0;

        if (isset($_POST['remember'])) {
            setcookie(
                'remember_user',
                $username,
                time() + (86400 * 30),
                '/'
            );
        }

        header('Location: dashboard.php');
        exit;
    } else {

        $_SESSION['attempts']++;

        $error =
            'Invalid username or password. Attempt ' .
            $_SESSION['attempts'] .
            ' of 3.';
    }
}

$savedUser = $_COOKIE['remember_user'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

<h1>Login</h1>

<?php if ($error): ?>
    <p>
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endif; ?>

<form method="post">

    <label>
        Username:
        <input
            type="text"
            name="username"
            value="<?= htmlspecialchars($savedUser, ENT_QUOTES, 'UTF-8') ?>">
    </label>

    <br><br>

    <label>
        Password:
        <input type="password" name="password">
    </label>

    <br><br>

    <label>
        <input type="checkbox" name="remember">
        Remember Me
    </label>

    <br><br>

    <button type="submit">Login</button>

</form>

</body>
</html>