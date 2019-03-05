<?php
namespace App\TwigExtension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TextExtension extends AbstractExtension {

    public function getFilters()
    {
        return [
          new TwigFilter('resume',[$this,'resumeText'],['is_safe' =>['html']])
        ];
    }

    public function resumeText(string $text,int $limit): string {

        if (strlen($text) > $limit) {

            $text = substr($text,0,$limit);
            $lastSpace = strrpos($text,' ');
            $text = substr($text,0,$lastSpace);
        }

        return $text.'...';

    }

}