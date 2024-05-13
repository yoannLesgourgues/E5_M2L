<div class="conteneur">
	<header>
		<?php include 'haut.php' ;?>
	</header>
	<main>
	<br></br><br></br>
		<div class ='texteMission'>
			<h3> Liste des utilisateurs </h3>
			<?php echo $menuContratUtilisateur; ?>
		</div>
		<br></br><br></br>
		<div class ='texteMission'>
		<?php $formContrat->afficherFormulaire(); ?>
		</div>
	</main>
	<footer>
		<?php include 'bas.php' ;?>
	</footer>
</div>