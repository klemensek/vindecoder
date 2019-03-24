<?php
require_once('vendor/autoload.php');
header ('Content-type: application/json; charset=utf-8');
use Sunra\PhpSimple\HtmlDomParser;

$e = $_SERVER["HTTP_HOST"] . "/parseVin.php?vin=WBABG21030ET13882";
if (empty($_GET["vin"])) {
    die("missing vin:
    $e
    ");
}

$url = 'https://www.vindecoder.pl/' . $_GET["vin"];
//$url = 'https://www.mdecoder.com/decode/' . $_GET["vin"];

//$url = "f.html";
$file = file_get_contents($url);
//file_put_contents("f.html", $file);

$dom = HtmlDomParser::str_get_html($file);
$res = array();

$elems = $dom->find('.table-two-col tr');
foreach ($elems as $elem) {
    $th = $elem->find("th");
    $td = $elem->find("td");
    $rv = new \stdClass();
    if ($th) {
        $rv->r = $th[0]->innertext();
    }
    if ($td) {
        $rv->v = $td[0]->innertext();
    }
    $res[] = $rv;
}
echo json_encode($res);