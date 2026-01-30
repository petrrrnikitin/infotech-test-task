<?php

class ReportController extends CController
{
    public $layout = '//layouts/main';

    public function actionTopAuthors(): void
    {
        $year = Yii::app()->request->getPost('year');
        $results = null;

        if ($year !== null) {
            try {
                $results = Yii::app()->authorService->getTopAuthorsByYear((int)$year);
            } catch (Exception $e) {
                Yii::app()->user->setFlash('error', $e->getMessage());
            }
        }

        $this->render('topAuthors', [
            'results' => $results,
            'year' => $year,
        ]);
    }
}
