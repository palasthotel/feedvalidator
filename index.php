<!DOCTYPE html>
<html>
<head>




  <meta charset="utf-8" />
  <title>Futterprüfer 0.1</title>
  <link type="text/css" rel="stylesheet" href="style.css" media="screen" />
  <link href='http://fonts.googleapis.com/css?family=Lato:300,700' rel='stylesheet' type='text/css' />
</head>
<body>
<form method="post">
Feed-URL: <br/>
<input class="url" type="text" name="url" value="<?=(isset($_POST['url'])?$_POST['url']:'')?>"><br/>
<input class="submit" type=submit>
</form>
<?php

require "simplepie_1.3.1.compiled.php";

if(isset($_POST['url']))
{
	$pie=new SimplePie();
	$pie->set_feed_url($_POST['url']);
	$pie->init();
	$array=$pie->error();
	if(!empty($array))
	{
?>

<?php
	if(!is_array($array))
		$array=array($array);
	foreach($array as $error)
	{
?>
<div class="hop"><p><?php echo $error;?></p></div>
<?php
	}
?>

<?php
	}
	else
	{
?>
<div class="top"><p>Der Feed ist in Ordnung</p></div>
<h1>Feed Items: </h1>
<div class="items">
	<ul>
		<?php
			$items=$pie->get_items();
			for($i=0;$i<5 && $i<count($items); $i++)
			{
		?>
		<li>
			<a href="<?php echo $items[$i]->get_permalink();?>"><h4><?php echo $items[$i]->get_title();?></h4></a>
			<div class="content"><?php echo $items[$i]->get_content(); ?>
			</div>
		</li>
		<?php
			}
		?>
	</ul>
</div>
<?php
	}
}

?>
</body>
</html>
