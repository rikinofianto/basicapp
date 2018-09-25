<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\DclFieldDataBody;
use app\modules\admin\models\searchs\DclFieldDataBody as DclFieldDataBodySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\modules\admin\components\BaseController;

/**
 * ContentController implements the CRUD actions for DclFieldDataBody model.
 */
class ContentController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all DclFieldDataBody models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DclFieldDataBodySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // $dataProvider->sort = ['defaultOrder' => ['dcl_node.changed' => SORT_DESC] ];
        $dataProvider->query->orderBy(['dcl_node.changed' => SORT_DESC]);
        $dataProvider->pagination = ['pageSize' => 10 ];


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DclFieldDataBody model.
     * @param integer $id
     * @param integer $deleted
     * @param string $node_id
     * @param string $language
     * @param integer $delta
     * @return mixed
     */
    public function actionView($id, $deleted, $node_id, $language, $delta)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $deleted, $node_id, $language, $delta),
        ]);
    }

    /**
     * Creates a new DclFieldDataBody model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DclFieldDataBody();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'deleted' => $model->deleted, 'node_id' => $model->node_id, 'language' => $model->language, 'delta' => $model->delta]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DclFieldDataBody model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $deleted
     * @param string $node_id
     * @param string $language
     * @param integer $delta
     * @return mixed
     */
    public function actionUpdate($id, $deleted, $node_id, $language, $delta)
    {
        $model = $this->findModel($id, $deleted, $node_id, $language, $delta);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'deleted' => $model->deleted, 'node_id' => $model->node_id, 'language' => $model->language, 'delta' => $model->delta]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DclFieldDataBody model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $deleted
     * @param string $node_id
     * @param string $language
     * @param integer $delta
     * @return mixed
     */
    public function actionDelete($id, $deleted, $node_id, $language, $delta)
    {
        $this->findModel($id, $deleted, $node_id, $language, $delta)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DclFieldDataBody model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $deleted
     * @param string $node_id
     * @param string $language
     * @param integer $delta
     * @return DclFieldDataBody the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $deleted, $node_id, $language, $delta)
    {
        if (($model = DclFieldDataBody::findOne(['id' => $id, 'deleted' => $deleted, 'node_id' => $node_id, 'language' => $language, 'delta' => $delta])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
