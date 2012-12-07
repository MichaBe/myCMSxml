<div class="navigation">
	<ul>
		<?php
			echo '<li><a href="/cms/management/">Zur Startseite</a></li>';
			for($i = 1; $i < count($currentRights); $i++) {
				if($currentRights[$i]['Xvalue'] == 1)
					echo '<li><a href="/cms/management/'.$currentRights[$i]['Rshort'].'/">'.$currentRights[$i]['Rtopic'].'</a></li>';
			}						
			echo '<li><a href="/cms/management/logout.php">Vom System abmelden</a></li>';
		?>
	</ul>
</div>