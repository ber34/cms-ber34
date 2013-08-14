<?php
$czas_stop = (float)microtime();
$czas1 = $czas_stop-$czas_start;
$czas2 = round($czas1, 2);
?>
<div class="stopka">
Stopka<br/>
<mark style="margin: 0 0 0.01% 33.0%;">Strona została wygenerowana w <?php echo  $czas2;?> sek.</mark>
