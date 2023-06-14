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
$appWebPage->appendContent(<<<HTML
            <a class='accueil' href="index.php">
                <?xml version="1.0" ?><svg enable-background="new 0 0 32 32" id="Glyph" height="24" width="24" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M30.854,16.548C30.523,17.43,29.703,18,28.764,18H28v11c0,0.552-0.448,1-1,1h-6v-7c0-2.757-2.243-5-5-5  s-5,2.243-5,5v7H5c-0.552,0-1-0.448-1-1V18H3.235c-0.939,0-1.759-0.569-2.09-1.451c-0.331-0.882-0.088-1.852,0.62-2.47L13.444,3.019  c1.434-1.357,3.679-1.357,5.112,0l11.707,11.086C30.941,14.696,31.185,15.666,30.854,16.548z" id="XMLID_219_"/></svg>
            </a>
            <div class="list">
                <div class="people-description">
                    <img src='image.php?imageId={$stmt->getAvatarId()}' alt='{$stmt->getName()}'>
                    <div class="text">
                        <p>Nom : {$stmt->getName()}</p>
                        <p>Lieu de naissance : {$stmt->getPlaceOfBirth()}</p>
                        <p>Date : {$stmt->getBirthday()} - {$stmt->getDeathday()}</p>
                        <p>Biographie : {$stmt->getBiography()}</p>
                    </div>
                </div>
            <div class="movie-list">
            HTML);
$casts = $stmt->getCast();
foreach ($casts as $cast) {
    $movie = Movie::findById($cast->getMovieId());
    $appWebPage->appendContent(<<<HTML
            <a class='movie-list__movie' href='movie.php?movieId={$cast->getMovieId()}'>
                <img src='image.php?imageId={$movie->getPosterId()} alt='{$movie->getTitle()}'>
                <div class="text">
                    <p>Titre : {$appWebPage->escapeString($movie->getTitle())}</p>
                    <p>Date : {$appWebPage->escapeString($movie->getReleaseDate())}</p>
                </div>
                <p>Rôle de l'acteur : {$appWebPage->escapeString($cast->getRole())}</p>
            </a>
            HTML);

}
$appWebPage->appendContent('</div>');
echo $appWebPage->toHTML();
