<?php

namespace App\Actions\Helpers;

class ParseEmailAction {

    private const TEXT_RELATED_TAGS = [
        '<h1>', '<h2>', '<h3>', '<h4>', '<h5>',
        '<p>', '<li>', '<br>', '<small>', '<span>',
        '<title>', '<th>', '<td>', '<blockquote>', '<style>'
    ];

    private const LINE_BREAK_TAGS = [
        "<br>", "<br/>", "<br />", "</p>", '</li>', 
        '</h1>','</h2>', '</h3>', '</h4>', '</h5>',
        '</small>', '</span>', '</title>', '</td>',
        '</blockquote>', '</th>'
    ];

    public function execute(string $email): string
    {
        //Remove HTML Tags but include text related tags to have line break indicators
        $textWithCss = strip_tags($email, self::TEXT_RELATED_TAGS);

        //Remove CSS block if exist.
        $plainText = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $textWithCss);
        $plainText = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $plainText);

        //Remove end tag for each text related html tag.
        $removedLineBreakText = str_replace(self::LINE_BREAK_TAGS, "\n", $plainText);

        //Remove the opening tag for each text related html tag. Outputs clean line-break separated text.
        $finalText = str_replace(self::TEXT_RELATED_TAGS, "", $removedLineBreakText);

        return $finalText;
    }
}