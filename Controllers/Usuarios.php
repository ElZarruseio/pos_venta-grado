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
        <button class="btn btn-primary btn-sm" onclick="btnEditarUser(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i> Editar</button>
        <button class="btn btn-danger btn-sm" onclick="eliminarUsuario(' . $data[$i]['id'] . ')"><i class="fas fa-trash-alt"></i> Eliminar</button>
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

    public function Registrar(){
         header('Content-Type: application/json');
        $usuario = $_POST ['usuario'];
        $nombre = $_POST ['nombre'];
        $clave = $_POST ['clave'];
        $confirmar = $_POST ['confirmar'];
        $caja = $_POST ['caja'];
        if(empty($usuario) || empty($nombre) || empty($caja)){
            $msg = "Todos los campos son obligatorios";
        }else {
            if ($_POST['id'] == "") {
                if ($clave != $confirmar) {
                    $msg = "Las contraseñas no coinciden";
                    echo json_encode($msg, JSON_UNESCAPED_UNICODE);
                    die();
                }
                $data = $this->model->registrarUsuario($usuario, $nombre, $clave, $caja);
                if($data == "ok"){
                    $msg = "Si";
                } else if ($data == "El usuario ya existe") {
                    $msg = "El usuario ya existe";
                } else {
                    $msg = "Error al registrar el usuario";
                } 
               

            }else {
                    # code...
                }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar (int $id){
       $data = $this->model->editarUser($id);
       echo json_encode($data, JSON_UNESCAPED_UNICODE);
       die();
       }
}
                                

?>