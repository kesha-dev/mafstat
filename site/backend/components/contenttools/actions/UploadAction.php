<?php

namespace backend\components\contenttools\actions;

use Yii;
use yii\base\Action;
use yii\helpers\Json;
use yii\web\UploadedFile;
use backend\components\contenttools\models\ImageForm;

/**
 * @author Paweł Bizley Brzozowski
 * @version 1.0
 * @license Apache 2.0
 * https://github.com/bizley-code/yii2-content-tools
 * http://www.yiiframework.com/extension/yii2-content-tools
 *
 * ContentTools was created by Anthony Blackshaw
 * http://getcontenttools.com/
 * https://github.com/GetmeUK/ContentTools
 *
 * Example action prepared for the Yii 2 ContentTools.
 *
 * This action handles validation of the uploaded image and saving it.
 *
 * Validation is done using the ImageForm.
 * Action returns the size and url of uploaded image.
 */
class UploadAction extends Action
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (Yii::$app->request->isPost) {
            $model = new ImageForm;
            $model->image = UploadedFile::getInstanceByName('image');
            if ($model->validate()) {
                if ($model->upload()) {
                    list($width, $height) = getimagesize($model->path);
                    return Json::encode([
                        'size' => [$width, $height],
                        'url' => $model->url
                    ]);
                }
            } else {
                $errors = [];
                $modelErrors = $model->getErrors();
                foreach ($modelErrors as $field => $fieldErrors) {
                    foreach ($fieldErrors as $fieldError) {
                        $errors[] = $fieldError;
                    }
                }
                if (empty($errors)) {
                    $errors = ['Unknown file upload validation error!'];
                }
                return Json::encode(['errors' => $errors]);
            }
        }
    }
}