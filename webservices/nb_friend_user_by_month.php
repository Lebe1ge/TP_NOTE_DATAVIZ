<?php
	// Le tableau de résultat
	$result_request = array();
	
	/*
		On teste si le paramètre GET existe
		0 -> tous les utilisateurs
		id_unique -> un seul utilisateur
		plusieurs id séparés par des virgules -> plusieurs utilisateurs
	*/
	if(isset($_GET['user'])) {
		// Connexion à la BDD
		include("../bdd/connexion_bdd.php");
		
		$user = $_GET['user'];
		$month = date('Y-m');

		// On récupère les amis que le user avait avant le mois en cours
		$query = "SELECT count(*) as nb FROM relations WHERE user1 = " . $user . " AND relations.date < '" . $month . "-01'";
		$result = mysqli_query($conn, $query);
		$nb = mysqli_fetch_assoc($result)['nb'];

		// On récupère le dernier jour du mois en cours
		$date = $month . "-01";
		$end_date = date("t", strtotime($date));

		// On passe de jour en jour pour récupérer le nombre d'ami à un jour i
		for ($i=1; $i <= $end_date; $i++) { 
			$query = "SELECT count(*) as nb FROM relations WHERE user1 = " . $user . " AND relations.date = '" . $month . "-" . $i . "'";
			$result = mysqli_query($conn, $query);
			$nb += mysqli_fetch_assoc($result)['nb'];
			$result_request[] = [$month . "-" . $i, $nb];
		}
	
		// Déconnexion de la BDD
		include("../bdd/deconnexion_bdd.php");
	}
	
	// Renvoyer le résultat au javascript
	echo json_encode($result_request);

?>