<?php

class Guga_Auth {

    public static $controleAtual;
    public static $actionAtual;

    public static function getBaseUrl() {
        return str_replace('/index.php' , '', $_SERVER["SCRIPT_NAME"]);
    }

    public static function getControlesPermissao() {
        return empty($_SESSION['permission']) ? array() : $_SESSION['permission'];
    }

    public static function setControlesPermissao($controles) {
        $_SESSION['permission'] = $controles;
    }

    public static function getControleAtual() {
        return self::$controleAtual;
    }

    public static function setControleAtual($controleAtual) {
        self::$controleAtual = $controleAtual;
    }

    public static function getActionAtual() {
        return self::$actionAtual;
    }

    public static function setActionAtual($actionAtual) {
        self::$actionAtual = $actionAtual;
    }

    public static function getUsuario() {
        return empty($_SESSION["usuario"]) ? null : $_SESSION["usuario"];
    }

    public static function setUsuario($usuario) {
        $_SESSION["usuario"] = $usuario;
    }

    public static function verificarLogin() {

        $controleAtual = str_replace('controle', '', strtolower(self::$controleAtual));

        /*if (self::getUsuario()) {
            if ($controleAtual == 'login') {
                header('Location:' . self::getBaseUrl() . '/index/index');
            }
        } else {
            if ($controleAtual !== 'login') {
                header('Location:' . self::getBaseUrl() . '/login/index');
            }
        }*/
    }

    public static function verificarPermissaoControle() {

       /* $controleAtual = str_replace('controle', '', strtolower(self::$controleAtual));

        if ($controleAtual != 'login' && $controleAtual != 'error' && $controleAtual != 'index') {
            if (!in_array($controleAtual, self::getControlesPermissao())) {
                header('Location:' . self::getBaseUrl() . '/error/permisao');
            }
        }*/
    }

}
