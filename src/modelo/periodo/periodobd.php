<?php
class PeriodoBD {

  static private $BASEQUERY = '
  SELECT
  id_prd_lectivo,
  prd_lectivo_nombre
  FROM public."PeriodoLectivo"
  WHERE ';

  static private $ENDQUERY = '
  prd_lectivo_activo = true
  ORDER BY
  prd_lectivo_nombre,
  prd_lectivo_fecha_fin DESC;';

  static private $QUERYCMB = '
  SELECT
  id_prd_lectivo,
  prd_lectivo_nombre
  FROM
  public."PeriodoLectivo"
  WHERE
  prd_lectivo_activo = true AND
  prd_lectivo_estado = true ';

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

  static function getCiclosByPermiso($idPermiso) {
    $sql = '
    SELECT
    DISTINCT curso_ciclo AS ciclo
    FROM public."Cursos" c
    WHERE c.curso_activo = true
    AND c.id_prd_lectivo = (
      SELECT DISTINCT id_prd_lectivo
      FROM public."PermisoIngresoFichas"
      WHERE id_permiso_ingreso_ficha = :idPermiso
    ) ORDER BY c.curso_ciclo; ';
    return getArrayFromSQL($sql , [
      'idPermiso' => $idPermiso
    ]);
  }

  static function getCiclosByPeriodo($idPeriodo) {
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

  static function getParaCombo(){
    $sql = self::$QUERYCMB . '
    ORDER BY
    prd_lectivo_fecha_fin DESC;';
    return getArrayFromSQL($sql, []);
  }

  static function getParaCmbGuardar($idTipoFicha) {
    $sql = self::$QUERYCMB . '
    AND id_prd_lectivo NOT IN (
      SELECT id_prd_lectivo
      FROM public."PermisoIngresoFichas"
      WHERE id_tipo_ficha = :idTipoFicha
    )
    ORDER BY
    prd_lectivo_fecha_fin DESC;';
    return getArrayFromSQL($sql, [
      'idTipoFicha' => $idTipoFicha
    ]);
  }

  static function getParaCmbEditar($idPermiso) {
    $sql = '
    SELECT
    id_prd_lectivo,
    prd_lectivo_nombre,
    prd_lectivo_fecha_fin
    FROM
    public."PeriodoLectivo"
    WHERE
    prd_lectivo_activo = true AND
    prd_lectivo_estado = true
    AND id_prd_lectivo NOT IN (
        SELECT id_prd_lectivo
        FROM public."PermisoIngresoFichas"
        WHERE id_tipo_ficha = (
          SELECT id_tipo_ficha
          FROM public."PermisoIngresoFichas"
          WHERE id_permiso_ingreso_ficha = :idPermiso
        )
      )
    UNION
    SELECT
    id_prd_lectivo,
    prd_lectivo_nombre,
    prd_lectivo_fecha_fin
    FROM
    public."PeriodoLectivo"
    WHERE
    prd_lectivo_activo = true AND
    prd_lectivo_estado = true
    AND id_prd_lectivo = (
      SELECT id_prd_lectivo
    	FROM public."PermisoIngresoFichas"
    	WHERE id_permiso_ingreso_ficha = :idPermiso
    )
    ORDER BY
    prd_lectivo_fecha_fin DESC;';
    return getArrayFromSQL($sql, [
      'idPermiso' => $idPermiso
    ]);
  }

}
?>
