<div id="divCallCtrl" class="content_phone">
    <div class="phone__overlay"></div>
    <input type="hidden" id="txtDisplayName" value="6001"/>
    <input type="hidden" id="txtPrivateIdentity" value="6001" />
    <input type="hidden" id="txtPublicIdentity" value="sip:6001@<?php echo Yii::app()->params['url_call']; ?>" />
    <input type="hidden" id="txtPassword" value="M01ses8o8o@1980" />
    <input type="hidden" id="txtRealm" value="<?php echo Yii::app()->params['url_call']; ?>" />
    <input type="hidden" id="txtidDebtor" name="idDebtor" value="" />
    <input type="hidden" id="is_contact" name="is_contact" value="0" />
    <div class="phone call_off">
        <!--<a class="phone__close"></a>-->
        <div class="phone__bg">
            <div class="phone__logo"></div>
        </div>
        <div class="phone_skin"></div>
        <div class="phone__content">

            <!--Initial screen-->
            <div class="phone__content1 phone__content__inner">
                <label class="hide" style="width: 100%;" align="center" id="txtCallStatus"></label>
                <label class="hide" style="width: 100%;" align="center" id="txtRegStatus"></label>                
                <div class="phone__container">
                    <label align="center" id="txtNote"><a href="#modal_manual_call" class="modal_clic"><?php echo Yii::t('front', 'Recuerda : Autenticar tu equipo antes realizar llamadas'); ?></a></label>
                    <select id="txtPhoneNumber" name="number">
                        <option><?php echo Yii::t('front', 'Número de teléfono'); ?></option>
                        <?php if(isset($phones)){ 
                                foreach ($phones as $phone){
                        ?>
                            <option value="<?php echo $phone->getIndicative().$phone->number; ?>"><?php echo $phone->number. ' - '.$phone->name; ?></option>
                        <?php 
                                }  
                              } 
                        ?>
                    </select>
                    <a onclick="sipCall('call-audio');" class="btn__call"></a>
                </div>
            </div>

            <!--main call view-->
            <div class="phone__content2 phone__content__inner">
                <div  class="phone__container">
                    <h4 class="txtCallStatus"></h4>
                    <div id="divCallOptions" class="phone__actions">
                        <a class="open-video"></a>
                        <a onclick="sipToggleMute();" class="mute"></a>
                        <a onclick="openKeyPad();" class="open-keypad"></a>
                        <a class="open-comments"></a>
                    </div>
                    <a id="btnHangUp" onclick="sipHangUp();" class="btn__call--end"></a>
                </div>
            </div>

            <!--keypad view-->
            <div class="phone__content3 phone__content__inner">
                <div class="phone__container">
                    <h4 class="txtCallStatus"></h4>
                    <div id="divKeyPad" class="phone__keypad">
                        <a onclick="sipSendDTMF('1');" class="key key-1">1</a>
                        <a onclick="sipSendDTMF('2');" class="key key-2">2</a>
                        <a onclick="sipSendDTMF('3');" class="key key-3">3</a>
                        <a onclick="sipSendDTMF('4');" class="key key-4">4</a>
                        <a onclick="sipSendDTMF('5');" class="key key-5">5</a>
                        <a onclick="sipSendDTMF('6');" class="key key-6">6</a>
                        <a onclick="sipSendDTMF('7');" class="key key-7">7</a>
                        <a onclick="sipSendDTMF('8');" class="key key-8">8</a>
                        <a onclick="sipSendDTMF('9');" class="key key-9">9</a>
                        <a onclick="sipSendDTMF('#');" class="key key-hash">#</a>
                        <a onclick="sipSendDTMF('0');" class="key key-0">0</a>
                        <a onclick="sipSendDTMF('*');" class="key key-asterisk">*</a>
                    </div>
                    <div class="text-center">
                        <a class="btn btn--back btn--green"><?php echo Yii::t('front', 'Volver'); ?></a>
                    </div>
                </div>
            </div>
            <!--Comments view-->
            <div class="phone__content4 phone__content__inner">
                <div class="phone__container">
                    <h4 class="txtCallStatus"></h4>
                        <div id="content-form-call">                        
                        <form id="form-call" class="form-call ">  
                            <input type="hidden" id="txtidDebtor" name="idDebtorDebt" value="<?php echo $model->id;  ?>" />
                            <input type="hidden" id="is_contact" name="is_contact" value="0" />
                            <input type="hidden" name="callInfo" id="callInfo" />
                            <div class="phone__comments">
                                <select name="idDebtorState" id="tasks-call-idDebtorState" class="tasks-debtorState">
                                    <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                                    <?php foreach ($status as $stat) { ?>
                                        <option value="<?php echo $stat->id; ?>"><?php echo Yii::t('front', $stat->name); ?></option>-->
                                    <?php } ?>  
                                </select>                            
                                <textarea id="tasks-call-comments" name="comments" placeholder="Comentarios"></textarea>
                            </div>
                            <div class="comments__btns">
                                <a id="management-back" class="btn btn--back btn--green"><?php echo Yii::t('front', 'Volver'); ?></a>
                                <button id="management-submit" type="submit" class="btn btn--green hide"><?php echo Yii::t('front', 'Guardar'); ?></button>
                                <!--<a class="btn btn--back btn--red"><?php echo Yii::t('front', 'Cancelar'); ?></a>-->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--End call view-->
            <div class="phone__content5 phone__content__inner">
                <div class="phone__container">
                    <h4 class="txtCallStatus"></h4>
                    <div id="content-form-management">
                        
                    </div>
                </div>
            </div>

        </div>
    </div>
    <audio id="audio_remote" autoplay="autoplay"> </audio>
    <audio id="ringtone" loop src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/calls/sounds/ringtone.wav"> </audio>
    <audio id="ringbacktone" loop src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/calls/sounds/ringbacktone.wav"> </audio>
    <audio id="dtmfTone" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/calls/sounds/dtmf.wav"> </audio>
</div>

<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/calls/phone.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/calls/SIPml-api.js?svn=252', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/calls/call.min.js', CClientScript::POS_END);
