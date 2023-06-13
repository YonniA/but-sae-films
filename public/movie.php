<?php
declare(strict_types=1);

use Entity\Movie;
use Html\AppWebPage;
use Entity\Exception\EntityNotFoundException;

if (!empty($_GET["artistId"]) && ctype_digit($_GET["artistId"])) {
    $artistId=(int)$_GET["artistId"];

} else {
    header("location: index.php");
    exit(302);
}

try {
    $stmt = Movie::findById($artistId);
} catch (EntityNotFoundException) {
    header('HTTP/1.0 404 Not Found');
    exit(404);
}
echo 'test';
