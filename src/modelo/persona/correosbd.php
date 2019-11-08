<?php

abstract class CorreosBD {

  static private $BASEQUERY = '
  SELECT id_persona,
  persona_primer_nombre || \' \' ||
  persona_primer_apellido AS persona_nombre,
  persona_correo
  FROM public."Personas" ';

  static private $ENDQUERY = '
  AND persona_activa = true
  ORDER BY persona_primer_apellido;';

  static function getCorreosAlumnosPorPeriodoCiclo($idPeriodo, $ciclo) {
    $sql = self::$BASEQUERY . '
    WHERE id_persona IN (
      SELECT id_persona FROM public."Alumnos"
      WHERE id_alumno IN (
        SELECT id_alumno FROM public."AlumnoCurso"
        WHERE id_curso IN (
          SELECT DISTINCT id_curso FROM public."Cursos"
          WHERE id_prd_lectivo = :idPeriodo
          AND curso_ciclo = :numCiclo
        )
      )
    ) ' . self::$ENDQUERY;
    return getArrayFromSQL($sql, [
      'idPeriodo' => $idPeriodo,
      'numCiclo' => $ciclo
    ]);
  }

  static function getCorreosDocentesPorPeriodoCiclo($idPeriodo, $ciclo) {

  }

  static function getCorreoPorIndentificacion($identificacion) {
    $sql = self::$BASEQUERY . '
    WHERE persona_identificacion ILIKE :identificacion
    ' . self::$ENDQUERY;
    return getArrayFromSQL($sql, [
      'identificacion' => '%' . $identificacion . '%'
    ]);
  }

}
?>
