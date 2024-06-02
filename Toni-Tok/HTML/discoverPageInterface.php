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
        require("{$root}/Toni-Tok/CSS/errors.css"); 
        ?>
    </style>
</head>
<body>

    <?php

    require('partials/navigation.php');?>

    <center>
    <div id='searchContainer'>
        <input id='searchInput' type='text' autocomplete='off'>
        <input type="submit" id='searchButton' value=''>
    </div>
    </center>

    <?php require('partials/selectVideo.php');

    ?>

    <script>
        let searchButton = document.querySelector('#searchButton');
        let searchInput = document.querySelector('#searchInput');

        searchButton.addEventListener('click', function(){
            let search = searchInput.value.trim();
            if(search !== ''){
                window.location.href = `/Toni-Tok/controllers/searchTitle.php?search=${search}`;
            } else {
                window.location.href = '/Toni-Tok/';
            }
        });
    </script>

</body>
</html>