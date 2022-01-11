<?php

namespace PyrobyteWeb\MetaTemplates\Placeholder;

use PyrobyteWeb\MetaTemplates\Helpers\Placeholders;

abstract class TemplatePlaceholderRenderAbstract implements TemplatePlaceholderRenderInterface
{
    public function replace(string $value): string
    {
        $defaultPlaceholders = [];

        foreach (config('meta-templates.common') as $common) {
            $defaultPlaceholders = array_merge($defaultPlaceholders, (new $common)->getPlaceholders());
        }

        return Placeholders::replace($value, $this->getPlaceholders(), $defaultPlaceholders);
    }
}
