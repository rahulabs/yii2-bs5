<div class="row">
    <div class="col-sm-12">
        <?= $form->field($model, 'meta_title['.$language['language_id'].']')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-12">
        <?= $form->field($model, 'meta_description['.$language['language_id'].']')->textarea(['rows' => 6]) ?>
    </div>

    <div class="col-sm-12">
        <?= $form->field($model, 'meta_keyword['.$language['language_id'].']')->textInput(['maxlength' => true]) ?>
    </div>
</div>