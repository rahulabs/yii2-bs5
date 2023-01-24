<?php
use mihaildev\ckeditor\CKEditor;
?>
<div class="row">
    <div class="col-sm-12">
        <?= $form->field($model, 'title['.$language['language_id'].']')->textInput() ?>
    </div>

    <div class="col-sm-12">
        <?=
        $form->field($model, 'description['.$language['language_id'].']')->widget(CKEditor::class,[
            'editorOptions' => [
                'preset' => 'full',
                'inline' => false,
            ],
        ]);
        ?>

    </div>
</div>
