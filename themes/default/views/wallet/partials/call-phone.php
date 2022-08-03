<form id="divCallCtrl" class="formweb form-call" data-id="phones-">
    <fieldset class="large-12 medium-12 small-12 columns padding"> 
        <label style="width: 100%;" align="center" id="txtCallStatus"></label>
        <label style="width: 100%;" align="center" id="txtRegStatus"></label>
        <input type="hidden" id="txtDisplayName" value="6001"/>
        <input type="hidden" id="txtPrivateIdentity" value="6001" />
        <input type="hidden" id="txtPublicIdentity" value="sip:6001@<?php echo Yii::app()->params['url_call']; ?>" />
        <input type="hidden" id="txtPassword" value="M01ses8o8o@1980" />
        <input type="hidden" id="txtRealm" value="<?php echo Yii::app()->params['url_call']; ?>" />
        <input type="hidden" id="txtidDebtor" name="idDebtor" value="<?php echo $model->id;  ?>" />
        <input type="hidden" id="is_contact" name="is_contact" value="0" />
    </fieldset>
    <div class="row padd_v">            
        <fieldset class="large-6 medium-6 small-12 columns padding"> 
            <label><?php echo Yii::t('front', 'Número'); ?></label>                       
            <input id="txtPhoneNumber" name="number" type="number" readonly>
        </fieldset>
        <fieldset class="large-6 medium-6 small-12 columns padding">          
            <label><?php echo Yii::t('front', 'Estado'); ?></label>                       
            <select  name="idDebtorState" id="tasks-call-idDebtorState" data-substate="#tasks-call-" class="tasks-debtorState <?php echo ($model->is_legal)? 'select-debtorStateLegal' : ''; ?>">
                <option value=""><?php echo Yii::t('front', 'Seleccionar'); ?></option>
                <?php foreach ($status as $stat) { ?>
                    <option value="<?php echo $stat->id; ?>"><?php echo Yii::t('front', $stat->name); ?></option>-->
                <?php } ?>  
            </select>            
        </fieldset>
        <fieldset class="large-12 medium-12 small-12 columns padding">            
            <label><?php echo Yii::t('front', 'Comentario'); ?></label>
            <textarea name="comments" cols="30" rows="10" id="ta-comment"></textarea>
            <input type="hidden" name="callInfo" id="callInfo" />
        </fieldset>
        <div class="clear"></div>
        <fieldset id="divCallOptions" style="opacity: 0;" class="large-6 medium-6 small-12 columns padding">  
            <a href="#" id="btnMute" onclick="sipToggleMute();" class="btnb pop waves-effect waves-light"><i class="fas fa-microphone-alt-slash" style="
    color: #50ff90;
    background: -webkit--webkit-linear-gradient(#50ff90, #01ffff);
    background: -webkit--o-linear-gradient(#50ff90, #01ffff);
    background: -webkit--ms-linear-gradient(#50ff90, #01ffff);
    background: -webkit--moz-linear-gradient(#50ff90, #01ffff);
    background: #00f5f8;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    background-size: cover;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
" aria-hidden="true"></i>  <?php echo Yii::t('front', 'Silenciar'); ?></a>
                    <a href="#" id="btnHoldResume" onclick="sipToggleHoldResume();" class="btnb pop waves-effect waves-light"><i class="fas fas fa-pause" aria-hidden="true"></i>  <?php echo Yii::t('front', 'Retener'); ?></a>                    
                    <a href="#" id="btnKeyPad" onclick="openKeyPad();" class="btnb pop waves-effect waves-light"><i class="fas fa-keyboard" aria-hidden="true"></i>  <?php echo Yii::t('front', 'KeyPad'); ?></a>                    
        </fieldset>  
        <fieldset class="large-6 medium-6 small-12 columns padding">  
            <a href="#!" id="btnHangUp" onclick="sipHangUp();" class="btnb pop waves-effect waves-light"><i class="fas fa-phone-slash" style="
    color: #50ff90;
    background: -webkit--webkit-linear-gradient(#50ff90, #01ffff);
    background: -webkit--o-linear-gradient(#50ff90, #01ffff);
    background: -webkit--ms-linear-gradient(#50ff90, #01ffff);
    background: -webkit--moz-linear-gradient(#50ff90, #01ffff);
    background: red;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    background-size: cover;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
" aria-hidden="true"></i>  <?php echo Yii::t('front', 'Colgar'); ?></a>
            <a href="#!" onclick="sipCall('call-audio');" class="btnb pop waves-effect waves-light"><i class="fas fa-phone" style="color: #50ff90;background: -webkit--webkit-linear-gradient(#50ff90, #01ffff);background: -webkit--o-linear-gradient(#50ff90, #01ffff);background: -webkit--ms-linear-gradient(#50ff90, #01ffff);background: -webkit--moz-linear-gradient(#50ff90, #01ffff);background: #00cfb0;-webkit-background-size: cover;-moz-background-size: cover;background-size: cover;-webkit-background-clip: text;-webkit-text-fill-color: transparent;" aria-hidden="true"></i>  <?php echo Yii::t('front', 'Llamar'); ?></a>
        </fieldset>
        <fieldset class="large-12 medium-12 small-12 columns padding" >  
            <fieldset id="divKeyPad" class="large-6 medium-6 small-12 columns padding" style="visibility:hidden">  
                <fieldset class="large-4 medium-4 small-12 columns padding">  
                    <a href="#" class="btnb pop waves-effect waves-light" onclick="sipSendDTMF('1');">1</a>
                    <a href="#" class="btnb pop waves-effect waves-light" onclick="sipSendDTMF('4');">4</a>
                    <a href="#" class="btnb pop waves-effect waves-light" onclick="sipSendDTMF('7');">7</a>
                    <a href="#" class="btnb pop waves-effect waves-light" onclick="sipSendDTMF('*');">*</a>
                </fieldset>
                <fieldset class="large-4 medium-4 small-12 columns padding">  
                    <a href="#" class="btnb pop waves-effect waves-light" onclick="sipSendDTMF('2');">2</a>
                    <a href="#" class="btnb pop waves-effect waves-light" onclick="sipSendDTMF('5');">5</a>
                    <a href="#" class="btnb pop waves-effect waves-light" onclick="sipSendDTMF('8');">8</a>
                    <a href="#" class="btnb pop waves-effect waves-light" onclick="sipSendDTMF('0');">0</a>
                </fieldset>
                <fieldset class="large-4 medium-4 small-12 columns padding">  
                    <a href="#" class="btnb pop waves-effect waves-light" onclick="sipSendDTMF('3');">3</a>
                    <a href="#" class="btnb pop waves-effect waves-light" onclick="sipSendDTMF('6');">6</a>
                    <a href="#" class="btnb pop waves-effect waves-light" onclick="sipSendDTMF('9');">9</a>
                    <a href="#" class="btnb pop waves-effect waves-light" onclick="sipSendDTMF('#');">#</a>
                </fieldset>
                <fieldset class="large-12 medium-12 small-12 columns padding">  
                    <a href="#" class="btnb pop waves-effect waves-light" onclick="closeKeyPad();">Cerrar</a>
                </fieldset>
            </fieldset>
        </fieldset>
    </div>
    <div class="modal-footer">    
        <button type="submit" class="btnb waves-effect waves-light right"><?php echo Yii::t('front', 'Guardar'); ?></button>
        <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?php echo Yii::t('front', 'Cancelar'); ?></a>
    </div>
    <audio id="audio_remote" autoplay="autoplay"> </audio>
    <audio id="ringtone" loop src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/calls/sounds/ringtone.wav"> </audio>
    <audio id="ringbacktone" loop src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/calls/sounds/ringbacktone.wav"> </audio>
    <audio id="dtmfTone" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/calls/sounds/dtmf.wav"> </audio>
</form>
<!-- Call button options -->
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/debtor.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/calls/SIPml-api.js?svn=252', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/calls/call.min.js', CClientScript::POS_END);
?>