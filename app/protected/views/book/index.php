<?php

$this->pageTitle = 'Книги';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Каталог книг</h2>
</div>

<?php
$this->widget('zii.widgets.CListView', [
        'dataProvider' => $dataProvider,
        'itemView' => '/book/_item',
        'itemsCssClass' => 'row',
        'summaryCssClass' => 'text-muted mb-3',
        'pagerCssClass' => 'd-flex justify-content-center',
]); ?>
