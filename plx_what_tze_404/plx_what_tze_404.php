<?php
class plx_what_tze_404 extends plxPlugin {	 

	public function __construct($default_lang) {

		# appel du constructeur de la classe plxPlugin (obligatoire)
		parent::__construct($default_lang);
		
		# déclaration des hooks
		$this->addHook('IndexBegin', 'IndexBegin');
		$this->addHook('get404', 'get404');
		
		# droits pour accèder à la page config.php du plugin
		$this->setConfigProfil(PROFIL_ADMIN);		

	}
		# désactive de force la compression gzip 
	public function  IndexBegin() {
	echo '<?php ';
		?>
		$plxMotor->aConf['gzip'] ='0';
	?>
		<?php 

	}		
	#code à exécuter à l’activation du plugin
	/* config par defaug  */		
	public function OnActivate() { 
	$jour = date("d M Y");
	if($this->getParam('set')=='') {
        $this->setParam('set', $jour , 'string'); 
		$this->saveParams();		
	}
	}	
	/* Affiche et incremente le nombre de vues */
	public function get404() {	
		#récuperation contenu article et comptage
			global $plxMotor;
		/* gestion et message de la sauvegarde param en silencieux*/
			include_once('core/lib/class.plx.msg.php');
			defined('L_SAVE_SUCCESSFUL') or define('L_SAVE_SUCCESSFUL', '');
			defined('L_SAVE_ERR') or define('L_SAVE_ERR', '');
		/* fin reset message sauvegardes */
		
		$useragent = isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : 'hidden';	
		#comptage et enregistrement des vues	
	
			if(isset($plxMotor->mode) && $plxMotor->mode == 'erreur' ) {
				$fp = fopen(dirname(__FILE__) . '/error404.csv', 'a');
				fwrite($fp, $useragent.' |  erreur  | '.$_SERVER['REQUEST_URI']. '<br>'. @$_SERVER['HTTP_REFERER'] .' | '.$_SERVER ['REMOTE_ADDR'].'  | '. date('d-M-Y / h:i:s').PHP_EOL);
				fclose($fp);
				$var['erreur'] =   $plxMotor->plxPlugins->aPlugins[__CLASS__]->getParam('erreur') ==''  ? '0' :$plxMotor->plxPlugins->aPlugins[__CLASS__]->getParam('erreur') ;	
				$var['erreur']++;
				$plxMotor->plxPlugins->aPlugins[__CLASS__]->setParam( 'erreur', $var['erreur'], 'numeric') ; 
				$plxMotor->plxPlugins->aPlugins[__CLASS__]->saveParams();	
				$infosViews	= $plxMotor->plxPlugins->aPlugins[__CLASS__]->getLang('L_PAGE_404').' '.$var['erreur'];			
			}			
	}


	/* traduction du mois si langue autre que anglais et disponible */
	public function checkMonthLangDate($stringDate) {
		if($this->default_lang !='en' && file_exists(PLX_PLUGINS.basename(dirname(__FILE__)).'/lang/'.$this->default_lang.'.php')) {
			$MonthToTranslate = array('Jan','Feb','Mar','Apr','May','Jun','July','Aug','Sept','Oct',' Nov','Dec') ;
			$index=0;
			foreach($this->getLang('L_DATE_LANG') as $month){
				$stringDate = str_replace(trim($MonthToTranslate[$index]), $this->getLang('L_DATE_LANG')[$index], $stringDate);  	
				$index++;				
			}
		return $stringDate;
		}
		
	}


}
?>	
