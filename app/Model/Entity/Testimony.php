<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Testimony
{
    /**
     * ID do depoimentos
     * @var integer
     */

    public $id;

    /**
     * Nome do usuário que fez o depoimento
     *@var string
     */

    public $nome;

    /**
     * Mensagem do depoimentos
     * @var string
     */

    public $mensagem;

    /**
     * Data de publicação do depoimentos
     * @var string
     */
    public $data;

    /**
     * Método responsável por cadastrar a instancia atual no banco de addos
     * @return boolean
     */
    public function cadastrar()
    {
        //DEFINE A DATA
        $this->data = date('Y-m-d H:i:s');

        //INSERE O DEPOIMENTOS NO BANCO DE DADOS
        $this->id = (new Database('depoimentos'))->insert([
            'nome'      => $this->nome,
            'mensagem'  => $this->mensagem,
            'data'      => $this->data
        ]);

        //SUCESSO
        return true;
    }

    /**
     * Método responsável por retornar os Depoimentos
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getTestimonies($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('depoimentos')) ->select($where,$order,$limit,$fields);
    }
}
