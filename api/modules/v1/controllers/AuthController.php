<?php

namespace api\modules\v1\controllers;

use common\models\User as User2;
use Yii;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\User;

/**
 * Description of AuthController
 *
 * @author Alejandro Zanlongo <azanlongo at gmail.com>
 */
class AuthController extends ActiveController
{

    public $modelClass = User::class;

    public function init() {
        parent::init();
        Yii::$app->user->enableSession = false;
    }

    public function actionLogin() {
        $post = Yii::$app->request->post();

        $model = User2::findOne(['username' => $post['username']]);
        if (empty($model)) {
            throw new NotFoundHttpException('User not found');
        }
        if (!$model->validatePassword($post['password'])) {
            throw new ForbiddenHttpException('Please check your username and password and try again');
        }
        return $model;
    }

}
