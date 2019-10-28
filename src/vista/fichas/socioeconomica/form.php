<?php if (isset($act)): ?>
<!--Iniciamos las constantes-->
<script type="text/javascript">
  const URLACT = '<?php echo constant('URL')?>api/v1/ficha/guardar/?socioeconomica=asas';
  const URLGURDAR = '<?php echo constant('URL'); ?>api/v1/ficha/guardar';
</script>

<script type="text/javascript" src="<?php echo constant('URL') ?>public/js/ajax/formsocioeconomica.js?v=21">
</script>

<?php endif; ?>

<?php
//Cargamos las funciones para generar el formulario
require_once 'src/vista/fichas/socioeconomica/respuestas.php';
 ?>

<?php foreach ($secciones as $ks => $s) :?>
  <div class="row my-3 seccion">

    <div class="col-sm-11 col-lg-8 col-xl-7 pb-2 mx-auto ">

      <div class="bg-blue py-1 rounded-lg shadow">
        <h2 class="text-center text-white my-3 border-bottom pb-2 mx-2">
          <?php echo ($ks + 1) . '. ' . $s['seccion_ficha_nombre']; ?>
        </h2>
      </div>

      <?php if (isset($s['preguntas'])): ?>

          <?php foreach ($s['preguntas'] as $vp => $p): ?>

          <div class="card m-3 mb-4 border-0">
            <div class="card-header-blue rounded-lg">
              <h5 class="card-title"><?php echo $p['pregunta_ficha']; ?></h5>
              <h6 class="card-subtitle text-white"><?php echo $p['pregunta_ficha_ayuda']; ?></h6>
              <?php if (isset($act) && $p['pregunta_ficha_tipo'] == 1): ?>
                <span class="badge badge-danger">Obligatoria</span>
              <?php endif; ?>
            </div>

            <div class="card-body">

              <?php if (isset($p['respuestas']) && $p['pregunta_ficha_respuesta_tipo'] == 1): ?>

                <?php foreach ($p['respuestas'] as $vr => $r): ?>

                  <?php
                  /*if($p['pregunta_ficha_respuesta_tipo'] == 1){*/
                    formRespuestaUnica(
                      isset($act) ? $act : false,
                      $vp,
                      $vr,
                      $p['actualizar'],
                      $p['respuesta'],
                      $p['id_pregunta_ficha'],
                      $r['id_respuesta_ficha'],
                      $r['respuesta_ficha']
                    );
                  //}
                  ?>


                <?php endforeach; ?>

              <?php endif; ?>

              <?php
              if ($p['pregunta_ficha_respuesta_tipo'] == 3) {
                formRespuestaLibreUnica(
                  isset($act) ? $act : false,
                  $ks,
                  $ks,
                  $p['id_pregunta_ficha'],
                  isset($p['respuesta_libre']) ? $p['respuesta_libre'] : null,
                  $p['pregunta_ficha_respuesta_campo']
                );
              }

              if($p['pregunta_ficha_respuesta_tipo'] == 4){
                formRespuestaLibreMultiple(
                  isset($act) ? $act : false,
                  $p['id_pregunta_ficha'],
                  isset($p['respuesta_libre']) ? $p['respuesta_libre'] : null,
                  $p['pregunta_ficha_respuesta_campo'],
                  $s['id_seccion_ficha']
                );
              }
              ?>

              <?php if (isset($p['respuestas']) && $p['pregunta_ficha_respuesta_tipo'] == 5): ?>

                <?php
                formRespuestaSeleccion(
                  isset($act) ? $act : false,
                  $p['id_pregunta_ficha'],
                  $p['respuestas'],
                  isset($p['respuesta_libre']) ? $p['respuesta_libre'] : null,
                  $s['id_seccion_ficha']
                );
                 ?>

              <?php endif; ?>

            </div>

          </div>

        <?php endforeach; ?>

      </div>

    </div>

  <?php endif; ?>

<?php endforeach; ?>


<script type="text/javascript">
  var vclick = 0;
  /*const BTNSMASTXT = document.querySelectorAll('.btn-mas-txt');

  BTNSMASTXT.forEach(b => {
    b.onclick = agregarOtroTxtResMul;
  });*/
</script>
