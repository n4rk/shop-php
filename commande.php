<?php
	include "ressources/header.php";

	echo "<div class=\"container\">";
	if(isset($_POST['ok'])) {

	// Convertir le panier en commande
		// Récupérer l'adresse de livraison
		$req = $cnx -> Query("SELECT * FROM clients WHERE idClient={$_SESSION['user']['idC']}");
		$tabClient = $req -> fetch_assoc();
		/*$SQL = "SELECT * FROM clients WHERE idClient=1";
		$req = $cnx -> Query($SQL);
		$tabClient = $req -> fetch_assoc();*/

		//Transaction Commandes
		$flag = 0;
		$cnx -> autocommit(FALSE);
		$SQL = "INSERT INTO commandes(adresseLivraison,totalCommande,idClient) VALUES('{$tabClient['adresse']}',{$_SESSION['total']},{$tabClient['idClient']})";
		$cnx -> Query($SQL);
		$flag+=$cnx -> affected_rows;

		//Details
		$idCmd = $cnx -> insert_id;
		foreach ($_SESSION['panier'] as $tabArt) {
			$reqa = $cnx -> Query("SELECT * FROM articles a LEFT JOIN promotions p ON a.idArticle=p.idArticle WHERE a.idArticle={$tabArt['idA']}");
			$ta = $reqa -> fetch_assoc();
			//Calcul de $price en fct de promotions
				if(is_null($ta['tauxPromo'])) $price = $ta['prix'];
				else $price = $ta['prix'] - ($ta['prix']*$ta['tauxPromo'])/100;

			$cnx -> Query("INSERT INTO details VALUES ('',{$tabArt['qte']},$price,$idCmd,{$tabArt['idA']})");
			$flag+=$cnx -> affected_rows;

			//Modification de la quantité en stock
			$cnx -> Query("UPDATE articles SET quantiteStock=(quantiteStock-{$tabArt['qte']}) WHERE idArticle={$tabArt['idA']}");
			$flag+=$cnx -> affected_rows;
		}

		if($flag == 2*count($_SESSION['panier'])+1) {
			$cnx -> commit();
			$id = mysqli_insert_id($cnx);
			echo "<center><a href=\"profile.php?commandes=1\" class=\"btn btn-info col-sm-6 text-center\" style=\"margin-top:100px;\"><i class=\"fa fa-printer\"></i> Imprimer</a></center>";

			unset($_SESSION['panier']);
		}
		else $cnx -> rollback();

	}


	if(isset($_SESSION['user']) && isset($_SESSION['panier'])) {
		for($i=0;$i<count($_SESSION['panier']);$i++) {
			$SQL = "SELECT * FROM articles a LEFT JOIN promotions p ON a.idArticle=p.idArticle
					WHERE a.idArticle={$_SESSION['panier'][$i]['idA']}";

			$req = mysqli_query($cnx,$SQL);
			$row = mysqli_fetch_assoc($req);

			//affichage de la commande et demande de validation pour passer au bon de commande qui peut être imprimé (PDF)
		}

		if(!isset($_POST['ok']))
		echo "
			<div class=\"col-sm-12\" style=\"margin-top:20px;\">
				<h2 style=\"padding:10px 20px;margin:50px 0 50px 0;border-left:8px solid #1C7DCE;\">Votre Commande est prête...</h2>
				<form method=post>
					<input type=submit name=\"ok\" class=\"btn btn-success btn-lg col-sm-5\" style=\"float:left;margin-top:10px;\" value=\"Valider la commande\">
				</form>
				<a href=\"accueil.php\" class=\"btn btn-danger btn-lg col-sm-5\" style=\"float:right;margin-top:10px;\">Annuler la commande</a>
			</div>
		";
	}

	if(!isset($_SESSION['user'])) {
		echo "
		<div class=\"text-center\" style=\"color:#1C7DCE;margin-top:50px;\">
			<h1>Vous devez d'abord vous connecter !</h1>
		</div>
		";
	}

	echo "</div>";

?>
