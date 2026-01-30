<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle = 'Вход';
?>

<h2>Вход</h2>

<?php $form = $this->beginWidget('CActiveForm', [
    'id' => 'login-form',
    'enableClientValidation' => true,
    'clientOptions' => [
        'validateOnSubmit' => true,
    ],
]); ?>

<div class="mb-3">
    <?php echo $form->labelEx($model, 'username', ['class' => 'form-label']); ?>
    <?php echo $form->textField($model, 'username', ['class' => 'form-control']); ?>
    <?php echo $form->error($model, 'username', ['class' => 'text-danger small']); ?>
</div>

<div class="mb-3">
    <?php echo $form->labelEx($model, 'password', ['class' => 'form-label']); ?>
    <?php echo $form->passwordField($model, 'password', ['class' => 'form-control']); ?>
    <?php echo $form->error($model, 'password', ['class' => 'text-danger small']); ?>
</div>

<div class="mb-3 form-check">
    <?php echo $form->checkBox($model, 'rememberMe', ['class' => 'form-check-input']); ?>
    <?php echo $form->label($model, 'rememberMe', ['class' => 'form-check-label']); ?>
</div>

<div class="mb-3">
    <?php echo CHtml::submitButton('Войти', ['class' => 'btn btn-primary']); ?>
</div>

<?php $this->endWidget(); ?>