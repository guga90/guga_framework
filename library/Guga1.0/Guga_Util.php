<?php

class Guga_Util {

    public function encodeArrayUTF8(&$arrayMaster, $encode = true) {
        //Verifica se elemento passado é um array
        if (is_array($arrayMaster)) {
            //Percorre cada posição do array chamando recursivamente o mesmo método
            foreach ($arrayMaster as $id => $elemento) {
                $arrayMaster[$id] = $this->encodeArrayUTF8($elemento, $encode);
            }
        } else {
            //Verifica se valor é string para Codificar
            if (is_string($arrayMaster))
            //Se elemento não for um array, codifica o valor pra UTF-8
                $arrayMaster = ($encode) ? utf8_encode($arrayMaster) : utf8_decode($arrayMaster);
        }
        //Retorna array ou valor convertido
        return $arrayMaster;
    }

    public function decodeArrayUTF8(&$arrayMaster, $encode = true) {
        //Verifica se elemento passado é um array
        if (is_array($arrayMaster)) {
            //Percorre cada posição do array chamando recursivamente o mesmo método
            foreach ($arrayMaster as $id => $elemento) {
                $arrayMaster[$id] = $this->decodeArrayUTF8($elemento, $encode);
            }
        } else {
            //Verifica se valor é string para Codificar
            if (is_string($arrayMaster))
            //Se elemento não for um array, codifica o valor pra UTF-8
                $arrayMaster = ($encode) ? utf8_decode($arrayMaster) : utf8_encode($arrayMaster);
        }
        //Retorna array ou valor convertido
        return $arrayMaster;
    }

}
