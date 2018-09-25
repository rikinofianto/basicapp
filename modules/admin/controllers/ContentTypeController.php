<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\DclNodeType;
use app\modules\admin\models\searchs\DclNodeType as DclNodeTypeSearch;

use app\modules\admin\models\DclFieldConfig;
use app\modules\admin\models\searchs\DclFieldConfig as DclFieldConfigSearch;

use app\modules\admin\components\BaseController;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContentTypeController implements the CRUD actions for DclNodeType model.
 */
class ContentTypeController extends BaseController
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
                    'fields-delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all DclNodeType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $modelForm = new DclNodeType();

        if ($modelForm->load(Yii::$app->request->post())) 
        {
            if ($modelForm->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('app','Data Saved'));
                return $this->redirect(['index']);
            }
            else
            {
                // print_r($modelForm->getErrors());die;
                Yii::$app->getSession()->setFlash('danger', Yii::t('app','Save Failed!'));
            }
        } 

        $searchModel = new DclNodeTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['created' => SORT_DESC] ];
        $dataProvider->pagination = ['pageSize' => 10 ];


        return $this->render('index', [
            'modelForm' => $modelForm,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DclNodeType model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DclNodeType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // public function actionCreate()
    // {
    //     $model = new DclNodeType();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->node_type]);
    //     } else {
    //         return $this->render('create', [
    //             'model' => $model,
    //         ]);
    //     }
    // }

    /**
     * Updates an existing DclNodeType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->node_type]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DclNodeType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DclNodeType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return DclNodeType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DclNodeType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



    // Fields Area
    /**
     * [actionManageFields description]
     * @return [type] [description]
     */
    public function actionManageFields($id = null)
    {
        // \Yii::$app->db->createCommand()->createTable('news', [
        //         'id' => \yii\db\Schema::TYPE_PK,
        //         'title' => \yii\db\Schema::TYPE_STRING . ' NOT NULL',
        //         'content' => \yii\db\Schema::TYPE_TEXT,
        //         ])->execute();
        $modelForm = new DclFieldConfig();

        if ($modelForm->load(Yii::$app->request->post())) 
        {
            $modelForm->node_type = $id;
            if ($modelForm->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('app','Data Saved'));
                // $modelForm = new DclFieldConfig();
                return $this->refresh();
            }
            else
            {
                // print_r($modelForm->getErrors());die;
                Yii::$app->getSession()->setFlash('danger', Yii::t('app','Save Failed!'));
            }
        } 

        $searchModel = new DclFieldConfigSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where(['node_type' => $id]);
        $dataProvider->sort = ['defaultOrder' => ['id' => SORT_DESC] ];
        $dataProvider->pagination = ['pageSize' => 10 ];


        return $this->render('manage-fields', [
            'id' => $id,
            'modelForm' => $modelForm,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

/**
     * Updates an existing DclFieldConfig model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionFieldsUpdate($id)
    {
        $model = $this->findModelFields($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('app','Data Saved'));
            return $this->redirect(['manage-fields', 'id' => $model->node_type]);
        } else {
            return $this->render('fields-update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DclFieldConfig model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionFieldsDelete($id)
    {
        $model = $this->findModelFields($id);
        $model->delete();

        Yii::$app->getSession()->setFlash('success', Yii::t('app','Data Deleted'));
        return $this->redirect(['manage-fields','id' => $model->node_type ]);
    }

    /**
     * Finds the DclFieldConfig model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DclFieldConfig the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelFields($id)
    {
        if (($model = DclFieldConfig::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }






}
