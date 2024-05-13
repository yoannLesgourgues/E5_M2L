<div class="conteneur">
	<header>
		<?php include 'haut.php' ;?>
	</header>
	<main>
	<br></br><br></br>
		<div class ='texteMission'>
			<h3> Liste des utilisateurs </h3>
			<?php echo $leMenuUtilisateurs; ?>
		</div>
		<br></br><br></br>
		<div class ='texteMission'>
		<?php $formUtilisateur->afficherFormulaire(); ?>
		</div>
	</main>
	<footer>
		<?php include 'bas.php' ;?>
	</footer>
</div>