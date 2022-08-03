<!-- Modal List Advisers -->
<section id="modals-sessions" class="modal modal-l">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'SESSIONES') ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <div class="row padd_v">            
        <section class="padd_v">
            <div class="row"> 
                <article id="" class="block">                              
                    <div class="clear"></div>
                    <section class="padding m_t_20">
                        <div class="clearfix">                                        
                            <table class="bordered responsive-table">
                                <thead>
                                    <tr class="backgroung-table-4">
                                        <th width="20%" class="txt_center"><?php echo Yii::t('front', 'FECHA'); ?></th>
                                        <th width="20%" class="txt_center"><?php echo Yii::t('front', 'HORA'); ?></th>
                                        <th width="20%" class="txt_center"><?php echo Yii::t('front', 'USUARIO'); ?></th>
                                        <th width="20%" class="txt_center"><?php echo Yii::t('front', 'IP'); ?></th>
                                        <th width="20%" class="txt_center"><?php echo Yii::t('front', 'DISPOSITIVO'); ?></th>
                                    </tr>
                                </thead>
                                <tbody id="content-modal-sessions">

                                </tbody>
                            </table>                                           
                        </div>
                        <div class="clear"></div>
                    </section>
                </article>
            </div>
        </section>            
        <div class="clear"></div>
    </div>
    <div class="modal-footer">    
        <input id="users-id" name="id" type="hidden" value="" />
        <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
    </div>
</section>

