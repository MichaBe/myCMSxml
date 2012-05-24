<?php
	include("cms/backend/dbconnector.php");
	$myConnector = new simle_dbconnector();
	
	$myCMSxml = simplexml_load_file("cms/myCMS.xml");
	$categories = simplexml_load_file("cms/categories.xml");
	$validcatchoosen = FALSE;
	$current_catName;
	if (isset($_REQUEST['CID'])) {
		for ($i = 0; $i < count($categories -> category); $i++) {
			if ($_REQUEST['CID'] == $categories -> category[$i] -> id)
				$validcatchoosen = TRUE;
		}
		for ($i = 0; $i < count($categories -> category); $i++) {
			if ($categories -> category[$i] -> id == $_REQUEST['CID']) {
				$current_catName = $categories -> category[$i] -> showname;
				break;
			}
		}
		
		if(!$validcatchoosen) {
			$hostname = $_SERVER['HTTP_HOST'];
			header('Location: http://'.$hostname.'/error.php');
		}
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			
			if ($validcatchoosen) {
				$tags;
				$description;
				for($i = 0; $i < count($categories->category); $i++) {
					if($categories->category[$i]->id == $_REQUEST['CID']) {
						$tags = $categories->category[$i]->tags;
						$description = $categories->category[$i]->description;
					}
				}
				echo '<title>' . $myCMSxml -> config -> title . ' - ' . $current_catName . '</title>';
				echo '<meta name="keywords" content="'.$tags.'"/>';
				echo '<meta name="description" content="'.$description.'"/>';
			}
			else {
				echo '<title>' . $myCMSxml -> config -> title . '</title>';
				echo '<meta name="description" content="'.$myCMSxml->config->description.'"/>';
			}
			echo '<link rel="stylesheet" type="text/css" href="/cms/style/' . $myCMSxml -> config -> theme . '/theme.css" />';
		?>
	</head>
	<body>
		<div class="wrapper">
			<div class="header">
				<?php
					echo $myCMSxml -> config -> title;
				?>
			</div>
			<div class="categories">
				<ul>
					<?php
						echo '<li id="startseite"><a href="index.php">Startseite</a></li>';
						for ($i = 0; $i < count($categories -> category); $i++) {
							echo '<li id="' . $categories -> category[$i] -> id . '"><a href="index.php?CID=' . $categories -> category[$i] -> id . '">' . $categories -> category[$i] -> showname . '</a></li>';
						}
					?>
				</ul>
			</div>
			<div class="inhalt">
				<?php
					$snippetpaths;
					$snippetstoload;
					if($validcatchoosen)
					{
						foreach (glob($_REQUEST['CID']."/snippet*.xml") as $path) {
							$snippetpaths[count($snippetpaths)] = $path;
						}
					}
					else
					{
						for($i = 0; $i < count($categories->category); $i++)
						{
							foreach (glob($categories->category[$i]->id."/snippet*.xml") as $path) {
								$snippetpaths[count($snippetpaths)] = $path;
							}
						}
					}
					for($i = 0; $i < count($snippetpaths); $i++)
					{
						$tempsnippet = simplexml_load_file($snippetpaths[$i]);
						if($tempsnippet->state == "released")
						{
							$snippetstoload[$i]->releasedate = $tempsnippet->released;
							$snippetstoload[$i]->path = $snippetpaths[$i];
						}
					}
					for($j = 0; $j < count($snippetstoload)*count($snippetstoload); $j++)
					{
						for($i = 0; $i < count($snippetstoload)-1; $i++)
						{
							if(intval($snippetstoload[$i]->releasedate) < intval($snippetstoload[$i+1]->releasedate))
							{
								$tempdata->releasedate = $snippetstoload[$i]->releasedate;
								$snippetstoload[$i]->releasedate = $snippetstoload[$i+1]->releasedate;
								$snippetstoload[$i+1]->releasedate = $tempdata->releasedate;
								
								$tempdata->path = $snippetstoload[$i]->path;
								$snippetstoload[$i]->path = $snippetstoload[$i+1]->path;
								$snippetstoload[$i+1]->path = $tempdata->path;
							}
							
						}
					}
					for($i = 0; $i < count($snippetstoload); $i++)
					{
						$snippettoshow = simplexml_load_file($snippetstoload[$i]->path);
						echo '<div class="snippet" id="'.$snippettoshow->cID.'">';
						echo '<h2>'.$snippettoshow->headline.'</h2>';
						echo '<div class="s_header">';
						echo 'Ver&#246;ffentlicht am '.date("j.n.Y", intval($snippettoshow->released)).' von '.$snippettoshow->author.', letzte Änderung am '.date("j.j.Y", intval($snippettoshow->lastmod));
						echo '</div>';
						echo '<a href="snippet.php?SID='.$snippettoshow->sID.'">';
						echo $snippettoshow->description;
						echo '</a>';
						echo '</div>';
					}
				?>
			</div>
			<div class="footer">
				<?php
					echo '<ul>';
					foreach (glob("footer/snippet*.xml") as $path) {
						$tempfootersnippet = simplexml_load_file($path);
						echo '<li><a href="snippet.php?SID=' . $tempfootersnippet->sID . '">' . $tempfootersnippet -> headline . '</a></li>';
					}
					echo '</ul>';
				?>
			</div>
		</div>
	</body>
</html>