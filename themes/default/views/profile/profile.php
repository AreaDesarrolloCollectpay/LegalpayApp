<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">
            <div class="tittle_head">
                <h2><?php echo Yii::t('front', 'Mi perfil'); ?></h2>
            </div>
        </section>   
        <section class="row p_t_80">
            <section class="padding">
                <section class="bg_perfil m_b_20">
                    <!--Datos iniciales-->
                    <section class="row">
                        <div class="dates_user m_t_20">
                            <form id="frmPersonalInfo" action="" class="formweb form_user" enctype="multipart/form-data">
                                <fieldset class="large-6 medium-6 small-12 columns">
                                    <div class="large-12 medium-12 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Imagen perfil'); ?></label>
                                        <section class="marco_img_cargar cargar_img">                          
                                            <div class="form-item">        
                                                <div class="file-preview">
                                                    <a href="#" data-position="bottom" data-delay="50" data-tooltip="Editar" class="file-select tooltipped">
                                                        <span>
                                                            <div class="relative">
                                                                <i class="feather feather-image"></i>
                                                                <b><?php echo Yii::t('front', 'Cargar imagen'); ?></b>
                                                            </div>
                                                        </span>
                                                    </a>
                                                    <figure><img src="<?php echo $model->image; ?>" title="<?php echo $model->name; ?>"/></figure>                    
                                                </div>
                                                <input name="image" type="file" class="file2 file-preview" />
                                            </div>
                                        </section>
                                    </div>
                                    <div class="large-12 medium-12 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Nombres'); ?></label>
                                        <input type="text" id="user-name" name="name" placeholder="<?php echo $model->name; ?>" value="<?php echo $model->name; ?>">
                                    </div>
                                    <div class="large-12 medium-12 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Usuario'); ?></label>
                                        <input type="text" id="user-userName" name="userName" placeholder="<?php echo $model->userName; ?>" value="<?php echo $model->userName; ?>" readonly>
                                    </div>                                    
                                    <div class="large-12 medium-12 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Correo Electrónico'); ?></label>
                                        <input type="text" id="user-email" name="email" placeholder="<?php echo $model->email; ?>" value="<?php echo $model->email; ?>">
                                    </div>
                                    <div class="large-12 medium-12 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Teléfono'); ?></label>
                                        <input type="text" id="user-phone" name="phone" placeholder="<?php echo $model->phone; ?>" value="<?php echo $model->phone; ?>" >                                    
                                    </div>                                                                                                       
                                </fieldset>
                                <fieldset class="large-6 medium-6 small-12 columns">
                                    <div class="large-12 medium-12 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Celular'); ?></label>
                                        <input type="text" id="user-mobile" name="mobile" placeholder="<?php echo $model->mobile; ?>" value="<?php echo $model->mobile; ?>" >
                                    </div>  
                                    <div class="large-12 medium-12 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'País'); ?></label>
                                        <input type="text" id="user-country" name="" placeholder="" value="<?php echo ($model->idCity0->idDepartment0 != NULL)? $model->idCity0->idDepartment0->idCountry0->name : ''; ?>" readonly>                                
                                    </div>
                                    <div class="large-12 medium-12 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Ciudad'); ?></label>
                                        <input type="text" id="user-city" name="" placeholder="" value="<?php echo ($model->idCity0 != NULL)? $model->idCity0->name : ''; ?>" readonly>       
                                    </div>  
                                    <div class="large-12 medium-12 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Departamento'); ?></label>
                                        <input type="text" id="user-department" name="" placeholder="" value="<?php echo ($model->idCity0 != NULL)? $model->idCity0->idDepartment0->name : ''; ?>" readonly>                                                                        
                                    </div>
                                    <div class="large-12 medium-12 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Dirección'); ?></label>
                                        <input type="text" id="user-address" name="address" placeholder="<?php echo $model->address; ?>" value="<?php echo $model->address; ?>">                                    
                                    </div>
                                    <div class="large-12 medium-12 small-12 columns padding">                                     
                                        <label><?php echo Yii::t('front', 'Nueva Contraseña'); ?></label>
                                        <input type="password" id="user-newPassword" name="newPassword"  value="" class="clear">
                                    </div>
                                    <div class="large-12 medium-12 small-12 columns padding">
                                        <label><?php echo Yii::t('front', 'Repetir Nueva Contraseña'); ?></label>
                                        <input type="password" id="user-confirmPassword" name="confirmPassword"  value="" class="clear">
                                    </div>   
                                </fieldset>
                                <div class="clear"></div>
                                <input type="hidden" name="is_internal" value="<?php  echo ($model->usersProfiles != null)? $model->usersProfiles[0]->is_internal : "" ; ?>"  />
				<input type="hidden" name="notification" value="<?php  echo ($model->notification != null)? $model->notification : 0; ?>"  />
                                
                     
                                <div class="txt_right block padding m_t_10 m_b_20">
                                    <button id="btnSaveInfo" class="btnb waves-effect waves-light"><?php echo Yii::t('front', 'Guardar'); ?></button>
                                </div>
                                <div class="clear"></div>
                            </form>
                        </div>
                        <div class="clear"></div>
                    </section>
                </section>    
            </section>
        </section>
        <div class="clear"></div>
    </section>
    <div class="clear"></div>
</section>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/profile.min.js', CClientScript::POS_END);
?>
