<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Movie
{
    private int $id;
    private int $posterId;
    private string $originalLanguage;
    private string $originalTitle;
    private string $overview;
    private string $releaseDate;
    private int $runtime;
    private string $tagline;
    private string $title;
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }/**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }/**
     * @return int
     */
    public function getPosterId(): int
    {
        return $this->posterId;
    }/**
     * @return string
     */
    public function getOriginalLanguage(): string
    {
        return $this->originalLanguage;
    }/**
     * @return string
     */
    public function getOriginalTitle(): string
    {
        return $this->originalTitle;
    }/**
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }/**
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }/**
     * @return int
     */
    public function getRuntime(): int
    {
        return $this->runtime;
    }/**
     * @return string
     */
    public function getTagline(): string
    {
        return $this->tagline;
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
