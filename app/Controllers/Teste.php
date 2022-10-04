<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use NFePHP\Common\Certificate;
use NFePHP\Common\Soap\SoapCurl;
use NFePHP\NFSe\NFSe;
use Spatie\ArrayToXml\ArrayToXml;

class Teste extends Controller
{

  private static $arr = [
    "atualizacao" => "2016-08-03 18:01:21",
    "tpAmb" => 1,
    "versao" => 3.10,
    "razaosocial" => "SUA RAZAO SOCIAL LTDA",
    "cnpj" => "02926118000170",
    "cpf" => "",
    "im" => "",
    "cmun" => "3550308",
    "siglaUF" => "SP",
    "pathNFSeFiles" => "\/dados\/nfse",
    "proxyConf" => [
      "proxyIp" => "",
      "proxyPort" => "",
      "proxyUser" => "",
      "proxyPass" => ""
    ]
  ];
  public function index()
  {
    $data = array(
      "titulo" => "Nota",
      'nota' => ''
    );
    return view('Home/mainHome', $data);
  }
  function rodar()
  {
    $configJson = json_encode(self::$arr);
    $contentpfx = file_get_contents('../SANFRA_COMERCIO_-_eCNPJ_A1_-_2022');
    $c =  Certificate::readPfx($contentpfx, 'sc0002');
    $nfse = new NFSe($configJson, $c);
    $nfse->tools->loadSoapClass(new SoapCurl());

    $nfse->tools->setDebugSoapMode(false);

    $cnpj = '17077718000189'; //cnpj do cliente
    $cpf = '';
    $im = '46268561';
    $dtInicial = '2022-09-01';
    $dtFinal = '2022-09-27';
    $pagina = 1;
    $response = $nfse->tools->consultaNFSeEmitidas($cnpj, $cpf, $im, $dtInicial, $dtFinal, $pagina);
    
    $response = $nfse->response->readReturn('RetornoXML', $response);
    echo "<pre>";
    print_r($response);
    echo "</pre>";


  }
  function consultar()
    {
    $configJson = json_encode(self::$arr);
    $contentpfx = file_get_contents('C:\Users\Kleberson de Moura\Downloads\SANFRA_COMERCIO_-_eCNPJ_A1_-_2022.pfx');
    $c =  Certificate::readPfx($contentpfx, 'sc0002');
    $nfse = new NFSe($configJson, $c);
    $nfse->tools->loadSoapClass(new SoapCurl());

    $nfse->tools->setDebugSoapMode(false);
   
    $cnpj = '17077718000189'; //cnpj do cliente

    $im = '27755223';
    $arr1 = [
      [
        "prestadorIM" => $im,
        "numeroNFSe" => $this->request->getVar('numero')
      ]
    ];
    $arrNull = array(
      
    );

    $response = $nfse->tools->consultaNFSe($arr1, $arrNull);
    $response = $nfse->response->readReturn('RetornoXML', $response);
    $response = json_encode($response->RetornoConsulta->NFe);
    $response = json_decode($response, true);

    $result = ArrayToXml::convert($response,'NFSe');

    header("Content-type:application/xml");
    die($result);
    
  }
}
