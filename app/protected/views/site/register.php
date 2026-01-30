<?php

$this->pageTitle = 'Регистрация';
?>

<h2>Регистрация</h2>

<?php
$form = $this->beginWidget('CActiveForm', [
        'id' => 'register-form',
        'enableClientValidation' => true,
]); ?>

<div class="mb-3">
    <?= $form->labelEx($model, 'username', ['class' => 'form-label']) ?>
    <?= $form->textField($model, 'username', ['class' => 'form-control']) ?>
    <?= $form->error($model, 'username', ['class' => 'text-danger small']) ?>
</div>

<div class="mb-3">
    <?= $form->label($model, 'password', ['class' => 'form-label']) ?>
    <?= CHtml::passwordField('User[password]', '', ['class' => 'form-control']) ?>
</div>

<div class="mb-3">
    <?= $form->labelEx($model, 'email', ['class' => 'form-label']) ?>
    <?= $form->textField($model, 'email', ['class' => 'form-control']) ?>
    <?= $form->error($model, 'email', ['class' => 'text-danger small']) ?>
</div>

<div class="mb-3">
    <?= CHtml::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary']) ?>
</div>

<?php
$this->endWidget(); ?>
