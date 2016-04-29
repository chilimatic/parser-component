<?php
namespace chilimatic\lib\Parser\Annotation;

use chilimatic\lib\Interfaces\IFlyWeightParser;


/**
 * Class AnnotationViewParser
 * @package chilimatic\lib\Parser\Annotation
 */
class AnnotationViewParser implements IFlyWeightParser
{

    /**
     * pattern for matching
     *
     * @view should only be the first <- we don't override inside of a doc block
     */
    const VIEW_RENDER           = '/@view[\s]+(.*)/';

    /**
     * template file name
     *
     * here as well only the first value does count
     */
    const VIEW_TEMPLATE_FILE    = '/@viewTemplate[\s]+(.*)/';

    /**
     * these can be n-times
     *
     * they always should be key=value the value can be any type
     */
    const VIEW_PARAMETERS       = '/@viewParam[\s]+(\w*)[\s]*[=]{1}[\s]*(.*)/';


    /**
     * @param string $content
     *
     * @return array
     */
    public function parse($content)
    {
        if (!$content || strpos($content, '@view') === false) {
            return [];
        }
        $ret = [];

        if (preg_match(self::VIEW_RENDER, $content, $match)) {
            $ret[0] = array_pop($match);
        } else {
            $ret[0] = null;
        }

        if (preg_match(self::VIEW_TEMPLATE_FILE, $content, $match)) {
            $ret[1] = array_pop($match);
        } else {
            $ret[1] = null;
        }

        if (preg_match_all(self::VIEW_PARAMETERS, $content, $match, PREG_SET_ORDER)) {
            $set = [];
            // "all" is excluded
            foreach ($match as $position => $group) {
                $set[$group[1]] = $group[2];
            }

            if ($set){
                $ret[] = $set;
            }

        }

        return $ret;
    }
}