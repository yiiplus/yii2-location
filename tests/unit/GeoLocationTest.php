<?php 
use Yii;

class GeoLocationTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    public $geolocation;
    
    protected function _before()
    {
        $this->geolocation = Yii::$app->geolocation;
    }

    public function testObjectIsHasAttribute()
    {
        $this->assertObjectHasAttribute('_resource', $this->geolocation);
        $this->assertObjectHasAttribute('country', $this->geolocation);
        $this->assertObjectHasAttribute('province', $this->geolocation);
        $this->assertObjectHasAttribute('housing_estate', $this->geolocation);
        $this->assertObjectHasAttribute('street', $this->geolocation);
        $this->assertObjectHasAttribute('street_number', $this->geolocation);
        $this->assertObjectHasAttribute('district', $this->geolocation);
        $this->assertObjectHasAttribute('ak', $this->geolocation);
    }

    public function testGetAddressIsSuccess()
    {
        $this->assertTrue($this->geolocation->getAddress('38.76623,116.43213'));
    }
}