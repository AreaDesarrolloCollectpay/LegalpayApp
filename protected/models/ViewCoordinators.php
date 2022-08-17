<?php

Yii::import('application.models._base.BaseViewCoordinators');

class ViewCoordinators extends BaseViewCoordinators
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}