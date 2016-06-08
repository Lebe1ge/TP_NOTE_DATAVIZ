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

    $query = "SELECT ROUND(AVG(note.note)) as note, note.date as date_popularite FROM notations note
					            LEFT JOIN photos photo ON note.photo = photo.id
                      LEFT JOIN utilisateurs us ON us.photo = photo.id
					            WHERE us.id = " . $user . " AND note.date = '" . $month . "-" . $i . "'" ;

    $result = mysqli_query($conn, $query);
    $res = mysqli_fetch_assoc($result);
    $result_request[] = [$res['date_popularite'], (int)$res['note']];

		// Déconnexion de la BDD
		include("../bdd/deconnexion_bdd.php");
	}
  echo json_encode($result_request);
?>
