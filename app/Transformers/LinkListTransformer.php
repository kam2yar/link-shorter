<?php

namespace App\Transformers;

class LinkListTransformer
{
    public static function transform(array $input): array
    {
        return array_map(function ($link) {
            return [
                'short_link' => base_url() . $link['short'],
                'original_link' => $link['original'],
            ];
        }, $input);
    }
}