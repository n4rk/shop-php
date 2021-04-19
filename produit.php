<?php
	include 'ressources/header.php';

	if(isset($_GET['id_article'])) {
		$articleID = $_GET['id_article'];
		echo "
			<div class=\"container\" style=\"margin-bottom:50px;\">
			<table class=\"table product\">
				<tr>
		";
		$SQL = "SELECT * FROM articles a LEFT JOIN promotions p ON a.idArticle=p.idArticle
				WHERE a.idArticle={$_GET['id_article']}";
		$SQL1 ="SELECT * FROM photos
				WHERE idArticle={$_GET['id_article']}";

		$req1 = mysqli_query($cnx,$SQL1);

		$row1 = mysqli_fetch_assoc($req1);
		$photo = $row1['photo'];



		echo "<td>
				<a data-toggle=\"modal\" data-target=\"#myModal\">
				<img src=\"assets/img/images/$photo\" id=\"myImg\" style=\"width:100%;max-width:250px;\">
				</a>

				<div id=\"myModal\" class=\"modal fade\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
				  <div class=\"modal-dialog\">
				        <div class=\"modal-body\">
				            <img src=\"assets/img/images/$photo\" class=\"img-responsive\" style=\"max-width:400px;\">
				        </div>
				  </div>
				</div>
					<br>

				<div class=\"lilImages\" style=\"display:inline-block;margin:20px -10px;\">";
				$x=0;
		while($row1 = mysqli_fetch_assoc($req1)) {
			$photo = $row1['photo'];
			$x++;
			echo "
			<a data-toggle=\"modal\" data-target=\"#myModal$x\"><img src=\"assets/img/images/$photo\" id=\"myImg\" width=80 style=\"border:1px solid #ddd;margin-left:10px;\"></a>
			<div id=\"myModal$x\" class=\"modal fade\" aria-labelledby=\"myModalLabel\">
				  <div class=\"modal-dialog\">
				        <div class=\"modal-body zoom\">
				            <img src=\"assets/img/images/$photo\"  style=\"max-width:400px;\" class=\"img-responsive zoom\">
				        </div>
				</div>
			</div>
			";
		}
		echo "</div></td>";



		$req = mysqli_query($cnx,$SQL);
		$row = mysqli_fetch_assoc($req);

		echo "<td><div style=\"margin-top:40px;\">
		<a style=\"font-weight:bold;font-size:20px;line-height:60px;\">{$row['libelle']}</a><br>";
		if(is_null($row['tauxPromo']))
			echo "<a style=\"color:green;font-weight:500;\">{$row['prix']} Dh</a><br>";
		else {
			$price = $row['prix'] - $row['prix']*$row['tauxPromo']/100;
			echo "
				<a style=\"color:red;font-weight:500;font-size:14px;\"><s>{$row['prix']} Dh</s></a><br>
				<a style=\"color:green;font-weight:500;\">$price Dh</s></a><br>
			";
		}


		if($row['quantiteStock']!=0)
			echo "
				<form class=\"form-group\" method=post action=\"panier.php?id_article={$articleID}&ajouter=1\">
					<label style='font-size:14px;margin-top:15px;'>Quantité : </label>
		  			<input type=\"number\" name=\"quantity\" value=1 max={$row['quantiteStock']} width=100 class=\"form-control\">
		  			<br>
					<input class=\"form-control btn btn-primary\" type=submit value=\"Ajouter au panier\">
				</form></tr></table>
			";
		if($row['quantiteStock']<=0)
			echo "<p style=\"color:red;margin-top:50px;font-size:20px;font-weigt:bold;\">! En Rupture De Stock !</p>";


		// Affichage des descriptions

		$SQL = "SELECT * FROM descriptions
				WHERE idArticle={$_GET['id_article']}";
		$req = mysqli_query($cnx,$SQL);
		echo "<table class=\"table table-bordered\">";
		while($row2=mysqli_fetch_assoc($req))
			echo "<tr>
					<td><b>{$row2['item']}</b></td>
					<td>{$row2['definition']}</td>
				</tr>";

		echo "</table></div>";
	}


	include 'ressources/footer.php';
?>
