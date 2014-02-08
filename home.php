<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!--<?
	//if no cookie, then create one and valid in 30 days
	if(!isset($_cookie["scid"])){
	$session =md5(uniqid(rand()));
	setcookie("scid",$session, time()+3600*24*30);
	}
	//put it into mysql and init all img click 1 time
	$con=mysql_connect("127.0.0.1","123","123")or die ("Failed to connect to MySQL: " . mysql_error());
	mysql_select_db("comp7105cept");
	mysql_query("insert into images (No1, No2, No3, No4, No5, No6, No7, No8, No9, No10, scid) 
	values (1,1,1,1,1,1,1,1,1,1,'$_cookie['scid']')")or die("Unable to create user". mysql_error());	
?> -->

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Target advertisement</title>
<link href="layout.css" rel="stylesheet" type="text/css">
</head>

<body>

<?php
	//to judge whether val is in range[low, high] or not
	function inRange($low, $high, $val)
	{
		return $val >= $low && $val <= $high;
	}
?>

<?php

/*To calculate the accumulate click times from zero till first img, second img, third img,..etc. Then use those
numbers to divide range 0 to 100 into some blocks. Then generate a random number of 0 to 100 and see
which block it falls in, and then return the according img number.
*/
function showImg(){
//to decide the freq of imgs
	$con=mysqli_connect("127.0.0.1","123","123","comp7105cept")or die ("Failed to connect to MySQL: " . mysqli_error());
	$count=mysqli_query($con, 'select * from images');
	if(! $count){
		die('Could not get data: ' . mysql_error());	
	}
	else{	
	//extract all data of a row from mysql	
	while($row=mysqli_fetch_array($count)){
		$total=0;
		$accum[0]=0;
	//count from column 0 to 9, 10 total		
		for($i=0;$i<=9;$i++){
			$total+=$row[$i];
			$accum[$i+1]=10*$total;
		} 		
	} 
	//generate a random number and find it belongs to which range	
	$number=rand(0,100);
	for($k=0;$k<=9;$k++){
		if(inRange($accum[$k],$accum[$k+1], $number)){
			return $k+1;			
			break;
		}		
	}
	
	//free and close connection	
	mysql_free_result($count);
	mysql_close($con);
	}
}	
?>

<!--top bar-->
<?php 
	//use a variable to store the number of showImg to ensure that the number in href and img
	//in the same ad banner are the same
	$topImg=showImg();
	echo'<a href="http://localhost/7105/home.php?id='.$topImg.'" >';
?>

<?php 
	echo '<div class="topAd" style="width:'.$_GET['topAdWidth'].'px;height:'.$_GET['topAdHeight'].'px;">';
?>

<?php 
	echo '<img style="width:100%; height:100% ;" src="ad-img/'.$topImg.'.jpg">';
?>

</div>
</a>
<!--end of top bar-->

<!--left bar-->
<?php 
	//use a variable to store the number of showImg to ensure that the number in href and img
	//in the same ad banner are the same
	$leftImg=showImg();
	echo'<a href="http://localhost/7105/home.php?id='.$leftImg.'" >';
?>
<?php 
	echo '<div class="leftAd" style="width:'.$_GET['leftAdWidth'].'px;height:'.$_GET['leftAdHeight'].'px;">';
?>

<?php 
	echo '<img style="width:100%; height:100% ;" src="ad-img/'.$leftImg.'.jpg">';
?>
</div>
</a>
<!--end of left bar-->


<!--right bar-->
<?php 
	//use a variable to store the number of showImg to ensure that the number in href and img
	//in the same ad banner are the same
	$rightImg=showImg();
	echo'<a href="http://localhost/7105/home.php?id='.$rightImg.'" >';
?>
<?php 
	echo '<div class="rightAd" style="width:'.$_GET['rightAdWidth'].'px;height:'.$_GET['rightAdHeight'].'px;">';
?>

<?php 
	echo '<img style="width:100%; height:100% ;" src="ad-img/'.$rightImg.'.jpg">';
?>
</div>
</a>
<!--end of right bar-->


<?php
	//when click the link, update the click time in mysql
	$num=$_GET['id'];
	$con=mysqli_connect("127.0.0.1","123","123","comp7105cept")or die ("Failed to connect to MySQL: " . mysqli_error());
	mysqli_query($con,"UPDATE images set No".$num."=No".$num."+1");
	mysqli_close($con);
?>
<div class="container">

<div class="menubar">
	<a href="login.php">Login</a>
</div>

<div class="content">

<?php
	if (file_exists("/tmp/rsscache") and (time() - filemtime("/tmp/rsscache") < 120)) { 
		
		// Does the cache exist and is it less than 2 mins old
		readfile("/tmp/rsscache");
	} else {

		// Array containing all the feeds you want to import
		$feeds = array(
				"http://feeds.feedburner.com/vgod/blog/feed",
               "http://modeflickan.se/lifebylinda/feed/",
               "http://modeflickan.se/stylemind/feed/",
               "http://modeflickan.se/ninniesodergren/feed/",
               "http://modeflickan.se/alvaasp/feed/");
               
	$results = (array)get_rss_items($feeds);
	$str = "";

	if (count($results) > 0) { // Are there results

		foreach ($results as $k => $v) {

			$str .= "<div class='feedblock'>
			<div class='feednews'>
					<a href='" . $v[1]['link'] . "' title='" . $v[1]['description'] . " - " . mb_substr($v[1]['description'], 100) . "'>" .
					$v[1]['title'] .
					"</a>
				</div>
				<div class='feedtitle'>".        
					$v['title'] .
					"</div>
			</div>";
		}

		echo $str;

		file_put_contents("/tmp/rsscache",$str,LOCK_EX); // Store the HTML in the cache file, overwrite old cache
	}
}

	function get_rss_items($feeds) {

		$result = array();

		if (count($feeds) > 0) { // are there any feeds to parse
			foreach ($feeds as $k => $feed) {

				// retrieve the feed
				if ($xml = simplexml_load_file($feed, 'SimpleXMLElement', LIBXML_NOCDATA)) {

					$result[$k]["title"] = $xml->channel->title; // Main title of blog or feed


					// Get the data about the first element in the feed
					$result[$k][1]["title"] = $xml->channel->item[0]->title;
					$result[$k][1]["link"] = $xml->channel->item[0]->link;
					$result[$k][1]["description"] = $xml->channel->item[0]->description;
				}
			}
			return $result;
		} else {
			return FALSE;
		}
	}

?>
</div>
</div>
	</body>
</html>
