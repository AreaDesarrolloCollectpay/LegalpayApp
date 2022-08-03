<!--Contenidos Sitio-->
<section class="cont_home">       
    <section class="conten_inicial task_content">
        <section class="row">
            <div class="tittle_head">
                <h2><?php echo Yii::t('front', 'CALENDARIO'); ?></h2>
            </div>
        </section>
        <section class="row p_t_70">
            <section class="padding animated fadeInUp">

                <section class="all_task_new m_b_20">

                    <div class="row">
                        <div class="large-2 medium-2 small-12 columns">
                            <div class="filter_task">
                                <h5 class="p_n_t"><?php echo Yii::t('front', 'Lista'); ?></h5>
                                <ul class="nav-task">
                                    <li class="task-type" data-type="">
                                        <a href="#" class="waves-effect waves-light active">
                                            <?php echo Yii::t('front', 'Todas'); ?> <span>(<?php echo $count; ?>)</span>
                                        </a>
                                    </li>                       
                                    <li class="task-type" data-type="1">
                                        <a href="#" class="waves-effect waves-light">
                                            <?php echo Yii::t('front', 'Hoy'); ?> 
                                        </a>
                                    </li>
                                    <li class="task-type" data-type="2">
                                        <a href="#" class="waves-effect waves-light">
                                            <?php echo Yii::t('front', 'Pendientes'); ?>
                                        </a>
                                    </li>
                                    <li class="task-type" data-type="3">
                                        <a href="#" class="waves-effect waves-light">
                                            <?php echo Yii::t('front', 'Proximas'); ?>
                                        </a>
                                    </li>
                                </ul>

<!--                                <h5 class="p_t_v">Estados</h5>
                                <ul class="nav-task tags_task">
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-fw fa-circle" color="#23b7e5" style="color: rgb(0, 255, 255);"></i>
                                            Llamadas
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-fw fa-circle" color="#7266ba" style="color: rgb(46, 36, 142);"></i>
                                            Correo electrónico
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-fw fa-circle" color="#fad733" style="color: rgb(76, 243, 144);"></i>
                                            Cartera
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-fw fa-circle" color="#ef5757" style="color: #ef5757;"></i>
                                            Atrasadas
                                        </a>
                                    </li>
                                </ul>-->
                            </div>
                        </div>
                        <div class="large-10 medium-10 small-12 columns padd_task">
                            <!-- Filters Task -->
                            <div class="filter_buttons_task block">
                                <button class="btn clicList waves-effect waves-black">
                                    <i class="feather feather-sliders"></i>
                                    Lista
                                </button>
                                <button class="btn clicCalendar waves-effect waves-black">
                                    <i class="feather feather-calendar"></i>
                                    Calendario
                                </button>
                                <!-- filter -->
                                <?php $this->renderPartial('/tasks/partials/filter-tasks', array('active' => 2, 'url' => $url,'actions' => $actions, 'profiles' => $profiles, 'profile' => $profile,'page' => $page)); ?>            
                                <!-- END filter -->
                            </div>
                            <!--/ Filters Task -->

                            <div class="viewsTask view_list">
                                <!--List Task-->
                                <ul class="list_my_task table_scroll">
                                    <?php 
                                    $i = 1;
                                    foreach ($model as $value){
                                        
                                        
                                        $this->renderPartial('/tasks/partials/item-tasks', array('model' => $value, 'i' => $i));
                                    
                                        if($i == 3){
                                            $i = 1;
                                        }else{
                                            $i++;
                                        }
                                    } ?>
                                </ul>
                                
                                <div class="item-loading <?php echo ($count > 10)? '' : 'hide'; ?>">
                                    <a class="view-more see-more" data-page="<?php echo $page +1; ?>" href=""><i class="fa fa-arrow-alt-circle-down lin2"></i> <?php echo Yii::t('front', 'Ver más'); ?></a>
                                    <b class="view-more hide"><?php echo Yii::t('front', 'Cargando'); ?>...</b>
                                </div>
                                <!--/ List Task-->
                            </div>
                            <div class="viewsTask view_calendar">
                                <!-- Calendar -->
                                <div class="custom-fullcalendar fullcalendar" id="fullcalendar" data-toggle="fullcalendar"></div>
                                <!--/ Calendar -->
                            </div>
                        </div>
                    </div>
                </section>
            </section>    
        </section>
        <div class="clear"></div>
    </section>
</section>

<div class="clear"></div>

