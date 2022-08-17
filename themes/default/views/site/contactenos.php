<?php
/* @var $this SiteController */
$this->pageTitle = Yii::app()->name;
$base = Yii::app()->request->baseUrl;
$session = Yii::app()->session;
?>
<section class="contacto">
	<div class="first_content">
		<div id="map" class="map"></div>
	</div>
	<div class="content_contact">
		<div class="main_container">
			<div class="row">
				<div class="col-sm-7">
					<div class="contact_info">
						<div class="row">
							<div class="col-sm-6">
								<h3> <?=$session['idioma']==2?$genericText[6]->text_en:$genericText[6]->text_es?></h3>
								<p><?=$session['idioma']==2?$contact[0]->hotlines_en:$contact[0]->hotlines_es?></p>
							</div>
							<div class="col-sm-6">
								<h3><?=$session['idioma']==2?$genericText[7]->text_en:$genericText[7]->text_es?></h3>
								<p><?=$session['idioma']==2?$contact[0]->addres_en:$contact[0]->addres_es?></p>
							</div>
						</div>
						<div class="row">							
							<div class="col-sm-6">
								<h3><?=$session['idioma']==2?$genericText[8]->text_en:$genericText[8]->text_es?></h3>
								<p><?=$session['idioma']==2?$contact[0]->email_en:$contact[0]->email_es?></p>
							</div>

						</div>
					</div>
				</div>
				<hr/>
				<div class="col-sm-5">
					<div class="content_form">
						<h2 class="text-center"><?=$session['idioma']==2?$genericText[4]->text_en:$genericText[4]->text_es?></h2>
						<form action="<?=$base?>/contact" method="POST">
							<input type="text" class="input1" name="name" placeholder="Nombre">
							<input type="text" class="input1" name="email" placeholder="Correo electrónico">
							<input type="text" class="input1" name="subject" placeholder="Asunto">
							<textarea class="input1" placeholder="Mensaje" name="message" rows="4"></textarea>
							<button type="submit"  class="bold">ENVIAR</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBf5nCZKKO0GEVPmfeMb6Y2j3TLfdGXD04&signed_in=true&callback=initMap"></script>
<script type="text/javascript">
	function initMap() {
		var points;
		var sizePoints;
		var idioma = "<?=$session['idioma']?>"
		$.ajax({
  			url: "<?= $base ?>/site/getPointMap",
  			type : "json",
			success : function(data){
				//console.log(data);
				sizePoints = data.length;
				points = data;
				var map = new google.maps.Map(document.getElementById('map'), {
			        zoom: 12,
			        center:{lat: parseFloat(points[0].latitude), lng: parseFloat(points[0].lgn)},
			        scrollwheel:false
			      });
		      //points = objJson.point
		      	for(i=0; i< sizePoints; i++){
			      	var marker = new google.maps.Marker({
				        position: {
				        	lat : parseFloat(points[i].latitude),
				        	lng : parseFloat(points[i].lgn)
				        },
				        map: map,
				        title: idioma==2?points[i].title_en:points[i].title_es
			      	});
		      	}
			}
		});

		
      	
      
    }

    $(window).load(function(){
      initMap();
    })

</script>