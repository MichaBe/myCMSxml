<?php
	$myCMSxml = simplexml_load_file("cms/myCMS.xml");
	$categories = simplexml_load_file("cms/categories.xml");
	$validsnipchoosen = FALSE;
	$current_snippet;
	if (isset($_REQUEST['SID'])) {
		if(file_exists("footer/snippet".$_REQUEST['SID'].".xml")) {
			$current_snippet = simplexml_load_file("footer/snippet".$_REQUEST['SID'].".xml");
			$validsnipchoosen = TRUE;
			break;
		}
		if(file_exists("hidden/snippet".$_REQUEST['SID'].".xml")) {
			$current_snippet = simplexml_load_file("hidden/snippet".$_REQUEST['SID'].".xml");
			$validsnipchoosen = TRUE;
			break;
		}
		for($i = 0; $i < count($categories->category); $i++) {
			foreach (glob($categories->category[$i]->id."/snippet*.xml") as $search_path) {
				$qPath = $categories->category[$i]->id."/snippet".$_REQUEST['SID'].".xml";
				if($search_path == $qPath) {
					$current_snippet = simplexml_load_file($search_path);
					$validsnipchoosen = TRUE;
					break 2;
				}
			}
		}
	}
	if (!$validsnipchoosen) {
		$hostname = $_SERVER['HTTP_HOST'];
		header('Location: http://' . $hostname . '/error.php');
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php
			echo '<meta name="description" content="'.$current_snippet->description.'"/>';
			echo '<meta name="keywords" content="'.$current_snippet->tags.'"/>';
			echo '<title>' . $myCMSxml -> config -> title . ' - ' . $current_snippet->headline . '</title>';
			
			echo '<link rel="stylesheet" type="text/css" href="cms/style/' . $myCMSxml -> config -> theme . '/theme.css"/>';
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
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
					echo '<div class="snippet" id="'.$current_snippet->cID.'">';
					echo '<h2>'.$current_snippet->headline.'</h2>';
					echo '<div class="s_header">';
					echo 'Ver&#246;ffentlicht am '.date("j.n.Y", intval($current_snippet->released)).' von '.$current_snippet->author.', letzte Änderung am '.date("j.j.Y", intval($current_snippet->lastmod));
					echo '</div>';
					echo $current_snippet->text;
					echo '</div>';
				?>
			</div>
			<div class="footer">
				<?php
				echo '<ul>';
				foreach (glob("footer/snippet*.xml") as $path) {
					$tempfootersnippet = simplexml_load_file($path);
					echo '<li><a href="snippet.php?SID=' . $tempfootersnippet->sID. '">' . $tempfootersnippet -> headline . '</a></li>';
				}
				echo '</ul>';
				?>
			</div>
		</div>
	</body>
</html>