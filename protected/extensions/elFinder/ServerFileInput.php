<?php

/**
 * File input field with elFinder widget
 *
 * @author Robert Korulczyk <robert@korulczyk.pl>
 * @link http://rob006.net/
 * @author Bogdan Savluk <Savluk.Bogdan@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
class ServerFileInput extends CInputWidget {

	/**
	 * @var bool
	 */
	public $popupConnectorRoute = false;

	/**
	 * @var string
	 */
	public $popupTitle = 'Files';

	/**
	 * Custom "Browse" button html code
	 * Button id must be according with the pattern [INPUT_FIELD_ID]browse, for exaple:
	 * CHtml::button('Browse', array('id' => TbHtml::getIdByName(TbHtml::activeName($model, 'header_box_image')) . 'browse'));
	 * @var string
	 */
	public $customButton = '';
        
        /**
	 * @var bool
	 */
	public $multiple = false;
        
        /**
	 * @var bool
	 */
        public $file = false;
        
        public $imageDefault = "";

	public function run() {
                
		Yii::import('ext.elFinder.ElFinderHelper');
		ElFinderHelper::registerAssets();
                $this->imageDefault = Yii::app()->request->baseUrl . "/img/no_image.gif";
		list($name, $id) = $this->resolveNameID();

		if (isset($this->htmlOptions['id']))
			$id = $this->htmlOptions['id'];
		else
			$this->htmlOptions['id'] = $id;
		if (isset($this->htmlOptions['name']))
			$name = $this->htmlOptions['name'];
		else
			$this->htmlOptions['name'] = $name;

		$tipoenlace = "src";
                $defaultselect = $this->imageDefault;
                $contHtmlOptions = $this->htmlOptions;
                $contHtmlOptions['id'] = $id . 'container';
                if($this->multiple){
                    $contHtmlOptions['class'] = 'multiple-finder mult-class-'.$id;
                }
                echo CHtml::openTag('div', $contHtmlOptions);
                $inputOptions = array('id' => $id, 'class'=>'', 'readonly' => 'readonly');
                if ($this->hasModel()){
                    echo CHtml::activeHiddenField($this->model, $this->attribute, $inputOptions);
                    $imagenselect = $this->model->getAttribute($this->attribute);
                }else{
                    echo CHtml::hiddenField($name, $this->value, $inputOptions);
                    $imagenselect = $this->value;
                }
                
                echo CHtml::openTag('div', array('class'=>'col-lg-12 col-md-12 col-xs-12 col-sm-12'));
                if(!$this->file){
                    if($imagenselect == null){
                        $imagenselect = $this->imageDefault;
                    }
                    echo '<img id="'.$id.'image" src="'.$imagenselect.'" class="img-thumbnail img-finder" /> <i id="'.$id.'deleteimage" class="fa fa-minus-circle'.($this->multiple ? " multiple-deleteimage" : "").' pointer" title="Remover" style="vertical-align:top"></i>';
                }else{
                    $tipoenlace = "href";
                    $defaultselect = "#";
                    if($imagenselect == null){
                        $imagenselect = "#";
                    }
                    echo '<a id="'.$id.'image" href="'.$imagenselect.'" style="float:left; margin-right:5px;" class="btn btn-info" target="_blank" ><i class="fa fa-download"></i> Descargar </a> <i id="'.$id.'deleteimage" class="fa fa-minus-circle'.($this->multiple ? " multiple-deleteimage" : "").'" title="Remover" style="cursor:pointer"></i>';
                }
                echo CHtml::closeTag('div');
                
                echo CHtml::openTag('div', array('class'=>'col-lg-6 col-md-8 col-xs-8 col-sm-5'));
                
                echo CHtml::button('Examinar...', array('id' => $id . 'browse', 'class' => 'btn btn-primary btn-block btn-browse', 'style'=>'margin-top:3px;'));
                
                echo CHtml::closeTag('div');

                echo CHtml::closeTag('div');

		// set required options
		if (empty($this->popupConnectorRoute)){
			throw new CException('$popupConnectorRoute must be set!');
                }
		                
                if(!$this->multiple){
                    $url = Yii::app()->controller->createUrl($this->popupConnectorRoute, array('fieldId' => $id));
                    echo '<div id="' . $id . '-dialog" style="display:none;" title="' . $this->popupTitle . '">'
                    . '<iframe frameborder="0" width="100%" height="100%" src="' . $url . '">'
                    . '</iframe>'
                    . '</div>';
                    $js = '
                    $("#' . $id . 'browse").click(function(){ $(function() {
                        $("#' . $id . '-dialog" ).dialog({
                                autoOpen: false,
                                position: "center",
                                title: "' . $this->popupTitle . '",
                                width: 900,
                                height: 550,
                                close: function( event, ui ) {
                                    var url = $("#' . $id . '").val();
                                    if(url == ""){
                                        $("#' . $id . 'image").attr("src","'.$imagenselect.'");
                                        return;
                                    }
                                    if($("#' . $id . 'image").is("img")){
                                        $("#' . $id . 'image").attr("src",url);
                                    }else{
                                        $("#' . $id . 'image").attr("href",url);
                                    }
                                },
                                resizable : true,
                                modal : true,
                        }).dialog( "open" );
                    });});
                    ';

                    $js .= 
                    '$("#' . $id . 'deleteimage").click(function(){
                        $("#' . $id . '").val("");
                        $("#' . $id . 'image").attr("'.$tipoenlace.'", "'. $defaultselect . '");
                    });';
                    Yii::app()->getClientScript()->registerScript('ServerFileInput#' . $id, $js);
                }else{
                    $baseimage = $this->imageDefault;
                    $url = Yii::app()->controller->createUrl($this->popupConnectorRoute, array('multiple'=>'multiple', 'fieldId' => ''));
                    $js = "
                    var iframeFinder = '<div class=\"frame-multiple\" style=\"display:none;\" title=\"" . $this->popupTitle . "\"><iframe frameborder=\"0\" width=\"100%\" height=\"100%\" src=\"\"></iframe></div>';";
                    $js .= "
                    var urlIframe = '".$url."';";
                    $js .= '
                    $(".multiple-finder .btn-browse").click(function(){
                        var idinput = $(this).parent().find("input[type=\'text\']").attr("id");
                        $(".frame-multiple").remove();
                        $("body").append(iframeFinder);
                        $(".frame-multiple iframe").attr("src", urlIframe + idinput);
                        $(function() {
                            $(".frame-multiple").dialog({
                                autoOpen: false,
                                position: "center",
                                title: "' . $this->popupTitle . '",
                                width: 900,
                                height: 550,
                                close: function( event, ui ) {
                                    var idfield = $(".frame-multiple").attr("idfield");
                                    var url = $("#" + idfield).val();
                                    if(url === ""){
                                        if($("#" + idfield).parent().find("img").length > 0){
                                            $("#" + idfield).parent().find("img").attr("src", "'. $baseimage . '");
                                        }else{
                                            $("#" + idfield).parent().find("a").attr("href", "#");
                                        }
                                        return;
                                    }
                                    if($("#" + idfield).parent().find("img").is("img")){
                                        $("#" + idfield).parent().find("img").attr("src",url);
                                    }else{
                                        $("#" + idfield).parent().find("a").attr("href",url);
                                    }
                                },
                                resizable : true,
                                modal : true,
                            }).dialog( "open" );
                        });
                    });
                    ';

                    $js .= 
                    '$(".multiple-deleteimage").click(function(){
                        $(this).parent().parent().find("input[type=\'text\']").val("");
                        if($(this).parent().find("img").length > 0){
                            $(this).parent().find("img").attr("src", "'. $baseimage . '");
                        }else{
                            $(this).parent().find("a").attr("href", "#");
                        }
                    });';
                    
                    $js .= 
                    '$(".multiple-finder").each(function(){
                        var val = $(this).parent().parent().find("input[type=\'text\']").val();
                        if($(this).find("img").length > 0){
                            $(this).find("img").attr("src", val !== "" ? val : "'. $baseimage . '");
                        }else{
                            $(this).find("a").attr("href", (val !== "" ? val : "#"));
                        }
                    });
                    
                    $.fn.finderDefaultInput = function(newElem, sourceElem){
                        $(newElem).parent().parent(".multiple-finder").find("img").attr("src", "'. $baseimage . '");
                        $(newElem).parent().parent(".multiple-finder").find("a").attr("href", "#");
                    }';
                    
                    Yii::app()->getClientScript()->registerScript('Multiple-Finder', $js);
                }
	}
}