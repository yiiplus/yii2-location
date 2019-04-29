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
 * IpLocation Geocoder
 *
 * 普通IP定位是一套以HTTP/HTTPS形式提供的轻量级定位接口，用户可以通过该服务，根据IP定位来获取大致位置
 *
 * @author  耿贤坤 <gengxiankun@126.com>
 * @since   1.0.0
 */
class IpLocation extends AbstractLocation implements LocationInterface
{
    /**
     * @var string 基础请求地址
     */
    const BASE_URL = 'http://api.map.baidu.com/location/ip';

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
     * 根据IP定位位置信息
     *
     * @param $ip string IP地址
     *
     * @return bool|mixed
     */
    public function getAddress($ip)
    {
        $resource = $this->guzzleClient->request('GET', '', [
            'query' => [
                'ip' => $ip,
                'ak' => $this->ak,
            ]
        ]);

        if ($resource->getStatusCode() !== 200) {
            return false;
        }

        $resContentes = json_decode($resource->getBody()->getContents());

        if ($resContentes->status !== 0) {
            return false;
        }

        $this->_resource = $resContentes;
        $this->province = $resContentes->content->address_detail->province;
        $this->city = $resContentes->content->address_detail->city;
        $this->street = $resContentes->content->address_detail->street;
        $this->street_number = $resContentes->content->address_detail->street_number;
        $countryAB = strstr($resContentes->address, '|', true);
        if ($countryAB == 'CN') {
            $this->country = '中国';
        } else {
            // TODO: 其他国家简称的解析
            $this->country = null;
        }
        return true;
    }
}
