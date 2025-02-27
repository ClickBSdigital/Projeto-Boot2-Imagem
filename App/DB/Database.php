<?php

Class Database{
    private $conn;
    private string $local = 'localhost';
    private string $db = 'passcontrol';
    private string $user = 'root';
    private string $password = '';
    private $table;

    function __construct($table = null){
        $this->table = $table;
        $this->conecta();

    }

    private function conecta(){
        try{
            $this->conn = new PDO("mysql:host=".$this->local.";dbname=$this->db",$this->user,$this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Conectado com sucesso";
        }catch(PDOException $err){
            die("Connection Failed". $err->getMessage());
        }
    }

    public function execute($query, $binds = []){
        // echo $query;

        try{
            $stmt = $this->conn->prepare($query);
            $stmt->execute($binds);
            return $stmt;
        }catch(PDOException $err){
            die('Connection Failed'. $err->getMessage());
        }
    }

    public function insert($values){
        // quebrar o array associativo que veio como parametro
        $fields = array_keys($values);

        $binds = array_pad([], count($fields), '?');

        $query = 'INSERT INTO '.$this->table . '('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';

        $res = $this->execute($query, array_values($values));

        if($res){
            return true;
        }else{
            return false;
        }
    }


    public function select($where = null, $order = null, $limit = null, $fields = '*'){
        $where = strlen($where) ? 'WHERE '.$where : '';
        $order = strlen($order) ? 'ORDER BY '.$order : '';
        $limit = strlen($limit) ? 'LIMIT '.$limit : '';

        $query = 'SELECT '.$fields.' FROM '.$this->table. ' '.$where. ' '.$order . ' '.$limit ;

        return $this->execute($query);
    }

    public function select_by_id($where = null, $order = null, $limit = null, $fields = '*'){
        $where = strlen($where) ? 'WHERE '.$where : '';
        $order = strlen($order) ? 'ORDER BY '.$order : '';
        $limit = strlen($limit) ? 'LIMIT '.$limit : '';

        $query = 'SELECT '.$fields.' FROM '.$this->table. ' '.$where. ' '.$order . ' '.$limit ;

        return $this->execute($query)->fetch(PDO::FETCH_ASSOC);
    }


    public function delete($where){
        //Montar a query

        $query = 'DELETE FROM '.$this->table. ' WHERE '.$where;
        $del = $this->execute($query);
        $del = $del->rowCount();

        if($del == 1){
            return true;
        }else{
            return false;
        }
    }

    public function update($where, $array){
        //Extraindo as chaves, coluna
        $fields = array_keys($array);
        $values = array_values($array);
        //Montar Query
        $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields). '=? WHERE '. $where;

        //DEBUG
        // echo $query; // exit;
        $res = $this->execute($query, $values);
        
        return $res->rowCount();
    }
}