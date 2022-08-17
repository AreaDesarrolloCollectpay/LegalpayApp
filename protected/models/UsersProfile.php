<?php

Yii::import('application.models._base.BaseUsersProfile');

class UsersProfile extends BaseUsersProfile
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}