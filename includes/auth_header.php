<?php
// auth_header.php - para páginas de login/registo (redireciona se logado)
require_once __DIR__ . '/../config.php';
if (esta_logado()) {
    header("Location: index.php");
    exit;
}
$page_title = $page_title ?? 'Mundial 2026';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($page_title) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Advent+Pro:wght@400;700&family=VT323&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="forms.css">
    <link rel="stylesheet" href="typography.css">
    <link rel="stylesheet" href="components.css">
</head>
<body>
    <section class="cyberpunk black both">