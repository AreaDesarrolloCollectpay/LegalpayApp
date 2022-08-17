<section class="cont_home">       
    <section class="conten_inicial">
        <section class="row">

            <div class="tittle_head">
                <h2 class="inline">REMISIONES</h2>
                <div class="acions_head txt_right">      
                    <button type="button" href="#new_customers_modal" class="modal_clic btnb inline waves-effect waves-light createCustomers">
                        <i class="fa fa-plus" aria-hidden="true"></i> Nuevo
                    </button>                                              
                </div>        
            </div>

            <section class="padding animated fadeInUp">
                <!--Tabs-->
                <!-- <div class="block">
                    <fieldset class="m_b_20 large-4 medium-6 small-12s columns padding right">
                        
                    </fieldset>
                    <ul class="tabs tab_cartera">
                        <li class="tab"><a href="<?php echo $this->createUrl('/customers'); ?>" class="active"><i class="fa fa-user" aria-hidden="true"></i> REMISIONES</a></li>
                    </ul>
                </div>    -->
                <section class="panelBG m_t_20 m_b_20">
                    <div class="row"> 
                        <!--Tab 4-->
                        <article id="historia_pagos" class="block">
                            <!--Datos acordeon-->                                
                            <div class="clear"></div>
                            <section class="padding m_t_20">
                                <div class="clearfix">                                        
                                    <table class="bordered highlight responsive-table">                                            
                                        <thead>
                                            <tr>
                                                <th width="14%" class="txt_center">NOMBRES</th>
                                                <th width="13%" class="txt_center">CONTACTO</th>
                                                <th width="10%" class="txt_center">CAPITAL</th>
                                                <th width="10%" class="txt_center">INTERESES</th>
                                                <th width="10%" class="txt_center">HONORARIOS</th>
                                                <th width="10%" class="txt_center">COMISIÓN</th>
                                                <th width="10%" class="txt_center">ABONADO</th>
                                                <th width="10%" class="txt_center">ESTADO</th>
                                                <th width="13%" class="txt_center">ACCIONES</th>
                                            </tr>
                                            <tr class="filters formweb">
                                                <td>
                                                    <input type="text" class="searchCustomers"  name="name" maxlength="100" value="<?php echo (isset($_GET['name']) && $_GET['name'] != '') ? $_GET['name'] : ''; ?>">
                                                </td>
                                                <td>
                                                    <input type="text" class="searchCustomers"  name="contact" maxlength="100" value="<?php echo (isset($_GET['contact']) && $_GET['contact'] != '') ? $_GET['contact'] : ''; ?>">
                                                </td>
                                                <td>
                                                    <input type="text" class="searchCustomers" name="capital" maxlength="100" value="<?php echo (isset($_GET['capital']) && $_GET['capital'] != '') ? $_GET['capital'] : ''; ?>">
                                                </td>
                                                <td>
                                                    <input type="text" class="searchCustomers" name="interests" maxlength="100" value="<?php echo (isset($_GET['interests']) && $_GET['interests'] != '') ? $_GET['interests'] : ''; ?>">
                                                </td>
                                                <td>
                                                    <input type="text" class="searchCustomers" name="fee" maxlength="100" value="<?php echo (isset($_GET['fee']) && $_GET['fee'] != '') ? $_GET['fee'] : ''; ?>">
                                                </td>
                                                <td>
                                                    <input type="number" class="searchCustomers" name="commission" maxlength="100" value="<?php echo (isset($_GET['commission']) && $_GET['commission'] != '') ? $_GET['commission'] : ''; ?>">
                                                </td>
                                                <td>
                                                    <input type="text" class="searchCustomers" name="paid" maxlength="100" value="<?php echo (isset($_GET['paid']) && $_GET['paid'] != '') ? $_GET['paid'] : ''; ?>">
                                                </td>
                                                <td>
                                                    <select name="idState" class="cd-select filterType searchCustomers">
                                                        <option value="" selected>Seleccionar</option>
                                                        <?php foreach ($states as $value) { ?>
                                                            <option <?php echo (isset($_GET['idState']) && $_GET['idState'] == $value->id ) ? 'selected' : ''; ?> value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td>                                                        
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody id="usersCoordinators">
                                            <?php
                                            foreach ($model as $value) {
                                                $this->renderPartial('/customers/partials/item-customers', array('model' => $value));
                                            }
                                            ?>
                                        </tbody>
                                    </table>                                        
                                </div>
                                <div class="clear"></div>
                            </section>
                            <!--Fin Datos acordeon-->
                        </article>
                    </div>
                </section>
            </section>
        </section>
    </section>
</section>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/customers.min.js', CClientScript::POS_END);
Yii::app()->controller->renderPartial('/customers/partials/modal-customers', array(
    'countries' => $countries,
    'typeDocument' => $typeDocument,
));
?>