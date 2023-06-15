<?php

declare(strict_types=1);

use Entity\Collection\GenreCollection;
use Entity\Collection\MovieCollection;
use Entity\Genre;
use Html\AppWebPage;

require_once '../vendor/autoload.php';

if (isset($_GET['genre']) && $_GET['genre'] !== '') {
    $genreId = (int)$_GET['genre'];
    $genre = Genre::findById($genreId);
    $stmt = $genre->getMovies();
    $title = " - {$genre->getName()}";
} else {
    $stmt = MovieCollection::findAll();
    $title = '';
}
$appWebPage = new AppWebPage('Films');
$appWebPage->appendContent(
    <<<HTML
    <div class="navbar">
        <form action="index.php" method="get">
            <select name="genre">
                <option value="">Tous les genres</option>
HTML
);
$genres = GenreCollection::findAll();
foreach ($genres as $genre) {
    $appWebPage->appendContent("<option value='{$genre->getId()}'>{$appWebPage->escapeString($genre->getName())}</option>");
}
$appWebPage->appendContent(<<<HTML
            </select>
            <input type="submit" value="Rechercher">
        </form>
        <a href="movie-form.php" class="btn">Ajouter un film</a>
    </div>  
HTML);
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
