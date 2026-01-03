<?php

namespace Maker\Template;

final class MakerTemplate
{
    public static function getPath(string $templateName): string
    {
        return __DIR__ . '/' . $templateName;
    }
}
