<?php
namespace chilimatic\lib\Parser\Annotation;

use chilimatic\lib\Interfaces\IFlyWeightParser;

/**
 * Class AnnotationOrmParser
 * @package chilimatic\lib\Parser\Annotation
 */
class AnnotationOrmParser implements IFlyWeightParser
{
    /**
     * @var string
     */
    const PATTERN = '/@ORM[\s]*(\w*)=(.*);/';

    /**
     * @param string $content
     *
     * @return null|array
     */
    public function parse($content)
    {
        $set = null;
        if (strpos($content, '@ORM') === false) {
            return $set;
        }

        if (preg_match(self::PATTERN, $content, $matches)) {
            $set[] = [$matches[1], $matches[2]];
        }



        return $set;
    }
}