<!-- Modal Detalle Tarea -->
<section id="edit_task" class="modal modal-l">
    <div class="modal-header">
        <h1><?php echo Yii::t('front', 'ACTUALIZAR TAREA'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <form class="formweb form-customers">   
        <div class="row p_t_20">            
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label>Estado</label>  
                <select id="estados">
                    <option value="1">Cancelado</option>
                    <option value="2" selected>Proceso</option>      
                    <option value="3">Finalizado</option>                    
                </select>
                <label>Nombre Deudor</label>  
                <input name="name" type="text" value="Pedro León">
                <label>Correo Electrónico</label>  
                <input name="email" type="text" value="contabilidad_@cojunal.com">                
                <label>País</label>                       
                <select name="idCountry" class="select-country">
                    <option value="">Seleccionar</option>
                    <option value="114" selected>COLOMBIA</option>      
                </select>
                <label>Departamento</label>                       
                <select name="idDepartment" class="select-department">
                    <option value="">Seleccionar opción</option><option value="1">AMAZONAS</option><option value="2">ANTIOQUIA</option><option value="3">ARAUCA</option><option value="4">ATLÁNTICO</option><option value="5">BOLÍVAR</option><option value="6">BOYACÁ</option><option value="7">CALDAS</option><option value="8">CAQUETÁ</option><option value="9">CASANARE</option><option value="10">CAUCA</option><option value="11">CESAR</option><option value="12">CHOCO</option><option value="13">CÓRDOBA</option><option value="14">CUNDINAMARCA</option><option value="15">GUAINIA</option><option value="16">GUAVIARE</option><option value="17">HUILA</option><option value="18">LA GUAJIRA</option><option value="19">MAGDALENA</option><option value="20">META</option><option value="21">NARIÑO</option><option value="22">NORTE DE SANTANDER</option><option value="23" selected>PUTUMAYO</option><option value="24">QUINDO</option><option value="25">RISARALDA</option><option value="26">SAN ANDRÉS Y PROVIDENCIA</option><option value="27">SANTANDER</option><option value="28">SUCRE</option><option value="29">TOLIMA</option><option value="30">VALLE DEL CAUCA</option><option value="31">VAUPÉS</option><option value="32">VICHADA</option>
                </select>              
            </fieldset>
            <fieldset class="large-6 medium-6 small-12 columns padding">
                <label>Nombre Entidad</label>  
                <input name="legal_representative" type="text" value="E.S.E Hospital San Antonio">
                <label>Dirección</label>                       
                <input name="address" type="text" value="890689927">
                <label>Teléfono</label>                       
                <input name="phone" type="number" value="30059382949">
                <label>Dirección</label>  
                <input name="address" type="text" value="Carrera 9 # 33 -22">
                <label>Ciudad</label>                       
                <select id="customers-idCity" name="idCity" class="select-city"><option value="">Seleccionar opción</option><option value="517">AGUA DE DIOS</option><option value="518">ALBÁN</option><option value="519">ANAPOIMA</option><option value="520">ANOLAIMA</option><option value="521">APULO</option><option value="522">ARBELÁEZ</option><option value="633">ÁŠTICA</option><option value="523">BELTRÁN</option><option value="524">BITUIMA</option><option value="525">BOGOTÁ</option><option value="526">BOJACÁ</option><option value="527">CABRERA</option><option value="528">CACHIPAY</option><option value="529">CAJICÁ</option><option value="530">CAPARRAPÍ</option><option value="540">CÁQUEZA</option><option value="531">CARMEN DE CARUPA</option><option value="532">CHAGUANÍ</option><option value="536">CHÍA</option><option value="533">CHIPAQUE</option><option value="534">CHOACHÍ</option><option value="535">CHOCONTÁ</option><option value="537">COGUA</option><option value="538">COTA</option><option value="539">CUCUNUBÁ</option><option value="541">EL COLEGIO</option><option value="542">EL PEÑÓN</option><option value="543">EL ROSAL</option><option value="544">FACATATIVÁ</option><option value="548">FÓMEQUE</option><option value="545">FOSCA</option><option value="546">FUNZA</option><option value="549">FÚQUENE</option><option value="547">FUSAGASUGÁ</option><option value="550">GACHALÁ</option><option value="551" selected>GACHANCIPÁ</option><option value="552">GACHETÁ</option><option value="553">GAMA</option><option value="554">GIRARDOT</option><option value="555">GRANADA</option><option value="556">GUACHETÁ</option><option value="557">GUADUAS</option><option value="558">GUASCA</option><option value="559">GUATAQUÍ</option><option value="560">GUATAVITA</option><option value="561">GUAYABAL DE SIQUIMA</option><option value="562">GUAYABETAL</option><option value="563">GUTIÉRREZ</option><option value="564">JERUSALÉN</option><option value="565">JUNÍN</option><option value="566">LA CALERA</option><option value="567">LA MESA</option><option value="568">LA PALMA</option><option value="569">LA PEÑA</option><option value="570">LA VEGA</option><option value="571">LENGUAZAQUE</option><option value="572">MACHETÁ</option><option value="573">MADRID</option><option value="574">MANTA</option><option value="575">MEDINA</option><option value="576">MOSQUERA</option><option value="577">NARIÑO</option><option value="578">NEMOCÓN</option><option value="579">NILO</option><option value="580">NIMAIMA</option><option value="581">NOCAIMA</option><option value="582">PACHO</option><option value="583">PAIME</option><option value="584">PANDI</option><option value="585">PARATEBUENO</option><option value="586">PASCA</option><option value="587">PUERTO SALGAR</option><option value="588">PULÍ</option><option value="589">QUEBRADANEGRA</option><option value="590">QUETAME</option><option value="591">QUIPILE</option><option value="592">RICAURTE</option><option value="593">SAN ANTONIO DE TEQUENDAMA</option><option value="594">SAN BERNARDO</option><option value="595">SAN CAYETANO</option><option value="596">SAN FRANCISCO</option><option value="597">SAN JUAN DE RÍO SECO</option><option value="598">SASAIMA</option><option value="599">SESQUILÉ</option><option value="600">SIBATÉ</option><option value="601">SILVANIA</option><option value="602">SIMIJACA</option><option value="603">SOACHA</option><option value="604">SOPÓ</option><option value="605">SUBACHOQUE</option><option value="606">SUESCA</option><option value="607">SUPATÁ</option><option value="608">SUSA</option><option value="609">SUTATAUSA</option><option value="610">TABIO</option><option value="611">TAUSA</option><option value="612">TENA</option><option value="613">TENJO</option><option value="614">TIBACUY</option><option value="615">TIBIRITA</option><option value="616">TOCAIMA</option><option value="617">TOCANCIPÁ</option><option value="618">TOPAIPÍ</option><option value="619">UBALÁ</option><option value="620">UBAQUE</option><option value="621">UBATÉ</option><option value="622">UNE</option><option value="623">VENECIA (OSPINA PÉREZ)</option><option value="624">VERGARA</option><option value="625">VIANI</option><option value="626">VILLAGÓMEZ</option><option value="627">VILLAPINZÓN</option><option value="628">VILLETA</option><option value="629">VIOTÁ</option><option value="630">YACOPÍ</option><option value="631">ZIPACÓN</option><option value="632">ZIPAQUIRÁ</option>
                </select> 
            </fieldset>
            <div class="clear"></div>
            <fieldset class="large-12 medium-12 small-12 columns padding">
                <label>Comentarios</label>  
                <textarea name="" id="" cols="30" rows="10"></textarea>
            </fieldset>
            <div class="clear"></div>
        </div>
        <div class="modal-footer m_t_20">    
            <input type="hidden" id="customers-idUserProfile" name="idUserProfile" value="" style="pointer-events: none;">
            <input id="customers-id" name="id" type="hidden" value="194">
            <button type="submit" class="btnb waves-effect waves-light right">Actualizar</button>
            <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right">Cancelar</a>
        </div>
    </form>
</section>
<!--/ Modal Detalle Tarea -->


<!-- Modal Lista Tareas -->
<section id="list_task" class="modal modal-l">
    <div class="modal-header">
        <h1 id="modal_title_tasks"><?php echo Yii::t('front', 'TAREAS (12) - 19/07/2019'); ?></h1>
        <a href="#!" class="modal-action modal-close waves-effect waves-light close">
            <i class="feather feather-x-circle"></i>
        </a>
    </div>
    <div class="content_modal padd_all">
        <!--List Task-->
        <ul class="list_my_task" id="modal_content_task">
            
        </ul>
        <!--/ List Task-->
    </div>
</section>
<a href="#list_task" class="open_modal_list modal_clic"></a>
<!-- Modal Lista Tareas -->


<?php
$js = "";

Yii::app()->clientScript->registerScriptFile('//unpkg.com/jscroll/dist/jquery.jscroll.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/tasks.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/fullcalendar/moment.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/fullcalendar/fullcalendar.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/fullcalendar/locale-all.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScript("myquery", '
    $(document).ready(function(){    
        ' . $js . '
    });

    //Push Notification
    $(document).ready(function(){    
//        Push.create("Hola, Dayron!", {
//		    body: "Tienes una nueva tarea para completar en tu panel.",
//		    icon: "https://www.collectpay.co/demo/themes/default/assets/img/icons/icon_alert_push.png",
//		    // timeout: 6000,
//		    onClick: function () {
//		        window.focus();
//		        this.close();
//		        window.open("https://www.collectpay.co/demo/tasks");
//		    }
//		});
    });

    
	//Functions Js
    $(function() {
        //Actions Task
        $(".filter_task ul li a").click(function(event) {
            $(".filter_task ul li a").removeClass("active");
            $(this).addClass("active");
            $(".view_calendar").removeClass("open");
            $(".view_list").addClass("open");
        });

    });    
', CClientScript::POS_END
);
