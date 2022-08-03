<?php
/* @var $this SiteController */
/* @var $error array */
$this->pageTitle = Yii::app()->name . ' - Error1111';
?>
<section class="cont_home">  
    <section class="conten_inicial">
        <section class="wrapper_l dashContent p_t_25">
            <section class="padding">
                <div class="rc-anchor-content txt_center">
                    <div class="rc-inline-block">
                        <div class="rc-anchor-center-container">
                            <div class="rc-anchor-center-item rc-anchor-error-message" style="font-weight: bolder;"><h1>Error <?php echo $code; ?></h1><br><?php echo CHtml::encode($message); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </section>
</section>