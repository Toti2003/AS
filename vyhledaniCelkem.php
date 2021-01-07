<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<style>
        body {
            background-color: moccasin;
        }
    </style>
</head>
<body>
	<!--Menu-->
	<div>
		<a href="formVloz2.php"><button>Vkladani vozidel do database</button></a>&nbsp;
		<a href="prehled.php"><button>Prehled vozidel v databazi</button></a>&nbsp;
		<a href="vyhledani.php"><button>Vyhledani vozidel v databazi</button></a>&nbsp;
		<a href="vyhledaniCelkem.php"><button>Vyhledani vozidel v databazi - striktne</button></a>&nbsp;
	</div>

	<!--Vlozeni dat-->
	<?php
	if (!($con = mysqli_connect("localhost", "autobazar", "heslo", "autobazar"))) {	//navazani spojeni
		die("Nelze se připojit k databázovému serveru!</body></html>");
	} else {
		mysqli_query($con, "SET NAMES 'utf8'");
		if ((isset($_POST["odesli"])) && (($_POST["spz"] != "") || ($_POST["znacka"] != "") || ($_POST["typ"] != ""))) {	//osetreni nacteni stranky
			$where1 = "%";
			$where2 = "%";
			$where3 = "%";

			if ($_POST['spz'] != "") {
				$where1 = addslashes($_POST['spz']);
			}
			if ($_POST['znacka'] != "") {
				$where2 = addslashes($_POST['znacka']);
			}
			if ($_POST['typ'] != "") {
				$where3 = addslashes($_POST['typ']);
			}
			if (!($vysledek = mysqli_query($con, "SELECT * FROM seznamaut WHERE spz like '$where1' and znacka like '$where2' and typ like '$where3'"))) {
				die("Nelze provést dotaz 1.</body></html>");
			}

	?>
			<h1>Vypis database aut podle Kriterii</h1>
			<table border="1 solid black">
				<?php
				while ($radek = mysqli_fetch_array($vysledek)) {
				?>
					<tr>
						<td colspan="4"><?php echo "Toto je auto cislo : " . htmlspecialchars($radek["id_auta"]); ?></td>
					</tr>
					<tr>
						<td><?php echo "SPZ : " .  htmlspecialchars($radek["spz"]); ?></td>
						<td><?php echo "Znacka : " .  htmlspecialchars($radek["znacka"]); ?></td>
						<td><?php echo "Typ : " .  htmlspecialchars($radek["typ"]); ?></td>
						<td><?php echo "Popis : " .  htmlspecialchars($radek["popis"]); ?></td>
					</tr>
				<?php
				}
				?>
			</table>
	<?php
		}
	}
	?>

	<!--Formular-->
	<h3>Vyhledani vozidla</h3>
	<form method="POST" action="vyhledaniCelkem.php">
		<input type="text" name="spz" placeholder="spz" id="spzID"><label for="spzID">Vlozte SPZ auta.</label><br>
		<input type="text" name="znacka" placeholder="vyrobce" id="znackaID"><label for="znackaID">Vlozte znacku vyrobce auta.</label><br>
		<input type="text" name="typ" placeholder="typ" id="typID"><label for="typID">Vlozte typ auta.</label><br>
		<input type="submit" value="Vyhledat" name="odesli">
	</form>
	<?php
	mysqli_close($con);
	?>
</body>
</html>