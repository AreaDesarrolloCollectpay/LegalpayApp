<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>

class <?php echo $this->controllerClass; ?> extends ApiController {

    public $idParamName = '<?php echo $this->tableSchema->primaryKey; ?>';
    <?php 
        $fields = array();
        foreach ($this->tableSchema->columns as $column):
            $fields[] = "'$column->name'";
        endforeach;
        $relations = array();
        foreach ($this->getRelations($this->modelClass) as $relation):
            $relations[] = "'{$relation[0]}'";
        endforeach;
    ?>
public $safeAttributes = array(
        <?php echo implode(',', $fields) ?>, <?php echo implode(',', $relations) ?> // with relations
    );
    
    public function __construct($id, $module = null) {
        $this->model = new <?php echo $this->modelClass; ?>('read');
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
            <?php foreach ($relations as $key => $relation): ?>
    <?php echo $relation; ?> => array(// relation GET parameter name (...?with=nameRelation)
                'relationName' => <?php echo $relation; ?>, //model relation name
                'columnName' => <?php echo $relation; ?>, //column name in response
                'return' => 'array', //return array of arrays or array of models
            ),
            <?php endforeach; ?>
            );
    }

}
