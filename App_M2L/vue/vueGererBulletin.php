<div class="conteneur">
	<header>
		<?php include 'haut.php' ;?>
	</header>
	<main>
		<br></br><br></br>
		<div class ='texteMission'>
			<h3> Liste des utilisateurs </h3>
			<?php echo $menuBulletinUtilisateur; ?>
		</div>
		<br></br>
		<div class ='texteMission'>
			<h3> Liste des contrats de l'utilisateur </h3>
			<?php echo $menuContratUtilisateurSelect; ?>
		</div>
		<br></br>
		<div class ='texteMission'>
		<?php $formBulletin->afficherFormulaire(); ?>
		</div>
	</main>
	<footer>
		<?php include 'bas.php' ;?>
	</footer>
</div>