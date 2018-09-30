<?php
include("vues/v_sommaire.php");

$idVisiteur = $_SESSION['idVisiteur'];
$action = $_REQUEST['action'];
if (isset($_POST['ChoixVehicule'])){
  $IdChoixVehicule = $_POST['ChoixVehicule'];
  $pdo->ChoixVehicule($idVisiteur,$IdChoixVehicule);
}


$listeDeroulanteVehicule = '
        </p>
        <p>
          <form action="" method="post">
            <select name="ChoixVehicule">

                 <option value="1">4 CV Diesel</option>
                 <option value="2">5/6 CV Diesel</option>
                 <option value="3">4 CV Essence</option>
                 <option value="4">5/6 CV Essence</option>

            </select>
  <input type="submit" value="Enregistrer" id="ChoixVehicule"   size="20" />

        </p>
        ';





include("vues/v_infoVisiteur.php");

?>
