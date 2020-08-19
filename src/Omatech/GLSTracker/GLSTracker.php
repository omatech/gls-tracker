<?php

namespace Omatech\GLSTracker;

use \Omatech\GLSTracker\AppBase;
use Dotenv\Dotenv;

class GLSTracker extends AppBase {

  public $uid_cliente='';
  public $webservice_url='';
  public $raw_xml_response='';
  public $result_array=[];
  public $expediciones=[];

  function __construct($uid_cliente=null, $webservice_url=null)
  {

    $dotenv = Dotenv::createImmutable(__DIR__.'/../../../');
    $dotenv->load();

    if ($uid_cliente==null)
    {
      $uid_cliente=$_ENV['GLS_UID_CLIENTE'];
    }

    if ($webservice_url==null)
    {
      $webservice_url=$_ENV['GLS_WEBSERVICE_URL'];
    }

	  $this->webservice_url=$webservice_url;
	  $this->uid_cliente=$uid_cliente;
  }

  function getExpeditionStatus()
  {
    if (!$this->result_array) return false;
    if (!isset($this->expediciones)) return false;
    if (!isset($this->expediciones[0])) return false;
    if (!isset($this->expediciones[0]['estado'])) return false;

    return $this->expediciones[0]['estado'];

  }

  function getClientExpedition ($code)
  {
    $xml_query= '<?xml version="1.0" encoding="utf-8"?>
    <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
      <soap12:Body>
        <GetExpCli xmlns="http://www.asmred.com/">
          <codigo>'.$code.'</codigo>
          <uid>'.$this->uid_cliente.'</uid>
        </GetExpCli>
      </soap12:Body>
    </soap12:Envelope>';

    $call_result=$this->call($xml_query);
    if (!$call_result) return false;

    // Get all values from result_array

    $arr=$this->result_array;
    $ret2 = $arr[0]->xpath("//expediciones/exp");
    
    if ($ret2 == null)
    {
      return false;
    }
    else {
        $i=0;
        $this->expediciones=[];
        foreach ($ret2 as $ret) {
            $one_expedition=[];
            $one_expedition['expedicion']       = (string)$ret[0]->xpath("//expediciones/exp/expedicion")[$i];
            $one_expedition['albaran']          = (string)$ret[0]->xpath("//expediciones/exp/albaran")[$i];
            $one_expedition['codexp']           = (string)$ret[0]->xpath("//expediciones/exp/codexp")[$i];
            $one_expedition['codbar']           = (string)$ret[0]->xpath("//expediciones/exp/codbar")[$i];
            $one_expedition['uidExp']           = (string)$ret[0]->xpath("//expediciones/exp/uidExp")[$i];
                                                                                 
            $one_expedition['codplaza_cli']     = (string)$ret[0]->xpath("//expediciones/exp/codplaza_cli")[$i];
            $one_expedition['codcli']           = (string)$ret[0]->xpath("//expediciones/exp/codcli")[$i];
            $one_expedition['nmCliente']        = (string)$ret[0]->xpath("//expediciones/exp/nmCliente")[$i];
                                                                                 
            $one_expedition['fecha']            = (string)$ret[0]->xpath("//expediciones/exp/fecha")[$i];
            $one_expedition['FPEntrega']        = (string)$ret[0]->xpath("//expediciones/exp/FPEntrega")[$i];
                                                                                 
            $one_expedition['nombre_org']       = (string)$ret[0]->xpath("//expediciones/exp/nombre_org")[$i];
            $one_expedition['nif_org']          = (string)$ret[0]->xpath("//expediciones/exp/nif_org")[$i];
            $one_expedition['calle_org']        = (string)$ret[0]->xpath("//expediciones/exp/calle_org")[$i];
            $one_expedition['localidad_org']    = (string)$ret[0]->xpath("//expediciones/exp/localidad_org")[$i];
            $one_expedition['cp_org']           = (string)$ret[0]->xpath("//expediciones/exp/cp_org")[$i];
            $one_expedition['tfno_org']         = (string)$ret[0]->xpath("//expediciones/exp/tfno_org")[$i];
            $one_expedition['departamento_org'] = (string)$ret[0]->xpath("//expediciones/exp/departamento_org")[$i];
            $one_expedition['codpais_org']      = (string)$ret[0]->xpath("//expediciones/exp/codpais_org")[$i];




            $one_expedition['nombre_dst']       = (string)$ret[0]->xpath("//expediciones/exp/nombre_dst")[$i];
            $one_expedition['nif_dst']          = (string)$ret[0]->xpath("//expediciones/exp/nif_dst")[$i];
            $one_expedition['calle_dst']        = (string)$ret[0]->xpath("//expediciones/exp/calle_dst")[$i];
            $one_expedition['localidad_dst']    = (string)$ret[0]->xpath("//expediciones/exp/localidad_dst")[$i];
            $one_expedition['cp_dst']           = (string)$ret[0]->xpath("//expediciones/exp/cp_dst")[$i];
            $one_expedition['tfno_dst']         = (string)$ret[0]->xpath("//expediciones/exp/tfno_dst")[$i];
            $one_expedition['departamento_dst'] = (string)$ret[0]->xpath("//expediciones/exp/departamento_dst")[$i];
            $one_expedition['codpais_dst']      = (string)$ret[0]->xpath("//expediciones/exp/codpais_dst")[$i];
                                                                                   
            $one_expedition['codServicio']      = (string)$ret[0]->xpath("//expediciones/exp/codServicio")[$i];
            $one_expedition['codHorario']       = (string)$ret[0]->xpath("//expediciones/exp/codHorario")[$i];
            $one_expedition['servicio']         = (string)$ret[0]->xpath("//expediciones/exp/servicio")[$i];
            $one_expedition['horario']          = (string)$ret[0]->xpath("//expediciones/exp/horario")[$i];
                                                                                   
            $one_expedition['tipo_portes']      = (string)$ret[0]->xpath("//expediciones/exp/tipo_portes")[$i];
            $one_expedition['bultos']           = (string)$ret[0]->xpath("//expediciones/exp/bultos")[$i];
            $one_expedition['kgs']              = (string)$ret[0]->xpath("//expediciones/exp/kgs")[$i];
            $one_expedition['vol']              = (string)$ret[0]->xpath("//expediciones/exp/vol")[$i];
            $one_expedition['Observacion']      = (string)$ret[0]->xpath("//expediciones/exp/Observacion")[$i];
            $one_expedition['dac']              = (string)$ret[0]->xpath("//expediciones/exp/dac")[$i];
            $one_expedition['retorno']          = (string)$ret[0]->xpath("//expediciones/exp/retorno")[$i];
                                                                                   
            $one_expedition['borrado']          = (string)$ret[0]->xpath("//expediciones/exp/borrado")[$i];
            $one_expedition['codestado']        = (string)$ret[0]->xpath("//expediciones/exp/codestado")[$i];
            $one_expedition['estado']           = (string)$ret[0]->xpath("//expediciones/exp/estado")[$i];
            $one_expedition['incidencia']       = (string)$ret[0]->xpath("//expediciones/exp/incidencia")[$i];

            $this->expediciones[]=$one_expedition;
        }
    }

    return true;
  }

  private function call($xml_query)
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, TRUE);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);
    curl_setopt($ch, CURLOPT_URL, $this->webservice_url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_query);
    curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml; charset=UTF-8"));

    $postResult = curl_exec($ch);
    curl_close($ch);

    $this->raw_xml_response=$postResult;

    $xml = simplexml_load_string($postResult, NULL, NULL, "http://http://www.w3.org/2003/05/soap-envelope");
    $xml->registerXPathNamespace('asm', 'http://www.asmred.com/');
    $result_array = $xml->xpath("//asm:GetExpCliResponse/asm:GetExpCliResult");
    $this->result_array=$result_array;
    if (sizeof($result_array) == 0) return false;

    return true;
  }

}
