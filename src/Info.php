<?php

namespace Shipping;

class Info
{
  public $img;
  public $prazo;
  public $valor;
  public $cepOrigem;
  public $cepDestino;
  public $bairro;
  public $endereco;
  public $cidade;
  public $uf;
  public $boolean;

  public function setPrazo($prazo = '')
  {
    $this->prazo = $prazo;
  }

  public function getPrazo()
  {
    return $this->prazo;
  }

  public function setValor($valor = '')
  {
    $this->valor = $valor;
  }

  public function getValor()
  {
    return $this->valor;
  }

  public function setCepOrigem($cepOrigem = '')
  {
    $this->cepOrigem = $cepOrigem;
  }

  public function getCepOrigem()
  {
    return $this->cepOrigem;
  }

  public function setCepDestino($cepDestino = '')
  {
    $this->cepDestino = $cepDestino;
  }

  public function getCepDestino()
  {
    return $this->cepDestino;
  }

  public function setEndereco($endereco = '')
  {
    $this->endereco = $endereco;
  }

  public function getEndereco()
  {
    return $this->endereco;
  }

  public function setBairro($bairro = '')
  {
    $this->bairro = $bairro;
  }

  public function getBairro()
  {
    return $this->bairro;
  }

  public function setCidade($cidade = '')
  {
    $this->cidade = $cidade;
  }

  public function getCidade()
  {
    return $this->cidade;
  }

  public function setUf($uf = '')
  {
    $this->uf = $uf;
  }

  public function getUf()
  {
    return $this->uf;
  }

  public function setError($boolean = false)
  {
    $this->boolean = $boolean;
  }

  public function getError()
  {
    return $this->boolean;
  }
}
