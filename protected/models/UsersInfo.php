<?php

Yii::import('application.models._base.BaseUsersInfo');

class UsersInfo extends BaseUsersInfo
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}