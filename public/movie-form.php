<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\Movie;
use Html\MovieForm;

try {
    if (!isset($_GET['movieId'])) {
        $movie = null;
    } else {
        if (!(is_numeric($_GET['movieId']))) {
            throw new ParameterException("Parameter movieId should be an integer");
        } else {
            $movie = Movie::findById((int)$_GET['movieId']);
        }
    }

    $form = new MovieForm($movie);
    echo $form->getHtmlForm('movie-save.php');

} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
