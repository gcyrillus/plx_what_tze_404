<div id="help">
<h2>Aide du plugin</h2>	
<h3>Configuration</h3>
  <p>Elle demande deux actions:</p>
  <ul>
    <li> <b>L'une</b> , consiste à integreer le hook dans la page d'erreur de votre thème de façon à comptabiliser son affichage, à en extraire l'adresse recherché par le visiteur, son origine si il y a,  son IP et l'agent (navigateur ou robot ) </li>
    <li> <b>l'autre</b> est a effectué sur un fichier du coeur de PluXml qui vous permettra de rediriger toutes les adresses obsoletes ou inconnue pointant sur votre site vers la page d'erreur au lieu de la page d'accueil.</li>
  </ul>
  <h3>modification du fichier <code>erreur.php</code> du thème </h3>
  <p>Pour enregistrer les information menant à cette page d'erreur, il suffit d'inserer dans le fichier <code>erreur.php</code> de votre/vos thème le code suivant:<br>
<code>&lt;?php if (eval($plxMotor->plxPlugins->callHook('get404'))) return; ?></code><br> en ajout comme derniere ligne.</p>
  <h3>Modication du coeur de PluXml</h3>
  <p>Cette opération est minime et ne necessite pas de compétence particuliere, sauf celle de bien reperé la ligne 132 dans le fichier <code>plx.class.motor.php</code> qui se trouve dans le repertoire <code>core/lib/</code> de PluXml.</p>
  <p> Cette ligne contient le code suivant:<br>
    <code>		if(!empty($this->get) and !preg_match('#^(?:blog|article\d{1,4}/|static\d{1,3}/|categorie\d{1,3}/|archives/\d{4}(?:/\d{2})?|tag/\w|page\d|preview|telechargement|download)#', $this->get)) { $this->get = ''; }</code></p> 
  <p>Pour  rapatrier toutes les mauvaises url  vers la page d'erreur, il faut remplir une valeur que PluXml ne fait pas (encore). <br>Le plus pertinent est d'utilisé le mot 'error' comme valeur. <br>Il suffit donc de remplir cette valeur manquante en fin de ligne <code>$this->get = '';</code>.</p>
<p>  Notre ligne modifiée devient alors:<br>
    <code>		if(!empty($this->get) and !preg_match('#^(?:blog|article\d{1,4}/|static\d{1,3}/|categorie\d{1,3}/|archives/\d{4}(?:/\d{2})?|tag/\w|page\d|preview|telechargement|download)#', $this->get)) { $this->get = 'error'; }</code></p>
  
  <p>
    <b>c'est tout et maintenant</b> toutes les pages,dossiers,fichiers inexistants redirigeront vers votre page d'erreur vous permettant ainsi de découvrir les adresses que robots ou visiteurs ont utilisés sans succés
    </p> 
<hr>
<style>#help {max-width:120ch;}
h2,h4 {
  text-align: center;
  color: hotpink;
}
h3 {
  color: #6AA6CE;
  border-bottom: solid;
  width: max-content;
  padding-inline-end: 1.5em;
  border-inline-end: solid transparent 6px;
}
p,dd {
  padding: 1px 1em;
  margin:0 0 0.25em;
  text-indent:1em;
}
code, pre {
  background: ivory;
  color:blue
}
dd code {
  white-space:nowrap;
}
dt{
  font-weight:bold;
}
dt~dt {
  margin-top:1em;
}</style>
</div>
