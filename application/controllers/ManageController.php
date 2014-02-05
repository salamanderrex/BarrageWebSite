<?php
require_once 'BaseController.php';
require_once APPLICATION_PATH.'/models/av.php';
class manageController extends BaseController 
{
	
	public function checklogin()
	{
		session_start();
		$user=$_SESSION['user'];
		$pw=$_SESSION['pw'];
		if(!($user=="JINET"&&$pw=="JINET"))
		{
			return  false;
	
		}
		return true;
	}
	
	public function managepanelAction()
	{
	
	}
	public function indexAction()
	{
		// action body
		$login=$this->checklogin();
		if($login)
		{
			$this->render('managepanel');
		}
	}

	public function addavuiAction()
	{
		$login=$this->checklogin();
		if($login)
		{
			$this->render('addavui');
		}
		else
		{
			$this->render('index');
		}
			
		
		
	}
	
	public function deleteavuiAction()
	{
		$login=$this->checklogin();
		if($login)
		{
			$this->render('deleteavui');
		}
		else
		{
			$this->render('index');
		}
		
	}
	public function cleanbarrageuiAction()
	{
		$login=$this->checklogin();
		if($login)
		{
			$this->render('cleanbarrageui');
		}
		else
		{
			$this->render('index');
		}
	
	}
	

	
	public function addavAction()
	{
		
		echo'start adding av';
		$vid=$this->getRequest()->getParam('vid');
		$source=$this->getRequest()->getParam('source');
		$title=$this->getRequest()->getParam('title');
		$description=$this->getRequest()->getParam('description');
		echo $vid.' '.$source.$title.$description;
		
		$data=array('vid'=>$vid,'source'=>$source,'title'=>$title,'description'=>$description);
		$avModel =new av();
		$avModel->getAdapter()->query("set names utf8");
		$avModel->insert($data);
		echo "ok";
		
		$adapter = new Zend_File_Transfer_Adapter_Http();
		
		$adapter->setDestination(APPLICATION_PATH.'/../public/image/av');

		
		$av=new av;
		$count = $av->getAdapter()->fetchOne("select id  from av order by id desc");
		$count;
		$av->getAdapter()->query($sql="create table if not exists commentav{$count} (
		id int primary key auto_increment,
		user varchar(10),
		mode tinyint,
		color int,
		stime int,
		message varchar(256),
		size int,
		timestamp int)default charset=utf8;");
		$filename=$count.'.jpg';
	
		$adapter->addFilter('Rename', array('target' => $filename, 'overwrite' => true));//Ö´ÐÐÖØÃüÃû
		
		if (!$adapter->receive()) {
			$messages = $adapter->getMessages();
			echo implode("\n", $messages);
		}
		$this->render('ok');
		//exit();
		
		
	

	}
	
	public function cleanbarrageAction()
	{
		$id=$_POST['cleanid'];
		$av=new av;
		$sql="delete from commentav".$id;
		$av->getAdapter()->query($sql);
		$this->render("ok");
		//exit();
	}
	public function deleteavAction()
	{
		
		$id=$_POST['deleteid'];
		$av=new av;
		$sql="delete from av where id=".$id;
		$av->getAdapter()->query($sql);
		$sql="drop table commentav".$id;
		$av->getAdapter()->query($sql);
		$this->render("ok");
		//exit();
	}
	public function loginAction()
	{

	
	$user=$_POST['user'];
	$pw=$_POST['pw'];
	
	if($user=="JINET"&&$pw=="JINET")
	{
		session_start();
			
		$_SESSION['user']=$user;
		$_SESSION['pw']=$pw;
		$this->redirect('/manage/managepanel');
	}
	else 
	{
		$this->redirect('/manage/index');
	}
	
	}
	

}
?>