<?php

abstract class PersonaBD {

  static function cargarFoto($idPersona) {
    $ct = getCon();
    $sql =  '
    SELECT encode(persona_foto, \'base64\') as foto FROM public."Personas"
    WHERE id_persona = '.$idPersona.'
    ';

    if($ct != null){
      $res = $ct->query($sql);
      if($res != null){

        if($res->rowCount()) {
          $foto = null;
          while ($r = $res->fetch(PDO::FETCH_ASSOC)) {
            $foto = $r['foto'];
          }
          header('Content-type: image/png');
          echo base64_decode($foto);
        }
      }
    }
  }
}

 ?>