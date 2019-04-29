<?php 
use Yii;

class IpLocationTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    public $iplocation;
    
    protected function _before()
    {
        $this->iplocation = Yii::$app->iplocation;
    }

    public function testObjectIsHasAttribute()
    {
        $this->assertObjectHasAttribute('_resource', $this->iplocation);
        $this->assertObjectHasAttribute('country', $this->iplocation);
        $this->assertObjectHasAttribute('province', $this->iplocation);
        $this->assertObjectHasAttribute('housing_estate', $this->iplocation);
        $this->assertObjectHasAttribute('street', $this->iplocation);
        $this->assertObjectHasAttribute('street_number', $this->iplocation);
        $this->assertObjectHasAttribute('district', $this->iplocation);
        $this->assertObjectHasAttribute('ak', $this->iplocation);
    }

    public function testGetAddressIsSuccess()
    {
        $this->assertTrue($this->iplocation->getAddress('61.148.16.170'));
    }
}