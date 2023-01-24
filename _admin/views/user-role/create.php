<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserRole */

$this->title = Yii::t('app', 'Create User Role');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-role-create">
    <div class="d-flex align-items-center justify-content-between">
        <p>&nbsp;</p>
        <?= Html::a('Back',['index'],['class' => 'btn btn-outline-dark mb-3 btn-sm']) ?>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
        'permissions' => $permissions,
    ]) ?>

</div>
