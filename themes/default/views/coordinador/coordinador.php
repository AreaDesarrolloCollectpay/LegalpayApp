<?php
$session = Yii::app()->session;
?>
    <!--Contenidos Sitio-->
      <section class="cont_home">       
        <section class="conten_inicial">
          <section class="wrapper_l dashContent p_t_25">
            
            <section class="padding">

              <section class="all_tareas m_b_20">
                <section class="panelBG wow fadeInUp m_b_20 animated">
                  <div class="tittle_head">
                    <h2>PROMESAS Y AGENDAS</h2>
                  </div>
                  <div class="row block padd_v">
                    <div class="large-6 medium-6 small-12 columns">
                      <div class="bg_panel padding animated fadeInUp">
                        <div class="table_scroll">
                          <?php
                            $idAdviser = Yii::app()->session['cojunal']->idAdviser;
                          ?>
                          <?php
                            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
                            $date = DateTime::createFromFormat("d/m/Y", date("d/m/Y"));
                            $todayDate = strftime("%d de %B de %Y",$date->getTimestamp());
                            $today = Todaysmanagement::model()->findAllByAttributes(array('idAsesor'=>$idAdviser));
                            $todaysAgendas = null;
                            foreach ($today as $key) {
                              if($key->action == 'Promesa'){
                                $todaysAgendas++;
                              }
                              if($key->effect != null){
                                $todaysAgendas++;
                              }
                            }

                            //$todaysAgendas = count($today);                            
                          ?>
                          <table class="striped">
                            <thead>
                              <tr>
                                  <th data-field="id"><b>Hoy</b></th>
                                  <th data-field="name" class="txt_right padding"> <?= $todayDate; ?> <span class="animated flip"><?= $todaysAgendas; ?></span></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php 
                                foreach ($today as $agenda) {
                                  if($agenda->action == 'Promesa'){
                              ?>
                              <tr style="cursor:pointer" onClick="document.location.href='wallet/search/<?= $agenda->idWallet?>';">
                                <td><?= $agenda->legalName; ?> <br> <?= $agenda->phone?></td>
                                <td class="txt_right padding"><?= $agenda->action == 'Promesa' ? '$ '.number_format($agenda->comment, 2, ',', '.') : $agenda->action; ?></td>
                              </tr>
                              <?php
                                }

                                if($agenda->effect != null){
                                  ?>
                                  <tr style="cursor:pointer" onClick="document.location.href='wallet/search/<?= $agenda->idWallet?>';">
                                <td><?= $agenda->legalName; ?> <br> <?= $agenda->phone?></td>
                                <td class="txt_right padding"><?= $agenda->action == 'Promesa' ? '$ '.number_format($agenda->comment, 2, ',', '.') : $agenda->action; ?></td>
                              </tr>
                                  <?php
                                }
                                }
                              ?>                              
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="large-6 medium-6 small-12 columns">
                      <div class="bg_panel padding animated fadeInUp">
                        <div class="table_scroll">
                          <?php
                            $idAdviser = Yii::app()->session['cojunal']->idAdviser;
                          ?>
                          <?php
                            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
                            $rest = Restmanagement::model()->findAllByAttributes(array('idAsesor'=>$idAdviser));
                            $restAgendas = null;
                            foreach ($rest as $key) {
                              if($key->action == 'Promesa'){
                                $restAgendas++;
                              }
                              if($key->effect != null){
                                $restAgendas++;
                              }
                            }
                            //$restAgendas = count($rest);
                          ?>
                          <table class="striped">
                            <thead>
                              <tr>
                                  <th data-field="id"><b>Todas</b></th>
                                  <th data-field="name" class="txt_right padding" colspan="2"><span class="animated flip verde"><?= $restAgendas; ?></span></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php 
                                foreach ($rest as $nextAgenda) {
                                  if($nextAgenda->action == 'Promesa'){
                              ?>
                              <tr style="cursor:pointer" onClick="document.location.href='wallet/search/<?= $nextAgenda->idWallet2?>';">
                                <td><?= $nextAgenda->legalName; ?> <br> <?= $nextAgenda->phone; ?></td>
                                <!--
                                <td class="txt_right padding"><b><?= strftime("%d %B %Y",strtotime($nextAgenda->fecha)); ?></b></td>
                                -->
                                <td class="txt_right padding"><b><?= $nextAgenda->fecha ?></b></td>
                                <td class="txt_right padding"><?= $nextAgenda->action == 'Promesa' ? '$ '.number_format($nextAgenda->comment, 2, ',', '.') : $nextAgenda->action; ?></td>
                              </tr>
                              <?php
                                }//ENDIF
                                if($nextAgenda->effect != null){
                              ?>
                              <tr style="cursor:pointer" onClick="document.location.href='wallet/search/<?= $nextAgenda->idWallet2?>';">
                                <td><?= $nextAgenda->legalName; ?> <br> <?= $nextAgenda->phone; ?></td>
                                <!--
                                <td class="txt_right padding"><b><?= strftime("%d %B %Y",strtotime($nextAgenda->fecha)); ?></b></td>
                                -->
                                <td class="txt_right padding"><b><?= $nextAgenda->fecha ?></b></td>
                                <td class="txt_right padding"><?= $nextAgenda->action == 'Promesa' ? '$ '.number_format($nextAgenda->comment, 2, ',', '.') : $nextAgenda->action; ?></td>
                              </tr>
                              <?php
                                }//ENDIF
                              }
                              ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
              </section>

                
              </section>         

            </section>

            <div class="clear"></div>
          </section>
        </section>
          <div class="clear"></div>
      
<script type="text/javascript">
  $( document ).ready(function() {
    $("#tasks").addClass("activo");
  });
</script>