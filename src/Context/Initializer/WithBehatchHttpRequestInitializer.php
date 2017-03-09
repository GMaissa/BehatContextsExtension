<?php
/**
 * This file is part of the GMaissa Behat Context Extension
 *
 * @package   GMaissa\BehatContextsExtension
 * @author    Guillaume Maïssa <guillaume@maissa.fr>
 * @copyright 2017 Guillaume Maïssa
 * @license   https://opensource.org/licenses/MIT MIT
 */

namespace GMaissa\BehatContextsExtension\Context\Initializer;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\Initializer\ContextInitializer;
use Behatch\HttpCall\Request;
use GMaissa\BehatContextsExtension\Context\WithBehatchHttpRequestContextInterface;

/**
 * OAuth context initializer
 */
class WithBehatchHttpRequestInitializer implements ContextInitializer
{
    private $request;

    /**
     * Initializes initializer.
     *
     * @param array $parameters
     */
    public function __construct(Request $request)
    {
        $this->request    = $request;
    }

    /**
     * {@inheritdoc}
     */
    public function initializeContext(Context $context)
    {
        if (!$context instanceof WithBehatchHttpRequestContextInterface) {
            return;
        }

        $context->setRequest($this->request);
    }
}
