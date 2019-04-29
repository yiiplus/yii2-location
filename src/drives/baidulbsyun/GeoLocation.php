<?php
/**
 * yiiplus\yii2-location
 *
 * @category yiiplus
 */
namespace yiiplus\location\baidulbsyun;

use GuzzleHttp\Client;
use yii\base\InvalidConfigException;
use yiiplus\location\AbstractLocation;
use yiiplus\location\LocationInterface;

/**
 * Class GeoLocation
 *
 * 正\逆 地理编码服务
 *
 * @author  耿贤坤 <gengxiankun@126.com>
 * @since   1.0.0
 */
class GeoLocation extends AbstractLocation implements LocationInterface
{
    /**
     * @var string 基础请求地址
     */
    const BASE_URL = 'http://api.map.baidu.com/geocoder/v2/?callback=renderReverse';

    /**
     * @var string 用户（百度地图开放平台）申请注册的key，自v2开始参数修改为“ak”，之前版本参数为“key” [申请ak](http://lbsyun.baidu.com/apiconsole/key/create)
     */
    public $ak;

    /**
     * @var float 请求接口超时熔断，默认2.0秒
     */
    public $timeout = 2.0;

    /**
     * @var object/void GuzzleHttp Client实例
     */
    private $_guzzleClient;

    /**
     * Initializes the object.
     * This method is invoked at the end of the constructor after the object is initialized with the
     * given configuration.
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (empty($this->ak)) {
            throw new InvalidConfigException('The AK parameters must be configured.');
        }

        parent::init();
    }

    /**
     * 获取GuzzleHttp Client实例
     *
     * @return Client|object
     */
    public function getGuzzleClient()
    {
        if (!($this->_guzzleClient instanceof Client)) {
            $this->_guzzleClient = new Client([
                // Base URI is used with relative requests
                'base_uri' => self::BASE_URL,
                // You can set any number of default request options.
                'timeout'  => $this->timeout,
            ]);
        }

        return $this->_guzzleClient;
    }

    /**
     * 全球逆地理编码服务接口方法，全球逆地理编码服务（又名Geocoder）是一类Web API接口服务；
     * 逆地理编码服务提供将坐标点（经纬度）转换为对应位置信息（如所在行政区划，周边地标点分布）功能。
     * 服务同时支持全球行政区划位置描述及周边地标POI数据召回（包括中国在内的全球200多个国家地区）；
     * 若需访问境外POI，需申请「逆地理编码境外POI」服务权限，请申请开通境外服务权限。
     *
     * @link http://lbsyun.baidu.com/index.php?title=webapi/guide/webservice-geocoding-abroad
     *
     * @param $location string 根据经纬度坐标获取地址。
     *
     * @return bool|mixed
     */
    public function getAddress($location)
    {
        $resource = $this->guzzleClient->request('GET', '', [
            'query' => [
                'location' => $location,
                'ak' => $this->ak,
                'output' => 'json',
            ]
        ]);

        if ($resource->getStatusCode() != 200) {
            return false;
        }

        $resContents = json_decode($resource->getBody()->getContents());

        if ($resContents->status != 0) {
            return false;
        }

        $this->_resource = $resContents->result;
        $this->country = $this->_resource->addressComponent->country;
        $this->province = $this->_resource->addressComponent->province;
        $this->city = $this->_resource->addressComponent->city;
        $this->district = $this->_resource->addressComponent->district;
        $this->street = $this->_resource->addressComponent->street;
        $this->street_number = $this->_resource->addressComponent->street_number;

        return true;
    }
}
