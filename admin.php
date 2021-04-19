<?php
	include 'ressources/header.php';

	if(isset($_SESSION['user'])) {
		$req = mysqli_query($cnx,"SELECT * FROM clients WHERE idClient={$_SESSION['user']['idC']}");
		$adm = mysqli_fetch_assoc($req);

		if($adm['qualite']==1) {

			// Gérer les commandes
			if(isset($_GET['acmd'])) {

				if(isset($_GET['valider'])) {
					$SQL = "UPDATE commandes SET etatCommande=1 WHERE idCommande={$_GET['valider']}";
					@mysqli_query($cnx,$SQL) OR die("Erreur de modification !");
				}

				echo "<div class=\"container\">";
				$SQL = "SELECT * FROM commandes NATURAL JOIN details WHERE etatCommande=0 GROUP BY idCommande ORDER BY dateCommande ASC";
				$req = mysqli_query($cnx,$SQL);
				echo "<div style=\"float:left;margin:30px 0;\">
					<h3 style=\"font-weight:bold;color:#1C7DCE;border-left:7px solid #1C7DCE;padding-left:20px;\">Nouvelles Commandes :</h3>
					</div>
					<div style=\"margin:30px 0;float:right;\">
						<a href=\"admin.php\" class=\"btn btn-info text-white\"><i class=\"fa fa-arrow-left\" style=\"padding-right:10px\"></i> Administration</a>
					</div>
					<table class=\"table\">
					<thead>
						<tr class=\"d-flex\">
							<th class=\"col-1\">N°</th>
							<th class=\"col-6\">Adresse</th>
							<th class=\"col-4\">Total</th>
							<th class=\"col-1\">Valider</th>
						</tr>
					</thead>
					<tbody>";
					$i = 0;
				while($commandes = mysqli_fetch_assoc($req)) {
					$i++;
					echo "
						<tr class=\"d-flex\">
							<td class=\"col-1\">$i</td>
							<td class=\"col-6\">".$commandes['adresseLivraison']."</td>
							<td class=\"col-4\">".$commandes['totalCommande']." Dh</td>
							<td class=\"col-1 text-center\"><a href=\"?acmd=1&valider={$commandes['idCommande']}\"><i class=\"fa fa-check\"></i></a></td>
						</tr>";
				}
				echo "</tbody></table>
				<footer style=\"height:40px\"></footer>
				</div>";
			}





			// Gérer les Promos
			if(isset($_GET['aprm'])) {
				if(isset($_GET['addpromo'])) {
					if(isset($_POST['valid'])) {
						$promo = $_POST['promo'];
						$date1 = $_POST['dateDeb'];
						$date2 = $_POST['dateFin'];
						$id = $_GET['addpromo'];
						mysqli_query($cnx,"INSERT INTO promotions(tauxPromo,dateDebut,dateFin,idArticle) VALUES('$promo','$date1','$date2','$id')");
					}
					echo "<div class=\"container\">
								<div style=\"float:left;margin:30px 0;\">
									<h3 style=\"font-weight:bold;color:#1C7DCE;border-left:7px solid #1C7DCE;padding-left:20px;\">Les Promotions :</h3>
								</div>
								<div style=\"margin:30px 0;float:right;\">
									<a href=\"admin.php\" class=\"btn btn-info text-white\"><i class=\"fa fa-arrow-left\" style=\"padding-right:10px\"></i> Administration</a>
								</div>

								<div class=\"allproducts\">
								<table class=\"table table-bordered\">
								<thead>
									<tr class=\"text-center\">
										<th>Produit</th>
										<th>Libellé</th>
										<th>Promotion</th>
										<th>Date Début</th>
										<th>Date Fin</th>
										<th>Promotion</th>
									</tr>
								</thead>
								<tbody>
							";
						$req = mysqli_query($cnx,"SELECT * FROM articles WHERE idArticle={$_GET['addpromo']}");
						$inc = 1;
						while($article = $req -> fetch_assoc()) {
							$req2 = mysqli_query($cnx,"SELECT * FROM promotions WHERE idArticle={$article['idArticle']} AND NOW() BETWEEN dateDebut AND dateFin");
							$x = mysqli_num_rows($req2);
							if($x>0)
								$promos = mysqli_fetch_assoc($req2);
							echo "
								<tr class=\"text-center\">
									<form method=post>
										<td><img src=\"assets/img/vignette/{$article['vignette']}\" width=150></td>
										<td>{$article['libelle']}</td>
										<td><input type=\"number\" name=\"promo\" min=0 max=100 class=\"form-control\" placeholder=\"Promotion (%)\"";
										if($x>0) echo" value=\"{$promos['tauxPromo']}\""; echo"></td>
										<td><input type=\"date\" name=\"dateDeb\" class=\"form-control\"></td>
										<td><input type=\"date\" name=\"dateFin\" class=\"form-control\"></td>
										<td><input type=\"submit\" name=\"valid\" class=\"btn btn-outline-info\" placeholder=\"Valider\"></td>
									</form>
								</tr>
							";
							$inc++;
						}
					echo "</tbody></table></div>";
					/*<td>
						<input type=number min=0 max=100 class=\"form-control\""; if($x==1) { echo "value={$promos['tauxPromo']}"; } else echo "value=0"; echo">
					</td>
					<td><input type=date name=\"dateDb\" "; if($x==1) { echo "value={$promos['dateDebut']}"; } echo" class=\"form-control\"></td>
					<td><input type=date name=\"dateFn\" "; if($x==1) { echo "value={$promos['dateFin']}"; } echo" class=\"form-control\"></td>
					*/
					//$request=mysqli_query($cnx,"INSERT INTO promotions() VALUES ('','','','','','',)")
				}
				if(!isset($_GET['addpromo'])) {
					echo "<div class=\"container\">
								<div style=\"float:left;margin:30px 0;\">
									<h3 style=\"font-weight:bold;color:#1C7DCE;border-left:7px solid #1C7DCE;padding-left:20px;\">Les Promotions :</h3>
								</div>
								<div style=\"margin:30px 0;float:right;\">
									<a href=\"admin.php\" class=\"btn btn-info text-white\"><i class=\"fa fa-arrow-left\" style=\"padding-right:10px\"></i> Administration</a>
								</div>

								<div class=\"allproducts\">
								<table class=\"table table-bordered\">
								<thead>
									<tr class=\"text-center\">
										<th>Produit</th>
										<th>Libellé</th>
										<th>Confirmer Promo</th>
									</tr>
								</thead>
								<tbody>
							";
						$req = mysqli_query($cnx,"SELECT * FROM articles ORDER BY idCategorie");
						$inc = 1;
						while($articles = $req -> fetch_assoc()) {
							$req2 = mysqli_query($cnx,"SELECT * FROM promotions WHERE idArticle={$articles['idArticle']} AND NOW() BETWEEN dateDebut AND dateFin");
							$x = mysqli_num_rows($req2);
							$promos = mysqli_fetch_assoc($req2);
							echo "
								<tr class=\"text-center\">
									<td><img src=\"assets/img/vignette/{$articles['vignette']}\" width=150></td>
									<td>{$articles['libelle']}</td>
									<td><a href=\"?aprm=1&addpromo={$articles['idArticle']}\" class=\"btn btn-outline-info\">Ajouter Promotion<a></td>
								</tr>
							";
							$inc++;
						}
					echo "</tbody></table></div>";
				}
			}




			// Gérer les articles
			if(isset($_GET['aart'])) {

				if(!isset($_GET['modif']) AND !isset($_GET['add']) AND !isset($_GET['supp']))
					echo "
					<div class=\"container\">
						<div class=\"row text-center\" style=\"margin:100px 0;\">
							<div class=\"col-lg-4\">
								<a href=\"?aart=1&modif=0\" class=\"mod\">Modifier les articles</a>
							</div>
							<div class=\"col-lg-4\">
								<a href=\"?aart=1&add=0\" class=\"mod\">Ajouter de nouveaux articles</a>
							</div>
							<div class=\"col-lg-4\">
								<a href=\"?aart=1&supp=0\" class=\"mod\">Supprimer des articles</a>
							</div>
						</div>
					</div>
					";

				if(isset($_GET['modif'])) {

					echo "<div class=\"container\">
							<div style=\"float:left;margin:30px 0;\">
								<h3 style=\"font-weight:bold;color:#1C7DCE;border-left:7px solid #1C7DCE;padding-left:20px;\">Nos Articles :</h3>
							</div>
							<div style=\"margin:30px 0;float:right;\">
								<a href=\"admin.php\" class=\"btn btn-info text-white\"><i class=\"fa fa-arrow-left\" style=\"padding-right:10px\"></i> Administration</a>
							</div>

							<div class=\"allproducts\">
							<table class=\"table\">
							<thead>
								<tr class=\"d-flex text-center\">
									<th class=\"col-2\">Image</th>
									<th class=\"col-5\">Libellé</th>
									<th class=\"col-2\">Prix</th>
									<th class=\"col-1\">Quantité</th>
									<th class=\"col-1\">Catégorie</th>
									<th class=\"col-1\"></th>
								</tr>
							</thead>
							<tbody>
						";
					$req = mysqli_query($cnx,"SELECT * FROM articles ORDER BY idCategorie");
					$inc = 1;
					while($articles = $req -> fetch_assoc()) {
						if(isset($_POST['ok$inc'])) {
							$label = $_POST['label'];
							$price = $_POST['price'];
							$qte = $_POST['quantity'];
							$categ = $_POST['categ'];

							$SQL = "UPDATE articles SET libelle='$label' , prix=$prix , quantiteStock=$qte , idCategorie=$categ WHERE idArticle={$_GET['modif']} ";
							@mysqli_query($cnx,$SQL) OR die("ERREUR DE MODIFICATION !");
						}

						echo "
							<tr class=\"d-flex text-center\">
							<form method=post>
								<td class=\"col-2\"><img src=\"assets/img/vignette/{$articles['vignette']}\" class=\"img-rounded\" width=100></td>
								<td class=\"col-5\"><input class=\"form-control\" type=text value=\"{$articles['libelle']}\" size=30 name=\"label\"></td>
								<td class=\"col-2\"><input class=\"form-control\" type=text value=\"{$articles['prix']}\" size=5 name=\"price\"></td>
								<td class=\"col-1\"><input class=\"form-control\" type=text value=\"{$articles['quantiteStock']}\" size=2 name=\"quantity\"></td>
								<td class=\"col-1\"><input class=\"form-control\" type=text value=\"{$articles['idCategorie']}\" size=1 name=\"categ\"></td>
								<td class=\"col-1\">
									<a href=\"admin.php?aart=1&modif=$inc\">
										<input type=submit class=\"btn btn-success\" name=\"ok$inc\" value=\"Changer\">
									</a>
								</td>
							</form>
							</tr>
						";
						$inc++;
					}

					echo "</tbody></table></div>";

				}


				if(isset($_GET['add'])) {

					if(isset($_POST['upload'])) {

							//Extraire le nom du fichier
							$nom_image = $_FILES['vignette']['name'];
							$fichier = basename($_FILES['vignette']['name']);
							$dossier = 'img/vignette/';

							//Extraire l'extension du fichier
								//end() déplace le pointeur interne du tableau array jusqu'au dernier élément et retourne sa valeur.
							$temp = explode('.', $nom_image);
							$extension = end($temp);

							// Extensions permises
							$extension_autor = array('jpg','jpeg','png','bmp','gif');

							//Chaînes non valides
							$e_accent = array('é','ê','ë','è');
							$espace = array(' ');
							$fichier=str_replace($e_accent, 'e', $fichier);
							$fichier=str_replace($espace, '_', $fichier);

							//Tests pour uploader
							if(in_array($extension , $extension_autor)) {

								//Executer l'upload
								if(move_uploaded_file($_FILES['vignette']['tmp_name'], $dossier.$fichier))
									echo "Uploaded Successfully<br>";

								else echo "Upload Failed<br>";
							}

							else echo "Fichier non valide<br>";

							$label = $_POST['label'];
							$price = $_POST['price'];
							$qte = $_POST['qte'];
							$categ = $_POST['categ'];

							$SQL = "INSERT INTO articles(libelle,prix,quantiteStock,vignette,idCategorie)
									VALUES ('$label', '$price', '$qte', '$fichier', '$categ')";

							@mysqli_query($cnx,$SQL) OR die("ERREUR D'AJOUT DE PRODUIT");

					}

					echo "
					<div class=\"container\" style=\"margin-top:50px;\">
						<form method=post enctype=\"multipart/form-data\" class=\"form-group\">
							<input type=text name= \"label\" placeholder=\"Libellé\" class=\"form-control\" required><br>
							<input type=number name=\"price\" placeholder=\"Prix\" class=\"form-control\" required><br>
							<input type=number name=\"qte\" placeholder=\"Quantité Stock\" class=\"form-control\" required><br>

						<div class=\"input-group\">
							<div class=\"input-group-prepend\">
    							<span class=\"input-group-text\" id=\"inputGroupFileAddon01\">Upload</span>
  							</div>
							<div class=\"custom-file\">
								<input type=file name=\"vignette\" class=\"custom-file-input\" id=\"inputGroupFile01\" aria-describedby=\"inputGroupFileAddon01\" required>
								<input type=hidden name=MAX_FILE_SIZE value=1000000>
								<label class=\"custom-file-label\" for=\"inputGroupFile01\">Choose file</label>
							</div>
						</div><br>


							<input type=number name=\"categ\" placeholder=\"Catégorie\" class=\"form-control\" required><br>
							<input type=\"submit\" name=\"upload\" value=\"Ajouter\" class=\"btn btn-info\">
						</form>
					</div>
					";
				}


				if(isset($_GET['supp'])) {

					if(isset($_GET['supprimer'])) {
						$SQL = "DELETE FROM articles WHERE idArticle={$_GET['supprimer']}";
						@mysqli_query($cnx,$SQL) OR die(mysqli_error($cnx));
					}

					echo "<div class=\"container\">
							<div style=\"float:left;margin:30px 0;\">
								<h3 style=\"font-weight:bold;color:#1C7DCE;border-left:7px solid #1C7DCE;padding-left:20px;\">Nos Articles :</h3>
							</div>
							<div style=\"margin:30px 0;float:right;\">
								<a href=\"admin.php\" class=\"btn btn-info text-white\"><i class=\"fa fa-arrow-left\" style=\"padding-right:10px\"></i> Administration</a>
							</div>

							<div class=\"allproducts\">
							<table class=\"table table-bordered\">
							<thead>
								<tr class=\"d-flex text-center\">
									<th class=\"col-2\">Image</th>
									<th class=\"col-5\">Libellé</th>
									<th class=\"col-2\">Prix</th>
									<th class=\"col-2\">Quantité</th>
									<th class=\"col-1\">Supprimer</th>
								</tr>
							</thead>
							<tbody>
						";
					$req = mysqli_query($cnx,"SELECT * FROM articles ORDER BY idCategorie");
					while($articles = mysqli_fetch_assoc($req))
						echo "
							<tr class=\"d-flex text-center\">
								<td class=\"col-2\">
									<img src=\"assets/img/vignette/{$articles['vignette']}\" class=\"img-rounded\" width=100>
								</td>
								<td class=\"col-5\">{$articles['libelle']}</td>
								<td class=\"col-2\">{$articles['prix']}</td>
								<td class=\"col-2\">{$articles['quantiteStock']}</td>
								<td class=\"col-1\">
									<a href=\"?aart=1&supp=0&supprimer={$articles['idArticle']}\"><i class=\"fa fa-trash\"></i></a>
								</td>
							</tr>
						";

					echo "</tbody></table></div>";
				}

			}




			// Gérer les catégories
			if(isset($_GET['acat'])) {
				if(isset($_GET['del'])) {
					$SQL = "DELETE FROM categories WHERE idCategorie={$_GET['del']}";
					@mysqli_query($cnx,$SQL) OR die("Erreur de suppression !");
				}

				if(isset($_POST['nvcat'])) {
					$titre = $_POST['titre'];
					$description = $_POST['descrp'];
					$SQL = "INSERT INTO categories (titreCategorie,descriptionCategorie) VALUES ('$titre','$description')";
					@mysqli_query($cnx,$SQL) OR die("Erreur d'ajout de nouvelle catégorie !");
				}


				echo "<div class=\"container\">
						<div style=\"float:left;margin:30px 0;\">
							<h3 style=\"font-weight:bold;color:#1C7DCE;border-left:7px solid #1C7DCE;padding-left:20px;\">Nos Catégories :</h3>
						</div>
						<div style=\"margin:30px 0;float:right;\">
							<a href=\"admin.php\" class=\"btn btn-info text-white\"><i class=\"fa fa-arrow-left\" style=\"padding-right:10px\"></i> Administration</a>
						</div>

						<div class=\"allcategs\">
						<table class=\"table\">
						<thead>
							<tr class=\"d-flex text-center\">
								<th class=\"col-4\">Categorie</th>
								<th colspan=2 class=\"col-8\">Désignation</th>
							</tr>
						</thead>
						<tbody>
					";
				$req = mysqli_query($cnx,"SELECT * FROM categories");
				while($categs = $req -> fetch_assoc()) {
					echo "
						<tr class=\"d-flex text-center\">
							<td class=\"col-4\">{$categs['titreCategorie']}</td>
							<td class=\"col-7\">{$categs['descriptionCategorie']}</td>
							<td class=\"col-1\"><a href=\"?acat=1&del={$categs['idCategorie']}\"><i class=\"fa fa-trash\"></i></a></td>
						</tr>
					";
				}
				echo "
						<form method=post><tr class=\"d-flex text-center\">
							<td class=\"col-4\"><input placeholder=\"Titre de la categorie\" type=text name=titre class=\"form-control\"></td>
							<td class=\"col-7\"><input placeholder=\"Description de la categorie\" type=text name=descrp class=\"form-control\"></td>
							<td class=\"col-1\"><input type=submit name=nvcat value=Ajouter class=\"btn btn-outline-info\"></td>
						</tr></form>

					</tbody>
				</table>
				</div>
				</div>";
			}

			if(!isset($_GET['acmd']) && !isset($_GET['aart']) && !isset($_GET['aprm']) && !isset($_GET['acat'])) {
				echo "
				<div class=\"container\">

					<h2 style=\"font-weight:bold;color:#1C7DCE;margin:20px 0;border-left:7px solid #1C7DCE;padding-left:20px;\">Administration :</h2>
					<div class=\"adminpanel text-center\" style=\"margin-top:60px\">

						<div class=\"row\">
							<div class=\"col-sm-6\" style=\"margin:50px auto;\">
								<a href=\"?acmd=1\" style=\"padding:30px 100px;font-size:20px;background-color:#1C7DCE;color:white;text-decoration:none\" class=\"col-sm-12\">Gérer les Commandes</a>
							</div>
							<div class=\"col-sm-6\" style=\"margin:50px auto;\">
								<a href=\"?aprm=1\" style=\"padding:30px 105px;font-size:20px;background-color:#1C7DCE;color:white;text-decoration:none\" class=\"col-sm-12\">Gérer les Promotions</a>
							</div>
						</div>

						<div class=\"row\">
							<div class=\"col-sm-6\" style=\"margin:50px auto;\">
								<a href=\"?aart=1\" style=\"padding:30px 120px;font-size:20px;background-color:#1C7DCE;color:white;text-decoration:none\" class=\"col-sm-12\">Gérer les Articles</a>
							</div>
							<div class=\"col-sm-6\" style=\"margin:50px auto;\">
								<a href=\"?acat=1\" style=\"padding:30px 105px;font-size:20px;background-color:#1C7DCE;color:white;text-decoration:none\" class=\"col-sm-12\">Gérer les Catégories</a>
							</div>
						</div>

					</div>

				</div>";
			}
		}
	}
?>
