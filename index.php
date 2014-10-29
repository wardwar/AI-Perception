<!DOCTYPE html>
<html>
<head>
	<title>Tugas AI Perception</title>
</head>
<style type="text/css">
	table {
		border-collapse: collapse;
		margin: 10px;
	}

	td,th {
		padding: 5px;
	}
</style>
<body>

<form action="" method="post" name="inisiasi">
	<table border="1">
		<tr>
			<td>W1</td>
			<td><input type="text" name="w1" value="<?=rand(-0.5,0.5)?>"></td>
		</tr>
		<tr>
			<td>W2</td>
			<td><input type="text" name="w2"></td>
		</tr>
		<tr>
			<td>Treshold</td>
			<td><input type="text" name="treshold"></td>
		</tr>
		<tr>
			<td>n</td>
			<td><input type="text" name="lr"></td>
		</tr>

	</table>

	<table border="1">
		<tr>
			<td><input type="radio" name="fungsi" id="and" value="and"><label for="and">AND</label></td>
		</tr>
		<tr>
			<td><input type="radio" name="fungsi" id="or" value="or"><label for="and">OR</label></td>
		</tr>
		<tr>
			<td><input type="radio" name="fungsi" id="xor" value="xor"><label for="xor">XOR</label></td>
		</tr>
		<tr>
			<td><input type="radio" name="fungsi" id="xnor" value="xnor"><label for="xnor">XNOR</label></td>
		</tr>
	</table>

	<input type="submit" value="Uji">

</form>

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
			} else {
				$target = array(0,1,1,0);
			}
	

		do{
			// table
			?>
				<table border="1">
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
			$pw1 = ($p1[$i]*1)*($w1[$iterasi]*1);
			$pw2 = ($p2[$i]*1)*($w2[$iterasi]*1);
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
			break;
		}
		}while($a != $target);
			?>
			<tr>
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
					

	}	
	echo '</table>';
}while ($a != $target);

		} else {
			echo "Isi Yang lengkap";
		}
	}
?>

</body>
</html>