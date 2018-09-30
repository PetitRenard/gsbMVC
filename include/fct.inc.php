<?php
/**
 * Fonctions pour l'application GSB

 * @package default
 * @author Cheri Bibi
 * @version    1.0
 */
 /**
 * Teste si un quelconque visiteur est connecté
 * @return vrai ou faux
 */
function estConnecte(){
  return isset($_SESSION['idVisiteur']);
}
/**
 * Enregistre dans une variable session les infos d'un visiteur

 * @param $id
 * @param $nom
 * @param $prenom
 */
function connecter($id,$nom,$prenom,$vehicule){
	$_SESSION['idVisiteur']= $id;
	$_SESSION['nom']= $nom;
	$_SESSION['prenom']= $prenom;
  $_SESSION['vehicule']= $vehicule;

}
// fonction pour ouvrir la base à pdo
function ouvre_base() {
 //global $sgbd;
  $login = "root";
  $mdp = "";
  $bdd = "gsb_frais";
  $serveur = "localhost";

 $port = "";

   $PARAM_dsn = "mysql:host=$serveur; port=$port; dbname=$bdd; charset=utf8" ;

   $sgbd = new PDO($PARAM_dsn, $login, $mdp);
   $sgbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
   if (!$sgbd){
 echo 'probleme avec "PDO" gsb_frais !';
 return false;
   }

    return $sgbd;
}




/**
 * Détruit la session active
 */
function deconnecter(){
	session_destroy();
}
/**
 * Transforme une date au format français jj/mm/aaaa vers le format anglais aaaa-mm-jj

 * @param $madate au format  jj/mm/aaaa
 * @return la date au format anglais aaaa-mm-jj
*/
function dateFrancaisVersAnglais($maDate){
	@list($jour,$mois,$annee) = explode('/',$maDate);
	return date('Y-m-d',mktime(0,0,0,$mois,$jour,$annee));
}
/**
 * Transforme une date au format format anglais aaaa-mm-jj vers le format français jj/mm/aaaa

 * @param $madate au format  aaaa-mm-jj
 * @return la date au format format français jj/mm/aaaa
*/
function dateAnglaisVersFrancais($maDate){
   @list($annee,$mois,$jour)=explode('-',$maDate);
   $date="$jour"."/".$mois."/".$annee;
   return $date;
}
/**
 * retourne le mois au format aaaamm selon le jour dans le mois

 * @param $date au format  jj/mm/aaaa
 * @return le mois au format aaaamm
*/
function getMois($date){
		@list($jour,$mois,$annee) = explode('/',$date);
		if(strlen($mois) == 1){
			$mois = "0".$mois;
		}
		return $annee.$mois;
}

/* gestion des erreurs*/
/**
 * Indique si une valeur est un entier positif ou nul

 * @param $valeur
 * @return vrai ou faux
*/
function estEntierPositif($valeur) {
	return preg_match("/[^0-9]/", $valeur) == 0;

}

/**
 * Indique si un tableau de valeurs est constitué d'entiers positifs ou nuls

 * @param $tabEntiers : le tableau
 * @return vrai ou faux
*/
function estTableauEntiers($tabEntiers) {
	$ok = true;
	foreach($tabEntiers as $unEntier){
		if(!estEntierPositif($unEntier)){
		 	$ok=false;
		}
	}
	return $ok;
}
/**
 * Vérifie si une date est inférieure d'un an à la date actuelle

 * @param $dateTestee
 * @return vrai ou faux
*/
function estDateDepassee($dateTestee){
	$dateActuelle=date("d/m/Y");
	@list($jour,$mois,$annee) = explode('/',$dateActuelle);
	$annee--;
	$AnPasse = $annee.$mois.$jour;
	@list($jourTeste,$moisTeste,$anneeTeste) = explode('/',$dateTestee);
	return ($anneeTeste.$moisTeste.$jourTeste < $AnPasse);
}
/**
 * Vérifie la validité du format d'une date française jj/mm/aaaa

 * @param $date
 * @return vrai ou faux
*/
function estDateValide($date){
	$tabDate = explode('/',$date);
	$dateOK = true;
	if (count($tabDate) != 3) {
	    $dateOK = false;
    }
    else {
		if (!estTableauEntiers($tabDate)) {
			$dateOK = false;
		}
		else {
			if (!checkdate($tabDate[1], $tabDate[0], $tabDate[2])) {
				$dateOK = false;
			}
		}
    }
	return $dateOK;
}

