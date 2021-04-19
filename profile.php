<?php
	include 'ressources/header.php';
	$admin = 0;

	echo "<div class='container'>";
	if(isset($_SESSION['user'])) {
		$id = $_SESSION['user']['idC'];
		$req = mysqli_query($cnx,"SELECT * FROM clients WHERE idClient=$id");
		$tabCl = mysqli_fetch_assoc($req);

		if (isset($_POST['editer'])) {
			$avt = $_POST['avatar'];
			$nvNom = $_POST['nom'];
			$nvPrenom = $_POST['prenom'];
			$nvAddr = $_POST['address'];
			$SQL = "UPDATE clients SET nomClient='$nvNom',prenomClient='$nvPrenom',adresse='$nvAddr',avatar='$avt' WHERE idClient=$id";
			@mysqli_query($cnx,$SQL) OR die("Erreur de modification de donnée !!");
		}

		if(isset($_GET['edit'])) {
			echo "
				<div class=\"col-lg-9 col-md-8 col-sm-8\" style=\"margin:30px 100px;\">
		            <div class=\"main-box clearfix\">
		                <div class=\"profile-header\">
		                    <h3><span>Modification de Données :</span></h3>
		                </div>
		            </div>
		        </div>
		        <div class=\"form\" style=\"margin:50px 100px;\">
					<form class=\"form-group \" method=post action=\"profile.php\">
						<table class=\"table table-bordered text-center\">
							<tr>
								<td>Avatar :</td>
								<td>
									<div class=\"custom-file\">
									    <input type=\"file\" class=\"custom-file-input\" name=\"avatar\" id=\"validatedCustomFile\" value=\"{$tabCl['avatar']}\" required>
									    <label class=\"custom-file-label\" for=\"validatedCustomFile\">Choose file...</label>
									    <div class=\"invalid-feedback\">Example invalid custom file feedback</div>
									</div>
								</td>
							</tr>
							<tr>
								<td>Nom :</td>
								<td><input type=\"text\" class=\"form-control\" name=\"nom\" value=\"{$tabCl['nomClient']}\" required></td>
							</tr>
							<tr>
								<td>Prénom :</td>
								<td><input type=\"text\" class=\"form-control\" name=\"prenom\" value=\"{$tabCl['prenomClient']}\" required></td>
							</tr>
							<tr>
								<td>Adresse :</td>
								<td><input type=\"text\" class=\"form-control\" name=\"address\" value=\"{$tabCl['adresse']}\" required></td>
							</tr>
							<tr>
								<td colspan=2><input type=submit name=\"editer\" class=\"btn btn-success btn-block\"</td>
							</tr>
						</table>
					</form>
				</div><br>
			";
		}

		if(isset($_GET['commandes'])) {
			$SQL = "SELECT * FROM commandes c WHERE idClient={$tabCl['idClient']}";
			$req = mysqli_query($cnx,$SQL);
			echo "
			<table class=\"table\" style=\"margin-top:50px;\">
			<thead style=\"color:white;\">
				<tr class=\"d-flex text-center\">
					<td colspan=2 class=\"col-5\">Produit</td>
					<td class=\"col-1\">Quantité</td>
					<td class=\"col-2\">Total</td>
					<td class=\"col-4\">Etat de la commande</td>
				</tr>
			</thead><tbody>
			";
			while($cmds = mysqli_fetch_assoc($req)) {
				$SQL = "SELECT * FROM details WHERE idCommande={$cmds['idCommande']}";
				$req2 = mysqli_query($cnx,$SQL);
				while ($dets = mysqli_fetch_assoc($req2)) {
					$SQL = "SELECT * FROM articles WHERE idArticle={$dets['idArticle']}";
					$req3 = mysqli_query($cnx,$SQL);
					$art = mysqli_fetch_assoc($req3);

					echo "
						<tr class=\"d-flex\">
							<td class=\"col-2\"><img src=\"assets/img/vignette/{$art['vignette']}\" width=100 ></td>
							<td class=\"col-3\">{$art['libelle']}</td>
							<td class=\"col-1 text-center\">{$dets['quantite']}</td>
							<td class=\"col-2 text-center\">{$cmds['totalCommande']}</td>
					";

					switch($cmds['etatCommande']) {
						 case 0:
					        $etat="Commande en cours de traitement";
					        break;
					    case 1:
					        $etat="Commande acceptée et en cours de livraison";
					        break;
					    case 2:
					        $etat="Commande arrivée à destination";
					        break;
					}

					echo "<td class=\"col-4 text-center\">$etat</td>
						</tr>";
				}

				/*foreach ($cmds as $key => $value) {
					echo "<b>".$key ." :</b> ". $value . "<br>";
					while ($dets = mysqli_fetch_assoc($req2)) {
						foreach ($dets as $key => $val)
							echo "<b>".$key ." :</b> ". $val . "<br>";
					}
				}
				echo "<br>";*/
			}
			echo "</tbody></table>";
		}

		if(!isset($_GET['edit']) && !isset($_GET['commandes'])) {
			if($tabCl['qualite'] == 1) {
				$admin = 1;
			}
		    echo "
		    <div class=\"row\" id=\"user-profile\" style=\"margin-top:50px;margin-bottom:120px;\">
		        <div class=\"col-lg-3 col-md-3 col-sm-3\">
		            <div class=\"main-box clearfix\">
		                <img src=\"assets/avatars/{$tabCl['avatar']}\" alt=\"\" class=\"rounded-circle img-responsive\" width=120 style=\"border:3px solid #333;margin-left:20px;\">

		                <div class=\"profile-since\" style=\"margin-top:20px;\">
		                    Member since: <b>".substr($tabCl['dateInscription'],0,-9)."</b>
		                </div>

		                <div class=\"profile-details\">
		                    <ul class=\"fa-ul\">
		                        <li><i class=\"fa-li fa fa-truck\"></i>Commandes :";

		                        $req = mysqli_query($cnx,"SELECT * FROM commandes WHERE idClient={$tabCl['idClient']}");
		                        $x = mysqli_affected_rows($cnx);

		                        echo "<b> $x </b></li>
		                    </ul>
		                </div>
		            </div>
		        </div>

		        <div class=\"col-lg-9 col-md-8 col-sm-8\">
		            <div class=\"main-box clearfix\">
		                <div class=\"profile-header\">
		                    <h3><span>Informations de l'utilisateur :</span></h3>
							<div class=\"col-lg-3 col-sm-3 text-right\" style=\"float:right;margin-top:-40px;\">
		                    <div style=\"margin:5px 0\">
			                    <a href=\"?edit=1\" class=\"btn btn-primary\">
			                        <i class=\"fa fa-pencil-square\"></i> Editer
			                    </a>
		                    </div>

		                    <div style=\"margin:5px 0\">
			                    <a href=\"?commandes=1\" class=\"btn btn-primary\">
			                        <i class=\"fa fa-shopping-cart\"></i> Commandes
			                    </a>
		                    </div>
		                    ";
		                    if($admin==1) {
		                    	echo "
		                    	<div style=\"margin:5px 0\">
		                    		<a href=\"admin.php\" class=\"btn btn-success\">
		                        		<i class=\"fa fa-wrench\"></i> Administrer
		                    		</a>
		                    	</div>";
		                    }
		            echo "
		            	</div>
		                </div>

		                <div class=\"row profile-user-info\">
		                    <div class=\"col-sm-10\" style=\"margin-top:30px;margin-left:-20px;\">
		                    <table class=\"table table-bordered\">
		                        <tr>
			                        <td>Nom :</td>
			                        <td><b>{$tabCl['nomClient']}</b></td>
		                        </tr>
		                        <tr>
			                        <td>Prénom :</td>
			                        <td><b>{$tabCl['prenomClient']}</b></td>
		                        </tr>
		                        <tr>
			                        <td>Adresse : </td>
			                        <td><b>{$tabCl['adresse']}</b></td>
		                        </tr>
		                        <tr>
			                        <td>Email :</td>
			                        <td><b>{$tabCl['email']}</b></td>
		                        </tr>
		                    </table>
		                    </div>
		                </div>
		           	</div>
		        </div>
		   	</div>";

   		}
	}
	echo "</div>";
	include 'ressources/footer.php';
?>
