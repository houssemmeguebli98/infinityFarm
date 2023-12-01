<?php

namespace App\Utils;

class MessageGenerator
{
    private const TEMPLATES = [
        'greeting' => 'Hello, how can I assist you today?',
        'asking_for_help' => 'I seem to be having an issue, could you please help me out?'
    ];

    public function generateMessage(string $type): string
    {
        return self::TEMPLATES[$type] ?? 'Type not recognized.';
    }
}