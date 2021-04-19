<?php
  $cnx = mysqli_connect(URL,USER,PWD,DB);
?>

<!-- Footer -->
<div style="height:20px;"></div>
<footer class="page-footer font-small unique-color-dark" style="background-color:#222;color:#f8f9fa;padding-top:10px;">

  <!-- Footer Links -->
  <div class="container text-center text-md-left mt-5">

    <!-- Grid row -->
    <div class="row mt-3">

      <!-- Grid column -->
      <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">

        <!-- Content -->
        <h6 class="text-uppercase font-weight-bold">Biougnach</h6>
        <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
        <p>Spécialiste de l'Électronique au Maroc depuis 1973, Biougnach Electro vous souhaite la bienvenue sur biougnach.ma, la nouvelle référence d'électronique en ligne.</p>

      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">

        <!-- Links -->
        <h6 class="text-uppercase font-weight-bold">Catégories</h6>
        <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
        <?php
          $req = mysqli_query($cnx,"SELECT titreCategorie FROM categories ORDER BY idCategorie");
          while($cats = mysqli_fetch_array($req))
            echo "
              <p>
                <a href=\"#\" style=\"color:#6bbbff;\">".$cats['titreCategorie']."</a>
              </p>
            ";
        ?>
      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">

        <!-- Links -->
        <h6 class="text-uppercase font-weight-bold">Liens Utiles</h6>
        <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
        <p>
          <a href="#" style="color:#6bbbff;">À Propos</a>
        </p>
        <p>
          <a href="#" style="color:#6bbbff;">Conditions générales</a>
        </p>
        <p>
          <a href="#" style="color:#6bbbff;">Recrutement</a>
        </p>
        <p>
          <a href="#" style="color:#6bbbff;">Aide</a>
        </p>

      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">

        <!-- Links -->
        <h6 class="text-uppercase font-weight-bold">Contact</h6>
        <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
        <p>
          <i class="fa fa-home mr-3"></i> 22 Lot Al Waha - Errachidia</p>
        <p>
          <i class="fa fa-envelope mr-3"></i> elhcm12@gmail.com</p>
        <p>
          <i class="fa fa-phone mr-3"></i> +2126 123 456 789</p>

      </div>
      <!-- Grid column -->

    </div>
    <!-- Grid row -->

  </div>
  <!-- Footer Links -->

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">
    © 2020 Copyright | Made with <i class="fa fa-heart" style="color:#fa0f2f;font-size:14px;"></i> by
    <a href="https://github.com/n4rk" target=_blank style="color:white;text-decoration:underline;font-weight:600"> Amine HCM (a.k.a <b>n4rk</b>)</a>
  </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->
