<?php
declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Genre
{
    private int $id;
    private string $name;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public static function findById(int $id): Genre
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
SELECT *
FROM genre
WHERE id = :id
SQL
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, Genre::class);
        $res = $stmt->fetch();
        if (!$res) {
            throw new EntityNotFoundException();
        }
        return $res;
    }
    public function getMovies(): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
SELECT DISTINCT m.*
FROM movie m
    JOIN movie_genre mg on m.id = mg.movieId
WHERE mg.genreId = :id
ORDER BY m.title
SQL
        );
        $stmt->bindValue(':id', $this->getId(), PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, Movie::class);
    }

}
