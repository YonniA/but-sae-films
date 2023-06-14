<?php

declare(strict_types=1);

namespace Html;

class AppWebPage extends WebPage
{
    public function __construct(string $title="")
    {
        parent::__construct($title);
        $this->appendCssUrl("/css/style.css");
    }

    public function toHTML(): string
    {
        return <<<HTML
            <!doctype html>
            <html lang="fr">
            <head>
                <title>{$this->getTitle()}</title>
                <meta name="viewport" content="width=device-width, initial-scale=1" />
                <meta charset="UTF-8">
                <link rel="shortcut icon" href="img/favicon.ico">
                {$this->getHead()}
            </head>
            <body>
                <header class="header">
                    <h1>{$this->getTitle()}</h1>
                </header>
                
                <div class="content">
                    {$this->getBody()}
                </div>
                <footer class="footer">{$this->getLastModification()}</footer>
            
            
            </body>
            </html>
            HTML;
    }
}
