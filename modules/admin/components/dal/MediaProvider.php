<?php 

namespace app\modules\admin\components\dal;


use Yii;
use app\modules\admin\models\DclMedia;
use app\modules\admin\models\searchs\DclMedia as DclMediaSearch;


class MediaProvider implements \app\modules\admin\components\dal\IMediaProvider
{
	/**
	 * [mediaSearchInstance description]
	 * @return [type] [description]
	 */
	public function mediaSearchInstance()
	{
		return new DclMediaSearch();
	}

	/**
	 * [getAllMedia description]
	 * @param  string $order [description]
	 * @return [type]        [description]
	 */
	public function getAllMedia($order = 'media_id')
	{
		return DclMedia::find()->orderBy($order)->all();
	}
}