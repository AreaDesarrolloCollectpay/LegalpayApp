<?php

Yii::import('application.models._base.BaseUsersSessions');

class UsersSessions extends BaseUsersSessions
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}