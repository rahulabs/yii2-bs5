<?php

use yii\bootstrap5\Tabs;
use yii\bootstrap5\Html;

$items = [];
foreach ($all_languages as $all_language):
    $flag = Html::img(Yii::$app->request->baseUrl.'/images/flags/'.$all_language['image'],['class' => 'img-fluid','alt' => $all_language['name'],'title' => $all_language['name'], 'width' => 20]);
    $items[] = [
        'label' => $flag.' '.$all_language['name'],
        'content' => '<br/>'.$this->render('_language_meta_info',['form'=>$form, 'model'=>$model, 'language' => $all_language])
    ];
endforeach;
?>
<div class="row">
    <div class="col-sm-12 mb-3">
        <?=
        Tabs::widget([
            'encodeLabels' => false,
            'items' => $items
        ]);
        ?>
    </div>
</div>
