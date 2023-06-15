<?php
declare(strict_types=1);

namespace Entity;

class MovieGenre
{
    private int $movieId;
    private int $genreId;

    /**
     * @return int
     */
    public function getMovieId(): int
    {
        return $this->movieId;
    }

    /**
     * @return int
     */
    public function getGenreId(): int
    {
        return $this->genreId;
    }

}
