<?php

class BillingController extends Controller {

    //=============================================================================================
    //=======================Init Class============================================================
    //=============================================================================================
    public $access;
    public $adviser;

    public function init() {
        //Yii::app()->getComponent("bootstrap");
        //Yii::app()->theme = $this->theeFront; //set theme default front
        $this->layout = 'layout_secure';
        $session = Yii::app()->session;
        if (!isset($session['idioma']))
            $session['idioma'] = 1;
        parent::init();
        Yii::app()->errorHandler->errorAction = 'site/error';
        $this->access = array_merge(Yii::app()->params['admin'],Yii::app()->params['accounting'],Yii::app()->params['customers']);        
        $this->adviser = array(3, 6);
    }

    //=============================================================================================    
    public function filters() {
        $this->setLanguageApp();
        return array(
            array(
                'application.filters.html.ECompressHtmlFilter',
                'gzip' => true,
                'doStripNewlines' => false,
                'actions' => '*'
            ),
        );
    }

    //=============================================================================================
    public function actionIndex() {

        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {

            if (Yii::app()->user->getState('rol') == 1) {
                $this->redirect(array('/users/internal'));
            } else {
                $this->redirect(array('/users/external'));
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }

    //=============================================================================================
    public function actionPayments() {

        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {
            
            $filters = array('datePay', 'idCustomer', 'customer', 'idCoordinator', 'coordinator', 'code', 'value');
            $no_filters = array('page', 'from', 'to');
            $criteria = new CDbCriteria();
            $condition = '';

            if (isset($_GET)) {
                $i = 0;
                foreach ($_GET as $key => $value) {

                    if ((!in_array($key, $no_filters)) && $value != '' && in_array($key, $filters)) {
                        $condition .= ($i == 0) ? '( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        $condition .= 't.' . $key;
                        $condition .= (($key != 'idCustomer' && $key != 'idCoordinator')) ? ' LIKE "%' . $value . '%"' : ' = ' . $value;
                        $i++;
                    }
                }

                $condition .= ($condition != '') ? ')' : '';
            }
            if (isset($_GET['from']) && $_GET['from'] != '') {
                $condition .= ($condition != '') ? ' AND ' : '';
                $to = (isset($_GET['to']) && $_GET['to'] != '') ? ' "' . $_GET['to'] . '"' : ' CURDATE()';
                $condition .= '(t.datePay BETWEEN "' . $_GET['from'] . '"  AND' . $to . ')';
            }

//               echo $condition;
//               exit;

            $criteria->condition = $condition;
            
            $criteria->select = 'SUM(value) as value';
            $total = ViewPayments::model()->find($criteria);
            
            
            $criteria->select = 't.*';
            $criteria->order = "t.datePay DESC";
            $criteria->group = 't.id';
            $count = ViewPayments::model()->count($criteria);
            

            $pages = new CPagination($count);

            $pages->pageSize = 20;
            $pages->applyLimit($criteria);

            $model = ViewPayments::model()->findAll($criteria);

            $customers = ViewCustomers::model()->findAll(array('select' => 'id, name', 'order' => 'name ASC'));
            $coodinators = ViewCoordinators::model()->findAll(array('order' => 'name ASC'));
            
            $this->render('payments', array(
                'model' => $model,
                'pages' => $pages,
                'customers' => $customers,
                'coodinators' => $coodinators,
                'total' => $total,
            ));
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }

    //=============================================================================================

    public function actionExportFilterPayments() {
        $return = array('status' => 'error',
            'msg' => Yii::t('front', 'Solicitud Invalida'),
            'file' => '',
        );

        set_time_limit(0);
        $connection = Yii::app()->db;
        $transaction = $connection->beginTransaction();

        try {
            $root = Yii::getPathOfAlias('webroot');
            $filename = "/uploads/export/" . "export_payments_" . Date('d_m_Y_h_i_s') . ".csv";


            $filters = array('datePay', 'idCustomer', 'customer', 'idCoordinator', 'coordinator', 'code', 'value');
            $no_filters = array('page', 'from', 'to');
            $condition = '';

            if (isset($_POST)) {
                $i = 0;
                foreach ($_POST as $key => $value) {

                    if ((!in_array($key, $no_filters)) && $value != '' && in_array($key, $filters)) {
                        $condition .= ($i == 0) ? '( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        $condition .= 't.' . $key;
                        $condition .= (($key != 'idCustomer' && $key != 'idCoordinator')) ? ' LIKE "%' . $value . '%"' : ' = ' . $value;
                        $i++;
                    }
                }

                $condition .= ($condition != '') ? ')' : '';
            }

            if (isset($_POST['from']) && $_POST['from'] != '') {
                $condition .= ($condition != '') ? ' AND ' : '';
                $to = (isset($_POST['to']) && $_POST['to'] != '') ? ' "' . $_POST['to'] . '"' : ' CURDATE()';
                $condition .= '(t.datePay BETWEEN "' . $_POST['from'] . '"  AND' . $to . ')';
            }

//               echo $condition;
//               exit;

            $condition = ($condition != '') ? 'WHERE ' . $condition : '';


            $sql = 'SELECT 
                       \'Fecha Pago\',\'Cliente\',\'Coordinador\',\'Nombre Deudor\',\'CC / NIT \',\'Valor Pago\'
                       UNION
                       SELECT 
                       REPLACE(REPLACE(REPLACE(datePay , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(REPLACE(REPLACE(customer , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),                       
                       REPLACE(REPLACE(REPLACE(coordinator , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'), 
                       REPLACE(REPLACE(REPLACE(name , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'), 
                       code,
                       REPLACE(value,\'.\',\',\') AS value                                             
                       FROM view_payments t
                       ' . $condition . '
                       INTO OUTFILE \'' . $root . $filename . '\'
                       FIELDS TERMINATED BY \',\'
                       OPTIONALLY ENCLOSED BY \'"\'
                       LINES TERMINATED BY\'\n\'';

            $connection->createCommand($sql)->execute();
            //.... other SQL executions
            $transaction->commit();

            if (file_exists($root . $filename)) {
                $return['status'] = 'success';
                $return['file'] = $filename;
                $return['msg'] = Yii::t('front', 'download !.');
            }
        } catch (Exception $e) { // an exception is raised if a query fails
            $transaction->rollback();
            $return['msg'] = $e->getMessage();
        }

        echo CJSON::encode($return);
    }

    //=============================================================================================
    public function actionSpending() {

        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {


            $filters = array('dateSpending', 'idCustomer', 'customer', 'idCoordinator', 'coordinator', 'code', 'value');
            $no_filters = array('page', 'from', 'to');
            $criteria = new CDbCriteria();
            $condition = '';

            if (isset($_GET)) {
                $i = 0;
                foreach ($_GET as $key => $value) {

                    if ((!in_array($key, $no_filters)) && $value != '' && in_array($key, $filters)) {
                        $condition .= ($i == 0) ? '( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        $condition .= 't.' . $key;
                        $condition .= (($key != 'idCustomer' && $key != 'idCoordinator')) ? ' LIKE "%' . $value . '%"' : ' = ' . $value;
                        $i++;
                    }
                }

                $condition .= ($condition != '') ? ')' : '';
            }
            if (isset($_GET['from']) && $_GET['from'] != '') {
                $condition .= ($condition != '') ? ' AND ' : '';
                $to = (isset($_GET['to']) && $_GET['to'] != '') ? ' "' . $_GET['to'] . '"' : ' CURDATE()';
                $condition .= '(t.dateSpending BETWEEN "' . $_GET['from'] . '"  AND' . $to . ')';
            }

//               echo $condition;
//               exit;

            $criteria->condition = $condition;
            
            $criteria->select = 'SUM(value) as value';
            $total = ViewSpendings::model()->find($criteria);
            
            
            $criteria->select = 't.*';
            $criteria->group = 't.id';
            $criteria->order = "t.dateSpending DESC";
            $count = ViewSpendings::model()->count($criteria);

            $pages = new CPagination($count);

            $pages->pageSize = 20;
            $pages->applyLimit($criteria);

            $model = ViewSpendings::model()->findAll($criteria);

            $customers = ViewCustomers::model()->findAll(array('select' => 'id, name', 'order' => 'name ASC'));
            $coodinators = ViewCoordinators::model()->findAll(array('order' => 'name ASC'));

            $this->render('spendings', array(
                'model' => $model,
                'pages' => $pages,
                'customers' => $customers,
                'coodinators' => $coodinators,
                'total' => $total,
            ));
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }

    //=============================================================================================

    public function actionExportFilterSpendings() {
        $return = array('status' => 'error',
            'msg' => Yii::t('front', 'Solicitud Invalida'),
            'file' => '',
        );

        set_time_limit(0);
        $connection = Yii::app()->db;
        $transaction = $connection->beginTransaction();

        try {
            $root = Yii::getPathOfAlias('webroot');
            $filename = "/uploads/export/" . "export_spendings_" . Date('d_m_Y_h_i_s') . ".csv";


            $filters = array('dateSpending', 'idCustomer', 'customer', 'idCoordinator', 'coordinator', 'code', 'value');
            $no_filters = array('page', 'from', 'to');
            $condition = '';

            if (isset($_POST)) {
                $i = 0;
                foreach ($_POST as $key => $value) {

                    if ((!in_array($key, $no_filters)) && $value != '' && in_array($key, $filters)) {
                        $condition .= ($i == 0) ? '( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        $condition .= 't.' . $key;
                        $condition .= (($key != 'idCustomer' && $key != 'idCoordinator')) ? ' LIKE "%' . $value . '%"' : ' = ' . $value;
                        $i++;
                    }
                }

                $condition .= ($condition != '') ? ')' : '';
            }

            if (isset($_POST['from']) && $_POST['from'] != '') {
                $condition .= ($condition != '') ? ' AND ' : '';
                $to = (isset($_POST['to']) && $_POST['to'] != '') ? ' "' . $_POST['to'] . '"' : ' CURDATE()';
                $condition .= '(t.dateSpending BETWEEN "' . $_POST['from'] . '"  AND' . $to . ')';
            }

//               echo $condition;
//               exit;

            $condition = ($condition != '') ? 'WHERE ' . $condition : '';


            $sql = 'SELECT 
                       \'Fecha Gasto\',\'Cliente\',\'Coordinador\',\'Nombre Deudor\',\'CC / NIT \',\'Valor Gasto\'
                       UNION
                       SELECT 
                       REPLACE(REPLACE(REPLACE(dateSpending , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(REPLACE(REPLACE(customer , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),                       
                       REPLACE(REPLACE(REPLACE(coordinator , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'), 
                       REPLACE(REPLACE(REPLACE(name , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'), 
                       code,
                       REPLACE(value,\'.\',\',\') AS value                                             
                       FROM view_spendings t
                       ' . $condition . '
                       INTO OUTFILE \'' . $root . $filename . '\'
                       FIELDS TERMINATED BY \',\'
                       OPTIONALLY ENCLOSED BY \'"\'
                       LINES TERMINATED BY\'\n\'';

            $connection->createCommand($sql)->execute();
            //.... other SQL executions
            $transaction->commit();

            if (file_exists($root . $filename)) {
                $return['status'] = 'success';
                $return['file'] = $filename;
                $return['msg'] = Yii::t('front', 'download !.');
            }
        } catch (Exception $e) { // an exception is raised if a query fails
            $transaction->rollback();
            $return['msg'] = $e->getMessage();
        }

        echo CJSON::encode($return);
    }

    //=============================================================================================
    public function actionBusiness() {

        if (!Yii::app()->user->isGuest && in_array(Yii::app()->user->getState('rol'), $this->access)) {


            $filters = array('date', 'idUser', 'idBusinessAdvisor', 'numberDocument');
            $no_filters = array('page', 'from', 'to');
            $criteria = new CDbCriteria();
            $condition = '';

            if (isset($_GET)) {
                $i = 0;
                foreach ($_GET as $key => $value) {

                    if ((!in_array($key, $no_filters)) && $value != '' && in_array($key, $filters)) {
                        $condition .= ($i == 0) ? '( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        $condition .= 't.' . $key;
                        $condition .= (($key != 'idUser' && $key != 'idBusinessAdvisor')) ? ' LIKE "%' . $value . '%"' : ' = ' . $value;
                        $i++;
                    }
                }

                $condition .= ($condition != '') ? ')' : '';
            }
            if (isset($_GET['from']) && $_GET['from'] != '') {
                $condition .= ($condition != '') ? ' AND ' : '';
                $to = (isset($_GET['to']) && $_GET['to'] != '') ? ' "' . $_GET['to'] . '"' : ' CURDATE()';
                $condition .= '(t.date BETWEEN "' . $_GET['from'] . '"  AND' . $to . ')';
            }

//               echo $condition;
//               exit;

            $criteria->condition = $condition;
            
            $criteria->select = 'SUM(value) as value';
            $total = ViewBusinessSpendings::model()->find($criteria);
            
            
            $criteria->select = 't.*';
            $criteria->order = "t.date DESC";
            $criteria->group = 't.id';

            $count = ViewBusinessSpendings::model()->count($criteria);

            $pages = new CPagination($count);

            $pages->pageSize = 20;
            $pages->applyLimit($criteria);

            $model = ViewBusinessSpendings::model()->findAll($criteria);

            $business = ViewBusiness::model()->findAll(array('select' => 'id, idUser, name', 'order' => 'name ASC'));
            $businessAdvisors = ViewBusinessAdvisor::model()->findAll(array('order' => 'name ASC'));

            $this->render('business', array(
                'model' => $model,
                'pages' => $pages,
                'business' => $business,
                'businessAdvisors' => $businessAdvisors,
                'total' => $total,
            ));
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }

    //=============================================================================================

    public function actionExportFilterBusiness() {
        $return = array('status' => 'error',
            'msg' => Yii::t('front', 'Solicitud Invalida'),
            'file' => '',
        );

        set_time_limit(0);
        $connection = Yii::app()->db;
        $transaction = $connection->beginTransaction();

        try {
            $root = Yii::getPathOfAlias('webroot');
            $filename = "/uploads/export/" . "export_business_spendings_" . Date('d_m_Y_h_i_s') . ".csv";


            $filters = array('date', 'idUser', 'idBusinessAdvisor', 'numberDocument');
            $no_filters = array('page', 'from', 'to');
            $criteria = new CDbCriteria();
            $condition = '';

            if (isset($_GET)) {
                $i = 0;
                foreach ($_GET as $key => $value) {

                    if ((!in_array($key, $no_filters)) && $value != '' && in_array($key, $filters)) {
                        $condition .= ($i == 0) ? '( ' : '';
                        $condition .= ($i > 0) ? ' AND ' : '';
                        $condition .= 't.' . $key;
                        $condition .= (($key != 'idUser' && $key != 'idBusinessAdvisor')) ? ' LIKE "%' . $value . '%"' : ' = ' . $value;
                        $i++;
                    }
                }

                $condition .= ($condition != '') ? ')' : '';
            }
            if (isset($_GET['from']) && $_GET['from'] != '') {
                $condition .= ($condition != '') ? ' AND ' : '';
                $to = (isset($_GET['to']) && $_GET['to'] != '') ? ' "' . $_GET['to'] . '"' : ' CURDATE()';
                $condition .= '(t.date BETWEEN "' . $_GET['from'] . '"  AND' . $to . ')';
            }

//               echo $condition;
//               exit;

            $condition = ($condition != '') ? 'WHERE ' . $condition : '';


            $sql = 'SELECT 
                       \'Fecha Gasto\',\'Cliente\',\'CC / NIT\',\'Comercial\',\'Ubicacion\',\'Valor Gasto\'
                       UNION
                       SELECT 
                       REPLACE(REPLACE(REPLACE(date , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(REPLACE(REPLACE(nameUser , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),                       
                       REPLACE(REPLACE(REPLACE(numberDocument , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'), 
                       REPLACE(REPLACE(REPLACE(businessAdvisor , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'), 
                       REPLACE(REPLACE(REPLACE(location , \'"\',\'\'), CHAR(13), \' \'), CHAR(10), \' \'),
                       REPLACE(value,\'.\',\',\') AS value                                             
                       FROM view_business_spendings t
                       ' . $condition . '
                       INTO OUTFILE \'' . $root . $filename . '\'
                       FIELDS TERMINATED BY \',\'
                       OPTIONALLY ENCLOSED BY \'"\'
                       LINES TERMINATED BY\'\n\'';

            $connection->createCommand($sql)->execute();
            //.... other SQL executions
            $transaction->commit();

            if (file_exists($root . $filename)) {
                $return['status'] = 'success';
                $return['file'] = $filename;
                $return['msg'] = Yii::t('front', 'download !.');
            }
        } catch (Exception $e) { // an exception is raised if a query fails
            $transaction->rollback();
            $return['msg'] = $e->getMessage();
        }

        echo CJSON::encode($return);
    }

}
