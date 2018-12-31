<?php

class Guga_AutoLoad {

    public function loadFiles() {

        $mapeamentos = array(
            'app/controle',
            'app/objeto',
            'app/persistencia');

        foreach ($mapeamentos as $mapeamento) {

            $arquivos = array_diff(scandir($mapeamento), array('..', '.', '.svn'));
            foreach ($arquivos as $arquivo) {
                require $mapeamento . '/' . $arquivo;
            }
        }
    }

}
