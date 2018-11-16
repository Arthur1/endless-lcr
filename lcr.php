<?php

$chips = [3, 3, 3, 3];
$order = 0;
$trials = 0;

echo 'Welcome to the Endress LCR!!' . "\n";
usleep(500000);

while (true) {
	echo "\033[;H\033[2J"; // clear
	$str = 'Player' . ($order + 1) . ' ';
	if ($chips[$order] !== 0) { // 手番が来る時
		$trials++;
		for ($i = 0; $i < 3 and $i < $chips[$order]; $i++) {
			$dice = random_int(0, 5);
			switch ($dice) {
				case 1: // L
					$str .= 'L ';
					$chips[$order]--;
					$chips[($order + 1) % 4]++;
					break;
				case 3: // C
					$str .= 'C ';
					$chips[$order]--;
					$chips[($order + 2) % 4]++;
					break;
				case 5: // R
					$str .= 'R ';
					$chips[$order]--;
					$chips[mod($order - 1, 4)]++;
					break;
				default:
					$str .= '･ ';
					break;
			}
		}
		$str .= "\n";
	} else { // passのとき
		$str .= "pass\n";
	}
	for ($i = 0; $i < 4; $i++) {
		$str .= ($i + 1) . ': ';
		for ($j = 0; $j < $chips[$i]; $j++) {
			$str .= '|';
		}
		$str .= "\n";
	}
	echo $str;
	if (max($chips) === 20) break;
	$order = ($order + 1) % 4;
	usleep(500000);
}

echo 'Finish!' . $trials . "\n";

function mod($i, $j) {
	return ($i % $j) < 0 ? ($i % $j) + 0 + ($j < 0 ? -$j : $j) : ($i % $j + 0);
}