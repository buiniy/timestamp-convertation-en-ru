<?php

include '../TimeCorrector.php';

$new = new TimeCorrector();

// Доступные запросы

//$new->getConvertFormat(3601); // 1 час и 1 секунда
//$new->getConvertFormat(35061, 1); // 9 часов 44 минуты, 21 секунда назад
//$new->getConvertFormat(0); // Сейчас

$new->getConvertFormat(35061, 1);
?>