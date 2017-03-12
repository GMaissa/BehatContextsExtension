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

use Behatch\HttpCall\Request;

/**
 * Context with parameters interface class
 */
interface BehatchRequestAwareContextInterface
{
    /**
     * Set the HTTP Request object
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function setRequest(Request $request);
}
