<?php

Yii::import('application.models._base.BaseViewDependents');

class ViewDependents extends BaseViewDependents
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}