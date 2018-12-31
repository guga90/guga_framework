<?php

class Router {

    private $_arrUriParam;
    private $_strUriParam;
    private $_strUri;

    public function defineRouter() {

        $this->_strUri = $_SERVER['REQUEST_URI'];
                
        $strBaseUrl = str_replace('/index.php', '', $_SERVER["SCRIPT_NAME"]);
        $this->_strUriParam = str_replace($strBaseUrl, '', $_SERVER["REQUEST_URI"]);
        $this->_arrUriParam = explode('/', $this->_strUriParam);

        $this->callMethodController();
    }

    private function callMethodController() {

        Guga_Auth::setControleAtual($this->getController());
        Guga_Auth::setActionAtual($this->getAction());
        Guga_Auth::verificarLogin();
        Guga_Auth::verificarPermissaoControle();
        
        $classReflection = new ReflectionClass($this->getController());
        $classReflection->newInstance(array('controle' => $this->getController(),
            'action' => $this->getAction(),
            'params' => $this->getParams(),
        ));
    }
    
    private function lcfirst($str) {
        $str[0] = strtolower($str[0]);
        return $str;
    }

    private function getController() {
        return ucwords(empty($this->_arrUriParam[1]) ? 'Index' : $this->_arrUriParam[1]) . 'Controle';
    }

    private function toCamelCase($string) {
        $string = ucwords(strtolower($string));
        $string = implode('', array_map('ucfirst', explode('-', $string)));

        return $this->lcfirst($string);
    }

    private function getAction() {
      
        $arrActions = get_class_methods($this->getController());
        
        $action = $this->toCamelCase(empty($this->_arrUriParam[2]) ? 'index' : $this->_arrUriParam[2]);

        if (empty($action) || !in_array(($action . 'Action'), $arrActions)) {
            return 'index';
        } else {
            return $action;
        }
    }

    private function getParams() {

        $arrParam = array();
        if ($_POST) {
            $arrParam = $_POST;
        } else {
            
            $strParametros = str_replace($this->getAction() . '/', '', substr($this->_strUriParam, strrpos($this->_strUriParam, $this->getAction())));
            $arrParamentros = explode('/', $strParametros);

            $index = '';
            foreach ($arrParamentros as $key => $param) {
                if ($key % 2) {
                    $arrParam[$index] = $param;
                } else {
                    $index = $param;
                }
            }
        }
        return $arrParam;
    }

}
