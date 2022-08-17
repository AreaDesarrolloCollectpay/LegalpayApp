<?php

Yii::import('application.models._base.BaseCoordinatorAdviser');

class CoordinatorAdviser extends BaseCoordinatorAdviser
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}