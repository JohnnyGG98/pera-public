<?php
require_once 'src/modelo/fichas/ficha.php';

abstract class FichaBD {

  static function getPorPersona($idPersona){
    $ct = getCon();

    $sql = '
    SELECT
    tf.id_tipo_ficha,
    tf.tipo_ficha,
    pl.id_prd_lectivo,
    pl.prd_lectivo_nombre,
    pif.id_permiso_ingreso_ficha,
    pif.permiso_ingreso_fecha_inicio,
    pif.permiso_ingreso_fecha_fin,
    pf.id_persona_ficha,
    pf.persona_ficha_fecha_ingreso,
    pf.persona_ficha_fecha_modificacion
    FROM
    public."PersonaFicha" pf,
    public."PermisoIngresoFichas" pif,
    public."TipoFicha" tf,
    public."PeriodoLectivo" pl
    WHERE
    pf.id_persona = '.$idPersona.' AND
    pf.id_permiso_ingreso_ficha = pif.id_permiso_ingreso_ficha AND
    tf.id_tipo_ficha = pif.id_tipo_ficha AND
    pl.id_prd_lectivo = pif.id_prd_lectivo
    ORDER BY
    permiso_ingreso_fecha_fin DESC;
    ';

    if ($ct != null) {
      $res = $ct->query($sql);
      if ($res != null) {
        $fichas = array();
        while($r = $res->fetch(PDO::FETCH_ASSOC)){
          $f = FichaMD::getFromRow($r);
          /*echo "<hr>";
          var_dump($f);
          echo "<hr>";*/
          //array_push($fichas, $r);
          array_push($fichas, $f);
        }
        return $fichas;
      } else {
        echo "No pudimos consultar fichas";
        return null;
      }
    }
  }

}

 ?>
