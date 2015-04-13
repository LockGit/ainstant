<?php

$abc = '<p>在重庆，小面从来都不是登大雅之堂的美味。印象里，吃小面总是作为匆忙赶路的凑合之举，或早起上班</p><p><br></p><p>摊主总是兼任老板、账房、伙计：他们站在路边招呼着食客赶紧坐下，殷勤地问要味重面硬的干溜</p>';

echo $abc;

$replacement = '/(<p><br><\/p>)/';

$aaa = preg_replace($replacement, '', $abc);

echo $aaa;
?>