
<?php

 class Certificate  {
  protected $ISIN;
  protected $trading_Market;
  protected $currency;
  protected $issuer;
  protected $issuing_Price;
  protected $current_Price;
 
  protected function __construct($requestData){
    $this->ISIN = $requestData['ISIN_'];
    $this->trading_Market = $requestData['tradingMarket_'];
    $this->currency = $requestData['currency_'];
    $this->issuer = $requestData['issuer_'];
    $this->issuing_Price = $requestData['issuingPrice_'];
    $this->current_Price = $requestData['currentPrice_'];
  }
 
  public function get(){
    return get_object_vars($this);
  }

  public function __destruct(){
  }
}
 


