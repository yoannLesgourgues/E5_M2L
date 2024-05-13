<div class="conteneur">
	<header>
		<?php include 'haut.php' ;?>
	</header>
	<main>
		<br></br><br></br>
		<div class ='texteMission'>
			<h3> Liste des contrats </h3>
			<?php echo $menuContratUtilisateur; ?>
		</div>
		<br></br>
		<div class ='texteMission'>
		<h3> Bulletins </h3>	
		<?php $formInfosBulletin->afficherFormulaire(); ?>
		</div>
	</main>
	<footer>
		<?php include 'bas.php' ;?>
	</footer>
</div>