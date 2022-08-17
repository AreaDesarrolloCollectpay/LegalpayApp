<?php

Yii::import('application.models._base.BaseTypeSupports');

class TypeSupports extends BaseTypeSupports
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}