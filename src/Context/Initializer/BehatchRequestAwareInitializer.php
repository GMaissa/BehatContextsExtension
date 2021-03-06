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
use GMaissa\BehatContextsExtension\Context\BehatchRequestAwareContextInterface;

/**
 * Initializer for contexts using Behatch Request object
 */
class BehatchRequestAwareInitializer implements ContextInitializer
{
    private $request;

    /**
     * Initializes initializer.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * {@inheritdoc}
     */
    public function initializeContext(Context $context)
    {
        if (!$context instanceof BehatchRequestAwareContextInterface) {
            return;
        }

        $context->setRequest($this->request);
    }
}
