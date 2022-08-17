<div class="well well-sm">
  <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
              <h4>Nueva base de datos</h4>         
            </div>
  </div>
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12">
      <p><b>Numero de campañas cargadas: <h3><?= $usersUpload?></h3></b></p>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12">    
      <a href="<?php echo Yii::app()->baseUrl;?>/cms/tempoCampaigns/uploadLote/<?=$lote?>" class="btn btn-success btn-lg submit-form">Aceptar</a>
      <a href="<?php echo Yii::app()->baseUrl;?>/cms/tempoCampaigns/deleteLote/<?=$lote?>" class="btn btn-danger btn-lg submit-form" >Declinar</a>
    </div>
  </div>
</div>