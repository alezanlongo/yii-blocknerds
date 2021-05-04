<?php

namespace frontend\controllers\api;

use Codeception\Util\HttpCode;
use frontend\models\UserCollectionQuery;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

/**
 * Description of CollectionController
 *
 * @author Alejandro Zanlongo <azanlongo at gmail.com>
 */
class CollectionController extends ActiveController
{

    public $modelClass = 'common\models\UserCollection';

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
        unset($actions['delete'], $actions['create'], $actions['update'], $actions['view']);
        $actions['index']['prepareDataProvider'] = [$this, 'actionIndex'];
        return $actions;
    }

    protected function verbs() {
        return [
            'view' => ['GET', 'HEAD'],
        ];
    }

    public function actionIndex() {
        $model = UserCollectionQuery::getCollectionsByUserId(Yii::$app->user->id);
        return $model->all();
    }

    public function actionView($id) {
        $res = UserCollectionQuery::getUserCollectionById(Yii::$app->user->id, $id);
        if ($res === null) {
            $this->response->setStatusCode(HttpCode::NOT_FOUND);
            return[];
        }
        return ['id' => $res->id, 'name' => $res->name, 'images' => $res->getUserCollectionImage()->all()];
    }

}
