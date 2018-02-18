<?php
/**
 * This file is part of the GMaissa Behat Context Extension
 *
 * Largely inspired by Akeneo's Spin Trait
 *
 * @package   GMaissa\BehatContextsExtension
 * @author    Guillaume Maïssa <guillaume@maissa.fr>
 * @copyright 2017 Guillaume Maïssa
 * @license   https://opensource.org/licenses/MIT MIT
 */

namespace GMaissa\BehatContextsExtension\Utils;

use GMaissa\BehatContextsExtension\Exception\Timeout;

/**
 * Trait class to manage step spin
 */
trait SpinTrait
{
    /**
     * Step timeout
     * @var integer
     */
    protected static $timeout = 30;

    /**
     * Retrieve the waiting timeout
     *
     * @return int the timeout in milliseconds
     */
    public static function getTimeout()
    {
        return static::$timeout;
    }

    /**
     * Set the waiting timeout
     *
     * @param integer $timeout
     */
    public function setTimeout($timeout)
    {
        static::$timeout = $timeout;
    }

    /**
     * This method executes the $callable every second.
     *
     * If the return value is true, it stops spinning and returns the value
     * If the return value is false or null, it keeps spinning until the timeout is reached
     *
     * @param callable $callable
     * @param string   $message
     *
     * @return mixed
     * @throws Timeout if the timeout is reached
     */
    public function spin($callable, $message = null)
    {
        $timeout           = self::getTimeout();
        $end               = microtime(true) + ($timeout);
        $callableException = null;
        $result            = false;
        $spin              = false;

        do {
            if ($spin) {
                sleep(1);
            }
            try {
                $result = $callable($this);
            } catch (\Exception $e) {
                $callableException = $e;
            }
            $spin = true;
        } while (microtime(true) < $end && empty($result) && !$callableException instanceof Timeout);

        if (!$result) {
            if ($message === null) {
                $message = ($callableException !== null) ? $callableException->getMessage() : 'no message';
            }
            $info = sprintf('Spin : timeout of %d exceeded, with message : %s', $timeout, $message);
            throw new Timeout($info, 0, $callableException);
        }

        return $result;
    }
}
