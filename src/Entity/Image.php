<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Image
{
    private int $id;
    private string $jpeg;
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }/**
     * @return string
     */
    public function getJpeg(): string
    {
        return $this->jpeg;
    }
    public static function findById(int $id): Image
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
SELECT *
FROM image
WHERE id=:id;
SQL
        );
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, Image::class);
        $res = $stmt->fetch();
        if (!$res) {
            throw new EntityNotFoundException();
        }
        return $res;
    }

}
