<?php
class PeriodoBD {

  static private $BASEQUERY = '
  SELECT
  id_prd_lectivo,
  prd_lectivo_nombre
  FROM public."PeriodoLectivo"
  WHERE

  ';
  static private $ENDQUERY = '
  prd_lectivo_activo = true
  ORDER BY
  prd_lectivo_nombre,
  prd_lectivo_fecha_fin DESC;
  ';

  static function cargarTodos() {
    $sql = self::$BASEQUERY . ' ' . self::$ENDQUERY;
    return getArrayFromSQL($sql , []);
  }

  static function buscar($idPeriodo) {
    $sql = self::$BASEQUERY . "
      id_prd_lectivo = :idPeriodo AND
    " . self::$ENDQUERY;
    return getArrayFromSQL($sql , [
      'idPeriodo' => $idPeriodo
    ]);
  }

  static function buscarPeriodo($aguja) {
    $sql = self::$BASEQUERY . "
      prd_lectivo_nombre ILIKE '%:aguja%' AND
    " . self::$ENDQUERY;
    return getArrayFromSQL($sql , [
      'aguja' => $aguja
    ]);
  }

  static function buscarPorCarrera($idCarrera) {
    $sql = self::$BASEQUERY . "
      id_carrera = :idCarrera AND
    " . self::$ENDQUERY;
    return getArrayFromSQL($sql , [
      'idCarrera' => $idCarrera
    ]);
  }

  static function getCiclos($idPeriodo) {
    $sql = '
    SELECT
    DISTINCT curso_ciclo AS ciclo
    FROM public."Cursos" c
    WHERE c.curso_activo = true
    AND c.id_prd_lectivo = :idPeriodo
    ORDER BY c.curso_ciclo; ';
    return getArrayFromSQL($sql , [
      'idPeriodo' => $idPeriodo
    ]);
  }

}

?>
