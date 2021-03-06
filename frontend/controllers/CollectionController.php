<?php

namespace frontend\controllers;

use frontend\models\UserCollectionForm;
use frontend\models\UserCollectionQuery;
use common\models\User;
use common\models\UserCollection;
use DateTime;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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
        return $this->render('index', [
                    'dataProvider' => new ActiveDataProvider(['query' => UserCollectionQuery::getCollectionsByUserId(Yii::$app->getUser()->getId()), 'pagination' => ['pageSize' => 20]]),
        ]);
    }

    /**
     * Displays a single UserCollection model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $model = UserCollectionQuery::getUserCollectionById(\Yii::$app->getUser()->getId(), $id);
        if ($model === null) {
            throw new NotFoundHttpException('collection not forund');
        }
        return $this->render('view', [
                    'model' => $model,
        ]);
    }

    /**
     * Creates a new UserCollection model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = User::findIdentity(Yii::$app->getUser()->getId());
        $modelCollectionForm = new UserCollectionForm();

        if ($modelCollectionForm->load(Yii::$app->request->post()) && $modelCollectionForm->validate() && $modelCollectionForm->createCollection($model)) {
            return $this->redirect(['view', 'id' => $modelCollectionForm->id]);
        }

        return $this->render('create', [
                    'model' => $modelCollectionForm,
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
        $model = UserCollectionQuery::getUserCollectionById(\Yii::$app->getUser()->getId(), $id);
        if ($model === null) {
            throw new NotFoundHttpException('collection not forund');
        }
        $modelCollectionForm = new UserCollectionForm($model);
        if ($modelCollectionForm->load(Yii::$app->request->post()) && $modelCollectionForm->validate() && $modelCollectionForm->updateCollection()) {
            return $this->redirect(['view', 'id' => $modelCollectionForm->id]);
        }

        return $this->render('update', [
                    'model' => $modelCollectionForm,
        ]);
    }

    /**
     * Receive and retrieve through AJAX unsplash search results
     * @return Response
     * @throws BadRequestHttpException
     */
    public function actionLookup() {
        if (!$this->request->isAjax || !$this->request->isPost) {
            throw new BadRequestHttpException("bad request");
        }
        $kwd = $this->request->post()['keyword'] ?? '';
        $this->response->format = Response::FORMAT_JSON;
        $imgRes = Yii::$app->unsplashApi->reduceSearchResult(Yii::$app->unsplashApi->search($kwd), ['alt_description']);
        $this->response->data = ['img' => $imgRes];
        return $this->response;
    }

    /**
     * Deletes an existing UserCollection model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $model = UserCollectionQuery::getUserCollectionById(Yii::$app->user->id, $id);
        if ($model === null) {
            Yii::$app->session->setFlash('error', "Collection {$id} doesn't exists");
            return $this->redirect(['index']);
        }

        foreach ($model->getUserCollectionImage()->all() as $v) {
            Yii::$app->imageStorage->deleteImage($v['image_file']);
        }
        $model->delete();
        Yii::$app->session->setFlash('success', "Collection {$id} was deleted");
        return $this->redirect(['index']);
    }

    public function beforeAction($action): bool {
        if ($action->actionMethod === 'actionLookup') {
            $dt = new DateTime();
            Yii::info("action method '{$action->actionMethod
                    }' start: {$dt->format('Y-m-d H:i:s')}", 'unsplashSearch');
        }
        return parent::beforeAction($action);
    }

    public function afterAction($action, $result) {
        if ($action->actionMethod === 'actionLookup') {
            $dt = new DateTime();
            Yii::info("action method '{$action->actionMethod}' end: {$dt->format('Y-m-d H:i:s')}", 'unsplashSearch');
        }

        return parent::afterAction($action, $result);
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
