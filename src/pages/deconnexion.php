<?php
session_start();
session_destroy();

echo "<script>window.location.replace('./connexion.php');</script>";