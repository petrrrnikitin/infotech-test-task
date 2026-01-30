<?php
$form = $this->beginWidget('CActiveForm', [
    'id' => 'book-form',
    'enableClientValidation' => true,
    'htmlOptions' => ['enctype' => 'multipart/form-data'],
]); ?>

<div class="mb-3">
    <?= $form->labelEx($model, 'title', ['class' => 'form-label']) ?>
    <?= $form->textField($model, 'title', ['class' => 'form-control']) ?>
    <?= $form->error($model, 'title', ['class' => 'text-danger small']) ?>
</div>

<div class="mb-3">
    <?= $form->labelEx($model, 'year', ['class' => 'form-label']) ?>
    <?= $form->textField($model, 'year', ['class' => 'form-control']) ?>
    <?= $form->error($model, 'year', ['class' => 'text-danger small']) ?>
</div>

<div class="mb-3">
    <?= $form->labelEx($model, 'isbn', ['class' => 'form-label']) ?>
    <?= $form->textField($model, 'isbn', ['class' => 'form-control']) ?>
    <?= $form->error($model, 'isbn', ['class' => 'text-danger small']) ?>
</div>

<div class="mb-3">
    <?= $form->labelEx($model, 'description', ['class' => 'form-label']) ?>
    <?= $form->textArea($model, 'description', ['class' => 'form-control', 'rows' => 4]) ?>
    <?= $form->error($model, 'description', ['class' => 'text-danger small']) ?>
</div>

<div class="mb-3">
    <?= $form->labelEx($model, 'photo', ['class' => 'form-label']) ?>
    <?= $form->fileField($model, 'photo', ['class' => 'form-control']) ?>
    <?= $form->error($model, 'photo', ['class' => 'text-danger small']) ?>
    <?php if ($model->photo): ?>
        <div class="mt-2">
            <img src="/uploads/<?= CHtml::encode($model->photo) ?>" class="img-thumbnail" style="max-width: 100px;">
        </div>
    <?php endif; ?>
</div>

<div class="mb-3">
    <label class="form-label">Авторы</label>
    <?php
    $authors = CHtml::listData(Author::model()->findAll(), 'id', 'fullName');
    $selected = $model->isNewRecord ? [] : CHtml::listData($model->authors, 'id', 'id');
    echo CHtml::listBox('Book[authorIds]', $selected, $authors, [
        'multiple' => 'multiple',
        'size' => 6,
        'class' => 'form-select',
    ]);
    ?>
</div>

<div class="mb-3">
    <?= CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php $this->endWidget(); ?>
