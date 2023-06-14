<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Movie;
use PDO;

class MovieCollection
{
    /** permet de trouver et de mettre dans une instance les films trouvés
    * @return Movie[]
     */
    public function findAll(): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
SELECT *
FROM movie
ORDER BY title
SQL
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, Movie::class);

    }
}
