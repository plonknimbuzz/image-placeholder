<?php
require_once('../ImagePlaceholder.php');
require_once('config.php');

$a = new ImagePlaceholder($config);
$p = isset($_GET['p']) ? $_GET['p']:'';
$a->parseRequest($p)->draw();
