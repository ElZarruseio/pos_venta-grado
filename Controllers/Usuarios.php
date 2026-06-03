<?php
class Usuarios extends Controller{
    public function __construct() {
        session_start();
        parent::__construct();
    }
    public function index(){
        $data ['cajas'] = $this->model->getCajas();
        $this->views->getView($this, "index", $data);
    }
    public function listar(){
       $data = ($this->model->getUsuarios());
       for ($i=0; $i < count($data); $i++) { 
        if ($data[$i]['estado'] == 1) {
            $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
        }else {
            $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
        }
        $data[$i]['acciones'] = '<div>
        <button class="btn btn-primary btn-sm" onclick="editarUsuario(${id})"><i class="fas fa-edit"></i> Editar</button>
        <button class="btn btn-danger btn-sm" onclick="eliminarUsuario(${id})"><i class="fas fa-trash-alt"></i> Eliminar</button>`;
        </div>';
       }
       echo json_encode($data, JSON_UNESCAPED_UNICODE);
       die();
    }

    public function validar (){

        if(empty($_POST['usuario']) || empty($_POST['clave'])){
            $msg = "Los campos no pueden estar vacíos";

        }else {
            $usuario = $_POST ['usuario'];
            $clave = $_POST ['clave'];
            $data = $this->model->getUsuario($usuario, $clave);
            if($data){
             
                $_SESSION['id_usuario'] = $data['id'];
                $_SESSION['usuario'] = $data['usuario'];
                $_SESSION['nombre'] = $data['nombre'];
                   $msg = "ok";
            }else{
               $msg = "Usuario o contraseña incorrectos"; 
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die(); 

    }
}

?>
