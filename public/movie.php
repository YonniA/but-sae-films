<?php

declare(strict_types=1);

use Entity\Movie;
use Entity\People;
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
$appWebPage->appendContent('<div class="movie-description">');
$appWebPage->appendContent("<img src='image.php?imageId={$stmt->getPosterId()}' alt='Poster de {$stmt->getTitle()}'>");
$appWebPage->appendContent('<div class="text">');
$appWebPage->appendContent('<div class="text__header">');
$appWebPage->appendContent("<p>Titre : {$stmt->getTitle()}</p>");
$appWebPage->appendContent("<p>Date : {$stmt->getReleaseDate()}</p>");
$appWebPage->appendContent('</div>');
$appWebPage->appendContent("<p>Nom original : {$stmt->getOriginalTitle()}</p>");
$appWebPage->appendContent("<p>Slogan : {$stmt->getTagline()}</p>");
$appWebPage->appendContent("<p>Durée : {$stmt->getRuntime()} minutes</p>");
$appWebPage->appendContent("<p>Résumé : {$stmt->getOverview()}</p>");
$appWebPage->appendContent('</div>');
$appWebPage->appendContent('</div>');
$appWebPage->appendContent('<div class="people-list">');
$casts = $stmt->getCast();
foreach ($casts as $cast) {
    $people = People::findById($cast->getPeopleId());
    $appWebPage->appendContent("<a class='people-list__people' href='people.php?peopleId={$cast->getPeopleId()}'>"."\n");
    $appWebPage->appendContent("<img src='image.php?imageId={$people->getAvatarId()} alt='{$people->getName()}'>"."\n");
    $appWebPage->appendContent('<div class="text">');
    $appWebPage->appendContent("<p>Rôle : {$appWebPage->escapeString($cast->getRole())}</p><p>Nom : {$appWebPage->escapeString($people->getName())}</p>"."\n");
    $appWebPage->appendContent('</div>');
    $appWebPage->appendContent("</a>");
}

$appWebPage->appendContent('</div></div>');
echo $appWebPage->toHTML();
