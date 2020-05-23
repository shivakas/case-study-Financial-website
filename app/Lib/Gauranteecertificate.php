

<?php
class Gauranteecertificate extends Certificate{
 	protected $participation_Rate;

	public function __construct($requestData){
		parent::__construct($requestData);
		$this->participation_Rate=$requestData['participation_rate'];
	}

	public function __destruct(){
 	}
}

