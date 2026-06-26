<?php
// header.php - inclui config e abre HTML + <section class="cyberpunk black both">
require_once __DIR__ . '/../config.php';
$page_title = $page_title ?? 'Mundial 2026';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($page_title) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Advent+Pro:wght@400;700&family=VT323&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <section class="cyberpunk black both">