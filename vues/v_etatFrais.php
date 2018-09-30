
<h3>Fiche de frais du mois <?php echo $numMois."-".$numAnnee?> :
    </h3>
    <div class="encadre">
    <p>
        Etat : <?php echo $libEtat?> depuis le <?php echo $dateModif?> <br> Montant validé : <?php echo $montantValide?>


    </p>
    <table class="listeLegere">
      <caption>Eléments forfaitisés </caption>

        <td>Frais Forfait </td>
        <td>Quantité</td>
        <td>Montant Unitaire</td>
        <td>Total</td>
     </tr>
     <tr>
       <td>Forfait Etape </td>
       <td><?PHP echo $tabFraisForfait[0][0] ?> </td>
       <td><?PHP echo $tabFraisForfait[0][0]." €" ?></td>
       <td><?PHP echo ($TotalFraisForfait =($LigneFraisForfait[0][0])*($tabFraisForfait[0][0])).' €' ?></td>
    </tr>


     <tr>
       <td>Nuitée </td>
       <td><?PHP echo $LigneFraisForfait[2][0] ?> </td>
       <td><?PHP echo $tabFraisForfait[1][0]." €" ?></td>
       <td><?PHP echo ($TotalNuitee =($LigneFraisForfait[2][0])*($tabFraisForfait[0][0])).' €' ?></td>
    </tr>

    <tr>
      <td>Repas Midi </td>
      <td><?PHP echo $LigneFraisForfait[3][0] ?></td>
      <td><?PHP echo $tabFraisForfait[2][0]." €" ?></td>
      <td><?PHP echo ($TotalRepasMidi =($LigneFraisForfait[3][0])*($tabFraisForfait[1][0])).' €' ?></td>
    </tr>

    <tr>
     <td>Véhicule </td>
     <td><?PHP echo $LigneFraisForfait[1][0] ?></td>
     <td><?PHP echo floatval($MontantKilometrique[0][0])." €"?></td>
     <td><?PHP echo($TotalVehicule =($LigneFraisForfait[1][0])*($MontantKilometrique[0][0])).' €' ?></td>
    </tr>
    <tr>
    <td>Total</td>
    <td></td>
    <td></td>
    <td><?PHP echo($MontantTotal = $TotalFraisForfait + $TotalNuitee + $TotalRepasMidi + $TotalVehicule)  ?></td>
    </tr>

    </table>
  	<table class="listeLegere">
  	   <caption>Descriptif des éléments hors forfait -<?php echo $nbJustificatifs ?> justificatifs reçus -
       </caption>
             <tr>
                <th class="date">Date</th>
                <th class="libelle">Libellé</th>
                <th class='montant'>Montant</th>
             </tr>
        <?php
          foreach ( $lesFraisHorsForfait as $unFraisHorsForfait )
		  {
			$date = $unFraisHorsForfait['date'];
			$libelle = $unFraisHorsForfait['libelle'];
			$montant = $unFraisHorsForfait['montant'];
		?>
             <tr>
                <td><?php echo $date ?></td>
                <td><?php echo $libelle ?></td>
                <td><?php echo $montant ?></td>
             </tr>
        <?php
          }
		?>
    </table>
  </div>
  </div>
