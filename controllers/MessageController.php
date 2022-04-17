<?php

namespace app\controllers;

use app\models\Follow;
use app\models\Message;
use app\models\Player;
use app\models\PlayerSearch;
use app\models\User;
use app\models\MessageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
/**
 * MessageController implements the CRUD actions for Message model.
 */
class MessageController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Message models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new Message();
        $title = "";
        $is_me = 0;
        $user_id = Yii::$app->user->identity->id;
        if(isset($_REQUEST['user_id']) && $_REQUEST['user_id']!=$user_id){
            $user = User::findOne($_REQUEST['user_id']);
            if($user)
            $title = $user->first_name.' '.$user->last_name.'`s ';
        }
        else{
            $is_me = 1;
            $title = "My ";
        }
            

        $searchModel = new MessageSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $followers=Follow::find()->select('touser_id')->andFilterWhere(['user_id'=>$user_id]);
        $players=Player::find()->andFilterWhere(['<>','user_type',1])->andFilterWhere(['<>','id',$user_id])
            ->andFilterWhere(['in','id',$followers])->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title' => $title,
            'model'=>$model,
            'is_me'=>$is_me,
            'players'=>$players
        ]);
    }

    /**
     * Displays a single Message model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Message model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function beforeAction($action)
    {            
        if ($action->id == 'create') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }
    public function actionCreate()
    {
        $model = new Message();

        if ($this->request->isPost) {

            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $model->addError('message','HTML not allow in message');
                if(ActiveForm::validate($model))
                return ActiveForm::validate($model);
            }

            if ($model->load($this->request->post()) ) {

                $model->user_id = Yii::$app->user->identity->id;
                $model->created_date = date('Y-m-d H:i:s');
                if($model->save())
                {

                }
                else{

                }
            }
            
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Message model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Message model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Message model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Message the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Message::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
