<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - Contact form</title>
    <link rel="stylesheet" href="php.css">
</head>
<body>
    
    <a href="index.html">Back to contact page</a>

<?php
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email  = $_POST['email'];
    $message = $_POST['message'];

    $conn = new mysqli('localhost', 'root', '', 'customerdb');

    $firstName = filter_input(INPUT_POST, "firstName", FILTER_SANITIZE_SPECIAL_CHARS);

    $lastName = filter_input(INPUT_POST, "lastName", FILTER_SANITIZE_SPECIAL_CHARS);

    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);

    $message = filter_input(INPUT_POST, "message", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($firstName)) {
        echo '<p class="p-empty">Please enter your first name.</p>';
        exit;
    }

    elseif (empty($lastName)) {
        echo '<p class="p-empty">Please enter your last name.</p>';
        exit;
    }

    elseif (empty($email)) {
        echo '<p class="p-empty">Please enter your email.</p>';
        exit;
    }

    // Database connection
    if ($conn->connect_error) {

        die ('Connection Failed : '.$conn->connect_error);
    } else {
        $stmt = $conn->prepare("INSERT INTO contact (firstName, lastName, email, message) values(?, ?, ?, ?)");
        $stmt->bind_param("ssss", $firstName, $lastName, $email, $message);
        $stmt->execute();
        echo '<p class="p-sucess">Your message has been sent</p>';
        $stmt->close();
        $conn->close();
    }
?>
</body>
</html>