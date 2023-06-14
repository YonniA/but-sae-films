<?php

declare(strict_types=1);

namespace Html;

trait StringEscaper
{
    public function escapeString(?string $string): ?string
    {
        return htmlspecialchars($string);
    }
    public function stripTagsAndTrim(?string $string): ?string
    {
        if ($string === null) {
            $string = '';
        }
        return trim(strip_tags($string));
    }
}
