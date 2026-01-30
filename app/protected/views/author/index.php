<?php
$this->pageTitle = 'Авторы';
?>

<h2>Авторы</h2>

<?php $this->widget('zii.widgets.grid.CGridView', [
        'dataProvider' => $dataProvider,
        'cssFile' => false,
        'htmlOptions' => ['class' => 'table-responsive'],
        'itemsCssClass' => 'table table-striped table-hover table-bordered align-middle',
        'summaryCssClass' => 'text-end text-muted',
        'pager' => [
                'class' => 'CLinkPager',
                'htmlOptions' => ['class' => 'pagination justify-content-center'],
                'selectedPageCssClass' => 'active',
                'hiddenPageCssClass' => 'disabled',
        ],
        'columns' => [
                [
                        'name' => 'id',
                        'filter' => false,
                ],
                [
                        'name' => 'full_name',
                        'value' => '$data->getFullName()',
                        'filter' => false,
                ],
                [
                        'name' => 'books_count',
                        'value' => '$data->books_count',
                        'filter' => false,
                ],
                [
                        'class' => 'CButtonColumn',
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                                'update' => ['visible' => '!Yii::app()->user->isGuest'],
                                'delete' => ['visible' => '!Yii::app()->user->isGuest'],
                        ],
                ],
        ],
]); ?>
