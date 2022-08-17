<section id="load_db" class="modal modal-s open" style="z-index: 1003; display: block; opacity: 1; transform: scaleX(1); top: 10%;">
    <div class="modal-header">
        <h1>Nueva base de datos</h1>
    </div>
    <div class="row padd_v">
        <form id="" class="formweb " action="" method="">
            <fieldset>
                <div class="large-7 medium-12 small-12 columns padding">
                    <p><b>Dinero total cargado:</b></p>                  
                </div>
                <div class="large-5 medium-12 small-12 columns padding" id="amount">     
                    <p>$ 111.800.000</p>
                </div>
            </fieldset>
            <fieldset>
                <div class="large-7 medium-12 small-12 columns padding">
                    <p><b>Numero de usuarios cargados:</b></p>                       
                </div>
                <div class="large-5 medium-12 small-12 columns padding" id="usersUpload">
                    <p>900</p>
                </div>
            </fieldset>
            <div class="clear"></div>
        </form>
    </div>
    <div class="modal-footer">    
        <a href="<?php echo Yii::app()->baseUrl; ?>/uploadLote/<?= $lote ?>" id="btnUpload" class="btnb waves-effect waves-light right">Aceptar</a>
        <a href="<?php echo Yii::app()->baseUrl; ?>/deleteLote/<?= $lote ?>" class="btnb pop modal-action modal-close waves-effect waves-light right" onclick="deleteDatabase()" >Declinar</a>
    </div>
</section>

<script type="text/javascript">
    function deleteDatabase() {
        $("#load_db").hide();

    }

    $('html').on('click', '#btnUpload', function () {
        $(this).addClass('hide');
    });

</script>