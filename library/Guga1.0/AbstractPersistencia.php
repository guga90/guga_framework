<?php

abstract class AbstractPersistencia {

    protected $_session;
    protected $_PDO;

    public function __construct() {
        $this->session = $_SESSION;
        $this->_PDO = ConnectionBd::getInstance()->conn;
    }

    private function getPhpDoc($obj) {

        $rc = new ReflectionClass(get_class($obj));
        $str = $rc->getDocComment();
        if (preg_match_all('/@(\w+)\s+(.*)\r?\n/m', $str, $matches)) {
            $result = array_combine($matches[1], $matches[2]);
        }

        $result = array_map('trim', $result);

        return $result;
    }

    public function persistir($obj) {

        try {

            $doc = $this->getPhpDoc($obj);
            $dados = $obj->toArray();

            $sql = '';

            //Update
            if (!empty($dados[$doc['primary']])) {

                $sql .= 'update ' . $doc['table'] . ' set ';
                $campos = '';
                foreach ($dados as $campo => $valor) {
                    $campos[] = ($campo . ' = ' . (is_numeric($valor) ? $valor : ("'" . $valor . "'")));
                }

                $sql .= implode(',', $campos) . ' where ' . $doc['primary'] . ' = ' . $dados[$doc['primary']];
            } else {

                $sql .= 'insert into ' . $doc['table'] . ' (';
                $campos = '';
                $valores = '';
                foreach ($dados as $campo => $valor) {
                    $campos[] = $campo;
                    $valores[] = is_numeric($valor) ? $valor : ("'" . $valor . "'");
                }

                $sql .= implode(',', $campos) . ') values (';
                $sql .= implode(',', $valores) . ')';
            }

            $stmt = $this->_PDO->prepare($sql);
            $stmt->execute();
        } catch (Exception $e) {
            Guga_Debug::dump($e);
            exit;
        }
    }

    /**
     * 
     * @param type $obj
     * @return boolean
     */
    protected function validar($obj) {
        return true;
    }

    /**
     * 
     * @param type $obj
     * @return type
     */
    protected function tratarDados($obj) {
        return $obj;
    }

    /**
     * Converte campos para camelcase
     * @param type string
     * @return string
     */
    protected function _toCamelCase($property) {
        $property = preg_replace('/^_/', '', $property);
        $pieces = explode('_', $property);

        $property = '';
        foreach ($pieces as $piece) {
            $property .= ucfirst($piece);
        }

        return $property;
    }

    /**
     * Consulta um unico registro
     * @param int $id
     * @param string $db
     * @return object
     */
    public function consultar($obj, $id) {

        $doc = $this->getPhpDoc($obj);

        $stmt = $this->_PDO->prepare('select * from ' . $doc['table'] . ' where ' . $doc['primary'] . ' = ' . $id);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result) {
            $class = get_class($obj);
            return new $class($result);
        }
        return array();
    }

    public function fetchRow($sql, $obj = null) {

        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result && !empty($obj)) {
            $class = get_class($obj);
            return new $class($result);
        }

        return $result;
    }

    public function fetchAll($sql, $obj = null) {

        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        if (!empty($obj) && !empty($results)) {
            $arrResult = array();
            foreach ($results as $result) {
                $class = get_class($obj);
                $arrResult[] = new $class($result);
            }
            return $arrResult;
        }

        return $results;
    }

    /**
     * Lista todos dados da tabela
     * @param string $db
     * @return array object
     */
    public function listar($obj) {

        $doc = $this->getPhpDoc($obj);

        $stmt = $this->_PDO->prepare('select * from ' . $doc['table']);
        $stmt->execute();
        $results = $stmt->fetchAll();

        $arrResult = array();
        foreach ($results as $result) {
            $class = get_class($obj);
            $arrResult[] = new $class($result);
        }

        return $arrResult;
    }

    /**
     * Deleta um unico registro
     * @param int $id
     * @param string $db
     * @return int
     */
    public function deletar($id) {
        $arrPrimary = $this->_dbTable->info('primary');
        $where = (current($arrPrimary) . ' = ' . $id);
        return $this->_dbTable->delete($where);
    }

}
