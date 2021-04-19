<?php
// Function affichage articles
	function showProducts($tableau) {

		echo "<td class=\"align-middle\" style=\"height:150px;\">
			<div style=\"float:left;\">
				<a href=\"produit.php?id_article={$tableau['idArticle']}\">
					<img src=\"assets/img/vignette/{$tableau['vignette']}\" width=150>
				</a>
			</div>
			<div style=\"margin-left:10em;\">
				<a style=\"font-size:17px;font-weight:bold;\">{$tableau['libelle']}</a><br>
			";

		if(is_null($tableau['tauxPromo']))
			echo "<a style=\"color:green;font-weight:500;\">{$tableau['prix']} Dh</a><br>";

		else {
			$prix=$tableau['prix']-(($tableau['prix']*$tableau['tauxPromo'])/100);
			echo "
				<a style=\"color:red;font-weight:500;font-size:12px\"><s>{$tableau['prix']} Dh</s></a><br>
				<a style=\"color:green;font-weight:500;\">$prix Dh</a><br>
			";
		}

			echo "<a href=\"produit.php?id_article={$tableau['idArticle']}\" style=\"font-weight:bold;color:#1C7DCE !important;\">
					Voir Plus <i class=\"fa fa-arrow-right\" style=\"font-size:12px;padding-left:5px;\"></i></a>
			</div>
			</td>";
	}

	function afficherProduits($tableau) {

		echo "<td class=\"align-middle\" style=\"height:150px;\">
			<div style=\"float:left;\">
				<a href=\"produit.php?id_article={$tableau['articleID']}\"><img src=\"assets/img/vignette/{$tableau['vignette']}\" width=150></a>
			</div>
			<div style=\"margin-left:10em;\">
				<a style=\"font-size:17px;font-weight:bold;vertical-align:middle\">{$tableau['libelle']}</a><br>
			";
		if(is_null($tableau['tauxPromo'])) {
			echo "<a style=\"color:green;font-weight:500;\">{$tableau['prix']} Dh</a><br>";
		}


		else {
			$prix=$tableau['prix']-$tableau['prix']*$tableau['tauxPromo']/100;
			echo "
				<a style=\"color:red;font-weight:500;font-size:12px\"><s>{$tableau['prix']} Dh</s></a><br>
				<a style=\"color:green;font-weight:500;\">$prix Dh</a><br>
			";
		}
			echo "<a href=\"produit.php?id_article={$tableau['articleID']}\" style=\"font-weight:bold;\">Voir Plus <i class=\"fa fa-arrow-right\" style=\"font-size:12px;padding-left:5px;\"></i></a></div>
			</td>";
	}

	function removeSpecialChars($str) {
		$url = $str;
	    $url = preg_replace('#Ç#', 'C', $url);
	    $url = preg_replace('#ç#', 'c', $url);
	    $url = preg_replace('#è|é|ê|ë#', 'e', $url);
	    $url = preg_replace('#È|É|Ê|Ë#', 'E', $url);
	    $url = preg_replace('#à|á|â|ã|ä|å#', 'a', $url);
	    $url = preg_replace('#@|À|Á|Â|Ã|Ä|Å#', 'A', $url);
	    $url = preg_replace('#ì|í|î|ï#', 'i', $url);
	    $url = preg_replace('#Ì|Í|Î|Ï#', 'I', $url);
	    $url = preg_replace('#ð|ò|ó|ô|õ|ö#', 'o', $url);
	    $url = preg_replace('#Ò|Ó|Ô|Õ|Ö#', 'O', $url);
	    $url = preg_replace('#ù|ú|û|ü#', 'u', $url);
	    $url = preg_replace('#Ù|Ú|Û|Ü#', 'U', $url);
	    $url = preg_replace('#ý|ÿ#', 'y', $url);
	    $url = preg_replace('#Ý#', 'Y', $url);

	    return $url;
	}

?>
