<?php
declare(strict_types=1);

namespace Entity;

class People
{
    private int $avatarId;
    private int $birthday;
    private int $deathday;
    private string $name;
    private string $biography;
    private string $placeOfBirth;
    private int $id;

    /**
     * @return int
     */
    public function getAvatarId(): int
    {
        return $this->avatarId;
    }

    /**
     * @return int
     */
    public function getBirthday(): int
    {
        return $this->birthday;
    }

    /**
     * @return int
     */
    public function getDeathday(): int
    {
        return $this->deathday;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getBiography(): string
    {
        return $this->biography;
    }

    /**
     * @return string
     */
    public function getPlaceOfBirth(): string
    {
        return $this->placeOfBirth;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


}