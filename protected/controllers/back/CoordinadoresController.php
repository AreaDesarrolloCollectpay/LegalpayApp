<?php

class CoordinadoresController extends GxController{

    // public $defaultAction = 'admin';

        public function filters() {
            Yii::app()->getComponent('booster');
            return array(
                'accessControl', 
            );
        }

        public function accessRules() {
            return array(
                array('allow',
                        'expression'=>'Controller::validateAccess()',
                        ),
                array('deny', 
                        'users'=>array('*'),
                        ),
            );
        }

         
        //Método action
        public function actionIndex(){
        $hola="Hola mundo con Yii Framework!!! Soy Victor Robles";
         
               //Renderizamos la vista llamada index y le pasamos el parámetro hola
                $this->render('index',array(
                            "hola"=>$hola
                        ));
    }
         
        public function agregar_coordinadores(){
        $bruce="Deberias contratar a Victor Robles";
         
                //Renderizamos la vista llamada city y le pasamos el parámetro hola
                $this->render('city',array(
                            "hola"=>$bruce
                        ));
    }
}