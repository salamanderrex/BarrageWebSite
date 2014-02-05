<?php
class BaseController extends Zend_Controller_Action

// specify to controll the bakc
{
//bootstrap 初始化数据库适配器


public $db;

public function init()
 

    {
    	
 
     $url = constant("APPLICATION_PATH").DIRECTORY_SEPARATOR."configs".DIRECTORY_SEPARATOR."application.ini";
  
     $dbconfig = new Zend_Config_Ini($url,"mysql");
  
     $db = Zend_Db::factory($dbconfig->db);
  
     $db->query("SET NAMES utf8");
  
     Zend_Db_Table::setDefaultAdapter($db);
    }
     
     

}

?>