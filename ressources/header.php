<?php
	session_start();
	include "connexion.inc.php";
	include 'ressources/functions.php';
	$cnx=mysqli_connect(URL,USER,PWD,DB) OR die("Erreur de connexion");

	if(isset($_POST['con'])) {
		$email = $_POST['mail'];
		$pass = $_POST['pwd'];
		$flag=0;
		$SQL = "SELECT * FROM clients";
		$req = $cnx -> Query($SQL);
		while($tab=mysqli_fetch_assoc($req)) {
			//Décrypter le mot de passe
			$mdp = base64_decode($tab['password']);
			if($tab['email']==$email && $mdp==$pass) {
				$flag = 1;
				$_SESSION['user']['idC']=$tab['idClient'];
				$_SESSION['user']['avatar']=$tab['avatar'];
			}
		}

		if($flag == 0) echo "<script>alert(\"Email ou Mot de passe incorrect !!\")</script>";
	}


	if(isset($_POST['inscrip'])) {
		$nom = ucfirst(removeSpecialChars($_POST['nom']));
		$prenom = ucfirst(removeSpecialChars($_POST['prenom']));
		$mail = $_POST['mail'];
		//Crypter le mot de passe
		$pwd = base64_encode($_POST['pwd']);
		$address = strtoupper(removeSpecialChars($_POST['adresse']));
		$country = strtoupper(removeSpecialChars($_POST['pays']));
		$gender = ucfirst($_POST['sexe']);
		$SQL = "INSERT INTO clients(nomClient,prenomClient,sexe,email,password,adresse,pays)
				VALUES('$nom','$prenom','$gender','$mail','$pwd','$address','$country')";
		@mysqli_query($cnx,$SQL) OR die("Erreur d'inscription");

	}

	if(isset($_GET['disconnect'])) {
		unset($_SESSION['user']);
		header('Location:accueil.php');
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Shop</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/Contact-Form-Clean.css">
	<link href="XXX.css?v=1.0" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

</head>
<body>

<!-- Start Header -->
<header>

	<!-- Start Top Navigation Bar -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light topbar">
		<div class="container">

			<div class="socialMediaLinks">
				<a href="#" target="_blank" class="fb"><i class="fa fa-facebook"></i></a>
				<a href="#" target="_blank" class="ig"><i class="fa fa-instagram"></i></a>
				<a href="#" target="_blank" class="tw"><i class="fa fa-twitter"></i></a>
			</div>

			<div class="topnav">
				<ul class="navbar-nav ml-auto">
				 	<li class="nav-item">
				 		<a href="contact.php"><i class="fa fa-envelope"></i> Contact</a>
				 	</li>
  				 	<li class="nav-item">
  						<?php if(!isset($_SESSION['user'])) {?>
  						<a href="" data-toggle="modal" data-target="#modalLRForm"><i class="fa fa-sign-in"></i> Se Connecter</a>
  						<?php }
  						 	else {?>
  						 		<a href="?disconnect=1"><i class="fa fa-sign-out"></i> Se Déconnecter</a>
  						<?php }?>
				 	</li>
				 	<li class="nav-item">
				 		<?php if(isset($_SESSION['user'])) {?>
				 		<a href="profile.php"><i class="fa fa-user"></i> Mon compte</a>
				 		<?php }	?>
				 	</li>
				 	<li class="nav-item">
				 		<a href="commande.php"><i class="fa fa-credit-card"></i> Paiement</a>
				 	</li>
				</ul>
			</div>

		</div>
	</nav>
	<!-- End Top Navigation Bar -->


	<!-- Start Middle Navigation Bar -->
	<nav class="navbar navbar-expand-lg midbar">
		<div class="container">

			<div class="logo" style="margin-right:50px !important;">
				<a class="navbar-brand" href="accueil.php"><img src="assets/img/logo.png" alt="Biougnach" title="Biougnach" width=200></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
			</div>

			<div class="collzapse navbar-collapse col-sm-10" id="navbarSupportedContent">

				<form class="form-inline my-2 my-lg-0 col-sm-8 midsearch" method="post" action="accueil.php" style="margin-left:100px;">
					<input class="form-control col-sm-6" type="search" name="search" placeholder="Recherche...">
					<button class="btn col-sm-0" type="submit" name="find"><i class="fa fa-search" style="color: white;"></i></button>
				</form>

				<ul class="navbar-nav ml-auto" style="margin-right:80px !important;">
					<!--<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle btn btn-dark panierBtn" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false" title="Voir mon panier"><i class="fa fa-shopping-cart" style="padding-right:5px;"></i> Panier <span></span></a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
									<a class="dropdown-item" href="#">Action</a>
									<a class="dropdown-item" href="#">Another action</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="#">Something else here</a>
						</div>
					</li>
					-->

					<li class="nav-item">
						<a class="nav-link dropdown-toggle btn btn-dark panierBtn" href="panier.php" id="navbarDropdown" role="button" aria-expanded="false" title="Voir mon panier"><i class="fa fa-shopping-cart" style="padding-right:5px;"></i> Panier <span><?php if(isset($_SESSION['panier'])) echo "(".count($_SESSION['panier']).")"?></span></a>
					</li>
				</ul>

			</div>

		</div>
	</nav>
	<!-- End Middle Navigation Bar -->


	<!-- Start Bottom Navigation Bar -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark botbar">
		<div class="container">
			<ul class="navbar-nav ml-auto col">
				<li class="nav-item">
					<a class="nav-link" href="accueil.php"><i class="fa fa-home"></i></a>
				</li>

				<?php
					$SQL = "SELECT * FROM categories ORDER BY idCategorie";
					$req = $cnx -> Query($SQL);
					while($categs = $req -> fetch_array()) {
						echo "
							<li class=\"nav-item category\">
								<a class=\"nav-link\" href=\"accueil.php?id_categorie={$categs['idCategorie']}\">{$categs['titreCategorie']}</a>
							</li>
						";
					}
				?>
			</ul>
		</div>
	</nav>
	<!-- End Bottom Navigation Bar -->

</header>
<!-- End Header -->






	<!-- Start Modal -->
		<!--Modal: Login / Register Form-->
<div class="modal fade" id="modalLRForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog cascading-modal" role="document">
    <!--Content-->
    <div class="modal-content">

      <!--Modal cascading tabs-->
      <div class="modal-c-tabs">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs md-tabs tabs-2 light-blue darken-3" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#panel1" role="tab"><i class="fa fa-user mr-1"></i>
              Se connecter</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#panel2" role="tab"><i class="fa fa-user-plus mr-1"></i>
              S'inscrire</a>
          </li>
          <li class="nav-item ml-auto">
          	<a class="nav-link" data-dismiss="modal" title="Close" style="cursor:pointer;"><i class="fa fa-times"></i></a>
          </li>
        </ul>

        <!-- Tab panels -->
        <div class="tab-content">
          <!--Panel 7-->
          <div class="tab-pane fade in show active" id="panel1" role="tabpanel">

            <!--Body-->
            <form method="post">
            <div class="modal-body mb-1">
              <div class="md-form form-sm mb-4">
                <label data-error="wrong" data-success="right" for="modalLRInput10"><i class="fa fa-envelope prefix"></i> Email</label>
                <input type="email" id="modalLRInput10" class="form-control form-control-sm validate" name="mail" placeholder="Votre Adresse Email" required>
              </div>

              <div class="md-form form-sm mb-5">
                <label data-error="wrong" data-success="right" for="modalLRInput11"><i class="fa fa-lock prefix"></i> Password</label>
                <input type="password" id="modalLRInput11" class="form-control form-control-sm validate" name="pwd" placeholder="Votre Mot De Passe" required>
              </div>

              <div class="text-center mt-2">
                <button type="submit" name="con" class="btn btn-primary">Se connecter</button>
              </div>
              </form>
            </div>
            <!--Footer-->
            <div class="modal-footer">
              <div class="options mr-auto mt-1">
                <p>Not a member? <a href="#panel2" data-toggle="tab" class="blue-text">S'inscrire</a></p>
                <p><a href="#" class="blue-text">Forgot Password?</a></p>
              </div>
            </div>
          </div>
          <!--/.Panel 7-->



          <!--Panel 8-->
          <div class="tab-pane fade" id="panel2" role="tabpanel">

            <!--Body-->
            <div class="modal-body">
              <form method="post">

              	<div class="form-row form-sm mb-4">
              		<div class="col-sm-6">
              			 <label data-error="wrong" data-success="right" for="modalLRInput20"><i class="fa fa-user prefix"></i> Nom :</label>
	               		<input type="text" id="modalLRInput20" class="form-control form-control-sm validate" name="nom" placeholder="Votre Nom" required>
              		</div>
              		<div class="col-sm-6">
              			<label data-error="wrong" data-success="right" for="modalLRInput21"><i class="fa fa-user prefix"></i> Prénom :</label>
                		<input type="text" id="modalLRInput21" class="form-control form-control-sm validate" name="prenom" placeholder="Votre Prénom" required>
              		</div>
              	</div>

              	<div class="form-row form-sm mb-4">
              		<div class="col-sm-6">
		                <label data-error="wrong" data-success="right" for="modalLRInput22"><i class="fa fa-envelope prefix"></i> Email :</label>
		                <input type="email" id="modalLRInput22" class="form-control form-control-sm validate" name="mail" placeholder="Votre Adresse Email" required>
		            </div>
					<div class="col-sm-6">
						<label data-error="wrong" data-success="right" for="modalLRInput23"><i class="fa fa-lock prefix"></i> Password :</label>
                		<input type="password" id="modalLRInput23" class="form-control form-control-sm validate" name="pwd" placeholder="Votre Mot De Passe" required>
					</div>
              	</div>

              	<div class="form-row form-sm mb-4">
              		<div class="col-sm-6">
		                <label data-error="wrong" data-success="right" for="modalLRInput24"><i class="fa fa-address-card prefix"></i> Adresse :</label>
		                <input type="text" id="modalLRInput24" class="form-control form-control-sm validate" name="adresse" placeholder="Votre Adresse" required>
		            </div>
					<div class="col-sm-6">
						<label data-error="wrong" data-success="right" for="modalLRInput25"><i class="fa fa-flag prefix"></i> Pays :</label>
                		<input type="text" id="modalLRInput25" class="form-control form-control-sm validate" name="pays" placeholder="Votre Pays" required>
					</div>
              	</div>


				<label data-error="wrong" data-success="right"><i class="fa fa-users prefix"></i> Sexe :</label>
              	<div class="form-row form-sm mb-4">
              		<div class="col-sm-2"></div>
              		<div class="col-sm-4">
              			<label data-error="wrong" data-success="right" for="modalLRInput26"><i class="fa fa-male prefix"></i> Homme :</label>
                 		<input type="radio" name="sexe" id="modalLRInput26" value="homme">
              		</div>
              		<div class="col-sm-4">
              			<label data-error="wrong" data-success="right" for="modalLRInput27"><i class="fa fa-male prefix"></i> Femme :</label>
                 		<input type="radio" name="sexe" id="modalLRInput27" value="femme">
                	</div>
                	<div class="col-sm-2"></div>
				</div>

              <div class="form-sm mt-2">
                <button type="submit" class="btn btn-primary btn-block" name="inscrip">S'inscrire</button>
              </div>
			  </form>
            </div>
            <!--Footer-->
            <div class="modal-footer">
              <div class="options mr-auto">
                <p class="pt-1">Already have an account? <a href="#panel1" data-toggle="tab"  class="blue-text">Se connecter</a></p>
              </div>
            </div>
          </div>
          <!--/.Panel 8-->
        </div>

      </div>
    </div>
    <!--/.Content-->
  </div>
</div>

	<!-- End Modal -->






<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/main.js"></script>
