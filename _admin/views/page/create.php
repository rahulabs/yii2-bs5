<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Page */

$this->title = Yii::t('app', 'Create Page');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-create">
    <div class="d-flex align-items-center justify-content-between">
        <p>&nbsp;</p>
        <?= Html::a('Back',['index'],['class' => 'btn btn-outline-dark mb-3 btn-sm']) ?>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
