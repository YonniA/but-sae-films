<?php

declare(strict_types=1);

namespace Entity;

class Movie
{
    private int $id;
    private string $name;
    private int $posterId;
    private string $originalLanguage;
    private string $originalTitle;
    private string $overview;
    private string $releaseDate;
    private int $runtime;
    private string $tagline;
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }/**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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


}
