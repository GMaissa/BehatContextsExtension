<?php
/**
 * This file is part of the GMaissa Behat Context Extension
 *
 * @package   GMaissa\BehatContextsExtension
 * @author    Guillaume Maïssa <guillaume@maissa.fr>
 * @copyright 2017 Guillaume Maïssa
 * @license   https://opensource.org/licenses/MIT MIT
 */

namespace GMaissa\BehatContextsExtension\Context;

use Behat\Mink\Exception\UnsupportedDriverActionException;
use Behat\MinkExtension\Context\MinkContext;
use Behat\MinkExtension\Context\RawMinkContext;
use GMaissa\BehatContextsExtension\Utils\WindowSizeTrait;

/**
 * Context for defining Browser Window Size for tests
 */
class WindowSizeContext extends RawMinkContext
{
    use WindowSizeTrait;

    /**
     * Initialize with generic information
     *
     * @param null|integer $width window width
     * @param null|integer $height window height
     */
    public function __construct($width = null, $height = null)
    {
        $this->setWindowSize($width, $height);
    }
}
