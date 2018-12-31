<?php

class ConnectionBd {

    private static $_instance = null;
    public $conn;

    private function __construct() {

        try {

            $dadosConn = parse_ini_file('configs/geral.ini');
            $this->conn = new PDO('mysql:host=' . $dadosConn['bd.servername'] . ';dbname=' . $dadosConn['bd.database'], $dadosConn['bd.username'], $dadosConn['bd.password']);

            if (!$this->conn) {
                die('Nao foi possível conectar ao banco de dados');
            }

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            
        } catch (PDOException $e) {
            throw new $e;
        }
    }

    public function __destruct() {
        $this->conn = null;
    }

    public static function getInstance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new ConnectionBd();
        }
        return self::$_instance;
    }

}
