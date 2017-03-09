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

use Behat\MinkExtension\Context\RawMinkContext;
use Behatch\HttpCall\Request;

/**
 * OAuth Context
 */
class OauthContext extends RawMinkContext implements WithBehatchHttpRequestContextInterface
{
    protected static $request;
    protected $serverUrl;
    protected $grantType;
    protected $clientId;
    protected $clientSecret;

    /**
     * Class constructor
     *
     * @param string $serverUrl
     * @param string $grantType
     * @param string $clientId
     * @param string $clientSecret
     */
    public function __construct($serverUrl, $grantType, $clientId, $clientSecret)
    {
        $this->serverUrl    = $serverUrl;
        $this->grantType    = $grantType;
        $this->clientId     = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * {@inheritdoc}
     */
    public function setRequest(Request $request)
    {
        self::$request = $request;
    }

    /**
     * @Given I authenticated on OAuth server as :login and :password
     */
    public function iAuthenticatedOnOauthServerAs($login, $password)
    {
        $params   = [
            'grant_type'    => $this->grantType,
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'username'      => $login,
            'password'      => $password
        ];
        $body     = \json_encode($params);
        $result   = self::$request->send(
            'POST',
            $this->serverUrl,
            [],
            [],
            $body,
            ['CONTENT_TYPE' => 'application/json']
        );
        $response = json_decode($result->getContent(), true);
        if (isset($response['access_token'])) {
            $accessToken = $response['access_token'];
            self::$request->setHttpHeader('Authorization', 'Bearer ' . $accessToken);
        }
    }

    /**
     * @AfterFeature
     */
    public static function unsetToken()
    {
        self::$request->setHttpHeader('Authorization', '');
    }
}
