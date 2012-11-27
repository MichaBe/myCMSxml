<!--
	error404.php for noteMe
	by Micha Beierl
	01.11.2012
-->
<?php
	$myTIDBC = new TI_dbconnector();
	
	echo '<div class="wrapper">';
	
		echo '<div class="header">';
			echo $myTIDBC->getHeader();
		echo '</div>';
	
		echo '<div class="categories">';
			echo '<ul>';
				echo $myTIDBC->getKategorien();
			echo '</ul>';
		echo '</div>';
	
		echo '<div class="inhalt">';
			echo "<h2>Die Seite, die Sie suchen, konnte leider nicht gefunden werden</h2>";
			
			echo '<div class="footer">';
				echo '<ul>';
					echo $myTIDBC->getFooter();
				echo '</ul>';
			echo '</div>';
	
		echo '</div>';
	
	echo '</div>';
	unset($myTIDBC);
?>