<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tugas AI Perception</title>

	<link href="bootstrap.min.css" rel="stylesheet">
</head>
<style type="text/css">
	body {
		
	}


	td,th {
		padding: 5px;
	}

	
	.form {
		background: #D2D7D3;
		height: 500px;

	}
	.tombol {
		background: #eee;
	}
</style>
<body>
<center>
	<div class="form">
<form action="" method="post" role="form">
<div class="col-md-6">
<h2>Input Bobot dan bias</h2>
	<table class="table table-bordered" id="input">
		<tr>
			<td>W1</td>
			<td><input class="form-control" type="text" name="w1" value="<?=number_format(-0.5+lcg_value()*(abs(-0.5-0.5)),1)?>"></td>
		</tr>
		<tr>
			<td>W2</td>
			<td><input class="form-control" type="text" name="w2" value="<?=number_format(-0.5+lcg_value()*(abs(-0.5-0.5)),1)?>"></td>
		</tr>
		<tr>
			<td>Treshold</td>
			<td><input class="form-control" type="text" name="treshold"></td>
		</tr>
		<tr>
			<td>n</td>
			<td><input class="form-control" type="text" name="lr"></td>
		</tr>

	</table>
	</div>
	
	<div class="col-md-6">
	<h2>Pilih Fungsi Logika</h2>
	<table class="table table-bordered" id="fungsi">

		<tr>
			<td>
			<div class="radio">
			  <label>
			    <input type="radio" name="fungsi" id="optionsRadios1" value="and">
				AND
			  </label>
			</div>
			</td>
		</tr>
		<tr>
			<td>
				<div class="radio">
			  <label>
			    <input type="radio" name="fungsi" id="optionsRadios1" value="or">
				OR
			  </label>
			</div>
			</td>
		</tr>
		<tr>
			<td>
				<div class="radio">
			  <label>
			    <input type="radio" name="fungsi" id="optionsRadios1" value="xor">
				XOR
			  </label>
			</div>
			</td>
		</tr>
		<tr>
			<td>
				<div class="radio">
			  <label>
			    <input type="radio" name="fungsi" id="optionsRadios1" value="xnor">
				XNOR
			  </label>
			</div>
			</td>
		</tr>
	</table>
	
	</div>
	<div class="col-md-12">
	<button class="btn btn-large btn-success">Uji</button>
	</div>

</form>

</div>
</center>

<?php
	if (isset($_POST['w1'],$_POST['w2'],$_POST['treshold'],$_POST['lr'],$_POST['fungsi'])) {
		if (!empty($_POST['w1']) || !empty($_POST['w2']) || !empty($_POST['treshold']) || !empty($_POST['lr']) || !empty($_POST['fungsi'])) {
			
			// inisiasi
			$iterasi = 0;
			$p1 = array(0,0,1,1);
			$p2 = array(0,1,0,1);
			$w1 = array($_POST['w1']);
			$w2 = array($_POST['w2']);
			$treshold = $_POST['treshold'];
			$lr = $_POST['lr'];
			$fungsi = $_POST['fungsi'];
			$a = array ();
			$n = array ();
			$e = array ();
			$dw1 = array ();
			$dw2 = array ();

			// fungsi
			if($fungsi == 'and') {
				$target = array(0,0,0,1);
			} elseif ($fungsi == 'or') {
				$target = array(0,1,1,1);
			} elseif ($fungsi == 'xnor') {
				$target = array(1,0,0,1);
			} elseif($fungsi == 'xor') {
				$target = array(0,1,1,0);
			}



			// table
			?>
			<div class="container-fluid">
				
			<h2>Hasil Learning</h2>
				<table class="table table-bordered">
					<tr>
						<th>p1</th>
						<th>p2</td>
						<th>t</th>
						<th>n</th>
						<th>a=f(n)</th>
						<th>Delta w1</th>
						<th>Delta w2</th>
						<th>Error</th>
						<th>w1</th>
						<th>w2</th>
					</tr>
			<?php

			// pengulangan mencari target
		for ($i=0; $i <= 3 ; $i++) {
			$iterasi = $i;
		do{
			// menghitung nilai n
			$pw1 = ($p1[$i])*($w1[$iterasi]);
			$pw2 = ($p2[$i])*($w2[$iterasi]);
			$n[$i] = $pw1 + $pw2 - $treshold;

			// menentukan nilai a
			if($n[$i] >= 0) {
				$a[$i] = 1;
			} elseif ($n[$i] < 0) {
				$a[$i] = 0;
			}

			// menghitung error
			$e[$i] = $target[$i] - $a[$i];

			// megatur bobot
				// mengupdate bobot perceptron
			$dw1[$i] = $lr * $p1[$i] * $e[$i];
			$dw2[$i] = $lr * $p2[$i] * $e[$i];

			$w1[$iterasi+1] = $w1[$iterasi] + $dw1[$i];
			$w2[$iterasi+1] = $w2[$iterasi] + $dw2[$i];

		$iterasi++;


		if($a[$i] == $target[$i]) {
			?>
			<tr >
						<td><?=$p1[$i]?></td>
						<td><?=$p2[$i]?></td>
						<td><?=$target[$i]?></td>
						<td><?=$n[$i]?></td>
						<td><?=$a[$i]?></td>
						<td><?=$dw1[$i]?></td>
						<td><?=$dw2[$i]?></td>
						<td><?=$e[$i]?></td>
						<td><?=$w1[$i]?></td>
						<td><?=$w2[$i+1]?></td>
					</tr>
				
		<?php
			break;
		} else {
			?>
			<tr bgcolor="#E08283">
						<td><?=$p1[$i]?></td>
						<td><?=$p2[$i]?></td>
						<td bgcolor="#D64541"><?=$target[$i]?></td>
						<td><?=$n[$i]?></td>
						<td bgcolor="#D64541"><?=$a[$i]?></td>
						<td><?=$dw1[$i]?></td>
						<td><?=$dw2[$i]?></td>
						<td><?=$e[$i]?></td>
						<td><?=$w1[$i]?></td>
						<td><?=$w2[$i+1]?></td>
					</tr>
				
		<?php
		}
		}while($a != $target);
			
					

	}	
	echo '</table></div>';

		} else {
			echo "Isi Yang lengkap";
		}
	}
?>

</body>
</html>