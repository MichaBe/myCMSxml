<?php
	session_start();
	$current_dir = getcwd();
	chdir('../../backend');
	include('./a_dbconnector.php');
	include('./a_ftpconnector.php');
	chdir($current_dir);
	$myADBConnector = new advanced_dbconnector();
	$myAFTPConnector = new advanced_ftpconnector();
	$currentRights = $myADBConnector->getOneBenutzer($_SESSION['UID']);
	
	if($currentRights[6]['Xvalue'] != 1) {
		unset($myADBconnector);
		unset($myAFTPConnector);
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/index.php');
	}
	
	if(isset($_POST['BGID']) /*&& isset($_POST['sourcepath'])*/) {
		$newBild = array();
		$newBild['BGID'] = $_POST['BGID'];
		$newBild['Btitle'] = "";
		$newBild['Bdescription'] = "";
		$BID = $myADBConnector->addOneBild($newBild);
		
		$myAFTPConnector->uploadPic("sourcepath", '../../bilder/B'.$BID.'temp.jpg');
		echo var_dump($_FILES);
		
		$oldsize = getimagesize('../../bilder/B'.$BID.'temp.jpg');
		$newNormalsize = array();
		$newThumbsize = array();
		if($oldsize[0] >= $oldsize[1]*1.5) {
			$newNormalsize[0] = 750;
			$newNormalsize[1] = (750/$oldsize[0])*$oldsize[1];
			$newThumbsize[0] = 150;
			$newThumbsize[1] = (150/$oldsize[0])*$oldsize[1];
		}
		else {
			$newNormalsize[0] = (500/$oldsize[1])*$oldsize[0];
			$newNormalsize[1] = 500;
			$newThumbsize[0] = (100/$oldsize[1])*$oldsize[0];
			$newThumbsize[1] = 100;
		}
		
		$tempimage = imagecreatefromjpeg('../../bilder/B'.$BID.'temp.jpg');
		$thumbnail = imagecreatetruecolor($newThumbsize[0], $newThumbsize[1]);
		$grossesB = imagecreatetruecolor($newNormalsize[0], $newNormalsize[1]);
		
		imagecopyresampled($thumbnail, $tempimage, 0, 0, 0, 0, $newThumbsize[0], $newThumbsize[0], $oldsize[0], $oldsize[1]);
		imagecopyresampled($grossesB, $tempimage, 0, 0, 0, 0, $newNormalsize[0], $newNormalsize[1], $oldsize[0], $oldsize[1]);
		
		imagejpeg($thumbnail, '../../bilder/B'.$BID.'thmb.jpg', 75);
		imagejpeg($grossesB, '../../bilder/B'.$BID.'.jpg', 90);
		
		imagedestroy($tempimage);
		imagedestroy($thumbnail);
		imagedestroy($grossesB);
		unlink('../../bilder/B'.$BID.'temp.jpg');
	}
	
	unset($myADBConnector);
	unset($myAFTPConnector);
	
	//header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/galerien/BGmask.php?BGID='.$_POST['BGID']);
?>