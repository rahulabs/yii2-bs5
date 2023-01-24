<?php

use yii\bootstrap5\Html;
use kartik\select2\Select2;
use yii\bootstrap5\Tabs;

if(empty($model->page_order))
    $model->page_order = 1;

$items = [];
foreach ($all_languages as $all_language):
    $flag = Html::img(Yii::$app->request->baseUrl.'/images/flags/'.$all_language['image'],['class' => 'img-fluid','alt' => $all_language['name'],'title' => $all_language['name'], 'width' => 20]);
    $items[] = [
        'label' => $flag.' '.$all_language['name'],
        'content' => '<br/>'.$this->render('_language_general',['form'=>$form, 'model'=>$model, 'language' => $all_language])
    ];
endforeach;
?>
<div class="row">
    <div class="col-sm-12">
        <?=
        Tabs::widget([
            'encodeLabels' => false,
            'items' => $items
        ]);
        ?>
    </div>
    <div class="w-100 mt-3"></div>
    <div class="col-sm-4">
        <?= $form->field($model, 'slug')->textInput() ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'status')->widget(Select2::classname(), [
            'data' => [ 1 => 'Active', 0 => 'Inactive'],
        ]); ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'page_order')->textInput() ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'page_type')->widget(Select2::classname(), [
            'data' => [ 0 => 'Normal Page', 1 => 'Module'],
        ]); ?>
    </div>
    <div class="w-100"></div>

    <div class="col-sm-12">
        <?= $form->field($model, 'show_on_footer')->checkbox() ?>

        <?= $form->field($model, 'show_on_header')->checkbox() ?>
    </div>

    <div class="col-sm-6">
        <?= $form->field($model, 'external_url')->textInput() ?>
    </div>
</div>
<div class="w-100"></div>
