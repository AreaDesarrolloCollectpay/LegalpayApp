<?php
/* @var $this SiteController */
/* @var $error array */
$this->pageTitle = Yii::app()->name . ' - Error';
?>

<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row padd_all">

            <section class="panelBG">
                <div class="page-error">
                    <div class="relative">
                        <h1>Error <?php echo $code; ?></h1>
                        <p><?php echo CHtml::encode($message); ?></p>
                        <div class="centerBtn">
                            <a href="javascript:void(0)" class="btnb" onclick="goBack()">Volver</a>
                        </div>
                    </div>
                </div>
            </section>

        </section>
    </section>
</section>