<?php

declare(strict_types=1);
use Database\MyPdo;
use Html\AppWebPage;

require_once '../vendor/autoload.php';

$appWebPage = new AppWebPage('Films');
$stmt = (new Entity\Collection\MovieCollection())->findAll();
$appWebPage->appendContent('<div class="list">');
for ($i=0;$i<count($stmt);++$i) {
    $appWebPage->appendContent("<a class='movie' href='movie.php?movieId={$stmt[$i]->getId()}'>");
    if ($stmt[$i]->getPosterId() !== null) {
        $appWebPage->appendContent("<img src='image.php?imageId={$stmt[$i]->getPosterId()}' alt='Poster de {$stmt[$i]->getTitle()}'>");
    } else {
        $appWebPage->appendContent("<img src='img/movie.png' alt='Poster de {$stmt[$i]->getTitle()}'>");
    }
    $appWebPage->appendContent("<p>".$appWebPage->escapeString("{$stmt[$i]->getTitle()}")."</p>"."</a>");
}
$appWebPage->appendContent('</div>');

echo $appWebPage->toHTML();
