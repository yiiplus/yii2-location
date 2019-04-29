<?php
/**
 * yiiplus\yii2-location
 *
 * @category yiiplus
 */
namespace yiiplus\location;

use \yii\base\Component;

/**
 * Class AbstractLocation
 *
 * @author  耿贤坤 <gengxiankun@126.com>
 * @since   1.0.0
 */
class AbstractLocation extends Component
{
	/**
	 * @var object/miexd 请求返回的数据
	 */
    protected $_resource;

    /**
     * @var string 国家
     */
    public $country;

    /**
     * @var string 省会
     */
    public $province;

    /**
     * @var string 城市
     */
    public $city;

    /**
     * @var string 详细地址
     */
    public $housing_estate;

    /**
     * @var string 街道名（行政区划中的街道层级）
     */
    public $street;

    /**
     * @var string 街道门牌号
     */
    public $street_number;

    /**
     * @var string 和当前坐标点的方向
     */
    public $district;
}