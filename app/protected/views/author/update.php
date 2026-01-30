<?php

$this->pageTitle = 'Редактировать автора: ' . $model->getFullName();
?>

<h2>Редактировать автора: <?= CHtml::encode($model->getFullName()) ?></h2>

<?= $this->renderPartial('_form', ['model' => $model]) ?>
