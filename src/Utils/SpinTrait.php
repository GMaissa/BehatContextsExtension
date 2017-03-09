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
    protected static $timeout = 60;

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
    protected function setTimeout($timeout)
    {
        static::$timeout = $timeout;
    }

    /**
     * This method executes $callable every second.
     * If its return value is evaluated to true, the spinning stops and the value is returned.
     * If the return value is falsy, the spinning continues until the loop limit is reached,
     * In that case a TimeoutException is thrown.
     *
     * @param callable $callable closure to be called
     * @param string $message error message to display
     *
     * @throws Timeout
     *
     * @return mixed
     */
    public function spin($callable, $message)
    {
        $timeout = self::$timeout;
        $start = microtime(true);
        $end = $start + $timeout;
        $logThreshold = (int)$timeout * 0.8;
        $previousException = null;
        $result = null;
        $looping = false;

        do {
            if ($looping) {
                sleep(1);
            }
            try {
                $result = $callable($this);
            } catch (\Exception $e) {
                $previousException = $e;
            }
            $looping = true;
        } while (microtime(true) < $end && !$result && !$previousException instanceof Timeout);

        if (null === $message) {
            $message = (null !== $previousException) ? $previousException->getMessage() : 'no message';
        }
        if (!$result) {
            $info = sprintf('Spin : timeout of %d excedeed, with message : %s', $timeout, $message);
            throw new Timeout($info, 0, $previousException);
        }
        $elapsed = microtime(true) - $start;
        if ($elapsed >= $logThreshold) {
            printf('[%s] Long spin (%d seconds) with message : %s', date('y-md H:i:s'), $elapsed, $message);
        }
        return $result;
    }
}
