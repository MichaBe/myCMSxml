<!--
	main.php for noteMe
	by Micha Beierl
	31.10.2012
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
				echo $myTIDBC->getGalerien();
			echo '</ul>';
		echo '</div>';
	
		echo '<div class="inhalt">';
			$Beitraege = $myTIDBC->getBeitraege();
			foreach ($Beitraege as $curBeitrag) {
				echo $curBeitrag;
			}
			echo '<div class="footer">';
				echo '<ul>';
					echo $myTIDBC->getFooter();
				echo '</ul>';
			echo '</div>';
	
		echo '</div>';
	
	echo '</div>';
	unset($myTIDBC);
?>