<?php
	include "ressources/header.php";
?>

<div class="contact-clean">
    <form method="post">
        <h2 class="text-center">Contact us</h2>
        <div class="form-group"><input class="form-control" type="text" name="name" placeholder="Name"></div>
        <div class="form-group"><input class="form-control" type="email" name="email" placeholder="Email"><small class="form-text text-primary">Please enter a correct email address.</small></div>
        <div class="form-group"><textarea class="form-control" rows="14" name="message" placeholder="Message"></textarea></div>
        <div class="form-group"><button class="btn btn-primary" type="submit">send </button></div>
    </form>
</div>

<?php include "ressources/footer.php" ?>