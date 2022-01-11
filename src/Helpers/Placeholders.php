<?php

namespace PyrobyteWeb\MetaTemplates\Helpers;

class Placeholders
{
    public static function replace($text, $values = [], $defaultPlaceholders = [])
    {
        $replacement = [];

        if (!empty($values)) {
            $values = !is_array($values) ? json_decode($values, true) : $values;
            $replacement = array_merge($replacement, $values);
        }

        $replacement = array_merge($defaultPlaceholders, $replacement);

        foreach ($replacement as $placeholder => $value) {
            if (is_array($value)) {
                continue;
            }

            if (is_object($value)) {
                continue;
            }

            $text = str_replace('#' . strtoupper($placeholder) . '#', $value, $text);
            $text = str_replace('#' . $placeholder . '#', $value, $text);
        }

        return $text;
    }
}
