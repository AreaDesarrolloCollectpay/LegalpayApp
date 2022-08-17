<?php

class UserController extends ApiController {

    public $idParamName = 'idcmsusuario';
    public $safeAttributes = array(
        'idcmsusuario','usuario','contrasena','nombres','apellidos','email','empresa','telefono','descripcion','ciudad','cms_rol_id','token_chage','activo', 'cmsRol' // with relations
    );
    
    public function __construct($id, $module = null) {
        $this->model = new CmsUsuario('read');
        parent::__construct($id, $module);
    }
    
    public function filters(){
        if(!Controller::validAccessAuthRest()){
            $this->accessDenied();
        }
    }

    /**
     * Function returns user data
     * @method GET
     */
    public function actionView() {
        $this->getView();
    }

    /**
     * Function returns user list
     * @method GET
     */
    public function actionList() {
        $this->getList();
    }

    /**
     * Function creates new user
     * @method POST
     */
    public function actionCreate() {
        $this->model->setScenario('create');
        $this->create();
    }

    /**
     * Function updates user.
     * @method PUT
     */
    public function actionUpdate() {
        $this->model->setScenario('update');
        $this->update();
    }

    /**
     * Function deletes user.
     * @method DELETE
     */
    public function actionDelete() {
        $this->model->setScenario('delete');
        $this->delete();
    }

    public function getRelations() {
        return array(
                'cmsRol' => array(// relation GET parameter name (...?with=nameRelation)
                'relationName' => 'cmsRol', //model relation name
                'columnName' => 'cmsRol', //column name in response
                'return' => 'array', //return array of arrays or array of models
            ),
                        );
    }

}
