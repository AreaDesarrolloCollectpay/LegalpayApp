<?php

class MyDbHttpSession extends CDbHttpSession {

    public function writeSession($id, $data) {
        try {
            $expire = time() + $this->getTimeout();
            $db = $this->getDbConnection();
            if ($db->createCommand()->select('id')->from($this->sessionTableName)->where('id=:id', array(':id' => $id))->queryScalar() === false) {
                $db->createCommand()->insert($this->sessionTableName, array(
                    'id' => $id,
                    'idUser' => Yii::app()->user->getId(),
                    'data' => $data,
                    'expire' => $expire,
                ));
            } else {
                $db->createCommand()->update($this->sessionTableName, array(
                    'data' => $data,
                    'expire' => $expire
                        ), 'id=:id', array(':id' => $id));
            }
        } catch (Exception $e) {
            if (YII_DEBUG) {
                echo $e->getMessage();
            }
            // it is too late to log an error message here
            return false;
        }
        return true;
    }

}
