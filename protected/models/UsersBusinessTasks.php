<?php

Yii::import('application.models._base.BaseUsersBusinessTasks');

class UsersBusinessTasks extends BaseUsersBusinessTasks
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}