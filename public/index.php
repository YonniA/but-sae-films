<?php

declare(strict_types=1);
use Database\MyPdo;
use Html\AppWebPage;

require_once '../vendor/autoload.php';

$appWebPage = new AppWebPage('tests');
$stmt = (new Entity\Collection\MovieCollection())->findAll();
$appWebPage->appendCssUrl('css/style.css');
$appWebPage->appendContent('<div class="list">');
for ($i=0;$i<count($stmt);++$i) {
    $appWebPage->appendContent("<a class='movie' href='movie.php?movieId={$stmt[$i]->getId()}'>"."<p>".$appWebPage->escapeString("{$stmt[$i]->getTitle()}")."</p>"."</a>");
}
$appWebPage->appendContent('</div>');

echo $appWebPage->toHTML();
