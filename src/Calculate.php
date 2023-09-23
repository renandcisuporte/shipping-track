<?php

namespace Shipping;

class Calculate extends Info
{
  protected $params = [];

  protected $uri = 'https://www2.correios.com.br/sistemas/precosPrazos/prazos.cfm';

  public $info;

  function __construct()
  {
    parse_str('data=22%2F09%2F2023&dataAtual=22%2F09%2F2023&cepOrigem=14900000&cepDestino=14900000&servico=04510&Selecao=caixa+selected&Formato=1&embalagem1=outraEmbalagem1&embalagem2=&Altura=5&Largura=12&Comprimento=16&Selecao1=&proCod_in_1=&nomeEmbalagemCaixa=&TipoEmbalagem1=&Selecao2=&proCod_in_2=&TipoEmbalagem2=&Selecao3=&proCod_in_3=&TipoEmbalagem3=&Selecao4=&proCod_in_4=&TipoEmbalagem4=&Selecao5=&proCod_in_5=&TipoEmbalagem5=&Selecao6=&proCod_in_6=&TipoEmbalagem6=&Selecao7=&proCod_in_7=&TipoEmbalagem7=&Selecao14=&proCod_in_14=&TipoEmbalagem14=&Selecao15=&proCod_in_15=&TipoEmbalagem15=&Selecao16=&proCod_in_16=&TipoEmbalagem16=&Selecao17=&proCod_in_17=&TipoEmbalagem17=&Selecao18=&proCod_in_18=&TipoEmbalagem18=&Selecao19=&proCod_in_19=&TipoEmbalagem19=&Selecao20=&proCod_in_20=&peso=1&Selecao8=&proCod_in_8=&nomeEmbalagemEnvelope=&TipoEmbalagem8=&Selecao9=&proCod_in_9=&TipoEmbalagem9=&Selecao10=&proCod_in_10=&Selecao11=&proCod_in_11=&Selecao12=&proCod_in_12=&TipoEmbalagem12=&Selecao13=&proCod_in_13=&TipoEmbalagem13=&Selecao21=&proCod_in_21=&TipoEmbalagem21=&Selecao22=&proCod_in_22=&TipoEmbalagem22=&Selecao23=&proCod_in_23=&TipoEmbalagem23=&Selecao24=&proCod_in_24=&TipoEmbalagem24=&Selecao25=&proCod_in_25=&TipoEmbalagem25=&Selecao26=&proCod_in_26=&Selecao27=&proCod_in_27=&Selecao28=&proCod_in_28=&TipoEmbalagem28=&Selecao29=&proCod_in_29=&TipoEmbalagem29=&Selecao30=&proCod_in_30=&TipoEmbalagem30=&valorDeclarado=&Calcular=Calcular', $this->params);
  }

  /**
   * @description Principais dados para implementação do calculo
   * @param array $params [
   *  'cepOrigem' => '14900000',
   *  'cepDestino' => '15915970',
   *  'servico' => '',
   *  'peso'=>'5'
   *  'Altura'=>'5'
   *  'Largura'=>'5'
   *  'Comprimento'=>'5'
   * ]
   */
  public function calculatePrice(array $params = [])
  {
    $date = date('d/m/Y');
    $params['data'] = $date;
    $params['dataAtual'] = $date;
    $this->params = (array_replace_recursive($this->params, $params));

    $this->execute();
  }

  protected function execute()
  {
    $ch = curl_init();
    curl_setopt_array($ch, array(
      CURLOPT_URL => $this->uri,
      CURLOPT_POST => true,
      CURLOPT_POSTFIELDS => http_build_query($this->params),
      CURLOPT_RETURNTRANSFER  => true
    ));

    $response = curl_exec($ch);
    curl_close($ch);
    $response = utf8_encode($response);
    preg_match_all("/>(.+)<\/td>/", $response, $matches);

    if (!$data = current($matches)) {
      return $this->setError(true);
    }

    $dataExplode = explode('/', strip_tags(str_replace('>', '', end($data))));
    $city = current($dataExplode);
    $state = end($dataExplode);

    $this->setCepDestino($this->params['cepDestino']);
    $this->setCepOrigem($this->params['cepOrigem']);
    $this->setEndereco(trim(preg_replace('/[0-9,]/', '', strip_tags($data[9]))));
    $this->setPrazo(self::toNumber($data[1]));
    $this->setValor(self::toPrice($data[3]));
    $this->setCidade(trim($city));
    $this->setUf(trim($state));
  }

  protected function toPrice($string)
  {
    $price = self::toNumber($string);
    return number_format($price / 100, 2, '.', '');
  }

  protected function toNumber($string)
  {
    return preg_replace('/[^0-9]/', '', $string);
  }
}
