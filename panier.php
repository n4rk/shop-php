<?php
	include "ressources/header.php";

	// Suppression
	if(isset($_GET['supp'])) {
		$del = $_GET['supp'];
		array_splice($_SESSION['panier'],$del,1);

		if(count($_SESSION['panier'])==0)
			unset($_SESSION['panier']);
	}

	// Ajouter Article
	if(isset($_GET['ajouter'])) {
		$taille = 0;
		if(isset($_SESSION['panier'])) {
			$flag = 0;
			$taille = count($_SESSION['panier']);

			// Si article existe déjà dans le panier
			for ($i=0; $i < $taille; $i++)
				if($_GET['id_article'] == $_SESSION['panier'][$i]['idA']) {
					$_SESSION['panier'][$i]['qte']+=$_POST['quantity'];
					$flag = 1;
				}

			// Si on a pas trouvé l'article dans le panier on l'ajoute
			if($flag == 0) {
				$_SESSION['panier'][$taille]['idA'] = $_GET['id_article'];
				$_SESSION['panier'][$taille]['qte'] = $_POST['quantity'];
			}
		}

		if(!isset($_SESSION['panier'])) {
			$_SESSION['panier'][$taille]['idA'] = $_GET['id_article'];
			$_SESSION['panier'][$taille]['qte'] = $_POST['quantity'];
		}
	}

	//Vider Panier
	if(isset($_GET['vider'])) {
		unset($_SESSION['panier']);
	}

	//Affichage du panier
if(isset($_SESSION['panier'])) {
	echo "<div class=\"container\">
			<h2 style=\"font-weight:bold;color:#1C7DCE;padding-left:20px;margin:30px 0;border-left:7px solid #1C7DCE;\">Vos Articles choisis :</h2>
			<table class=\"table table-bordered\" style=\"text-align:center\">
				<thead class=\"table-dark\">
					<th>Produits</th>
					<th>Quantité</th>
					<th>Prix</th>
					<th>Supprimer</th>
				</thead>";

	if(count($_SESSION['panier'])!=0) {
		$total=0;
		for($i=0;$i<count($_SESSION['panier']);$i++) {
			$SQL = "SELECT * FROM articles a
					LEFT JOIN promotions p ON a.idArticle=p.idArticle
					WHERE a.idArticle={$_SESSION['panier'][$i]['idA']}";
			$req = mysqli_query($cnx,$SQL);
			$tab = mysqli_fetch_assoc($req);
			echo "<tr>
					<td><img src=\"assets/img/vignette/{$tab['vignette']}\" width=200><b>{$tab['libelle']}</b></td>
					<td>{$_SESSION['panier'][$i]['qte']}</td>";

						if(is_null($tab['tauxPromo'])) {
							$price = $tab['prix'];
							echo "<td class=\"my-auto\"><p style=\"color:green;font-weight:bold;vertical-align:middle;\">$price Dh</p></td>";
						}
						else {
							$price = $tab['prix'] - ($tab['prix']*$tab['tauxPromo']/100);
							echo "<td>
								<p style=\"color:red;font-weight:500;\"><s>{$tab['prix']} Dh</s></p>
								<p style=\"color:green;font-weight:bold;\">$price Dh</s><p>
								</td>";
						}
						echo "
						<td><a href=\"?supp=$i\" title=\"Supprimer cet article\" style=\"line-height:50px;\"><i class=\"fa fa-trash\" style=\"color:#1C7DCE;\"></i></a>
					</td>
				</tr>";
			$total += $price*$_SESSION['panier'][$i]['qte'];
		}

		$_SESSION['total']=$total;
				echo "
				<tr>
					<td colspan=2>Total : </td>
					<td colspan=2><b>$total Dh</b></td>
				</tr>";
	echo "
		</table><br>
		<div class=\"row text-center\" style=\"margin-bottom:100px;\">
			<div class=\"col-sm-4\" style=\"display:inline-block;margin-top:10px;\">
				<a href=\"accueil.php\">
					<button class=\"btn btn-primary col-sm-8\"><i class=\"fa fa-arrow-left\" style=\"margin-right:10px;\"></i> Continuer les achats</button>
				</a>
			</div>
			<div class=\"col-sm-4\" style=\"display:inline-block;margin-top:10px;\">
				<a href=\"commande.php\">
					<button class=\"btn btn-success col-sm-8\">Commander <i class=\"fa fa-arrow-right\" style=\"margin-left:10px;\"></i></button>
				</a>
			</div>
			<div class=\"col-sm-4\"  style=\"margin-top:10px;\"style=\"display:inline-block;margin:10px;\">
				<a href=\"?vider=1\" title=\"Vider le Panier\">
				<button class=\"btn btn-danger col-sm-8\">Vider <i class=\"fa fa-times\" style=\"margin-left:10px;\"></i></button>
				</a>
			</div>
		</div>
	</div>";
	}
}

if(!isset($_SESSION['panier'])) {
	echo "
		<div class=\"container text-center\" style=\"margin-top:100px;\">
		<h2>Vous n'avez pas encore choisi de produits...</h2>
		<br>
		<a href=\"accueil.php\" class=\"btn btn-info\">Consulter les articles <i class=\"fa fa-arrow-right\" style=\"padding-left:5px;\"></i></a>
		</div>
	";
}

?>
