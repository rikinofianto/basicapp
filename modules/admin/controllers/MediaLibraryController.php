<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\modules\admin\components\Helper;
use app\modules\admin\components\BaseController;

// Model
use app\modules\admin\models\DclMedia;
use app\modules\admin\models\searchs\DclMedia as DclMediaSearch;
use app\modules\admin\models\DclMediaContent;

use yii\data\Pagination;



/**
 * User controller
 */
class MediaLibraryController extends BaseController
{
    private $mediaService;

    public function __construct($id, $module, $config = [])
    {
        Yii::$container->setSingleton('app\modules\admin\components\bll\IMediaService',
            'app\modules\admin\components\bll\MediaService');
        $this->mediaService = Yii::$container->get('app\modules\admin\components\bll\IMediaService');

        parent::__construct($id, $module, $config);
    }
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
                   'delete-content' => ['POST'], 
               ],
            ],
        ];
    }



    /**
     * Lists all DclMedia models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new DclMediaSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['media_id' => SORT_DESC] ];
        $dataProvider->pagination = ['pageSize' => 12 ];


        $models = $dataProvider->getModels();
        $pages = $dataProvider->getPagination();

        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            ]);


    }



   /** 
    * Displays a single DclMedia model. 
    * @param integer $id 
    * @return mixed 
    */ 
   public function actionView($id) 
   { 
       // return $this->render('view', [ 
       //     'model' => $this->findModel($id), 
       // ]); 
       $media = $this->findModel($id);

       $query = DclMediaContent::find()->where(['parent_id' => $id]);
       $countQuery = clone $query;
       $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize'=> 12 ]);
       $models = $query->offset($pages->offset)
           ->limit($pages->limit)->orderBy(['media_content_id' => SORT_DESC])
           ->all();

       return $this->render('view', [
            'models' => $models,
            'pages' => $pages,
            'media' => $media,
        ]);
       
       
   } 
   /** 
    * Creates a new DclMedia model. 
    * If creation is successful, the browser will be redirected to the 'view' page. 
    * @return mixed 
    */ 
   public function actionCreate() 
   { 
        $model = new DclMedia(); 
        if ($model->load(Yii::$app->request->post())) {
            $pathname = $this->randomString(12);
            $model->path_name = $pathname;
            if ($model->save()) {
                // return $this->redirect(['index']); 
                // return $this->redirect(['view', 'id' => $model->media_id]); 
                return $this->redirect(['add-content', 'id' => $model->media_id]); 
            } 
        } 
        return $this->render('create', [ 
            'model' => $model, 
            ]); 
        
   } 

   /** 
    * Updates an existing DclMedia model. 
    * If update is successful, the browser will be redirected to the 'view' page. 
    * @param integer $id 
    * @return mixed 
    */ 
   public function actionUpdate($id) 
   { 
       $model = $this->findModel($id); 
       if ($model->load(Yii::$app->request->post()) && $model->save()) { 
           return $this->redirect(['index']); 
           // return $this->redirect(['view', 'id' => $model->media_id]); 
       } else { 
           return $this->render('update', [ 
               'model' => $model, 
           ]); 
       } 
   } 
 
   /** 
    * Deletes an existing DclMedia model. 
    * If deletion is successful, the browser will be redirected to the 'index' page. 
    * @param integer $id 
    * @return mixed 
    */ 
   public function actionDelete($id) 
   { 
       // $this->findModel($id)->delete(); 
 
       // return $this->redirect(['index']); 


        $model = $this->findModel($id);
        $rmPath = Yii::getAlias('@webroot') . "/uploads/" . $model->path_name . "/";
        $rmId = $model->media_id;

        if ($this->findModel($id)->delete()) {
            if (!empty($model->path_name) && is_dir($rmPath)) {
                $this->delTree($rmPath);
            }
            $DeleteModelContenMenu = DclMediaContent::deleteAll("parent_id = :rmId ",[ ':rmId' => $rmId ] );
        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            Yii::$app->getSession()->setFlash('success', 'Berhasil di hapus');
            return $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index'] );

   } 


   /**
    * [actionDeleteContent description]
    * @param  [type] $id [description]
    * @return [type]     [description]
    */
   // public function actionDeleteImage($id) 
   public function actionDeleteContent($id) 
   { 
        
        $model = DclMediaContent::findOne($id);
        $modelMedia = $this->findModel($model->parent_id);
        $rmPath = Yii::getAlias('@webroot') . "/uploads/" . $modelMedia->path_name . "/";

        if ($model->delete()) {
            if (!empty($modelMedia->path_name) && file_exists($rmPath . $model->path)) {
                @unlink($rmPath . $model->path);
            }

            $modelCover = DclMediaContent::find()->where(['parent_id' => $modelMedia->media_id])->orderBy(['media_content_id' => SORT_DESC])->one();
            
            $modelMedia->setting = $modelCover->path;

            if ($modelMedia->type == 1 && !file_exists($rmPath . $modelCover->path )) 
            {
                $modelMedia->setting = 'https://i.ytimg.com/vi/'.$modelCover->path.'/hqdefault.jpg' ;
            }
            $modelMedia->save();

            Yii::$app->getSession()->setFlash('success', 'Berhasil di hapus');
            return $this->redirect(['view','id'=>$modelMedia->media_id]);  
        }
 
        Yii::$app->getSession()->setFlash('danger', 'Gagal di hapus');
        return $this->redirect(['view','id'=>$modelMedia->media_id]);  
   } 

   /**
    * [actionDeleteVideo description]
    * @param  [type] $id [description]
    * @return [type]     [description]
    */
   // public function actionDeleteVideo($id) 
   // { 
   //     // $this->findModel($id)->delete();
   //      // Yii::$app->getSession()->setFlash('danger', 'Belum');
        
   //      $model = DclMediaContent::findOne($id);
   //      $modelMedia = $this->findModel($model->parent_id);
   //      $rmPath = Yii::getAlias('@webroot') . "/uploads/" . $modelMedia->path_name . "/";

   //      if ($model->delete()) {
   //          if (!empty($modelMedia->path_name) && file_exists($rmPath . $model->path)) {
   //              @unlink($rmPath . $model->path);
   //          }
   //          Yii::$app->getSession()->setFlash('success', 'Berhasil di hapus');
   //          return $this->redirect(['view','id'=>$modelMedia->media_id]);  
   //      }
 
   //      Yii::$app->getSession()->setFlash('danger', 'Gagal di hapus');
   //      return $this->redirect(['view','id'=>$modelMedia->media_id]);  
   //      // return $this->redirect(['index']); 
   //     // return $this->goBack(); 
   // } 
 
   /** 
    * Finds the DclMedia model based on its primary key value. 
    * If the model is not found, a 404 HTTP exception will be thrown. 
    * @param integer $id 
    * @return DclMedia the loaded model 
    * @throws NotFoundHttpException if the model cannot be found 
    */ 
   protected function findModel($id) 
   { 
       if (($model = DclMedia::findOne($id)) !== null) { 
           return $model; 
       } else { 
           throw new NotFoundHttpException('The requested page does not exist.'); 
       } 
   } 

   /**
    * [generate randomString]
    * @param  [type] $max [description]
    * @return [type]      [description]
    */
    public function randomString($max) {
        return $randomName = substr_replace(sha1(microtime(true)), '', $max);
    }

    /**
     * [actionAdd description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function actionAddContent($id) 
    { 
        // $model = new DclMedia(); 
        $model = $this->findModel($id); 

        return $this->render('add-content', [ 
            'model' => $model, 
            ]); 
        
   } 


    /**
     * [actionUpload description]
     * @return [type] [description]
     */
    public function actionUpload($id)  
    {
        $fileName = 'file';
        $uploadPath = './files';

        if (isset($_FILES[$fileName])) {
            $findPathName = $this->findModel($id);

            $file = \yii\web\UploadedFile::getInstanceByName($fileName);

            $tempFile = $file->tempName;
            $nameFile = $file->name;
            // echo($tempFile);die;

            if ($findPathName) {
                
                $targetPath = Yii::getAlias('@webroot').'/uploads/' . $findPathName->path_name . "/";
                if (!empty($findPathName->path_name) && !file_exists($targetPath)) {
                    mkdir($targetPath, 0777, true);
                }

                $randomName = $this->nameExist($targetPath, $nameFile);
                $targetFile = $targetPath . $randomName;


                $uploaded = TRUE;
                if (!empty($findPathName->path_name))
                    $uploaded = @move_uploaded_file($tempFile, $targetFile);

                $resultJson = $this->statusSaveReturnJson($uploaded, $randomName, $id);
                if (isset($resultJson['image']))
                    $randomName = $resultJson['image'];


                // Resize pending
                // 
                // $loadModelSetting = DclSetting::model()->loadModelSettingSize($getId);

                // $this->resize_image($targetPath, $randomName, $this->defaultSizeGlobalWidth, $this->defaultSizeGlobalHeight); //default Size

                // if ($loadModelSetting) {
                //     foreach ($loadModelSetting as $key => $data) {
                //         $this->resize_image($targetPath, $randomName, $data->width, $data->height);
                //     }
                // }
                // 


            }

            // if ($file->saveAs($uploadPath . '/' . $file->name)) {
            //     //Now save file data to database

            //     echo \yii\helpers\Json::encode($file);
            // }
            header('Content-type: application/json');
            echo \yii\helpers\Json::encode($resultJson);
            // return;
        }
        // print_r($_FILES);die;
        return false;
    }



    /**
     * [nameExist description]
     * @param  [type] $path     [description]
     * @param  [type] $filename [description]
     * @return [type]           [description]
     */
    protected function nameExist($path, $filename) {

        $stringRlpc = array(".", " ", ",", "?", "%", "#", "!", ";", '"', "'", "/");

        $file_info = pathinfo($path . $filename);
        $uploaded_filename = str_replace($stringRlpc, "", $file_info['filename']);
        $newName = $uploaded_filename . "." . $file_info['extension'];
        $fullpath = $path . $newName;

        $count = 1;
        while (file_exists($fullpath)) {
            $info = pathinfo($fullpath);

            $fullpath = $info['dirname'] . '/' . $uploaded_filename
            . '(' . $count . ')'
            . '.' . $info['extension'];
            $newName = $uploaded_filename
            . '(' . $count . ')'
            . '.' . $info['extension'];
            $count++;
        }

        return $newName;
    }




    /**
     * [statusSaveReturnJson description]
     * @param  boolean $isUpload  [description]
     * @param  [type]  $imageName [description]
     * @param  [type]  $idParent [description]
     * @return [type]             [description]
     */
    protected function statusSaveReturnJson($isUpload = FALSE, $imageName, $idParent) {
        $data = 0;


        if ($isUpload) {
            $model = new DclMediaContent;
            $model->parent_id = $idParent;
            // $model->create_by = Yii::$app->user->id;
            $model->create_by = Yii::$app->user->identity->username;
            $model->path = $imageName;
            $model->type = $this->getTypeDclMedia($idParent); //image type


            // $model->setting = $this->defaultSettingSlide(); //setingan default

            if ($model->save()) {
                $result = array(
                    'status' => 200,
                    'message' => "OK",
                    'image' => $model->path,
                    'parID' => $idParent,
                    'idobj' => $data
                    );
                $this->createdThumbnailMedia($model->path, $idParent);
            } else {
                $result = array(
                    'status' => 500,
                    'message' => "DB Error",
                    );
            }
        } else {
            $result = array(
                'status' => 500,
                'message' => "Error",
                );
        }

        return $result;
    }


    /**
     * [getTypeDclMedia description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    protected function getTypeDclMedia($id) {
        $model = DclMedia::findOne($id);
        if ($model != null) {
            return $model->type;
        }
        return 0;
    }

    /**
     * [createdThumbnailMedia description]
     * @param  [type] $fileName  [description]
     * @param  [type] $idParent [description]
     * @return [type]            [description]
     */
    protected function createdThumbnailMedia($fileName, $idParent) {
        $model = DclMedia::findOne($idParent);
        if ($model)
        {
            $model->setting = $fileName;
            $model->save();
        }
    }



    /**
     * [actionSaveImageUrl description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function actionSaveImageUrl($id = null)
    {  
        $model = $this->findModel($id);
        if (($data = Yii::$app->request->post()) && $model) {
            // print_r(Yii::$app->request->post());die;
            $DclModel = new DclMediaContent;
            $DclModel->type = $model->type;
            $DclModel->path = $data['externalImageLink'];
            $DclModel->create_by = Yii::$app->user->identity->username;
            $DclModel->parent_id = (int) $id;
            if ($DclModel->save()) {
                $model->setting = $data['externalImageLink'];
                $model->save();
                // print_r($model->getErrors());die;
            }
            return $this->redirect(['view','id'=>$id]);  
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSaveVideoUrl($id = null)
    {  
        $model = $this->findModel($id);
        if (($data = Yii::$app->request->post()) && $model) {

            $detailVideo = $this->checkVideoYoutubeLink($data['idVideo']);

             // print_r($detailVideo);die;
            if (!$detailVideo) 
            {
                Yii::$app->getSession()->setFlash('danger', 'Link is not valid');
                return $this->redirect(['add-content', 'id' => $id]); 
                
            }

            $DclModel = new DclMediaContent;
            $DclModel->type = $model->type;
            $DclModel->path = $data['idVideo'];
            $DclModel->create_by = Yii::$app->user->identity->username;
            $DclModel->setting = json_encode($detailVideo['items'][0]);
            $DclModel->parent_id = (int) $id;
            if ($DclModel->save()) {
                $model->setting = 'https://i.ytimg.com/vi/'.$data['idVideo'].'/hqdefault.jpg';
                $model->save();
            }
            return $this->redirect(['view','id'=>$id]);  
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }



    /**
     * [delTree description]
     * @param  [type] $dir [description]
     * @return [type]      [description]
     */
    protected function delTree($dir) {
        $files = glob($dir . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (substr($file, -1) == '/')
                delTree($file);
            else
                unlink($file);
        }
        return rmdir($dir);
    }


    // public function actionCheckVideoYoutubeLink($idVideo)
    protected function checkVideoYoutubeLink($idVideo)
    {
        // echo Yii::$app->reCaptcha->googleKey;die;
        // if (Yii::$app->reCaptcha->googleKey) {
        if (!Yii::$app->reCaptcha->googleKey) {
            $arrayDefault = $this->actionCheckYoutubeLinkWithoutApi($idVideo);
            return $arrayDefault;
        }
        // if (Yii::$app->request->isAjax) {
                # code...
            // $url = "https://www.googleapis.com/youtube/v3/videos?part=id&id={$idVideo}&key=".Yii::$app->reCaptcha->googleKey;
            $url = "https://www.googleapis.com/youtube/v3/videos?part=snippet&id={$idVideo}&key=".Yii::$app->reCaptcha->googleKey;
            //  Initiate curl
            $ch = curl_init();
            // Disable SSL verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            // Will return the response, if false it print the response
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // Set the url
            curl_setopt($ch, CURLOPT_URL,$url);
            // Execute
            $result=curl_exec($ch);
            // Closing
            curl_close($ch);

            // Will dump a beauty json :3
            // var_dump(json_decode($result, true));
            $arrayResult = json_decode($result, true);
            if ($arrayResult['items']) {
                // return $result;
                return $arrayResult;
                // echo \yii\helpers\Json::encode($result);
            }
        // }
        // throw new NotFoundHttpException('The requested page does not exist.');
        return false;
    }



    public function actionCheckYoutubeLinkWithoutApi($idVideo)
    {

        $url = 'https://www.youtube.com/oembed?format=json&url=http://www.youtube.com/watch?v='.$idVideo;
        // $url = "https://www.googleapis.com/youtube/v3/videos?part=snippet&id={$idVideo}&key=".Yii::$app->reCaptcha->googleKey;

        //  Initiate curl
        $ch = curl_init();
        // Disable SSL verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($ch, CURLOPT_URL,$url);
        // Execute
        $result=curl_exec($ch);
        // Closing
        curl_close($ch);

        // Will dump a beauty json :3
        // var_dump(json_decode($result, true));
        $arrayResult = json_decode($result, true);

        if (Yii::$app->request->isAjax) {
            header('Content-type: application/json');
            echo $result;
            return;
        }
        return $arrayDefault = ['items'=>[["kind"=>"youtube#video",'snippet' => $arrayResult]]];

    }


}
