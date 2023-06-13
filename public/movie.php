<?php

declare(strict_types=1);

use Entity\Movie;
use Html\AppWebPage;
use Entity\Exception\EntityNotFoundException;

if (!empty($_GET["movieId"]) && ctype_digit($_GET["movieId"])) {
    $movieId=(int)$_GET["movieId"];

} else {
    header("location: index.php");
    exit(302);
}

try {
    $stmt = Movie::findById($movieId);
} catch (EntityNotFoundException) {
    header('HTTP/1.0 404 Not Found');
    exit(404);
}
$appWebPage = new AppWebPage("Films - ".$stmt->getTitle());
$appWebPage->appendContent('<div class="list">');
$appWebPage->appendContent("<img src='image.php?imageId={$stmt->getPosterId()}' alt='Poster de {$stmt->getTitle()}'>");
$appWebPage->appendContent("<p>Titre : {$stmt->getTitle()}</p>");
$appWebPage->appendContent("<p>Date : {$stmt->getReleaseDate()}</p>");
$appWebPage->appendContent("<p>Nom original : {$stmt->getOriginalTitle()}</p>");
$appWebPage->appendContent("<p>Slogan : {$stmt->getTagline()}</p>");
$appWebPage->appendContent("<p>Durée : {$stmt->getRuntime()} minutes</p>");
$appWebPage->appendContent("<p>Résumé : {$stmt->getOverview()}</p>");
$appWebPage->appendContent('<div class="list_people">');

echo $appWebPage->toHTML();
