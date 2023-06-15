<?php

declare(strict_types=1);

namespace Html;

use Entity\Exception\ParameterException;
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
            <input type="text" name="originalTitle" id="originalTitle" value="{$this->escapeString($originalTitle)}" required>
        </label>
        <label for="releaseDate">
            Date de sortie
            <input type="date" name="releaseDate" id="releaseDate" value="{$this->escapeString($releaseDate)}" required>
        </label>
        <label for="runtime">
            Durée
            <input type="number" name="runtime" id="runtime" value="{$runtime}" required>
        </label>
        <label for="tagline">
            Tagline
            <input type="text" name="tagline" id="tagline" value="{$this->escapeString($tagline)}" required>
        </label>
        <label for="originalLanguage">
            Langue originale
            <input type="text" name="originalLanguage" id="originalLanguage" value="{$this->escapeString($originalLanguage)}" required>
        </label>
        <label for="overview">
            Synopsis
            <textarea name="overview" id="overview" required>{$this->escapeString($overview)}</textarea>
        </label>
        <input type="submit" value="Enregistrer">
    </form>
HTML);

        return $webPage->toHTML();
    }

    /**
     * @return void
     * @throws ParameterException
     */
    public function setEntityFromQueryString(): void
    {
        if (empty($_POST['title'])) {
            throw new ParameterException('Le titre est obligatoire');
        }
        if(!empty($_POST['id']) && is_numeric($_POST['id'])) {
            $id = (int)$_POST['id'];
        } else {
            $id = null;
        }
        $this->movie = Movie::create(
            $this->stripTagsAndTrim($_POST['originalLanguage']),
            $this->stripTagsAndTrim($_POST['originalTitle']),
            $this->stripTagsAndTrim($_POST['overview']),
            $this->stripTagsAndTrim($_POST['releaseDate']),
            (int)$this->stripTagsAndTrim($_POST['runtime']),
            $this->stripTagsAndTrim($_POST['tagline']),
            $this->stripTagsAndTrim($_POST['title']),
            null,
            $id
        );
    }
}
