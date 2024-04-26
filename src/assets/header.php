<?php require_once 'BDD.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
        session_start();
        if ($_SERVER['REQUEST_URI'] === "/~p2301285/weirdle/") {
            $style = "src/style.css";
        } else {
            $style = "../style.css";
        }
    ?>
    <link rel="stylesheet" href=<?= $style; ?>>
    <title>Weirdle</title>
</head>
<body>
    <header>
        <a id="titre" href="/~p2301285/weirdle/"><h1>Weirdle</h1></a>
    </header>
    <?php
    require_once 'navbar.php';