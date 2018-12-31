<?php

abstract class AbstractControle {

    protected $setNoRender = false;
    protected $baseUrl;
    protected $layout = 'default';
    private $_controle;
    private $_action;
    private $_conteudo = '';

    public function __construct($param) {

        $this->baseUrl = Guga_Auth::getBaseUrl();
        
        $this->_controleNome = strtolower(str_replace('Controle', '', $param['controle']));
        $this->_controle = $param['controle'];
        $this->_action = $param['action'];

        $this->init();

        $reflectionMethod = new ReflectionMethod($param['controle'], $param['action'] . 'Action');
        $reflectionMethod->invoke($this, $param['params']);

        //Chama a action
        //call_user_func_array(array($param['controle'], $param['action'] . 'Action'), $param['params']);
        //Renderiza a view
        $this->renderView($param['controle'], $param['action']);
        if (!$this->setNoRender) {
            $this->renderView();
            $this->setLayout();
        }
    }

    private function setLayout() {
        require_once ('app/layouts/' . $this->layout . '.php');
    }

    public function renderView() {

        $arquivo = $this->lcfirst('app/visao/' . str_replace('Controle', '', $this->lcfirst($this->_controle))) . '/' . $this->lcfirst($this->_action) . '.php';

        //Só renderiza a view se existir
        if (file_exists($arquivo)) {
            $this->_conteudo = $arquivo;
        }
    }
    
    private function lcfirst($str) {
        $str[0] = strtolower($str[0]);
        return $str;
    }

}
