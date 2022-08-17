<?php

Yii::import('application.models._base.BaseMetrics');

class Metrics extends BaseMetrics
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}