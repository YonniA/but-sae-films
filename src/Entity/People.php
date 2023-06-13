<?php
declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class People
{
    private ?int $avatarId;
    private ?string $birthday;
    private ?string $deathday;
    private string $name;
    private string $biography;
    private string $placeOfBirth;
    private int $id;

    /**
     * @return int
     */
    public function getAvatarId(): ?int
    {
        return $this->avatarId;
    }

    /**
     * @return int
     */
    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    /**
     * @return int
     */
    public function getDeathday(): ?string
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
    public static function findById(int $id): People
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
SELECT *
FROM people
WHERE id = :id;
SQL
        );
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, People::class);
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
WHERE peopleId = :id
SQL
        );
        $stmt->bindValue(':id', $this->getId(), PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, Cast::class);
    }
}