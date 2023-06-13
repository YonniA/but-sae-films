<?php

namespace Html;

class WebPage
{
    private string $head ='';
    private string $title;
    private string $body ='';

    /**
     * @param string $title
     */
    public function __construct(string $title='')
    {
        $this->title =$title;
    }

    /**
     * @return string
     */
    public function getHead(): string
    {
        return $this->head;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title=$title;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /** Ajouter un contenu dans $this->head
     * @param string $content
     * @return void
     */
    public function appendToHead(string $content): void
    {
        $this->head.=$content."\n";
    }

    /** Ajouter un contenu CSS dans $this->head.
     * @param string $css
     * @return void
     */
    public function appendCss(string $css): void
    {
        $this->head.="<style>".$css."</style>\n";
    }


    /** Ajouter l'URL d'un script CSS dans $this->head.
     * @param string $url
     * @return void
     */
    public function appendCssUrl(string $url): void
    {
        $this->head .= "<link rel='stylesheet' type='text/css' href='$url' />\n";
    }

    /** Ajouter un contenu JavaScript dans $this->head.
     * @param string $js
     * @return void
     */
    public function appendJs(string $js): void
    {
        $this->head.="<script>".$js."</script>"."\n";
    }

    /** Ajouter l'URL d'un script JavaScript dans $this->head.
     * @param string $url
     * @return void
     */
    public function appendJsUrl(string $url): void
    {
        $this->head.="<script src=\"".$url."\"></script>"."\n";
    }

    /** Ajouter un contenu dans $this->body.
     * @param string $content
     * @return void
     */
    public function appendContent(string $content): void
    {
        $this->body .= $content."\n";
    }

    /**
     * @return string
     */
    public function toHTML(): string
    {
        return <<<HTML
        <!doctype html>
        <html lang="fr">
            <head>
                <title>{$this->getTitle()}</title>
                <meta name="viewport" content="width=device-width, initial-scale=1" />
                <meta charset="UTF-8">
                {$this->getHead()}
            </head>
            <body>
                {$this->getBody()}
                <div>{$this->getLastModification()}</div>
            </body>
        </html>
        HTML;

    }

    public function escapeString(string $string): string
    {
        return htmlspecialchars("$string", ENT_QUOTES | ENT_HTML5 | ENT_SUBSTITUTE);
    }

    public function getLastModification(): string
    {
        return "Dernière modification : " . date("F d Y H:i:s.", getlastmod());

    }


}
