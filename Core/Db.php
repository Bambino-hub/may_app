<?php

namespace App\Core;

use PDO;
use PDOException;

class Db extends PDO
{
    // instance unique de la classe
    private static $instance;

    // les information lors de la connexion
    private const DHOST = "localhost";
    private const DBNAME = "my_app";
    private const DBUSER = "root";
    private const DBPASS = "";

    /**
     * constructeur qui nous permet de faire la connexion a la base de donnée
     */
    private function __construct()
    {
        // créeons notre dsn ( data source name)
        $dsn = 'mysql:host=' . self::DHOST . ';dbname=' . self::DBNAME;

        // on passe les information au constructeur de PPDO
        parent::__construct($dsn, self::DBUSER, self::DBPASS);

        try {
            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die('erreur:' . $e->getMessage());
        }
    }

    /**
     * fonction qui retourne l'instance de la connexion a la base de donnée
     *
     * @return Db
     */
    public static function getInstance(): Db
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
