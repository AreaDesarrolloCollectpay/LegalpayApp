<section class="list_dash list_detail hide">
    <ul id="contentModelMl" class=" "><!-- medium-offset-3 -->
        <?php foreach ($mlModels as $mlModel){ ?>
        <li class="large-6 medium-6 small-6 columns">                                
            <a href="" class="">
                <div class="card_dash sin_margin waves-effect waves-light border_content getChartModel" data-type="detail">
                    <div class="txt">
                        <p style="margin: -55px 0px; position: relative; white-space: pre;float: right;">ACUERDO DE PAGO</p>
                        <div class="row">                                                
                            <h1>04</h1>                                    
                            <p style="position: absolute; margin: 18px 0px 0px -23px;">Description</p>
                        </div>
                    </div>
                </div>
            </a>
        </li>
        <?php } ?>
        <li class="large-6 medium-6 small-6 columns">                                
            <a href="">
                <div class="card_dash sin_margin waves-effect waves-light border_content" data-type="detail">
                    <div class="txt">
                        <p style="margin: -55px 0px;
    position: relative;
    white-space: pre;
    float: right;">IMPAGO</p>
                        <div class="row">                                                
                            <h1>4 %</h1>                                    
                            <p style="position: absolute; margin: 18px 0px 0px -23px;">Description</p>
                        </div>
                    </div>
                </div>
            </a>
        </li>
<!--
        <li class="large-6 medium-6 small-6 columns">                                
            <a href="">
                <div class="card_dash sin_margin waves-effect waves-light border_content getChartModel" data-type="detail">
                    <div class="txt">
                        <p style="margin: -55px 0px;
    position: relative;
    white-space: pre;
    float: right;">NOVACION</p>
                        <div class="row">                                                
                            <h1>04</h1>                                    
                            <p style="position: absolute; margin: 18px 0px 0px -23px;">Description</p>
                        </div>
                    </div>
                </div>
            </a>
        </li>
        <li class="large-6 medium-6 small-6 columns">                                
            <a href="">
                <div class="card_dash sin_margin waves-effect waves-light border_content getChartModel" data-type="detail">
                    <div class="txt">
                        <p style="margin: -55px 0px;
    position: relative;
    white-space: pre;
    float: right;">DIFERENCIACIÓN</p>
                        <div class="row">                                                
                            <h1>4.1%</h1>                                    
                            <p style="position: absolute; margin: 18px 0px 0px -23px;">Description</p>
                        </div>
                    </div>
                </div>
            </a>
        </li>-->
    </ul>
    <div id="contentModelMLChart">
        
    </div>
</section>
<div class="row white border-tab border_content">
    <div id="frmManagement m_t_10"> 
        <div class="clear"></div> 
        <fieldset class="large-12 medium-12 small-12 columns padding" style="margin-bottom: 2px;">    

            <fieldset class="large-12 medium-12 small-12 columns padding m_t_5">
                <div class="modal-header row p_b_5 m_t_10">
                    <h1><?php echo Yii::t('front', 'INFORMACIÓN GENERAL'); ?></h1>
                </div>
            </fieldset>
            <form class="formweb m_t_5" type="post" >  
                <fieldset class="large-12 medium-12 small-12 columns padding m_t_10 m_b_5">
                    <label><?php echo Yii::t('front', 'Código Interno'); ?></label>
                    <input type="text" value="<?php echo $debt->accountNumber ?>" disabled />
                </fieldset>
                <fieldset class="large-12 medium-12 small-12 columns padding m_t_10 m_b_5">
                    <label><?php echo Yii::t('front', 'Etapa'); ?></label>
                    <select id="debtorObligations-ageDebt" disabled>
                        <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                        <?php foreach ($ageDebts as $ageDebt) { ?>
                            <option value="<?php echo $ageDebt->id; ?>" <?php echo ($debtor->ageDebt == $ageDebt->id) ? 'selected' : ''; ?>><?php echo Yii::t('front', $ageDebt->name); ?></option>
                        <?php } ?>
                    </select>   
                </fieldset>
                <fieldset class="large-12 medium-12 small-12 columns padding m_t_10 m_b_5"> 
                    <label><?php echo Yii::t('front', 'Estado'); ?></label>
                    <select id="debtorObligations-idDebtorState" class="stateWallet select-disabled" data-idDebtor="<?php echo $debtor->idDebtor; ?>">
                        <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                        <?php foreach ($status as $stat) { ?>
                            <option value="<?= $stat->id; ?>" <?php echo ($debtor->idState == $stat->id) ? 'selected="selected"' : ''; ?> ><?php echo Yii::t('front', $stat->name); ?></option>
                        <?php } ?>                          
                    </select>
                </fieldset>
                <fieldset class="large-12 medium-12 small-12 columns padding m_t_10 m_b_5"> 
                    <label><?php echo Yii::t('front', 'Ciudad'); ?></label>
                    <input type="text" value="<?php echo $debtor->city; ?>" disabled />
                </fieldset>
                <fieldset class="large-12 medium-12 small-12 columns padding m_b_5 m_t_5">
                    <label><?php echo Yii::t('front', 'Fecha de Asignación'); ?></label>
                    <div class="fecha">
                        <input name="date_assignment" id="debtorObligations-date_assignment" type="date" class="calendar" value="<?php echo $debtorObli->date_assignment; ?>" />
                    </div>
                </fieldset>
            </form> 
            <div class="clear"></div>
        </fieldset>
    </div>
</div>