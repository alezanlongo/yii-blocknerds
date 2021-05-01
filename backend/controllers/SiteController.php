<?php

namespace backend\controllers;

use app\libs\CollectionsUtils;
use common\models\LoginForm;
use common\models\User;
use common\models\UserCollection;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'download'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            return Yii::$app->user->identity->role == User::ROLE_ADMIN;
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        return $this->render('index',
                        ['collections' => UserCollection::find()->getCollectionsByUserId(Yii::$app->getUser()->getId(), 0, 10)->orderBy('updated_at', 'desc')->all()]
        );
    }

    public function actionDownload($id, $token = null) {
        $sess = Yii::$app->session;
        if ($token != null) {
            $fileToken = CollectionsUtils::getDownloadFileByToken($sess, $token, $id);
            if ($this->request->isAjax) {
                return new BadRequestHttpException('invalid request');
            }
            if ($fileToken === false) {
                return new BadRequestHttpException('invalid token');
            }
            return Yii::$app->response->sendFile($fileToken['file'], $fileToken['filename']);
        }

        if (!$this->request->isAjax || !$this->request->isGet) {
            return new BadRequestHttpException('request must be ajax GET');
        }

        $res = UserCollection::find()->getUserCollectionById(Yii::$app->getUser()->getId(), $id)->one();
        $this->response->format = Response::FORMAT_JSON;
        if (empty($res)) {
            $this->response->data(['status' => 'err', 'message' => 'collection doesn\'t exists']);
            return $this->response;
        }
        $files = [];
        foreach ($res['collection'] as $v) {
            $files[] = $v['img'];
        }
        $zipFile = CollectionsUtils::createZip(Yii::$app->getUser()->getId(), $id, $res['updated_at'], $files);
        if (!$zipFile) {
            $this->response->data(['status' => 'err', 'message' => 'error creating zip file']);
            return $this->response;
        }
        $hash = CollectionsUtils::createDownloadToken($sess, Yii::$app->getUser()->getId(), $id, $zipFile['file'], $zipFile['filename']);
        $this->response->data = ['status' => 'ok', 'download_token' => $hash];
        return $this->response;
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('site/login');
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
