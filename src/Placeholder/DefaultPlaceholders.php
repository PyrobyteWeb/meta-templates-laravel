<?php

namespace PyrobyteWeb\MetaTemplates\Placeholder;

class DefaultPlaceholders implements TemplatePlaceholderRenderInterface
{
    public function getPlaceholders(): array
    {
        return [
           'year' => date('Y'),
           'month' => date('m'),
           'day' => date('d'),
           'time' => time(),
        ];
    }
}
