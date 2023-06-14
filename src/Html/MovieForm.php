<?php

declare(strict_types=1);

namespace Html;

use Entity\Movie;

class MovieForm
{
    use StringEscaper;
    private ?Movie $movie;

    public function __construct(?Movie $movie = null)
    {
        $this->movie = $movie;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function getHtmlForm(string $action): string
    {
        $id = $this->movie !== null ? $this->movie->getId() : '';
        $title = $this->movie !== null ? $this->movie->getTitle() : '';
        $originalTitle = $this->movie !== null ? $this->movie->getOriginalTitle() : '';
        $releaseDate = $this->movie !== null ? $this->movie->getReleaseDate() : '';
        $runtime = $this->movie !== null ? $this->movie->getRuntime() : '';
        $posterId = $this->movie !== null ? $this->movie->getPosterId() : '';
        $overview = $this->movie !== null ? $this->movie->getOverview() : '';
        $originalLanguage = $this->movie !== null ? $this->movie->getOriginalLanguage() : '';
        $tagline = $this->movie !== null ? $this->movie->getTagline() : '';

        $webPage = new AppWebPage('Ajouter un film');

        $webPage->appendContent(<<<HTML
    <form action="$action" method="post" class="movie-form">
        <input type="hidden" name="id" value="{$id}">
        <label for="title">
            Titre
            <input type="text" name="title" id="title" value="{$this->escapeString($title)}" required>
        </label>
        <label for="originalTitle">
            Titre original
            <input type="text" name="originalTitle" id="originalTitle" value="{$this->escapeString($originalTitle)}">
        </label>
        <label for="releaseDate">
            Date de sortie
            <input type="date" name="releaseDate" id="releaseDate" value="{$this->escapeString($releaseDate)}">
        </label>
        <label for="runtime">
            Durée
            <input type="number" name="runtime" id="runtime" value="{$runtime}">
        </label>
        <label for="tagline">
            Tagline
            <input type="text" name="tagline" id="tagline" value="{$this->escapeString($tagline)}">
        </label>
        <label for="originalLanguage">
            Langue originale
            <input type="text" name="originalLanguage" id="originalLanguage" value="{$this->escapeString($originalLanguage)}">
        </label>
        <label for="overview">
            Synopsis
            <textarea name="overview" id="overview">{$this->escapeString($overview)}</textarea>
        </label>
        <input type="submit" value="Enregistrer">
    </form>
HTML);

        return $webPage->toHTML();
    }

}
