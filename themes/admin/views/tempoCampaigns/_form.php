<?php 
  if(isset($lote)){
    echo "<script>
            var lote = '".$lote."';
            var usersUpload = '".$usersUpload."';
        </script>";
  }else {
    echo "<script>
            var lote = null;
        </script>";
  }
?>

<?php 
  if(isset($lote))
    require("load_model.php");
  else {
    ?>
      <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12">
            <p>Aquí puedes descargar el formato que debes diligenciar para subir la base de datos<span>&#160;</span></p>         
            <a href="<?php echo Yii::app()->baseUrl; ?>/assets/PlantillaCampanas.csv" class="btn btn-info btn-block" download>Descargar Formato</a>                
          </div>
      </div>
      <hr/>
      <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12">
              <?= CHtml::beginForm('MasiveData', 'post', array('enctype' => 'multipart/form-data', 'class'=>'well well-sm')) ?>
              <p>Para realizar la carga de la base de datos sube el formato diligenciado aqui</p>      
              <div class="file-field input-field">
                <div class="btn">
                  <?= CHtml::fileField('file') ?>
                </div>
                <div class="file-path-wrapper">
                  <input class="file-path validate" type="hidden">
                </div>
              </div>
              <div class="centerbtn">
                <?= CHtml::submitButton('Cargar', array('class' => 'btn btn-success btn-lg submit-form')) ?>
              </div>
          </div>
      </div>
      <hr/>
<?php 
  }
?>

<script>
    $(document).ready(function(){
      $("#load_db").hide();
      if(lote!=null){
        $("#usersUpload").html(usersUpload);
        $("#load_db").show();
      }
    });

</script>
