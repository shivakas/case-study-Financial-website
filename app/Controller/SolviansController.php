<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */



App::uses('Certificate', 'Lib');
App::uses('Bonuscertificate', 'Lib');
App::uses('Gauranteecertificate', 'Lib');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link https://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class SolviansController extends AppController {
  public $components = array('RequestHandler');


  public function displayAsHtml(){
    if ($this->request->is('post')) {
      if(isset($this->request->data['barrier_level']) AND !isset($this->request->data['participation_rate'])){
        $bonusCertificate=new Bonuscertificate($this->request->data);
        $data=$bonusCertificate->get();
        unset($bonusCertificate);
      }else if(isset($this->request->data['participation_rate'])){
        $data =  new MethodNotAllowedException();
      }
      else{
        $Certificate=new Certificate($this->request->data);
        $data=$Certificate->get();
        unset($Certificate);
      }  

      //The Function saveData can be used when assumed Different certificatehs have different ISIN Code 

      //$this->saveData($this->request->data);


      //Function to savefile used to provide a link for attach files with pdf
      $file=$this->saveFile();
        
        $this->set(compact('data','file'));
           
    } 
  }

  public function displayAsXml(){
    $this->viewClass = 'Xml';
    if ($this->request->is('post')) {
      if(isset($this->request->data['barrier_level']) AND !isset($this->request->data['participation_rate'])){
        $bonusCertificate=new Bonuscertificate($this->request->data);
        $data=$bonusCertificate->get();
        unset($bonusCertificate);
      }else if(isset($this->request->data['participation_rate']) AND !isset($this->request->data['barrier_level'])){
        $Gauranteecertificate=new Gauranteecertificate($this->request->data);
        $data=$Gauranteecertificate->get();
        unset($Gauranteecertificate);
      }
      else{
        $Certificate=new Certificate($this->request->data);
        $data=$Certificate->get();
        unset($Certificate);
      } 
      $this->saveData($this->request->data);
      $this->set(compact('data'));
      $this->set('_serialize', array('data'));      
    }
  }


  public function saveFile() {
    $info = pathinfo($_FILES['file']['name']);
    $name= $info['filename'].'.'.$info['extension'];
    $target = '../../app/webroot/files/'.$name;
    $this->file= '<a href="'.$target.'">Download Brochure</a>';
    move_uploaded_file( $_FILES['file']['tmp_name'], $target);
    return $name;
  }

  public function saveData($data) {
    $this->autoRender = false;
    $this->loadModel('Solvian');
    $record = $this->Solvian->findByIsin($data['ISIN_']);
    if(!empty($record)){
        $this->Solvian->id = $record['Solvian']['id'];
        $this->Solvian->set(array('issuing_price'=>$record['Solvian']['issuing_price'],
        'current_price' => $record['Solvian']['current_price']));  
        $this->Solvian->save(); 
    }
    else{
   
      $dataToSave=array(
        'isin' => $data['ISIN_'],
        'trading_market' => $data['tradingMarket_'],
        'currency' => $data['currency_'],
        'issuer' => $data['issuer_'],
        'issuing_price' => $data['issuingPrice_'],
        'current_price' => $data['currentPrice_'],
      );
      $this->Solvian->create();
      $this->Solvian->save($dataToSave);
    }
    return $record;
  }

}




