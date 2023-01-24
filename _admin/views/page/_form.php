<?php
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Tabs;
use common\models\Language;

/* @var $this yii\web\View */
/* @var $model common\models\Page */
/* @var $form yii\widgets\ActiveForm */

$all_languages = Language::find()->where(['status' => 1])->asArray()->all();
$titles = $model->pagesDescriptions;
if(!empty($titles)){
    $title = $description = $meta_title = $meta_description = $meta_keyword = [];
    foreach ($titles as $page_title){
        $title[$page_title->language_id] = $page_title->title;
        $description[$page_title->language_id] = $page_title->description;
        $meta_title[$page_title->language_id] = $page_title->meta_title;
        $meta_description[$page_title->language_id] = $page_title->meta_description;
        $meta_keyword[$page_title->language_id] = $page_title->meta_keyword;
    }

    $model->title = $title;
    $model->description = $description;
    $model->meta_title = $meta_title;
    $model->meta_description = $meta_description;
    $model->meta_keyword = $meta_keyword;
}
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php
        echo Tabs::widget([
            'items' => [
                [
                    'label' =>yii::t('yii','General'),
                    'content' =>'<br/>'.
                        $this->render('_general_form',['form'=>$form,'model'=>$model,'all_languages' => $all_languages])
                ],
                [
                    'label' =>yii::t('yii','Meta Information'),
                    'content' =>'<br/>'.
                        $this->render('_meta_info_form',['form'=>$form,'model'=>$model,'all_languages' => $all_languages])
                ],
            ]
        ]);
    ?>
    <div class="form-group col-sm-12 mt-3">
        <?= Html::submitButton('<i class="fas fa-save"></i> '.(($model->isNewRecord) ? 'Save' : 'Update'), ['class' => 'btn btn-outline-dark mb-3 btn-sm']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$this->registerJs("
    function convertToSlug(Text)
    {
        return Text
            .toLowerCase()
            .replace(/[^\w ]+/g,'')
            .replace(/ +/g,'-')
            ;
    }
",yii\web\View::POS_HEAD);
$this->registerJs('
    $("#page-title-1").on("keyup",function(){
        var title = $(this).val();
        var slug = convertToSlug(title);
        $("#page-slug").val(slug);
    })
');