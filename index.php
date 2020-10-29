<!DOCTYPE html>
<html>

<head>
	<title>Leitor de xml</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
	<div style="text-align: center;">
		<h1>Leitor de xml</h1>
	</div>

	<div style="text-align: left;">

		<form style="text-align: center;" enctype="multipart/form-data" action="" method="POST">
			Enviar esse arquivo: <input style="display: inline-block;" name="userfile" type="file" />
			<input style="margin-top: 10px;" type="submit" value="enviar" name="enviar"/>
		</form>
	</div>

	<?php
	if(isset($_POST['enviar']))
	{
		$allowed = array('xml');
		$filename = $_FILES['userfile']['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if (!in_array($ext, $allowed)) {
			$message = "O arquivo não é xml!";
			echo "<script type='text/javascript'>alert('$message');</script>";
			$xml = null;
		} else {
			$uploaddir = 'upload/';
			$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
	
	
			move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
	
	
			$xml = simplexml_load_file($uploaddir . $_FILES['userfile']['name']);
		}
	} 

	?>

	<div class="body">
		<table class="table table-bordered table-striped table-hover js-basic-example" style="font-size:12px" id="consulta_xml" name="consulta_xml">
			<thead>
				<tr style="height: 50px;">
					<th><b>TAG</b></th>
					<th><b>VALOR</b></th>
				</tr>
			</thead>
			<tbody>

				<?php
				if (isset($_POST['enviar'])) {
					RecurseXML($xml);
				}
				function RecurseXML($xml, $parent = "")
				{
					if ($xml != null) {
						$uploaddir = 'upload/';
						$root = simplexml_load_file($uploaddir . $_FILES['userfile']['name']);
						$child_count = 0;
						//print_r("'.$root.'");

						foreach ($xml as $key => $value) {

							//$child_count++;
							if (RecurseXML($value, $parent . "/" . $key) == 0) {

								//print($parent . "/" . (string)$key . " = " . (string)$value . "<BR>\n");
								echo '<tr>
							<td>' . $root->getName() . '' . $parent . '/' . (string)$key . '</td>
							<td>
							  "' . (string)$value . '"
							</td>
						  </tr>';
							}
						}

						//return $child_count;
					}
				}

				?>
			</tbody>
		</table>
	</div>

</body>

</html>
<link rel="stylesheet" type="text/css" href="scripts/DataTables/datatables.min.css">

<script type="text/javascript" charset="utf8" src="scripts/DataTables/datatables.min.js"></script>

<script>
	$(document).ready(function() {
		$('#consulta_xml').DataTable({
			"order": []
		});
	});
</script>