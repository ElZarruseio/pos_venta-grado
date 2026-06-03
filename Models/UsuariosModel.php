<?php
class UsuariosModel extends Query{
    public function __construct() {
        parent::__construct();
    }
    public function getUsuario(string $usuario, string $clave) {
        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND clave = '$clave'";
        $data = $this->select($sql);
        return $data;
    }

    public function getCajas() {
        $sql = "SELECT * FROM caja WHERE estado = 1";
        $data = $this->selectAll($sql);
        return $data;
    }

   public function getUsuarios() {
    $sql = "SELECT u.id, u.usuario, u.nombre, u.id_caja, u.estado, c.caja 
            FROM usuarios u 
            INNER JOIN caja c ON u.id_caja = c.id";
    $data = $this->selectAll($sql);
    return $data;
}
    
}

?>