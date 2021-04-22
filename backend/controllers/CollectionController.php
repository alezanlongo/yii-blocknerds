<?php

namespace backend\controllers;

use app\models\UserCollectionSearch;
use common\models\UserCollection;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * CollectionController implements the CRUD actions for UserCollection model.
 */
class CollectionController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all UserCollection models.
     * @return mixed
     */
    public function actionIndex() {
//        $searchModel = new UserCollectionSearch();
        //$res = UserCollection::find()->getCollectionsByUserId(Yii::$app->getUser()->getId())->all();
        //var_dump($res);
        //die;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //Yii::$app->unsplashApi->search('fire');
        //var_dump(Yii::$app->unsplashApi->search('fire'));
        //echo Yii::$app->user->id;
        return $this->render('index', [
//                    'searchModel' => new UsersCollectionsQuery(UserCollection::class),
                    'dataProvider' => new ActiveDataProvider(['query' => UserCollection::find()->getCollectionsByUserId(Yii::$app->getUser()->getId()), 'pagination' => ['pageSize' => 20]]),
        ]);
    }

    /**
     * Displays a single UserCollection model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserCollection model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new UserCollection();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserCollection model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserCollection model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserCollection model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserCollection the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = UserCollection::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
