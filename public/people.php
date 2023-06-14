<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Movie;
use Entity\People;
use Html\AppWebPage;

if (!empty($_GET["peopleId"]) && ctype_digit($_GET["peopleId"])) {
    $peopleId=(int)$_GET["peopleId"];

} else {
    header("location: index.php");
    exit(302);
}

try {
    $stmt = People::findById($peopleId);
} catch (EntityNotFoundException) {
    header('HTTP/1.0 404 Not Found');
    exit(404);
}
$appWebPage = new AppWebPage("Films - {$stmt->getName()}");
$appWebPage->appendContent('<div class="list">');
$appWebPage->appendContent('<div class="people-description">');
$appWebPage->appendContent("<img src='image.php?imageId={$stmt->getAvatarId()}' alt='{$stmt->getName()}'>");
$appWebPage->appendContent('<div class="text">');
$appWebPage->appendContent("<p>Nom : {$stmt->getName()}</p>");
$appWebPage->appendContent("<p>Lieu de naissance : {$stmt->getPlaceOfBirth()}</p>");
$appWebPage->appendContent("<p>Date : {$stmt->getBirthday()} - {$stmt->getDeathday()}</p>");
$appWebPage->appendContent("<p>Biographie : {$stmt->getBiography()}</p>");
$appWebPage->appendContent('</div>');
$appWebPage->appendContent('</div>');
$appWebPage->appendContent('<div class="movie-list">');
$casts = $stmt->getCast();
foreach ($casts as $cast) {
    $movie = Movie::findById($cast->getMovieId());
    $appWebPage->appendContent("<a class='movie-list__movie' href='movie.php?movieId={$cast->getMovieId()}'>"."\n");
    $appWebPage->appendContent("<img src='image.php?imageId={$movie->getPosterId()} alt='{$movie->getTitle()}'>"."\n");
    $appWebPage->appendContent('<div class="text">');
    $appWebPage->appendContent("<p>Titre : {$appWebPage->escapeString($movie->getTitle())}</p><p>Date : {$appWebPage->escapeString($movie->getReleaseDate())}</p>"."\n");
    $appWebPage->appendContent('</div>');
    $appWebPage->appendContent("<p>Rôle de l'acteur : {$appWebPage->escapeString($cast->getRole())}</p>");
    $appWebPage->appendContent("</a>");




}




echo $appWebPage->toHTML();
