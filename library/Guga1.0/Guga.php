<?php

require 'ConnectionDb.php';
require 'Bootstrap.php';
require 'Router.php';
require 'Guga_Debug.php';
require 'Guga_Date.php';
require 'Guga_Auth.php';
require 'Guga_Util.php';
require 'Guga_AutoLoad.php';
require 'AbstractControle.php';
require 'AbstractObjeto.php';
require 'AbstractPersistencia.php';
require 'ExceptionAlerta.php';

class Guga {

    public function __construct() {

        $this->startAutoLoad();
        $this->startBootstrap();
        $this->startRouter();
    }

    public function startBootstrap() {

        $arrMethods = get_class_methods('Bootstrap');
        $classReflection = new ReflectionClass('Bootstrap');
        $booststrap = $classReflection->newInstance();
        foreach ($arrMethods as $method) {
            if (strpos($method, 'init') !== false) {

                $method = new ReflectionMethod($booststrap, $method);
                $method->invoke($booststrap);

            }
        }
    }

    public function startRouter() {

        $router = new Router();
        $router->defineRouter();
    }

    public function startAutoLoad() {

        $autoLoad = new Guga_AutoLoad();
        $autoLoad->loadFiles();
    }

}
