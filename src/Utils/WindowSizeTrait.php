<?php
/**
 * This file is part of the GMaissa Behat Context Extension
 *
 * @package   GMaissa\BehatContextsExtension
 * @author    Guillaume Maïssa <guillaume@maissa.fr>
 * @copyright 2017 Guillaume Maïssa
 * @license   https://opensource.org/licenses/MIT MIT
 */

namespace GMaissa\BehatContextsExtension\Utils;

use Behat\Mink\Exception\UnsupportedDriverActionException;

/**
 * Screenshot Context class
 */
trait WindowSizeTrait
{
    /**
     * Browser window width
     * @var integer|false
     */
    private static $windowWidth;

    /**
     * Browser window height
     * @var integer|false
     */
    private static $windowHeight;

    /**
     * Returns Mink session.
     *
     * @param string|null $name name of the session OR active session will be used
     *
     * @return Session
     */
    abstract public function getSession($name = null);

    /**
     * Set the window size parameters
     *
     * @param null|integer $width window width
     * @param null|integer $height window height
     */
    public function setWindowSize($width = null, $height = null)
    {
        self::$windowWidth  = is_int($width) ? $width : false;
        self::$windowHeight = is_int($height) ? $height : false;
    }

    /**
     * Get the window size parameters
     *
     * @return array
     */
    public function getWindowSize()
    {
        return [
            'width'  => self::$windowWidth,
            'height' => self::$windowHeight,
        ];
    }

    /**
     * Resize browser window before each scenario
     *
     * @BeforeScenario
     */
    public function resizeWindow()
    {
        try {
            $windowSize = $this->getWindowSize();
            $this->getSession()->resizeWindow($windowSize['width'], $windowSize['height']);
        } catch (UnsupportedDriverActionException $e) {
            // Need this for unsupported drivers
        }
    }
}
