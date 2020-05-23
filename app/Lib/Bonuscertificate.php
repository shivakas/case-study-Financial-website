

<?php

class Bonuscertificate extends Certificate{
  protected $barrier_Level;

  	public function __construct($requestData){
	  parent::__construct($requestData);
	  $this->barrier_Level=$requestData['barrier_level'];
 	}
 	
 	public function __destruct(){
 	}
}

