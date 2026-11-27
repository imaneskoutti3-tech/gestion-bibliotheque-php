<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Couleurs globales partagées
define('COLOR_PRIMARY', '#6b1d2f');   // Grenat / Bourgogne
define('COLOR_SECONDARY', '#4a2c2a'); // Marron Foncé
define('COLOR_ACCENT', '#d9a752');    // Doré léger pour le contraste

function inject_custom_css() {
    echo '
    <style>
        :root {
            --grenat: '.COLOR_PRIMARY.';
            --marron: '.COLOR_SECONDARY.';
            --accent: '.COLOR_ACCENT.';
        }
        body { background-color: #fcf9f5; color: #333; }
        .bg-grenat { background-color: var(--grenat) !important; color: white !important; }
        .bg-marron { background-color: var(--marron) !important; color: white !important; }
        .text-grenat { color: var(--grenat) !important; }
        .text-marron { color: var(--marron) !important; }
        .btn-grenat { background-color: var(--grenat); color: white; border: none; }
        .btn-grenat:hover { background-color: #521523; color: white; }
        .btn-marron { background-color: var(--marron); color: white; border: none; }
        .btn-marron:hover { background-color: #382120; color: white; }
        .card-custom { border-top: 4px solid var(--grenat); box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .navbar-custom { background-color: var(--marron); border-bottom: 3px solid var(--grenat); }
    </style>
    ';
}
?>