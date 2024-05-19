<?php
require_once 'src/load.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinemate - Your mate to find best Movies, TV Shows, and Celebse</title>
    <link rel="apple-touch-icon" href="./assets/cinimate-logo.webp">
    <link rel="icon" type="image/png" href="./assets/cinimate-logo.webp">
    <!-- Own Custom CSS -->
    <link rel="stylesheet" href="./css/app.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <? loadTemplate('header'); ?>
    <div class="container main-container">
        <?php loadTemplate('/movies/movies'); ?>
        <?php loadTemplate('/episodes/episodes'); ?>
        <?php loadTemplate('/cast/casts'); ?>
    </div>
    <? loadTemplate('footer'); ?>
    <script src="./js/app.js"></script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script> <!-- Masonry CDN -->
    <!-- Fontawesome -->
    <script src="https://kit.fontawesome.com/7990384401.js" crossorigin="anonymous"></script>
    <!-- Masonry -->
    <!-- <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script> -->
</body>

</html>