<?php

if (! function_exists('editorjs_text')) {
    function editorjs_text(?array $content): string
    {
        if (empty($content) || empty($content['blocks'])) {
            return '';
        }

        return collect($content['blocks'])
            ->map(function ($block) {
                return match ($block['type']) {
                    'paragraph' => $block['data']['text'] ?? '',
                    'header'    => $block['data']['text'] ?? '',
                    'list'      => implode(' ', $block['data']['items'] ?? []),
                    default     => '',
                };
            })
            ->implode(' ');
    }
}
