<?php

Yii::import('application.models._base.BaseState');

class State extends BaseState
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}