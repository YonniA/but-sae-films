<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Movie
{
    private ?int $id;
    private ?int $posterId;
    private ?string $originalLanguage;
    private ?string $originalTitle;
    private ?string $overview;
    private ?string $releaseDate;
    private ?int $runtime;
    private ?string $tagline;
    private ?string $title;
    private function __construct()
    {
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Movie
     */
    public function setId(?int $id): Movie
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPosterId(): ?int
    {
        return $this->posterId;
    }

    /**
     * @param int|null $posterId
     * @return Movie
     */
    public function setPosterId(?int $posterId): Movie
    {
        $this->posterId = $posterId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOriginalLanguage(): ?string
    {
        return $this->originalLanguage;
    }

    /**
     * @param string|null $originalLanguage
     * @return Movie
     */
    public function setOriginalLanguage(?string $originalLanguage): Movie
    {
        $this->originalLanguage = $originalLanguage;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOriginalTitle(): ?string
    {
        return $this->originalTitle;
    }

    /**
     * @param string|null $originalTitle
     * @return Movie
     */
    public function setOriginalTitle(?string $originalTitle): Movie
    {
        $this->originalTitle = $originalTitle;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOverview(): ?string
    {
        return $this->overview;
    }

    /**
     * @param string|null $overview
     * @return Movie
     */
    public function setOverview(?string $overview): Movie
    {
        $this->overview = $overview;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getReleaseDate(): ?string
    {
        return $this->releaseDate;
    }

    /**
     * @param string|null $releaseDate
     * @return Movie
     */
    public function setReleaseDate(?string $releaseDate): Movie
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getRuntime(): ?int
    {
        return $this->runtime;
    }

    /**
     * @param int|null $runtime
     * @return Movie
     */
    public function setRuntime(?int $runtime): Movie
    {
        $this->runtime = $runtime;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTagline(): ?string
    {
        return $this->tagline;
    }

    /**
     * @param string|null $tagline
     * @return Movie
     */
    public function setTagline(?string $tagline): Movie
    {
        $this->tagline = $tagline;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return Movie
     */
    public function setTitle(?string $title): Movie
    {
        $this->title = $title;
        return $this;
    }
    public static function findById(int $id): Movie
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
SELECT *
FROM movie
WHERE id = :id;
SQL
        );
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, Movie::class);
        $res = $stmt->fetch();
        if (!$res) {
            throw new EntityNotFoundException();
        }
        return $res;
    }
    public function getCast(): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
SELECT *
FROM cast
WHERE movieId = :id
SQL
        );
        $stmt->bindValue(':id', $this->getId(), PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, Cast::class);
    }
}
