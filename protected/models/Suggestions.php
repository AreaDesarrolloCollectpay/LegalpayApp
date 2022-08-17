<?php

Yii::import('application.models._base.BaseSuggestions');

class Suggestions extends BaseSuggestions
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}