<?php

namespace App\Services;

class EkoMarkDownParse {

    public function parse(string $string)
    {
        $markdownText = $string;
        $htmlOutput = $this->parseMarkdown($markdownText);
        
        return $htmlOutput;
    }

    private function parseMarkdown($text)
    {
        $text = preg_replace('/^###\s*(.*)$/m', '<h3 class="text-2xl font-semibold mt-6">$1</h3>', $text);
        $text = preg_replace('/^##\s*(.*?)\s*$/m', '<h2 class="text-3xl font-semibold mt-8">$1</h2>', $text);
        $text = preg_replace('/^#\s*(.*?)\s*$/m', '<h1 class="text-4xl font-semibold mt-10">$1</h1>', $text);
        
        // Parsing bold
        $text = preg_replace('/\*\*(.*)\*\*/U', '<strong class="font-bold">$1</strong>', $text);
        
        // Parsing italic
        $text = preg_replace('/\*(.*)\*/U', '<em class="italic">$1</em>', $text);
        
        // Parsing blockquotes
        $text = preg_replace('/^>(.*)$/m', '<blockquote class="border-l-4 border-gray-500 pl-2">$1</blockquote>', $text);
        
        // Parsing code blocks (fenced)
        $text = preg_replace('/```(.*?)```/s', '<pre class="bg-gray-100 rounded-lg p-4 overflow-x-auto overflow-y-auto"><code class="text-sm">$1</code></pre>', $text);
        
        // Parsing inline code
        $text = preg_replace('/`(.*?)`/', '<code class="bg-gray-100 rounded px-1">$1</code>', $text);
        
        // Parsing unordered list
        $text = preg_replace('/^\*(.*)$/m', '<ul class="list-disc pl-6"><li class="ml-2">$1</li></ul>', $text);
        
        // Parsing ordered list
        $text = preg_replace('/^\d+\.(.*)$/m', '<ol class="list-decimal pl-6"><li class="ml-2">$1</li></ol>', $text);
        
        // Parsing links
        $text = preg_replace('/\[(.*)\]\((.*)\)/U', '<a href="$2" class="text-blue-500 hover:underline">$1</a>', $text);
        
        // Parsing images
        $text = preg_replace('/\!\[(.*)\]\((.*)\)/U', '<img src="$2" alt="$1" class="my-4">', $text);
        
        // Remove extra <ul> and <ol> tags
        $text = preg_replace('/<\/ul>\s*<ul>/', '', $text);
        $text = preg_replace('/<\/ol>\s*<ol>/', '', $text);

        return $text;  // Convert newlines to <br> tags
    }
}