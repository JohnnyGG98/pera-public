<?php
require_once 'src/modelo/persona/personabd.php';

class PersonaAPI {

  function actualizar($idPersona = 0){
    if(isset($_POST['actualizar'])){
      $valor = isset($_POST['valor']) ? $_POST['valor'] : '';
      $columna = isset($_POST['columna']) ? $_POST['columna'] : '';
      if($idPersona != 0 && $valor != '' && $columna != ''){

        $res = PersonaBD::actualizarDato($idPersona, $valor, $columna);

        if($res){
          JSON::confirmacion('Editamos correctamente el campo.');
        }else{
          JSON::error('No editamos el campo, posiblemente exista un error en la sintaxis.');
        }
      }else{
        JSON::error('No existen todos los valores requeridos.');
      }
    }else{
      JSON::error('No especifico que actualizaremos ');
    }

  }

}
 ?>
