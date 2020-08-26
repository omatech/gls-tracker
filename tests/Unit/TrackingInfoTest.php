<?php

namespace Tests\Unit;

use Omatech\GLSTracker\GLSTracker;
use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;

class TrackingInfoTest extends TestCase
{
    public function testDummy()
    {
        $this->assertNotFalse(true);
    }

    public function testGetSavedClientExpedition()
    {

        $dotenv = Dotenv::createImmutable(__DIR__.'/../../');
        $dotenv->load();
        $code=$_ENV['GLS_TEST_EXPEDITION_GRABADA'];

        //$code='61771041367080';

        $gls_tracker=new GLSTracker();
        $result=$gls_tracker->getClientExpedition($code);
        $this->assertTrue($result);

        $first_expedition=$gls_tracker->expediciones[0];


        //var_dump($first_expedition);

        $this->assertEquals($first_expedition['expedicion'], '771-492340679');
        $this->assertEquals($first_expedition['albaran'], '12XYZ5AB');
        $this->assertEquals($first_expedition['codexp'], '492340679');
        $this->assertEquals($first_expedition['codbar'], '61771041379752');
        $this->assertEquals($first_expedition['uidExp'], 'fe5e9126-8e36-46bf-b3ec-f460de3a4022');
        $this->assertEquals($first_expedition['localidad_org'], 'Ciempozuelos');
        $this->assertEquals($first_expedition['estado'], 'GRABADO');
        $this->assertEquals($first_expedition['incidencia'], 'SIN INCIDENCIA');
        //print_r($first_expedition);
    }

    public function testGetStatusSavedClientExpedition()
    {
        $this->StatusValidation('GLS_TEST_EXPEDITION_GRABADA', 'GRABADO');
    }

    public function testGetStatusDeliveringClientExpedition()
    {
        $this->StatusValidation('GLS_TEST_EXPEDITION_EN_REPARTO', 'EN REPARTO');
    }

    public function testGetStatusDeliveredClientExpedition()
    {
        $this->StatusValidation('GLS_TEST_EXPEDITION_ENTREGADA', 'ENTREGADO');
    }    

    public function testGetWrongClientExpedition()
    {
        $code='99999999';

        $gls_tracker=new GLSTracker();
        $result=$gls_tracker->getClientExpedition($code);
        $this->assertFalse($result);
    }

    public function testNoStatusIfGetClientExpeditionNotCalled()
    {
        $gls_tracker=new GLSTracker();
        $result=$gls_tracker->getExpeditionStatus();
        $this->assertFalse($result);
    }

    public function StatusValidation ($code_env_key, $expected_status)
    {
        $dotenv = Dotenv::createImmutable(__DIR__.'/../../');
        $dotenv->load();
        $code=$_ENV[$code_env_key];

        $gls_tracker=new GLSTracker();
        $result=$gls_tracker->getClientExpedition($code);
        $status=$gls_tracker->getExpeditionStatus();
        $this->assertEquals($status, $expected_status);
    }

}
