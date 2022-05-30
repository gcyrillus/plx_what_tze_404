<?php if(!defined('PLX_ROOT')) exit;
	
	$var['erreur'	  ] = $plxPlugin->getParam('erreur'		)=='' ?  0  : $plxPlugin->getParam('erreur'		) ;	
	if(isset($_GET["reset_csv"])) {
		if(($open = fopen(PLX_PLUGINS.basename(dirname(__FILE__)).'/error404.csv', 'r')) !== false) {	
		// on efface le fichier
		$open = fopen(PLX_PLUGINS.basename(dirname(__FILE__)).'/error404.csv', 'w+');
		fclose($open);
		header('Location: parametres_plugin.php?p='.$plugin);
		exit;
		}
	}
	
?>
		<div class="help_404">	
			<h3>Configuration</h3>
	        <p><b><?php echo $plxPlugin->getLang('L_VIEW_CODE') ?></b></p>
			<form>
				<label for="code"><?php echo $plxPlugin->getLang('L_CODE_TO_INSERT_TO_TPLS') ?>:</label>
				<textarea id="code" readonly cols="68" rows="1" style="resize:none;height:1.8em;">&lt;?php if (eval($plxMotor->plxPlugins->callHook('get404'))) return; ?&gt;</textarea>
			</form>

			<h3><?php echo $plxPlugin->getLang('L_VIEWS_INFOS') . ' ' . $plxPlugin->checkMonthLangDate($plxPlugin->getParam('set'))?> </h3>
				<p><?php echo $plxPlugin->getLang('L_PAGE_404')  ; echo ' '.$var['erreur'	  ].$plxPlugin->getLang('L_VIEWS') ; ?> </p>

<?php	
	$arrayError = array();
	if(($open = fopen(PLX_PLUGINS.basename(dirname(__FILE__)).'/error404.csv', 'r')) !== false) {	
		// on lit les infos dans le fichier 
		while (($datas = fgetcsv($open, 1000, "|")) !== FALSE)     {        
		  $arrayError[] = $datas; 
		} 
		fclose($open);
	}	
	
		if(@count($arrayError)){
			echo '<p><a href="parametres_plugin.php?p='. $plugin.'&reset_csv">'.$plxPlugin->getLang('L_RAZ').'</a></p>
			<table class="  infos" style="margin:auto">
			<thead>
			<tr><th>Agent Visiteur</th><th>404 - Page demandée</th><th>IP</th><th>Date</th></tr>
			</thead>
			<tbody>';
		// on boucle sur les lignes du fichiers CSV pour récuperer les données 
		foreach($arrayError as $i => $line){
			echo '<tr><td>'.$line[0].'</td><td>'.$line[2].'</td><td>'.$line[3].'</td><td>'.$line[4].'</td></tr>';			
		}
		echo '</tbody>
		</table>';
		}
		else{
			echo '<p>'.$plxPlugin->getLang('L_RAZED').'</p>';
		}
		?>
		
</div>		
<script>
(function () {

function copy() {
  let code = document.querySelector("#code");  
  let statut = document.querySelector("[for='code']");
  code.select();
  document.execCommand("copy");
  statut.innerHTML="<?php echo $plxPlugin->getLang('L_CODE_TO_INSERT_COPIED') ?>";
}
document.querySelector("#code").addEventListener ("click", copy, false);
})();
</script>