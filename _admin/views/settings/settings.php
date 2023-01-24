<?php
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Tabs;
?>

<div class="settings-form card">
    <div class="card-body">
<?php
$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
$imageSrc= '';
$delUrl= '';
echo Tabs::widget([
        'items' => [
            [
                'label' =>yii::t('yii','General'),
                'content' =>'<br/>'.$this->render('_general',['form' => $form,'model' => $model])
            ],[
                'label' => yii::t('yii','Meta Information'),
                'content' =>'<br/>'.$this->render('_meta_information',['form' => $form,'model' => $model])
            ]
        ]
]);
?>

<div class="w-100"></div>
    <div class="form-group mt-3">
        <?= Html::submitButton(Yii::t('yii', '<i class="fas fa-save"></i> Save'), ['class' => 'btn btn-dark']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    </div>
</div>
