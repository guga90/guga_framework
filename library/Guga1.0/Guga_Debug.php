<?php

class Guga_Debug {

    public static function dump($data) {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }

}
