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

        $gls_tracker=new GLSTracker();
        $result=$gls_tracker->getClientExpedition($code);
        $this->assertTrue($result);

        $first_expedition=$gls_tracker->expediciones[0];
        $this->assertEquals($first_expedition['expedicion'], '771-490382283');
        $this->assertEquals($first_expedition['albaran'], '123456');
        $this->assertEquals($first_expedition['codexp'], '490382283');
        $this->assertEquals($first_expedition['codbar'], '61771040888151');
        $this->assertEquals($first_expedition['uidExp'], '46c51711-2c23-49eb-9920-9bccb608ed5a');
        $this->assertEquals($first_expedition['codplaza_cli'], '771');
        $this->assertEquals($first_expedition['codcli'], '601');
        $this->assertEquals(trim($first_expedition['nmCliente']), 'Pruebas WS');
        $this->assertEquals($first_expedition['fecha'], '18/08/2020 0:00:00');
        $this->assertEquals($first_expedition['FPEntrega'], '19/08/2020 0:00:00');
        $this->assertEquals($first_expedition['nombre_org'], 'Prueba');
        $this->assertEquals($first_expedition['nif_org'], '');
        $this->assertEquals($first_expedition['calle_org'], 'prueba');
        $this->assertEquals($first_expedition['localidad_org'], 'Ciempozuelos');
        $this->assertEquals($first_expedition['cp_org'], '28350');
        $this->assertEquals($first_expedition['tfno_org'], '666666666');
        $this->assertEquals($first_expedition['departamento_org'], '');
        $this->assertEquals($first_expedition['codpais_org'], '34');
        $this->assertEquals($first_expedition['nombre_dst'], 'Pruebas');
        $this->assertEquals($first_expedition['nif_dst'], '');
        $this->assertEquals($first_expedition['calle_dst'], 'pruebas');
        $this->assertEquals($first_expedition['localidad_dst'], 'Madrid');
        $this->assertEquals($first_expedition['cp_dst'], '28001');
        $this->assertEquals($first_expedition['tfno_dst'], '666666666');
        $this->assertEquals($first_expedition['departamento_dst'], '');
        $this->assertEquals($first_expedition['codpais_dst'], '34');
        $this->assertEquals($first_expedition['codServicio'], '14');
        $this->assertEquals($first_expedition['codHorario'], '3');
        $this->assertEquals($first_expedition['servicio'], 'DISTRIBUCION PROPIA');
        $this->assertEquals($first_expedition['horario'], 'BusinessParcel');
        $this->assertEquals($first_expedition['tipo_portes'], 'P');
        $this->assertEquals($first_expedition['bultos'], '1');
        $this->assertEquals($first_expedition['kgs'], '2,0');
        $this->assertEquals($first_expedition['vol'], '0,000');
        $this->assertEquals($first_expedition['Observacion'], 'alalal');
        $this->assertEquals($first_expedition['dac'], 'SIN RCS');
        $this->assertEquals($first_expedition['retorno'], 'SIN RETORNO');
        $this->assertEquals($first_expedition['borrado'], 'S');
        $this->assertEquals($first_expedition['codestado'], '-10');
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
