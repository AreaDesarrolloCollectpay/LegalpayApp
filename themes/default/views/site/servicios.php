<?php
/* @var $this SiteController */
$this->pageTitle = Yii::app()->name;
$base = Yii::app()->request->baseUrl;
$session = Yii::app()->session;
?>
<section class="servicios">
	<div class="first_content">
		<div class="bg_section img_parallax" style="background-image:url(<?php echo $base; ?>/assets/site/img/bg_servicios.jpg);"></div>
		<div class="over_init text-right">
			<div class="v_center1">
				<div class="v_center2">
					<div class="main_container2">
						<div class="over_init_serv">
							<h1 class="bold"><?=$session['idioma']==2?$genericText[3]->text_en:$genericText[3]->text_es?></h1>
							<p class="bold">
								<?=$session['idioma']==2?$genericText[5]->text_en:$genericText[5]->text_es?>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="content_dests">
		<div class="main_container2">
			<div class="clearfix">
				<div class="dest_col pull-left col_servicios1">
					<a href="#servicio1" class="item_dest light item_serv">
						<img src="<?=$session['idioma']==2?$servicio[0]->img_en:$servicio[0]->img_es?>">
						<div class="over_dest">
							<div class="v_center1">
								<div class="v_center2">
									<h2 class="bold"><?=$session['idioma']==2?$servicio[0]->title_en:$servicio[0]->title_es?></h2>
								</div>
							</div>
						</div>
					</a>

					<a href="#servicio2" class="item_dest light item_serv">
						<img src="<?=$session['idioma']==2?$servicio[1]->img_en:$servicio[1]->img_es?>">
						<div class="over_dest">
							<div class="v_center1">
								<div class="v_center2">
									<h2 class="bold"><?=$session['idioma']==2?$servicio[1]->title_en:$servicio[1]->title_es?></h2>
								</div>
							</div>
						</div>
					</a>

					<a href="#servicio3" class="item_dest light item_black item_serv">
						<img src="<?=$session['idioma']==2?$servicio[2]->img_en:$servicio[2]->img_es?>">
						<div class="over_dest">
							<div class="v_center1">
								<div class="v_center2">
									<h2 class="bold"><?=$session['idioma']==2?$servicio[2]->title_en:$servicio[2]->title_es?></h2>
								</div>
							</div>
						</div>
					</a>

					<a href="#servicio4" class="item_dest light item_serv">
						<img src="<?=$session['idioma']==2?$servicio[3]->img_en:$servicio[3]->img_es?>">
						<div class="over_dest">
							<div class="v_center1">
								<div class="v_center2">
									<h2 class="bold"><?=$session['idioma']==2?$servicio[3]->title_en:$servicio[3]->title_es?></h2>
								</div>
							</div>
						</div>
					</a>

					<a href="#servicio5" class="item_dest light item_black item_serv">
						<img src="<?=$session['idioma']==2?$servicio[4]->img_en:$servicio[4]->img_es?>">
						<div class="over_dest">
							<div class="v_center1">
								<div class="v_center2">
									<h2 class="bold"><?=$session['idioma']==2?$servicio[4]->title_en:$servicio[4]->title_es?></h2>
								</div>
							</div>
						</div>
					</a>
				</div>
				<div class="dest_col pull-right col_home2">
					<div class="content_detail_serv">
						<div class="detail_serv" id="servicio1">
							<h2 class="text-center bold">
								<?=$session['idioma']==2?$servicio[0]->subtitle_en:$servicio[0]->subtitle_es?>   
							</h2>
							<p>
								<?=$session['idioma']==2?$servicio[0]->des_en:$servicio[0]->des_es?>
							</p>
						</div>

						<div class="detail_serv" id="servicio2">
							<h2 class="text-center bold">
								<?=$session['idioma']==2?$servicio[1]->subtitle_en:$servicio[1]->subtitle_es?>
							</h2>
							<p>
								<?=$session['idioma']==2?$servicio[1]->des_en:$servicio[1]->des_es?>
							</p>
						</div>
						<div class="detail_serv" id="servicio3">
							<h2 class="text-center bold">
								<?=$session['idioma']==2?$servicio[2]->subtitle_en:$servicio[2]->subtitle_es?>   
							</h2>
							<p>
								<?=$session['idioma']==2?$servicio[2]->des_en:$servicio[2]->des_es?>
							</p>
						</div>

						<div class="detail_serv" id="servicio4">
							<h2 class="text-center bold">
								<?=$session['idioma']==2?$servicio[3]->subtitle_en:$servicio[3]->subtitle_es?>   
							</h2>
							<p>
								<?=$session['idioma']==2?$servicio[3]->des_en:$servicio[3]->des_es?>
							</p>
						</div>

						<div class="detail_serv" id="servicio5">
							<h2 class="text-center bold">
								<?=$session['idioma']==2?$servicio[4]->subtitle_en:$servicio[4]->subtitle_es?>   
							</h2>
							<p>
								<?=$session['idioma']==2?$servicio[4]->des_en:$servicio[4]->des_es?>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>