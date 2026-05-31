<?php 
class Conexion{
    private $conect;
    public function __construct(){

        $pdo = "mysql:host=".host.";dbname=".db.";.charset.";
        try {
            $this->conect = new PDO($pdo, user, pass);
            $this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Erro en la conexion a la base de datos: ".$e->getMessage();
        }
    }
    public function conect(){
        return $this->conect;
    }
}

?>