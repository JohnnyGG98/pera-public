<?php
require_once 'src/modelo/persona/personabd.php';
require_once 'src/modelo/alumno/alumnobd.php';
require_once 'src/modelo/usuario/usuariobd.php';

class PerfilCTR extends CTR implements DCTR {

  function __construct() {
    parent::__construct("todos");
  }

  public function inicio() {
    global $U;
    $_SESSION['U'] = $u = UsuarioBD::getUserByIDPersona($U->idPersona);
    require_once cargarVista('persona/perfil.php');
  }

  function guardar() {
    include cargarVista('persona/form.php');
  }

  function editar() {
    global $U;
    $persona = PersonaBD::getPorId($U->idPersona);
    $alumno = AlumnoBD::getPorId($U->idPersona);
    PersonaBD::actualizarFecha($U->idPersona);
    include cargarVista('persona/form.php');
  }

  function foto() {
    global $U;
    PersonaBD::getFotoPorId($U->idPersona);
  }

}
 ?>
