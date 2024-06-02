<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $root = $_SERVER['DOCUMENT_ROOT']; require "{$root}/Toni-Tok/HTML/partials/icon.php" ?>
    <title>Toni-Tok</title>
    <style>
        <?php
        require("{$root}/Toni-Tok/CSS/errors.css"); 
        ?>
    </style>
</head>
<body>

<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require("{$root}/Toni-Tok/Database.php");
require("{$root}/Toni-Tok/HTML/partials/loginFunction.php");

$db = new Database();

$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];

$profile_picture = $_FILES['imageInput']['tmp_name'];
$profile_picture_data = file_get_contents($profile_picture);

$allUsers = $db->query("SELECT * FROM users WHERE usernames = :username", ['username' => $username]);
$allEmails = $db->query("SELECT * FROM users WHERE emails = :email", ['email' => $email]);

if ($allUsers->rowCount() > 0) {
    echo "<p id='formSubmitted' style='font-size: 4vw'>We are sorry but this username already exists!<br>Please choose another one.</p>";
    echo "<center><a href='/Toni-Tok/controllers/signUp.php'><button id='formGBbutton'>Go back</button></a></center>";
} elseif ($allEmails->rowCount() > 0) {
    echo "<p id='formSubmitted' style='font-size: 4vw'>We are sorry but this email already exists!<br>Please use another one.</p>";
    echo "<center><a href='/Toni-Tok/controllers/signUp.php'><button id='formGBbutton'>Go back</button></a></center>";
} elseif (strlen($password) < 8) {
    echo "<p id='formSubmitted' style='font-size: 4vw'>We are sorry but your password must be at least 8 characters long!</p>";
    echo "<center><a href='/Toni-Tok/controllers/signUp.php'><button id='formGBbutton'>Go back</button></a></center>";
} else {
    
    $db->query('INSERT INTO users (usernames, emails, passwords, profile_pictures) VALUES (:username, :email , :password, :profile_picture)', [
        'username' => $username,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_BCRYPT),
        'profile_picture' => $profile_picture_data
    ]);

    login($username);
}
?>

</body>
</html>
