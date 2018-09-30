<?php
include("vues/v_sommaire.php");
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];
$IdVehiculebdd = $_SESSION['vehicule'];

switch($action){
	case 'selectionnerMois':{
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		// Afin de sélectionner par défaut le dernier mois dans la zone de liste
		// on demande toutes les clés, et on prend la première,
		// les mois étant triés décroissants
		$lesCles = array_keys( $lesMois );
		$moisASelectionner = $lesCles[0];
		include("vues/v_listeMois.php");
		break;
	}
	case 'voirEtatFrais':{
		$leMois = $_REQUEST['lstMois'];
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		$moisASelectionner = $leMois;
		include("vues/v_listeMois.php");
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$leMois);
		$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$leMois);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$leMois);
		$numAnnee =substr( $leMois,0,4);
		$numMois =substr( $leMois,4,2);
		$libEtat = $lesInfosFicheFrais['libEtat'];
		$montantValide = $lesInfosFicheFrais['montantValide'];
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
		$dateModif =  $lesInfosFicheFrais['dateModif'];
		$dateModif =  dateAnglaisVersFrancais($dateModif);
		// renvoit le montant de la nuitée et d'un repas
		 $tabFraisForfait = getFraisForfait();
		// renvoit le montant Kilometrique en fonction du vehicule de l'utilisateur
		$MontantKilometrique =	(getMontantKilometriqueVehicule($idVisiteur));
		// renvoit les quatité de la table de LigneFraisForfait

	if (isset($IdVehiculebdd)){
		$LigneFraisForfait = getLigneFraisForfait($idVisiteur,$leMois);
	}else $MontantKilometrique[0][0]=0;

		$LigneFraisForfait = getLigneFraisForfait($idVisiteur,$leMois);
		include("vues/v_etatFrais.php");
	}
}
?>
