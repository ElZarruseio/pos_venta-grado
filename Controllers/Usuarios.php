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
    $usuario = $_POST['usuario'];
    $nombre = $_POST['nombre'];
    $clave = $_POST['clave'];
    $confirmar = $_POST['confirmar'];
    $caja = $_POST['caja'];
    $id = $_POST['id'];
    $hash = hash("SHA256", $clave);
    
    if (empty($usuario) || empty($nombre) || empty($caja)) {
        $res = "Todos los campos son obligatorios";
    } else {
        if ($id == "") {
            if (empty($clave)) {
                $res = "La contraseña es obligatoria para usuarios nuevos";
            } else {
                $msg = $this->model->registrarUsuario($usuario, $nombre, $hash, $caja);
                if ($msg == "ok") {
                    // CAMBIO AQUÍ: Enviamos "si" en minúscula para que coincida con la validación JS
                    $res = "si"; 
                } else {
                    $res = $msg;
                }
            }
        } else {
            // MODIFICACIÓN DE REGISTRO
            $msg = $this->model->modificarUsuario($usuario, $nombre, $caja, $id);
            if ($msg == "modificado") {
                $res = "modificado";
            } else {
                $res = $msg;
            }
        }
    }
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    die();
}

    
    public function editar (int $id){
       $data = $this->model->editarUser($id);
       echo json_encode($data, JSON_UNESCAPED_UNICODE);
       die();
   }
    
}
                                

?>