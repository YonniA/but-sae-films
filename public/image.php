<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\Image;

try {
    if(isset($_GET['imageId'])) {
        throw new ParameterException();
    }
    $image = Image::findById($_GET['imageId']);
    echo $image->getJpeg();
    header('Content-type : image/jpeg');
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
