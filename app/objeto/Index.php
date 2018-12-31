<?php

/**
 * @primary index_id
 * @table index
 */
class Index extends AbstractObjeto {

    private $indexId;
    private $indexNome;

    public function __construct($dados = null) {

        if (!empty($dados)) {
            $this->setData($dados);
        }
    }

    function getIndexId() {
        return $this->indexId;
    }

    function getIndexNome() {
        return $this->indexNome;
    }

    function setIndexId($indexId) {
        $this->indexId = $indexId;
    }

    function setIndexNome($indexNome) {
        $this->indexNome = $indexNome;
    }

}
