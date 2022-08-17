<?php
/* @var $this SiteController */
$this->pageTitle = Yii::app()->name;
$base = Yii::app()->request->baseUrl;
$session = Yii::app()->session;
//echo "<pre>";
//print_r($genericText);
?>
<section class="nosotros">
	<div class="first_content">
		<div class="bg_section img_parallax" style="background-image:url(<?php echo $base; ?>/assets/site/img/bg_nosotros.jpg);"></div>
		<div class="over_init">
			<div class="v_center1">
				<div class="v_center2">
					<div class="main_container2">
						<p class="bold">
							<?= $session['idioma']==2?$genericText[0]->text_en:$genericText[0]->text_es ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="content_dests">
		<div class="main_container2">
			<div class="clearfix">
				<div class="dest_col pull-left col_home1">

					<a href="#" class="item_dest light">
						<img src="<?= $session['idioma']==2?$nosotros[0]->img_en:$nosotros[0]->img_es?>">
						<div class="over_dest">
							<div class="v_center1">
								<div class="v_center2">
									<h2 class="bold"><?= $session['idioma']==2?$nosotros[0]->title_en:$nosotros[0]->title_es ?></h2>
									<p><?= $session['idioma']==2?$nosotros[0]->des_en:$nosotros[0]->des_es?></p>
								</div>
							</div>
						</div>
					</a>

					<a href="#" class="item_dest light">
						<img src="<?= $session['idioma']==2?$nosotros[1]->img_en:$nosotros[1]->img_es?>">
						<div class="over_dest">
							<div class="v_center1">
								<div class="v_center2">
									<h2 class="bold"><?= $session['idioma']==2?$nosotros [1]->title_en:$nosotros [1]->title_es?></h2>
									<p><?= $session['idioma']==2?$nosotros[1]->des_en:$nosotros[1]->des_es?></p>
								</div>
							</div>
						</div>
					</a>

					<a href="#" class="item_dest light item_black">
						<img src="<?= $session['idioma']==2?$nosotros[2]->img_en:$nosotros[2]->img_es?>">
						<div class="over_dest">
							<div class="v_center1">
								<div class="v_center2">
									<h2 class="bold"><?= $session['idioma']==2?$nosotros[2]->title_en:$nosotros[2]->title_es?></h2>
									<p><?= $session['idioma']==2?$nosotros[2]->des_en:$nosotros[2]->des_es?></p>
								</div>
							</div>
						</div>
					</a>
				</div>
				<div class="dest_col pull-right col_home2">
					<div class="item_dest light">
						<img src="<?= $session['idioma']==2?$nosotros[3]->img_en:$nosotros[3]->img_es?>">
					</div>

					<a href="#" class="item_dest light item_black">
						<img src="<?= $session['idioma']==2?$nosotros[4]->img_en:$nosotros[4]->img_es?>">
						<div class="over_dest">
							<div class="v_center1">
								<div class="v_center2">
									<h2 class="bold"><?= $session['idioma']==2?$nosotros[4]->title_en:$nosotros[4]->title_es?></h2>
									<p><?= $session['idioma']==2?$nosotros[4]->des_en:$nosotros[4]->des_es?></p>
								</div>
							</div>
						</div>
					</a>
					<a href="#" class="item_dest light">
						<img src="<?= $session['idioma']==2?$nosotros[5]->img_en:$nosotros[5]->img_es?>">
						<div class="over_dest">
							<div class="v_center1">
								<div class="v_center2">
									<h2 class="bold"><?= $session['idioma']==2?$nosotros[5]->title_en:$nosotros[5]->title_es?></h2>
									<p><?= $session['idioma']==2?$nosotros[5]->des_en:$nosotros[5]->des_es?></p>
								</div>
							</div>
						</div>
					</a>

				</div>
			</div>
		</div>
	</div>

	<div class="contnt_clients">
		<div class="content_clients1">
			<h2 class="light"><?= $session['idioma']==2?$genericText[1]->text_en:$genericText[1]->text_es?></h2>
			<a href="#"><?= $session['idioma']==2?$genericText[2]->text_en:$genericText[2]->text_es?></a>
		</div>
		<div class="content_clients2">
			<?php foreach ($company as $data):?>
				<img src="<?= $session['idioma']==2?$data->img_en:$data->img_es?>">
			<?php endforeach;?>
		</div>
	</div>
</section>