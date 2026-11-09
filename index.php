<?php
declare(strict_types=1);

class ValidationException extends RuntimeException {}
class FormatException extends ValidationException {}

$result = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = filter_input(
        INPUT_POST,
        'email',
        FILTER_SANITIZE_SPECIAL_CHARS
    ) ?? '';

    $website = filter_input(
        INPUT_POST,
        'website',
        FILTER_SANITIZE_SPECIAL_CHARS
    ) ?? '';

    $phone = filter_input(
        INPUT_POST,
        'phone',
        FILTER_SANITIZE_SPECIAL_CHARS
    ) ?? '';

    $zip = filter_input(
        INPUT_POST,
        'zip',
        FILTER_SANITIZE_SPECIAL_CHARS
    ) ?? '';

    $productCode = filter_input(
        INPUT_POST,
        'product_code',
        FILTER_SANITIZE_SPECIAL_CHARS
    ) ?? '';

    $message = filter_input(
        INPUT_POST,
        'message',
        FILTER_SANITIZE_SPECIAL_CHARS
    ) ?? '';

    try {

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException(
                'Invalid email address.'
            );
        }

        if (!filter_var($website, FILTER_VALIDATE_URL)) {
            throw new ValidationException(
                'Invalid website URL.'
            );
        }

        if (!preg_match(
            '/^\d{3}-\d{3}-\d{4}$/',
            $phone
        )) {
            throw new ValidationException(
                'Phone must be 555-555-5555 format.'
            );
        }

        if (!preg_match(
            '/^\d{5}(-\d{4})?$/',
            $zip
        )) {
            throw new ValidationException(
                'Invalid ZIP code.'
            );
        }

        if (!preg_match(
            '/^[A-Z]{2}\d{4}$/',
            $productCode
        )) {
            throw new FormatException(
                'Product code must contain two uppercase letters and four digits.'
            );
        }

        $result = [
            'email' => $email,
            'website' => $website,
            'phone' => $phone,
            'zip' => $zip,
            'product_code' => $productCode,
            'message' => $message
        ];

    } catch (FormatException $e) {

        $error = $e->getMessage();

    } catch (ValidationException $e) {

        $error = $e->getMessage();

    } finally {

        error_log(
            'Validation processed at ' .
            date('Y-m-d H:i:s')
        );
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exercise 15-1 Validation</title>
</head>
<body>

<h1>Contact Form Validation</h1>

<?php if ($error): ?>

<p>
    <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
</p>

<?php endif; ?>

<?php if ($result): ?>

<h2>Valid Data</h2>

<ul>

<li>
    Email:
    <?= htmlspecialchars($result['email'], ENT_QUOTES, 'UTF-8') ?>
</li>

<li>
    Website:
    <?= htmlspecialchars($result['website'], ENT_QUOTES, 'UTF-8') ?>
</li>

<li>
    Phone:
    <?= htmlspecialchars($result['phone'], ENT_QUOTES, 'UTF-8') ?>
</li>

<li>
    ZIP:
    <?= htmlspecialchars($result['zip'], ENT_QUOTES, 'UTF-8') ?>
</li>

<li>
    Product Code:
    <?= htmlspecialchars($result['product_code'], ENT_QUOTES, 'UTF-8') ?>
</li>

</ul>

<p>
<?= nl2br(
    htmlspecialchars(
        $result['message'],
        ENT_QUOTES,
        'UTF-8'
    )
) ?>
</p>

<?php endif; ?>

<form method="post">

<p>
    Email:
    <input type="text" name="email">
</p>

<p>
    Website:
    <input type="text" name="website">
</p>

<p>
    Phone:
    <input type="text" name="phone">
</p>

<p>
    ZIP:
    <input type="text" name="zip">
</p>

<p>
    Product Code:
    <input type="text" name="product_code">
</p>

<p>
    Message:
</p>

<textarea
    name="message"
    rows="5"
    cols="40"></textarea>

<br><br>

<button type="submit">
    Validate
</button>

</form>

</body>
</html>