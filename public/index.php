<?php

declare(strict_types=1);
use Database\MyPdo;
use Html\AppWebPage;

require_once '../vendor/autoload.php';

$appWebPage = new AppWebPage('tests');
$appWebPage->appendCssUrl('css/style.css');



echo $appWebPage->toHTML();
