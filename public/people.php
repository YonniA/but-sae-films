<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\People;
use Html\AppWebPage;

if (!empty($_GET["peopleId"]) && ctype_digit($_GET["peopleId"])) {
    $peopleId=(int)$_GET["peopleId"];

} else {
    header("location: index.php");
    exit(302);
}

try {
    $stmt = People::findById($peopleId);
} catch (EntityNotFoundException) {
    header('HTTP/1.0 404 Not Found');
    exit(404);
}
$appWebPage = new AppWebPage("Films - {$stmt->getName()}");
$appWebPage->appendContent('<div class="list">');
$appWebPage->appendContent("<img src='image.php?imageId={$stmt->getAvatarId()}' alt='{$stmt->getName()}'>");
$appWebPage->appendContent("<p>Nom : {$stmt->getName()}</p>");
$appWebPage->appendContent("<p>Lieu de naissance : {$stmt->getPlaceOfBirth()}</p>");
$appWebPage->appendContent("<p>Date : {$stmt->getBirthday()} - {$stmt->getDeathday()}</p>");
$appWebPage->appendContent("<p>Biographie : {$stmt->getBiography()}</p>");
$appWebPage->appendContent('<div class="list_movie">');

echo $appWebPage->toHTML();
