<?php

Yii::import('application.models._base.BaseTypeDependents');

class TypeDependents extends BaseTypeDependents
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}