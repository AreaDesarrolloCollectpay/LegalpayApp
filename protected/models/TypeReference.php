<?php

Yii::import('application.models._base.BaseTypeReference');

class TypeReference extends BaseTypeReference
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}