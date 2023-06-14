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
$appWebPage->appendContent(<<<HTML
            <div class="list">
                <div class="movie-description">
                    <img src='image.php?imageId={$stmt->getPosterId()}' alt='Poster de {$stmt->getTitle()}'>
                    <div class="text">
                        <div class="text__header">
                            <p>Titre : {$stmt->getTitle()}</p>
                            <p>Date : {$stmt->getReleaseDate()}</p>
                    </div>
                    <p>Nom original : {$stmt->getOriginalTitle()}</p>
                    <p>Slogan : {$stmt->getTagline()}</p>
                    <p>Durée : {$stmt->getRuntime()} minutes</p>
                    <p>Résumé : {$stmt->getOverview()}</p>
                </div>
            </div>
            <div class="people-list">
            HTML);
$casts = $stmt->getCast();
foreach ($casts as $cast) {
    $people = People::findById($cast->getPeopleId());
    $appWebPage->appendContent(<<<HTML
                            <a class='people-list__people' href='people.php?peopleId={$cast->getPeopleId()}'>
                                <img src='image.php?imageId={$people->getAvatarId()} alt='{$people->getName()}'>
                                <div class="text">
                                    <p>Rôle : {$appWebPage->escapeString($cast->getRole())}</p><p>Nom : {$appWebPage->escapeString($people->getName())}</p>
                                </div>
                            </a>
HTML);
}

$appWebPage->appendContent('</div></div>');
echo $appWebPage->toHTML();
