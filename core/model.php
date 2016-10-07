<?php

class Model {

    private $bdd;
    public $table;
    public $id;

    public function __construct() {
        $this->bdd = new PDO('mysql:host=localhost;dbname=yba;charset=utf8', 'root', '');
    }

    public function read($fields = null) {
        if ($fields == null) {
            $fields = "*";
        }
        
        $sql = "SELECT $fields ";
        $sql .= "FROM $this->table ";
        $sql .= "WHERE id=$this->id ";
        
        $stmt = $this->bdd->prepare($sql);
        $result = $stmt->execute();
        $r = $stmt->fetch(PDO::FETCH_OBJ);
    }

}
