<?php

abstract class AbstractObjeto {

    public function setData($options) {
        if (!empty($options)) {
            $methods = get_class_methods($this);

            foreach ($options as $key => $value) {
                $method = 'set' . $this->_toCamelCase($key);
                if (in_array($method, $methods)) {
                    $this->$method($value == '' ? null : $value);
                }
            }
        }
    }

    protected function _toProperty($camelcase) {
        return '_' . strtolower(implode('_', $camelcase));
    }

    protected function _toCamelCase($property) {
        $property = preg_replace('/^_/', '', $property);
        $pieces = explode('_', $property);

        $property = '';
        foreach ($pieces as $piece) {
            $property .= ucfirst($piece);
        }

        return $property;
    }

    public function toArray(array $ignore = null) {

        $reflect = new ReflectionClass($this);

        $props = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);

        $attributes = array();

        foreach ($props as $prop) {

            $name = $prop->getName();

            //Muda os nomes dos atributos
            $key = '';
            for ($i = 0; $i < strlen($name); $i++) {
                if (ctype_upper($name[$i])) {
                    $key .= '_' . strtolower($name[$i]);
                } else {
                    $key .= $name[$i];
                }
            }

            if (!empty($ignore)) {
                if (in_array($key, $ignore)) {
                    continue;
                }
            }

            $method = 'get' . $this->_toCamelCase($key);

            $valor = $this->$method();

            if (!is_null($valor)){
                $attributes[$key] = $valor;
            }
        }

        return $attributes;
    }

    public function getDataHora() {
        return date('yyyy-MM-dd HH:mm:ss');
    }

}
