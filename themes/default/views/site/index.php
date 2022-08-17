<?php
/* @var $this SiteController */
$this->pageTitle = Yii::app()->name;
$base = Yii::app()->request->baseUrl;
$session = Yii::app()->session;
?>
<section class="home">
	<div class="first_content">
		<div class="bg_section img_parallax" style="background-image:url(<?php echo $base; ?>/assets/site/img/bg_home.jpg);"></div>
		<div class="over_init">
			<div class="v_center1">
				<div class="v_center2">
					<div class="main_container2">
						<h1 class="light"><?=$session['idioma']==2?$genericText[10]->text_en:$genericText[10]->text_es?></h1>
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
						<img src="<?= $session['idioma']==2?$home[0]->img_en:$home[0]->img_es?>">
						<div class="over_dest">
							<div class="v_center1">
								<div class="v_center2">
									<h2 class="bold"><?=$session['idioma']==2?$home[0]->title_en:$home[0]->title_es?></h2>
									<p><?=$session['idioma']==2?$home[0]->des_en:$home[0]->des_es?></p>
								</div>
							</div>
						</div>
					</a>

					<a href="#" class="item_dest light">
						<img src="<?= $session['idioma']==2?$home[1]->img_en:$home[1]->img_es?>">
						<div class="over_dest">
							<div class="v_center1">
								<div class="v_center2">
									<h2 class="bold"><?=$session['idioma']==2?$home[1]->title_en:$home[1]->title_es?></h2>
									<p><?=$session['idioma']==2?$home[1]->des_en:$home[1]->des_es?></p>
								</div>
							</div>
						</div>
					</a>

					<div class="item_dest light">
						<img src="<?= $session['idioma']==2?$home[2]->img_en:$home[2]->img_es?>">
					</div>

				</div>

				<div class="dest_col pull-right col_home2">

					<a href="#" class="item_dest light">
						<img src="<?= $session['idioma']==2?$home[3]->img_en:$home[3]->img_es?>">
						<div class="over_dest">
							<div class="v_center1">
								<div class="v_center2">
									<h2 class="bold"><?=$session['idioma']==2?$home[3]->title_en:$home[3]->title_es?></h2>
									<p><?=$session['idioma']==2?$home[3]->des_en:$home[3]->des_es?></p>
								</div>
							</div>
						</div>
					</a>

					<div class="item_dest light">
						<img src="<?= $session['idioma']==2?$home[4]->img_en:$home[4]->img_es?>">
					</div>

					<a href="#" class="item_dest light">
						<img src="<?= $session['idioma']==2?$home[5]->img_en:$home[5]->img_es?>">
						<div class="over_dest">
							<div class="v_center1">
								<div class="v_center2">
									<h2 class="bold"><?=$session['idioma']==2?$home[5]->title_en:$home[5]->title_es?></h2>
									<p><?=$session['idioma']==2?$home[5]->des_en:$home[5]->des_es?></p>
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
			<h2 class="light"><?=$session['idioma']==2?$genericText[11]->text_en:$genericText[11]->text_es?></h1></h2>
				<p><?=$session['idioma']==2?$genericText[12]->text_en:$genericText[12]->text_es?></p>
		</div>
		<div class="content_clients2">
			<div class="main_container">
				<div class="clearfix">
					<?php 
						foreach ($testimony as $test ) {
					?>
					<div class="item_client left">
						<div class="v_center1">
							<div class="v_center2">
								<img src="<?=$session['idioma']==2?$test->img_en:$test->img_es?>">
							</div>
						</div>
						
						<div class="over_item_client">
							<div class="v_center1">
								<div class="v_center2">
									<p><?=$session['idioma']==2?$test->testi_en:$test->testi_es?>
									</p>
									<h3 class="bold"><?=$session['idioma']==2?$test->name_person_en:$test->name_person_es?></h3>
									<span><?=$session['idioma']==2?$test->charge_person_en:$test->charge_person_es?></span>
								</div>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</section>