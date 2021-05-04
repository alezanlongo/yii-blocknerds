<?php

namespace frontend\controllers\api;

use Codeception\Util\HttpCode;
use frontend\models\UserCollectionImageQuery;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

/**
 * Description of ImageController
 *
 * @author Alejandro Zanlongo <azanlongo at gmail.com>
 */
class ImageController extends ActiveController
{

    public $modelClass = 'common\models\UserCollectionImage';

    public function init() {
        parent::init();
        Yii::$app->user->enableSession = false;
    }

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'authMethods' => [
                HttpBearerAuth::class,
            ],
        ];
        return $behaviors;
    }

    public function actions() {
        $actions = parent::actions();
        unset($actions['delete'], $actions['create'], $actions['update'], $actions['view'], $actions['index']);
        return $actions;
    }

    public function actionView($id) {
        $res = UserCollectionImageQuery::getUserImageById(\Yii::$app->user->id, $id)->one();
        if ($res === null) {
            $this->response->setStatusCode(HttpCode::NOT_FOUND);
            return[];
        }
        return $res;
    }

}
