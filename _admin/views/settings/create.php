<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Settings */

$this->title = Yii::t('yii', 'Update Settings', [
    'modelClass' => 'Settings',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Settings')];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="settings-create mb-4">

    <?= $this->render('settings', [
		   'model' => $model,
    ]) ?>

</div>
