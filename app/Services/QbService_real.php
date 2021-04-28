<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Exception\SdkException;
use QuickBooksOnline\API\Exception\ServiceException;
use QuickBooksOnline\API\Facades\Customer;
use QuickBooksOnline\API\Facades\Invoice;

class QbService
{
    protected $dataService;

    function __construct()
    {
    }

    public function reconnect() {
        $this->dataService = null;
        try {

            $user = Auth::user();

            $accessToken = $user->qb_access_token;
            $refreshToken = $user->qb_refresh_token;
            $realmId = $user->qb_realm_id;

            if ($accessToken) {
                if (my_date_compare($user->qb_access_token_expire_at) == 1 || my_date_compare($user->qb_refresh_token_expire_at) == 1) {
                    $dataService = DataService::Configure(array(
                        'auth_mode' => 'oauth2',
                        'ClientID' => $user->qb_client_id,
                        'ClientSecret' => $user->qb_client_secret,
                        'accessTokenKey' => $accessToken,
                        'refreshTokenKey' => $refreshToken,
                        'QBORealmID' => $realmId,
                        'baseUrl' => "development"
                    ));

                    //Refresh token
                    if (my_date_compare($user->qb_access_token_expire_at) < 1 && my_date_compare($user->qb_refresh_token_expire_at) == 1) {
                        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();

                        //        $accessTokenObj = $OAuth2LoginHelper->
                        //            refreshAccessTokenWithRefreshToken($refreshToken);
                        //        $accessTokenValue = $accessTokenObj->getAccessToken();
                        //        $refreshTokenValue = $accessTokenObj->getRefreshToken();

                        $refreshedAccessTokenObj = $OAuth2LoginHelper->refreshToken();
                        $error = $OAuth2LoginHelper->getLastError();
                        if ($error) {
                        } else {
                            //Refresh Token is called successfully
                            $dataService->updateOAuth2Token($refreshedAccessTokenObj);

                            $user->qb_access_token = $refreshedAccessTokenObj->getAccessToken();
                            $dat1 = new \DateTime();
                            $dat2 = new \DateTime();
                            $user->qb_refresh_token_expire_at = $dat1->setTimestamp(time() + 86400);
                            $user->qb_access_token_expire_at = $dat2->setTimestamp(time() + 3600);
                            $user->save();
                        }

                        $dataService->setLogLocation("~/qblog");
                        $dataService->throwExceptionOnError(false);

                    }

                    $this->dataService = $dataService;
                    return;
                }
            }
        } catch (SdkException $e) {
        } catch (ServiceException $e) {
            $user->qb_access_token = '';
            $user->qb_refresh_token = '';
            $user->save();
        }

        if ($user->qb_access_token) {
            $user->qb_access_token = '';
            $user->qb_refresh_token = '';
            $user->save();
        }
    }

    public function authCallback($data) {
        $dataService = $this->getServiceForOAuth();

        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();

        /*
         * Update the OAuth2Token
         */
        $accessToken = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($data['code'], $data['realmId']);
        $dataService->updateOAuth2Token($accessToken);

        $this->dataService = $dataService;
        return $accessToken;
    }

    public function getServiceForOAuth() {
        $user = Auth::user();

        $dataService = null;
        try {
            $dataService = DataService::Configure(array(
                'auth_mode' => 'oauth2',
                'ClientID' => $user->qb_client_id,
                'ClientSecret' => $user->qb_client_secret,
                'RedirectURI' => url('/qb/callback'),
                'scope' => 'com.intuit.quickbooks.accounting openid profile email phone address',
                'baseUrl' => "development"
            ));
            $dataService->throwExceptionOnError(false);

        } catch (\QuickBooksOnline\API\Exception\SdkException $e) {
        }

        return $dataService;
    }

    public function getService() {
        return $this->dataService;
    }

    public function getServiceWithReconnect() {
        $this->reconnect();
        return $this->dataService;
    }

    public function createInvoice($data) {
        $dataService = $this->dataService;
        $theResourceObj = Invoice::create([
            "TxnDate"=> $data['txn_date'],
            "DueDate"=> $data['due_date'],
            "Line" => [
                [
                    "Amount" => $data['fulltotal'],
                    "DetailType" => "SalesItemLineDetail",
                    "SalesItemLineDetail" => [
                        "ItemRef" => [
                            "value" => 1,
                            "name" => "Services"
                        ]
                    ],
                    "Description" => $data['product_names']
                ]
            ],
            "CustomerRef" => [
                "value" => $data['qbCustomerId']
            ],
//                "BillEmail" => [
//                    "Address" => "Familiystore@intuit.com"
//                ],
//                "BillEmailCc" => [
//                    "Address" => "a@intuit.com"
//                ],
//                "BillEmailBcc" => [
//                    "Address" => "v@intuit.com"
//                ]
        ]);
        $resultingObj = $dataService->Add($theResourceObj);

        return $resultingObj;
    }

    public function createCustomer($data) {
        $dataService = $this->dataService;
        $theResourceObj = Customer::create([
            "GivenName" => $data['first_name'],
            "FamilyName" => $data['last_name'],
            "FullyQualifiedName" => $data['customer_name'],
//                "CompanyName" => "King Groceries",
            "DisplayName" => $data['dispName'],
//                "PrimaryPhone" => [
//                    "FreeFormNumber" => $phone
//                ],
            "PrimaryEmailAddr" => [
                "Address" => $data['contact_email']
            ]
        ]);

        $qbCustomer = $dataService->Add($theResourceObj);

        return $qbCustomer;
    }

}