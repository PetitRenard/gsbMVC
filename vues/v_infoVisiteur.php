<h3> Info Visiteur </h3>
<p>
<?php //  vardump($pdo);?>
  Bonjour <?php echo $_SESSION['prenom'];?>,
<?php ?>
</p>
<p>
<?php


$id=($_SESSION['idVisiteur']);
// Si on envoie les données
if (isset( $_POST['ChoixVehicule'])){
  $IdChoixVehicule = $_POST['ChoixVehicule'];
  $IdVehiculebdd = $_POST['ChoixVehicule'];
}else {
    $IdVehiculebdd = $_SESSION['vehicule'];
}




$NomVehicule = InformationVehicule($IdVehiculebdd);
  // On Vérifie si le Visiteur à Saisie un véhicule ou non
  If (empty($_SESSION['vehicule'])){
        echo "Vous n'avez pas indiqué votre véhicule, veuillez le saisir ici : ".
        // liste déroulante en html
        $listeDeroulanteVehicule;

  }else {
    echo'Vous avez identifier votre véhicule
    comme étant '.$NomVehicule[0][0]."
    </p>
    <p> Vous pouvez modifier votre véhicule si dessous : ".$listeDeroulanteVehicule;

  }
//if(isset( $_POST['ChoixVehicule'])){echo$_POST['ChoixVehicule']]}else echo'tes';
//var_dump($test2);


?>
