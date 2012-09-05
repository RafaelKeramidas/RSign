<?php
	/***
	 * RSign - SA-MP Signature Generator
	 * 
	 * @Author		Rafael 'R@f' Keramidas <rafael@keramid.as>
	 * @Version		1.0
	 * @Date		05th September 2012
	 * @Licence		GPLv3 
	 ***/
	  
	header('Content-type: image/png');
	
	require('includes/config.inc.php');
	require('includes/lang/' . $config['language'] . '.inc.php');
	require('classes/sampquery.class.php'); 
	 
	if(isset($_GET['srv'])) {
		$serverinfos = explode(':', $_GET['srv']);
		if(!isset($serverinfos[1]))
			$serverinfos[1] = 7777;
		
		$ip = $serverinfos[0];
		$port = intval($serverinfos[1]);
		$sign = imagecreatefrompng('images/' . $config['background']);
		$font = 'fonts/' . $config['font'];
		$fontcolor = imagecolorallocate($sign, $config['fontcolorr'], $config['fontcolorg'], $config['fontcolorb']);
		
		$sampquery = new SampQuery($ip, $port);
		if($sampquery->isOnline()) {
			$sinfos = $sampquery->getInfo();
			$passwd = $lang['no'];
			if($sinfos['password'] == 1)
				$passwd = $lang['yes'];
			
			imagettftext($sign, 16, 0, 20, 35, $fontcolor, $font, substr($sinfos['hostname'], 0, 34));
			imagettftext($sign, 11, 0, 22, 60, $fontcolor, $font, $lang['ipport'] . ': ' . $ip . ':' . $port);
			imagettftext($sign, 11, 0, 22, 80, $fontcolor, $font, $lang['password'] . ': ' . $passwd);
			imagettftext($sign, 11, 0, 22, 100, $fontcolor, $font, $lang['players'] . ': ' . $sinfos['players'] . '/' . $sinfos['maxplayers']);
			imagettftext($sign, 11, 0, 22, 120, $fontcolor, $font, $lang['usage'] . ': ' . round((($sinfos['players'] * 100) / $sinfos['maxplayers']), 0) . '%');
			imagettftext($sign, 11, 0, 22, 140, $fontcolor, $font, $lang['gamemode'] . ': ' . $sinfos['gamemode']);
			imagettftext($sign, 11, 0, 22, 160, $fontcolor, $font, $lang['map'] . ': ' . $sinfos['mapname']);
		}
		else {
			$center = (450 - (strlen($lang['offline']) * 12)) / 2;
			imagettftext($sign, 16, 15, $center, 110, $fontcolor, $font, $lang['offline']);
		}
		
		imagesavealpha($sign, true);
		imagepng($sign);
	}
	
?>