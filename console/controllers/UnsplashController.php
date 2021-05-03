<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Description of UnsplashController
 *
 * @author Alejandro Zanlongo <azanlongo at gmail.com>
 */
class UnsplashController extends Controller
{

    public function actionSearch($keyword, $export = null) {
        try {
            $res = Yii::$app->unsplashApi->search($keyword);
        } catch (Exception $ex) {
            echo ('An exception was thrown!');
            return ExitCode::UNSPECIFIED_ERROR;
        } catch (HttpClientException) {
            echo ('An exception was thrown!');
            return ExitCode::UNSPECIFIED_ERROR;
        }

        if ($export != null) {
            $dt = new \DateTime();
            $filename = preg_replace("/([^0-9A-Z])+/i", '_', $keyword) . '-' . $dt->format('YmdHis');
            switch ($export) {
                case 'json':
                    $filename = $filename . '.json';
                    $fh = fopen($filename, 'w');
                    fwrite($fh, json_encode($res,JSON_PRETTY_PRINT));
                    fclose($fh);
                    break;
                default :
                    $this->stdout("Format: {$export} unsupported", \yii\helpers\Console::FG_YELLOW);
                    return ExitCode::UNAVAILABLE;
                    break;
            }
            $this->stdout("Exported successfully: " . $filename);
        } else {
            print_r($res);
        }
        return ExitCode::OK;
    }

    //put your code here
}
