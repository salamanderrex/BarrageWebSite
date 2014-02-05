<?php
require_once 'BaseController.php';
require_once APPLICATION_PATH.'/models/av.php';
require_once APPLICATION_PATH.'/models/comment.php';
class playerController extends BaseController
{
	
	

	public function init()
	{
		parent::init();
		
		
	}
	
	
	public function indexAction()
	{
	
		$av=new av();
		// action body
		//$id=$this->getParam('id');
		$request = $this->getRequest();
		$id =intval( $request->getParam('id'));
		$where =($av->getAdapter()->quoteInto('id=?', $request->getParam('id')));
		//echo $id;
		
		$res=$av->find($id)->toArray();
		$res=$res[0];

	 
	 	$playtime=$res['playtime']+1;
	 //	echo $playtime;
	 	$set=array ('playtime'=>$playtime);
	 	//$sql="update av set playtime ={$playtime} where id={$id}";
	 	//$where="id= {$id}";
	 	//$av->getAdapter()->query($sql);
	 	$av->update($set, $where);
	 	
		$sql =$av->getAdapter()->quoteInto('SELECT * FROM av WHERE id = ?', $id);

	 	$res=$av->getAdapter()->fetchRow($sql);
	 	if(empty($res))
	 	{
	 	echo 'empty';
	 	$this->render('error');
	 	exit();
	 	}
	 	$info=array('playtime'=>$playtime,'source'=>$res['source'],'vid'=>$res['vid'],'description'=>$res['description'],'title'=>$res['title']);
	 	$this->view->info=$info;
	 	
	 	
	 
	 	
	 	$this->render('index');

	 	//add playtime

	}
	
	
	public function sendcommentAction()
	{
		
		$vid=$_GET['vid'];//this id is av id for each video source
		
		$av=new av();
		$res=$av->getAdapter()->fetchRow( "SELECT * FROM av WHERE vid='$vid'");
		$id=$res['id'];
		$user=$_POST['user'];
		$mode=$_POST['mode'];
		$color=$_POST['color'];
		$stime=$_POST['stime'];
		$message=$_POST['message'];
		$size=$_POST['size'];
		$timestamp=time();
		
		$comment=new comment;
		$table=" commentav".$id." ";
		$sql="insert into {$table} (user ,mode ,color,stime,message,size,timestamp) values ('$id','$mode','$color','$stime','$message','$size','$timestamp')";
		echo $sql;
		$comment->getAdapter()->query($sql);
		exit();
	
	
	}
	
	
	public function getcommentAction()
	{
	
		$vid=$_GET['vid'];//this id is av id for each video source
	
		$av=new av();
		$res=$av->getAdapter()->fetchRow( "SELECT * FROM av WHERE vid='$vid'");
		$id=$res['id'];
		
		$comment=new comment;
		$sql="select * from commentav".$id;
		$res=$comment->getAdapter()->fetchAll($sql);
		
		echo "<i>";
		foreach($res as $row )
		{
		
			echo"<d p=\"";
			$id=$row['id'];
			$user=$row['user'];
			$mode=$row['mode'];
			$color=$row['color'];
			$stime=$row['stime'];
			$message=$row['message'];
			$size=$row['size'];
			$stamptime=$row['timestamp'];
			echo "{$stime},{$mode},{$size},{$color},{$stamptime},0,{$user},{$id}\">{$message}</d>";
		
		
		
		}
		echo"</i>";
		
		exit();
	
	
	}
}
?>