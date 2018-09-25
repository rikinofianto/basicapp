<?php 
namespace app\modules\admin\components\bll;

use Yii;

class MediaService implements \app\modules\admin\components\bll\IMediaService
{

    private $mediaProvider;

    public function __construct()
    {
    	Yii::$container->setSingleton('app\modules\admin\components\dal\IMediaProvider',
    		'app\modules\admin\components\dal\MediaProvider');

    	$this->mediaProvider = Yii::$container->get('app\modules\admin\components\dal\IMediaProvider');
    }


    /**
     * [mediaSearchInstance description]
     * @return [type] [description]
     */
    public function mediaSearchInstance()
    {
        return $this->mediaProvider->mediaSearchInstance();
    }


    public function getAllMedia($order = 'media_id')
	{
		return $this->mediaProvider->getAllMedia($order);
	}
}
