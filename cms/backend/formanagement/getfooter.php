<?php
	echo '<div class="footer">';
	echo '<ul>';
						
	$currentConfig = $myADBConnector->getKonfiguration();
							
	echo '<li>'.date("d.m.Y", time()).'</li>';
	echo '<li><a href="https://github.com/MichaBe/myCMSxml" target="_blank">myCMSxml auf github</a></li>';
	echo '<li>Lizenz: <a rel="license" href="http://creativecommons.org/licenses/by/3.0/" target="_blank">CC BY 3.0</a></li>';
	echo '<li>Version '.$currentConfig[0]['Kversion'].'</li>';
	echo '</ul>';
	echo '</div>';
?>