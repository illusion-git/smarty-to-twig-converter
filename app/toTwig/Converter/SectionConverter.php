<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace toTwig\Converter;

/**
 * Class SectionConverter
 */
class SectionConverter extends ConverterAbstract
{

    protected $name = 'section';
    protected $description = 'Convert smarty {section} to twig {for}';
    protected $priority = 20;

    // Lookup tables for performing some token
    // replacements not addressed in the grammar.
    private $replacements = [
        '\$smarty\.section.*\.index' => 'loop.index0',
        '\$smarty\.section.*\.iteration' => 'loop.index',
        '\$smarty\.section.*\.first' => 'loop.first',
        '\$smarty\.section.*\.last' => 'loop.last',
    ];

    /**
     * Function converts smarty {section} tags to twig {for}
     *
     * @param string $content
     *
     * @return null|string|string[]
     */
    public function convert(string $content): string
    {
        $contentReplacedOpeningTag = $this->replaceSectionOpeningTag($content);
        $content = $this->replaceSectionClosingTag($contentReplacedOpeningTag);

        foreach ($this->replacements as $k => $v) {
            $content = preg_replace('/' . $k . '/', $v, $content);
        }

        return $content;
    }

    /**
     * Function converts opening tag of smarty {section} to twig {for}
     *
     * @param string $content
     *
     * @return null|string|string[]
     */
    private function replaceSectionOpeningTag(string $content): string
    {
        $pattern = $this->getOpeningTagPattern('section');
        $string = '{% for :name in :start..:loop %}';

        return preg_replace_callback(
            $pattern,
            function ($matches) use ($string) {
                $replacement = $this->getAttributes($matches);
                $replacement['start'] = isset($replacement['start']) ? $replacement['start'] : 0;
                $replacement['name'] = $this->sanitizeVariableName($replacement['name']);
                $string = $this->replaceNamedArguments($string, $replacement);

                return str_replace($matches[0], $string, $matches[0]);
            },
            $content
        );
    }

    /**
     * Function converts closing tag of smarty {section} to twig {for}
     *
     * @param string $content
     *
     * @return null|string|string[]
     */
    private function replaceSectionClosingTag(string $content): string
    {
        $search = $this->getClosingTagPattern('section');
        $replace = '{% endfor %}';

        return preg_replace($search, $replace, $content);
    }
}
