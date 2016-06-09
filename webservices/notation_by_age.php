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
		$sexe = $_GET['sexe'];

		$query = "SELECT notations.note, utilisateurs.age FROM notations, utilisateurs WHERE notations.noteur = utilisateurs.id AND notations.photo = " . $user;

		if(isset($sexe) && strlen($sexe) > 0 && $sexe != 'null'){
			$query .= " AND utilisateurs.sexe = " . $sexe;
		}

		$result = mysqli_query($conn, $query);
		
		while ($row = mysqli_fetch_assoc($result)) {
			$result_request[] = [(int) $row['age'], (int) $row['note']];
		}

		mysqli_free_result($result);

		// Déconnexion de la BDD
		include("../bdd/deconnexion_bdd.php");
	}
	
	// Renvoyer le résultat au javascript
	echo json_encode($result_request);

?>