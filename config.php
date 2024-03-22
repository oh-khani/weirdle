<?php
session_start();
$_SESSION['pathRac'] = "../..";
$_SESSION['pathSrc'] = '../..';
$_SESSION['pathPges'] = '../pages';
$_SESSION['pathAssets'] = '../assets';

define('PATH_RAC', $_SESSION['pathRac']);
define('PATH_SRC', $_SESSION['pathSrc']);
define('PATH_ASSETS', $_SESSION['pathAssets']);