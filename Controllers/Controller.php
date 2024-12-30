<?php

namespace App\Controllers;

abstract class Controller
{
    public function render(string $file, array $data = [])
    {
        // on extrait les données
        extract($data);

        ob_start();

        require_once ROOT . '/Views/' . $file;

        $content = ob_get_clean();

        require_once ROOT . '/Views/default.php';
    }
}
