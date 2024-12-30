<?php

namespace App\Core;

use App\Controllers\MainController;

class Main
{
    /**
     * le controller principal
     *
     * @return void
     */
    public function start()
    {
        // on recupère l'url 
        $uri = $_SERVER['REQUEST_URI'];

        // on verifie si l'url n'est pas vide ou se termine par un
        if (!empty($uri) && $uri != '/' && $uri[-1] === "/") {
            $uri = substr($uri, 0, -1);

            // on fait une redirection 301
            http_response_code(301);

            // on rediririge vers url sans /
            header('Location:' . $uri);
        }

        // on reccupere les paramètre de l'url sous forme d'un tableau avec la methode explode
        $params = explode('/', $_GET['p']);
        // var_dump($params);
        // die;
        // on verifie si on a au moins un paramètre
        if ($params[0] != '') {

            // on recupère le controlleur a extensier
            $controller = '\\App\\Controllers\\' . ucfirst(array_shift($params)) . 'Controller';
            // on instancie le controlleur
            $controller = new $controller();

            // on recupère le deuxieme paramètre qui est la methode 
            $action = (isset($params[0])) ? array_shift($params) : 'index';

            // on verifie si la méthode exite dans le controller
            if (method_exists($controller, $action)) {
                //on verifie s'il reste de paramètre allors on le passe la methode
                (isset($params[0])) ? call_user_func_array([$controller, $action], $params) : $controller->$action();
            } else {
                http_response_code(404);
                echo 'La page recherchée n\'existe pas';
            }
        } else {
            $mains = new MainController();
            $mains->index();
        }
    }
}
