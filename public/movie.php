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
                <a class='accueil' href="index.php">
                    <?xml version="1.0" ?><svg enable-background="new 0 0 32 32" id="Glyph" height="24" width="24" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M30.854,16.548C30.523,17.43,29.703,18,28.764,18H28v11c0,0.552-0.448,1-1,1h-6v-7c0-2.757-2.243-5-5-5  s-5,2.243-5,5v7H5c-0.552,0-1-0.448-1-1V18H3.235c-0.939,0-1.759-0.569-2.09-1.451c-0.331-0.882-0.088-1.852,0.62-2.47L13.444,3.019  c1.434-1.357,3.679-1.357,5.112,0l11.707,11.086C30.941,14.696,31.185,15.666,30.854,16.548z" id="XMLID_219_"/></svg>
                </a>
                <div class="navbar">
                    <a href="movie-form.php?movieId={$stmt->getId()}" class="btn">Modifier</a>
                    <a href="movie-delete.php?movieId={$stmt->getId()}" class="btn">Supprimer</a>
                </div>
                <div class="list">
                 
                    <div class="movie-description">
                HTML);
if ($stmt->getPosterId() !== null) {
    $appWebPage->appendContent("<img src='image.php?imageId={$stmt->getPosterId()}' alt='Poster de {$stmt->getTitle()}'>");
} else {
    $appWebPage->appendContent("<img src='img/movie.png' alt='Poster de {$stmt->getTitle()}'>");
}
$appWebPage->appendContent(<<<HTML
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
    $appWebPage->appendContent("<a class='people-list__people' href='people.php?peopleId={$cast->getPeopleId()}'>");

    if ($people->getAvatarId() !== null) {
        $appWebPage->appendContent("<img src='image.php?imageId={$people->getAvatarId()}' alt='{$people->getName()}'>");
    } else {
        $appWebPage->appendContent("<img src='img/actor.png' alt='{$people->getName()}'>");
    }
    $appWebPage->appendContent(<<<HTML
                    <div class="text">
                        <p>Rôle : {$appWebPage->escapeString($cast->getRole())}</p>
                        <p>Nom : {$appWebPage->escapeString($people->getName())}</p>
                    </div>
                </a>
HTML);
}

$appWebPage->appendContent('</div>');
echo $appWebPage->toHTML();
