<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require "{$root}/Toni-Tok/HTML/partials/icon.php" ?>
    <title>Toni-Tok</title>
    <style>
        <?php
        $root = $_SERVER['DOCUMENT_ROOT'];
        require("{$root}/Toni-Tok/CSS/main.css"); 
        require("{$root}/Toni-Tok/CSS/form.css"); 
        
        ?>
    </style>
</head>
<body>

    <?php require('partials/navigation.php'); ?> 

    <form action="<?= "/Toni-Tok/controllers/signUpFormSubmition.php" ?>" id='signUpForm' method='POST' enctype="multipart/form-data">
        <label for='username'>Username:</label><br>
        <input type='text' name='username' id='username' autocomplete="off"><br>
        <label for='email'>email:</label><br>
        <input type='text' name='email' id='email' autocomplete="off"><br>
        <label for='password'>Password:</label><br>
        <div id="passwordGroup">
            <input type='password' name='password' id='password' autocomplete="off">
            <button type="button" id="togglePassword"></button><br>
        </div>
        <label for='password' id='passwordInstruction'>The password must contain at least 8 characters</label><br><br>
        <label for='password'>Profile picture:</label><br>
        <input type="file" id="imageInput" name="imageInput" accept="image/*" onchange="displaySelectedImage(event)">
        <div class="selected-image" id="selectedImageContainer">
            <img id="selectedImage">
        </div>
        <input type='submit' id='postSubmit' value='Sign up'><br>
        <center><a id='logInLink' href='/Toni-Tok/controllers/logIn.php'>Oh you already have an account? Click here to log-in.</a></center><br><br>
    </form>

    <script><?php require("{$root}/Toni-Tok/JS/profilePic.js"); require("{$root}/Toni-Tok/JS/showPassword.js")?></script>

</body>
</html>