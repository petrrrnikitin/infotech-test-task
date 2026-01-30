<?php
$form = $this->beginWidget('CActiveForm', [
        'id' => 'author-form',
        'enableClientValidation' => true,
]); ?>

<div class="mb-3">
    <?= $form->labelEx($model, 'last_name', ['class' => 'form-label']) ?>
    <?= $form->textField($model, 'last_name', ['class' => 'form-control']) ?>
    <?= $form->error($model, 'last_name', ['class' => 'text-danger small']) ?>
</div>

<div class="mb-3">
    <?= $form->labelEx($model, 'first_name', ['class' => 'form-label']) ?>
    <?= $form->textField($model, 'first_name', ['class' => 'form-control']) ?>
    <?= $form->error($model, 'first_name', ['class' => 'text-danger small']) ?>
</div>

<div class="mb-3">
    <?= $form->labelEx($model, 'middle_name', ['class' => 'form-label']) ?>
    <?= $form->textField($model, 'middle_name', ['class' => 'form-control']) ?>
    <?= $form->error($model, 'middle_name', ['class' => 'text-danger small']) ?>
</div>

<div class="mb-3">
    <?= CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php
$this->endWidget(); ?>
