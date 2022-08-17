<?php

Yii::import('application.models._base.BaseUsersBusiness');

class UsersBusiness extends BaseUsersBusiness
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}