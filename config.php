<?php
session_start();

require_once __DIR__ . '/supabase.php';
require_once __DIR__ . '/class/SupabaseClient.php';

function supabase(bool $useServiceRole = true): SupabaseClient {
    return new SupabaseClient($useServiceRole);
}

function db(): SupabaseClient {
    return supabase(true);
}

function esta_logado() {
    return isset($_SESSION['user_id']);
}

function eh_admin() {
    return isset($_SESSION['user_tipo']) && $_SESSION['user_tipo'] === '1';
}

function requer_admin() {
    if (!esta_logado()) {
        header("Location: login.php");
        exit;
    }
    if (!eh_admin()) {
        die("Acesso negado. Apenas administradores podem aceder a esta página.");
    }
}