/**
 * Vérifie que le tableau de frais ne contient que des valeurs numériques

 * @param $lesFrais
 * @return vrai ou faux
*/
function lesQteFraisValides($lesFrais){
	return estTableauEntiers($lesFrais);
}
/**
 * Vérifie la validité des trois arguments : la date, le libellé du frais et le montant

 * des message d'erreurs sont ajoutés au tableau des erreurs

 * @param $dateFrais
 * @param $libelle
 * @param $montant
 */
function valideInfosFrais($dateFrais,$libelle,$montant){
	if($dateFrais==""){
		ajouterErreur("Le champ date ne doit pas être vide");
	}
	else{
		if(!estDatevalide($dateFrais)){
			ajouterErreur("Date invalide");
		}
		else{
			if(estDateDepassee($dateFrais)){
				ajouterErreur("date d'enregistrement du frais dépassé, plus de 1 an");
			}
		}
	}
	if($libelle == ""){
		ajouterErreur("Le champ description ne peut pas être vide");
	}
	if($montant == ""){
		ajouterErreur("Le champ montant ne peut pas être vide");
	}
	else
		if( !is_numeric($montant) ){
			ajouterErreur("Le champ montant doit être numérique");
		}
}
/**
 * Ajoute le libellé d'une erreur au tableau des erreurs

 * @param $msg : le libellé de l'erreur
 */
function ajouterErreur($msg){
   if (! isset($_REQUEST['erreurs'])){
      $_REQUEST['erreurs']=array();
	}
   $_REQUEST['erreurs'][]=$msg;
}
/**
 * Retoune le nombre de lignes du tableau des erreurs

 * @return le nombre d'erreurs
 */
function nbErreurs(){
   if (!isset($_REQUEST['erreurs'])){
	   return 0;
	}
	else{
	   return count($_REQUEST['erreurs']);
	}
}

  function InformationVehicule($IdVehicule){
    $connexion = ouvre_base();
    $requette =
    " SELECT `Vehicule`.`Libelle`
      FROM `Vehicule`
      WHERE `Vehicule`.`Id` = $IdVehicule
    ";
    $requette = $connexion->prepare($requette);
    $requette->execute();
    $resultatRequette = $requette->fetchAll();
      return $resultatRequette;

  }

/*----- Fonction pdo --------- */
  function getFraisForfait(){
    $connexion = ouvre_base();
     $requette =
       "SELECT `fraisforfait`.`montant`
       FROM `fraisforfait`
       WHERE `fraisforfait`.`id` = 'ETP'
       OR `fraisforfait`.`id` = 'NUI'
       OR`fraisforfait`.`id`= 'REP'
       ";
       $requette = $connexion->prepare($requette);
       $requette->execute();
       $resultatRequette = $requette->fetchAll();
    return $resultatRequette;
  }

    function getMontantKilometriqueVehicule($idVisiteur){
        $connexion = ouvre_base();
        $requette =
          " SELECT `Vehicule`.`Montant`
            FROM `Vehicule`,`Visiteur`
            WHERE `Visiteur`.`IdVehicule` = `Vehicule`.`Id`
            AND `visiteur`.`id` = '$idVisiteur'
            ";
            $requette = $connexion->prepare($requette);
            $requette->execute();
            $resultatRequette = $requette->fetchAll();
      return $resultatRequette;

    }

    function getLigneFraisForfait($idVisiteur,$mois){
      $connexion = ouvre_base();
      $requette =
        " SELECT `lignefraisforfait`.`quantite` FROM `lignefraisforfait`
WHERE `lignefraisforfait`.`idVisiteur` = '$idVisiteur'
AND `lignefraisforfait`.`mois` = '$mois'
          ";
          $requette = $connexion->prepare($requette);
          $requette->execute();
          $resultatRequette = $requette->fetchAll();
    return $resultatRequette;

    }

    function getIdVehiculeVisiteur($idVisiteur){
      $connexion = ouvre_base();
      $requette =
      "SELECT `visiteur`.`IdVehicule`
FROM `visiteur`
WHERE `visiteur`.`id` = '$idVisiteur";
$requette = $connexion->prepare($requette);
$requette->execute();
$resultatRequette = $requette->fetchAll();
return $resultatRequette;
    }

    function VerifVehicule($id)
    {
      $connexion = ouvre_base();
      $requette =
      " SELECT `visiteur`.`IdVehicule`
        FROM `visiteur`
        WHERE `visiteur`.`id` = '$id'
      ";
      $requette = $connexion->prepare($requette);
      $requette->execute();
      $resultatRequette = $requette->fetchAll();
        return $resultatRequette;
    }

?>
