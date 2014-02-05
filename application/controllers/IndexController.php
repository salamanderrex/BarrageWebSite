<?php
require_once 'BaseController.php';
require_once APPLICATION_PATH.'/models/av.php';
class IndexController extends BaseController
{

			
    public function indexAction()
    {
        // action body
        $av=new av();
       // $res=$av->fetchAll()->toArray();
        $av->getAdapter()->query("set names utf8");
        $sql="select * from av ORDER BY id desc";
		$res=$av->getAdapter()->query($sql);
		//$res->
        $this->view->av=$res;

        $this->render('index');
        
    }
    
    public function waterfallAction()
    {        $av=new av();
       // $res=$av->fetchAll()->toArray();
        $av->getAdapter()->query("set names utf8");
        $sql="select * from av ORDER BY id desc";
		$res=$av->getAdapter()->query($sql);
		//$res->
        $this->view->av=$res;

      //  echo Zend_Json::prettyPrint($json, array("indent" => " "));
        $json =array();
        //= Zend_Json::encode($res->fetchAll());
    $av1=$res->fetchAll();
  // print_r($av1);
    $i=0;
        foreach ($av1 as $av)
        {
      	
        $new_row = array("imgSrc"=>"/image/av/".$av['id'],"href"=>"/player/index/id/". $av['id'] ,"title"=>$av['title'],"describe"=>$av['description']);
  	 	array_push($json,$new_row);
        	$i++;
        //
        }
       // print_r($json);
        $jsonData = Zend_Json::encode($json);
     //   echo $jsonData;
        
        $jsonData = Zend_Json::encode($json);
        $this->getResponse()
        ->setHeader('Content-Type', 'text/html')
        ->setBody($jsonData)
        ->sendResponse();
	exit;
    }
    


}

