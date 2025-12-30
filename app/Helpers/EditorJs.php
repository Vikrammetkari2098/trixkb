<?php

if (! function_exists('editorjs_text')) {
    function editorjs_text(?array $content): string
    {
        if (empty($content) || empty($content['blocks'])) {
            return '';
        }

        return collect($content['blocks'])
            ->map(function ($block) {
                
                if (empty($block['data'])) {
                    return '';
                }

                return match ($block['type']) {
                    'paragraph' => $block['data']['text'] ?? '',
                    'header'    => $block['data']['text'] ?? '',
                    
                   
                    'list'      => collect($block['data']['items'] ?? [])
                                    ->map(function ($item) {
                                        if (is_array($item)) {
                                            return $item['content'] ?? ($item['text'] ?? '');
                                        }
                                        return $item;
                                    })
                                    ->implode(' '),

                    default     => '',
                };
            })
            ->implode(' ');
    }
}