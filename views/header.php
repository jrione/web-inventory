<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= BASE_URL_PUBLIC ?>assets/style.css">
</head>
<header>
    <nav class="navbar">
        <div class="container-nav">
            <a href="#" class="navbar-brand"><?= $title ?></a>
            <button class="navbar-toggle" id="navbarToggle">&#9776;</button>
            <div class="navbar-links" id="navbarLinks">
                <a id="homeToggle" href="index.html">Login</a>
                <a id="certToggle" href="certs.html">Register</a>
            </div>
        </div>
    </nav>
</header>