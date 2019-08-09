<?php
require 'src/vista/templates/header.php';
 ?>

<div class="container my-4">
  <h1 class="text-center my-3">Ingreso de Ficha</h1>
<?php foreach ($secciones as $s) {
  ?>
  <div class="row my-3">
    <div class="col-md-8 border mx-auto">
      <form class="" action="#" method="post">
        <h2 class="text-center my-2"><?php echo $s->nombre; ?></h2>

        <?php foreach ($s->preguntas as $vp => $p) {
          ?>


        <div class="card m-3">
          <div class="card-header">
            <h5 class="card-title"><?php echo $p->pregunta; ?></h5>
            <h6 class="card-subtitle text-muted"><?php echo $p->ayuda; ?></h6>
          </div>

          <div class="card-body">

            <?php
            foreach ($p->respuestas as $r) {
             ?>
             <div class="form-group form-check">
              <input type="radio" class="form-check-input" name="<?php echo $vp; ?>">
              <label class="form-check-label"><?php echo $r->respuesta; ?></label>
            </div>

           <?php } ?>

          </div>

        </div>
      <?php } ?>
      <button type="submit" class="btn btn-primary btn-block mb-3">Guardar</button>

      </form>
    </div>
  </div>

<?php } ?>

</div>


<?php
require 'src/vista/templates/footer.php';
?>
