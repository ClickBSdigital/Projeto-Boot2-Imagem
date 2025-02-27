<?php

require './App/DB/Database.php';

class Produtos{

    public int $id_produtos;
    public string $nome;
    public string $descricao;
    public string $preco;
    public string $quantidade_em_estoque;
    public string $foto;

    public function cadastrar(){
        
        $db = new Database('produtos');
        $res = $db->insert(
                [
                    'nome' => $this->nome,
                    'descricao' => $this->descricao,
                    'preco' => $this->preco,
                    'quantidade_em_estoque' => $this->quantidade_em_estoque,
                    'foto' => $this->foto
                ]
            );
        return $res;
    }

    public function buscar($where=null,$order=null,$limit=null){
        $db = new Database('produtos');
        $res = $db->select($where,$order,$limit)->fetchAll(PDO::FETCH_CLASS,self::class);
        return $res;
    }

    public function buscar_por_id($id){
        $db = new Database('produtos');
        $obj = $db->select('id_produtos ='.$id)->fetchObject(self::class);
        return $obj; //retorna um objeto da CLASSE PRODUTOS!!!!
    }

    public function atualizar(){
        $db = new Database('produtos');

        $res = $db->update('id_produtos ='.$this->id_produtos,
                            [
                                'nome' => $this->nome,
                                'descricao' => $this->descricao,
                                'preco' => $this->preco,
                                'quantidade_em_estoque' => $this->quantidade_em_estoque,
                                'foto' => $this->foto
                            ]
                        );

        return $res;
    }

    public function excluir(){
        $db = new Database('produtos');
        $res = $db->delete('id_produtos ='.$this->id_produtos);
        return $res;
    }
}