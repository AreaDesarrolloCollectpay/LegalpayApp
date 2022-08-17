<?php

Yii::import('application.models._base.BasePlans');

class Plans extends BasePlans
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}