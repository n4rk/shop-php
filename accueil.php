<?php
	include 'ressources/header.php';
?>

<!-- Searching for a product -->
<?php

	if(isset($_POST['find'])) {
		echo "<div class=\"container\">";
		$SQL = "SELECT a.idArticle AS articleID,libelle,prix,quantiteStock,vignette,dateMiseVente,a.idCategorie, p.* FROM articles a LEFT JOIN promotions p ON a.idArticle=p.idArticle
				WHERE libelle LIKE '%{$_POST['search']}%' GROUP BY a.idArticle";
		$req = mysqli_query($cnx,$SQL);
		$f = 0;
		$i = 0;


		if(mysqli_num_rows($req) == 0)
			$f = 1;

		echo "<table class=\"table\"><tr>";
		while($results = mysqli_fetch_assoc($req)) {
			if($i%2==0) echo "</tr><tr>";
			afficherProduits($results);
			$i++;
		}

		if($f==1) {
			echo "<div style=\"margin:50px auto;\"><h3 style=\"color:red\">Aucun Résultat Trouvé !</h3></div>";
		}
		
		echo "</tr></table></div>";
	}

	//Articles
	if(!isset($_POST['find'])) {
?>

<div class="articles" style="margin-top:25px;">
	<div class="container">
		<?php
			if(!isset($_GET['id_categorie'])) {
				//Products having a Discount
				$SQL = "SELECT * FROM articles NATURAL JOIN promotions
						WHERE now() BETWEEN dateDebut AND dateFin
						ORDER BY tauxPromo DESC LIMIT 4";
				$req = mysqli_query($cnx,$SQL);
				echo "<h4 style=\"font-weight:bold;border-left:5px solid #1C7DCE;padding-left:10px;\">Fortes Promos :</h4><table class=\"table col-lg-12\"><tr>";
				$i = 0;
				while($tab=mysqli_fetch_assoc($req)) {
					if($i%2==0) echo "</tr><tr>";
					showProducts($tab);
					$i++;
				}
				echo "</tr></table><br>";

				// New Products
				$SQL = "SELECT a.idArticle articleID,libelle,prix,quantiteStock,vignette,tauxPromo FROM articles a LEFT JOIN promotions p ON a.idArticle=p.idArticle					
						ORDER BY dateMiseVente DESC LIMIT 4";
				$req = mysqli_query($cnx,$SQL);
				echo "<h4 style=\"font-weight:bold;border-left:5px solid #1C7DCE;padding-left:10px;\">Nouveautés :</h4><table class=\"table col-lg-12\"><tr>";
				$i = 0;
				while($tab2=mysqli_fetch_assoc($req)) {
					if($i%2==0) echo "</tr><tr>";
					afficherProduits($tab2);
					$i++;
				}
				echo "</tr></table><br>";


				// Most sold Products

				$SQL = "SELECT a.*,tauxPromo,count(d.idArticle) AS nbVentes FROM articles a
						INNER JOIN details d ON a.idArticle=d.idArticle
						LEFT JOIN promotions p ON a.idArticle=p.idArticle						
						GROUP BY a.idArticle ORDER BY nbVentes DESC LIMIT 4";
				$req = mysqli_query($cnx,$SQL);
				echo mysqli_error($cnx);
				echo "<h4 style=\"font-weight:bold;border-left:5px solid #1C7DCE;padding-left:10px;\">Les Plus Vendus :</h4><table class=\"table col-lg-12\"><tr>";
				$i = 0;
				while($tab3=mysqli_fetch_assoc($req)) {
					if($i%2==0) echo "</tr><tr>";
					showProducts($tab3);
					$i++;
				}
				echo "</tr></table><br>";
			}
		?>
	</div>
</div>
<div class="articlesCat">
	<div class="container">

		<?php 

			// when we choose a category, we show its products

			if(isset($_GET['id_categorie'])) {

				$nombre_par_page = 2;

				$SQL = "SELECT * FROM articles a LEFT JOIN categories c ON a.idCategorie=c.idCategorie WHERE a.idCategorie={$_GET['id_categorie']}";
				$req = $cnx -> Query($SQL);
				$categ = $req -> fetch_array();
				echo "<h2 style=\"font-weight:bold;color:#1C7DCE;margin:20px 0;border-left:7px solid #1C7DCE;padding-left:20px;\">{$categ['titreCategorie']} :</h2><table class=\"table col-lg-12\" style=\"margin-bottom:100px;\"><tr>";
				
				$nombre_total = mysqli_num_rows($req);
				$nombre_pages = ceil($nombre_total/$nombre_par_page);

				if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page']>0 AND $_GET['page']<=$nombre_pages) {
					$_GET['page'] = intval($_GET['page']);
					$indice_page = $_GET['page'];
				}
				else $indice_page = 1;

				$depart = ($indice_page-1)*$nombre_par_page;



				$SQL2 = "SELECT a.idArticle AS articleID,libelle,prix,quantiteStock,vignette,dateMiseVente,a.idCategorie, p.*
						FROM articles a	LEFT JOIN promotions p ON a.idArticle=p.idArticle
						WHERE a.idCategorie={$_GET['id_categorie']} ORDER BY prix LIMIT $depart,$nombre_par_page";
				$req2 = mysqli_query($cnx,$SQL2);
				
				
				$i = 0;
				while($tab=mysqli_fetch_assoc($req2)) {
				
					if($i%2==0) echo "</tr><tr>";
					afficherProduits($tab);
					$i++;
				
				}

/*				if(count($tab)==0) {
					echo "<h3 class=\"text-center\" style=\"margin:50px auto;\">Nous n'avons pas encore ajouté de nouveaux produits à cette catégorie !</h3>";
				}
*/
				echo "</tr></table>";
				echo "<div class=\"pagination\" style=\"margin-bottom:50px;\">";
				for($j=1;$j<=$nombre_pages;$j++) {
					if($j == $indice_page)
						echo "<div class=\"activePage\"><a>".$j."</a></div>";
					else 
						echo "<div><a style=\"color:white;\" href=\"accueil.php?id_categorie={$_GET['id_categorie']}&page=$j\">$j</a></div>";
				}
				echo "</div>";
			}


		?>
	</div>
</div>

<?php }
	include 'ressources/footer.php';
?>

