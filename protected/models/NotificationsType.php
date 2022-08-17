<?php

Yii::import('application.models._base.BaseNotificationsType');

class NotificationsType extends BaseNotificationsType
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}