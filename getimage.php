<?php

	$c =  $_GET['id'];

	$cat = substr($c, 0, 1);
	$tp = substr($c, 1, 1);
	$sz = substr($c, 2, 1);
	$id = substr($c, 3);

	switch ($cat)
	{
		case '1':
			$dir = "loads/tree";
			break;
		case '2':
			$dir = "loads/catalog";
			break;
		case '3':
			$dir = "loads/texts";
			break;
		case '4':
			$dir = "loads/partners";
			break;
		case '5':
			$dir = "loads/cataloggl";
			break;
		case '7':
			$dir = "loads/nominations";
			break;
		case '8':
			$dir = "loads/markers";
			break;
		case '9':
			$dir = "loads/masterclasses";
			break;
		case 'b':
			$dir = "loads/team";
			break;
		case 'c':
			$dir = "loads/main";
			break;
		case 'd':
			$dir = "loads/languages";
			break;
		case 'f':
			$dir = "loads/tfiles";
			break;
		default:
			exit();
			break;
	}

	switch ($tp)
	{
		case '1':
			$ext = "jpg";
			break;
		case '2':
			$ext = "gif";
			break;
		case '3':
			$ext = "png";
			break;
		default: 
			exit();
			break;
	}

	switch ($sz)
	{
		case '1':
			$mx = 90;
			$my = 90;
			break;
		case '2':
			$mx = 300;
			$my = 400;
			break;
		case '3':
			$mx = 520;
			$my = 2000;
			break;
		case '4':
			$mx = 280;
			$my = 240;
			break;
		case '5':
			$mx = 700;
			$my = 700;
			break;
		case '6':
			$mx = 600;
			$my = 600;
			break;
		case '7':
			$mx = 300;
			$my = 300;
			break;
		case '9':
			$mx = 600;
			$my = 900;
			break;
	}

	switch ($tp)
	{
		case '3':
			$ext2 = "png";
			break;
		default: 
			$ext2 = "jpg";
			break;
	}

	if (file_exists("temp/".$c.".".$ext2))
	{
		header("Location: /temp/".$c.".".$ext2);
		exit();
	}


	
	if (file_exists($dir . "/" . $id . "." . $ext))
	{
		$file = $dir . "/" . $id . "." . $ext;
		switch ($tp)
		{
			case '1';
				$img = imagecreatefromjpeg($file);
				$hd = "image/jpeg";
				break;
			case '1';
				$img = imagecreatefromjpeg($file);
				$hd = "image/jpeg";
				break;
			case '2':
				$img = imagecreatefromgif($file);
				$hd = "image/gif";
				break;
			case '3':
				$img = imagecreatefrompng($file);
				$hd = "image/png";
				break;
		}
		$w = imagesx($img);
		$h = imagesy($img);

		$maxw = $mx;
		$maxh = $my;

		if($maxw or $maxh)
		{
			$sam1=ImageSX($img)/$maxw;
			$sam2=ImageSY($img)/$maxh;
			$sam=max($sam1,$sam2);
			if($sam <1 ) $sam=1;
		}
		elseif($w)
		{
			$sam=ImageSX($img)/$w;
		}
		elseif($h)
		{
			$sam=ImageSY($img)/$h;
		} else
		{
			$sam=1;
		}

		$w=ImageSX($img)/$sam;
		$h=ImageSY($img)/$sam;

		$im = imagecreatetruecolor($w, $h);
		if ($tp!="3")
		{
			imagecopyresampled($im, $img, 0, 0, 0, 0, $w, $h, imagesx($img), imagesy($img));
			imagejpeg($im, "temp/" . $_GET['id'] . ".jpg", "100");
			@chmod("temp/" . $_GET['id'] . ".jpg", 0664);
			header("Content-type: " . $hd);
			imagejpeg($im);
		}
		else
		{

			$newImg = imagecreatetruecolor($w, $h);
			imagealphablending($newImg, false);
			imagesavealpha($newImg,true);
			$transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
			imagefilledrectangle($newImg, 0, 0, $w, $h, $transparent);
			imagecopyresampled($newImg, $img, 0, 0, 0, 0, $w, $h, imagesx($img), imagesy($img));

			header("Content-type: image/png");
			imagepng($newImg);

			//imagecopyresampled($newImg, $img, 0, 0, 0, 0, $w, $h, imagesx($img), imagesy($img));
			//header("Content-type: " . $hd);
			//imagepng($im);
		}

	}
	else
	{
		exit();
	}

?>