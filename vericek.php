<?php
function curl($url, $post=false)
{
    $user_agent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; tr; rv:1.9.0.6) Gecko/2009011913 Firefox/3.0.6';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, $post ? true : false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post ? $post : false);
    curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
    $icerik = curl_exec($ch);
    curl_close($ch);
    return $icerik;
}

function parcala_ve_al($bas, $son, $yazi)
{
    @preg_match_all('/' . preg_quote($bas, '/') .
        '(.*?)'. preg_quote($son, '/').'/i', $yazi, $m);
    return @$m[1];
}


$site = "https://www.ventusky.com/panel.php?link=39.956;33.094";
$icerik = curl($site);
$sicaklik = parcala_ve_al('<td class="temperature">
                        ', ' &deg;C                    </td>', $icerik);
$ilerisicak = parcala_ve_al('<b class="teplota">', ' &deg;C</b> <br>', $icerik);


?>