<?php
/**
 * This file is part of the GMaissa Behat Context Extension
 *
 * @package   GMaissa\BehatContextsExtension
 * @author    Guillaume Maïssa <guillaume@maissa.fr>
 * @copyright 2017 Guillaume Maïssa
 * @license   https://opensource.org/licenses/MIT MIT
 */

namespace GMaissa\BehatContextsExtension\Context\Resolver;

use Behat\Behat\Context\ContextClass\ClassResolver as BaseClassResolver;
use Symfony\Component\PropertyAccess\Exception\InvalidArgumentException;

/**
 * GMaissa Behat Context Class Resolver
 */
class ContextResolver implements BaseClassResolver
{
    /**
     * {@inheritdoc}
     */
    public function supportsClass($contextClass)
    {
        return (strpos($contextClass, 'gm:') === 0);
    }

    /**
     * {@inheritdoc}
     */
    public function resolveClass($contextClass)
    {
        if (strpos($contextClass, 'gm:context:') === false) {
            throw new InvalidArgumentException(
                sprintf('Invalid context name "%s".', $contextClass)
            );
        }

        list(,, $className) = explode(':', $contextClass);
        $className = ucfirst($className);

        $return = "\\GMaissa\\BehatContextsExtension\\Context\\{$className}Context";

        return $return;
    }
}
