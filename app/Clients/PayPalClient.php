<?php
namespace App\Clients;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
class PayPalClient
{
    /**
     * Returns PayPal HTTP context instance with environment that has access
     * credentials context. Use this instance to invoke PayPal APIs, provided the
     * credentials have access.
     */
    public function context()
    {
        return new ApiContext($this->credentials());
    }
    /**
     * Set up and return PayPal PHP SDK environment with PayPal access credentials.
     *
     * Paste your client_id and client secret as below
     */
    protected function credentials()
    {
        $clientId     = 'AWOqiWe_SYSaEh2xy_ZK_aGS6RF9CROm_R3jmWpOt3T2XUaSi2Wc1emFXxB3wBspJUohE778pRcIzFvU';
        $clientSecret = 'EFFc9TatnAPDN9EtD4b7VRIsQoR-oE3MwYDsWpH4o1PPwDabF9QZANFbfzIjzFHt_YSBrBeEtoNrpXY7';
        return new OAuthTokenCredential($clientId, $clientSecret);
    }
}