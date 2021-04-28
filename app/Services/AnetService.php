<?php

namespace App\Services;
use App\User;
use App\Models\MerchantGateway;
use DateTime;
use Exception;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Illuminate\Support\Facades\Auth;

/**
 * Authorize.Net payment process service
 *
 *---------------------------------------------------------------- */
class AnetService {
    /**
     * @var configData - configData
     */
    protected $configData;

    /**
     * @var configItem - configItem
     */
    protected $configItem;

    /**
     * @var configItem - configItem
     */
    protected $merchantAuthentication;

    /**
     * @var configItem - configItem
     */
    protected $isSupported = true;

    /**
     * Constructor.
     *
     *-----------------------------------------------------------------------*/
    public function __construct() {
        // $this->configData = configItem();

        //collect authorize-net data in config array
        // $this->configItem = getArrayItem($this->configData, 'payments.gateway_configuration.authorize-net', []);

        $phpVersion = phpversion();

        //check php version greater than 7.4 then apply
        if ($phpVersion > '7.4') {
            //set false
            $this->isSupported = false;

        } else {
            $this->merchantAuthentication = new AnetAPI\MerchantAuthenticationType();

//            $this->reconnect();

//            //check test mode or product mode set stripeSecretKey or stripePublishKey
//            if (!empty($this->configItem)) {
//                if ($this->configItem['testMode'] == true) {
//                    $this->merchantAuthentication->setName($this->configItem['authorizeNetTestApiLoginId']);
//                    $this->merchantAuthentication->setTransactionKey($this->configItem['authorizeNetTestTransactionKey']);
//                } else {
//                    $this->merchantAuthentication->setName($this->configItem['authorizeNetLiveApiLoginId']);
//                    $this->merchantAuthentication->setTransactionKey($this->configItem['authorizeNetLiveTransactionKey']);
//                }
//            }
        }
    }

    public function reconnect($req=null) {
        $mGateway = null;
        if ($req && $req['user_id']) {
            $USERID = $req['user_id'];
        } else if (Auth::user()) {
            $user = Auth::user();
            $admin = User::where(['email'=>$user->admin_email])->first();
            $USERID = $admin->user_id;
        }

        $mGateway = MerchantGateway::where(['user_id'=>$USERID, 'gateway'=>'authorize-net'])->first();
        if ($mGateway) {
            if ($mGateway->testMode=='true') {
                $loginId = $mGateway->authorizeNetTestApiLoginId;
                $txnKey = $mGateway->authorizeNetTestTransactionKey;

            } else {
                $loginId = $mGateway->authorizeNetLiveApiLoginId;
                $txnKey = $mGateway->authorizeNetLiveTransactionKey;

            }

            $this->merchantAuthentication->setName($loginId);
            $this->merchantAuthentication->setTransactionKey($txnKey);

            $this->configItem = [
                'enable'                         => $mGateway->enable,
                'testMode'                       => $mGateway->testMode, //test mode or product mode (boolean, true or false)
                'gateway'                        => 'Authorize.net', //payment gateway name
                'reference_id'                   => 'REF' . uniqid(), //generate random conversation id
                'currency'                       => 'USD', //currency
                'currencySymbol'                 => '$',
                'type'                           => 'individual',
                'txnType'                        => 'authCaptureTransaction',
//            'callbackUrl'                    => '/checkout/successCheckoutAnet' //callback Url after payment successful
            ];

        }

    }

    /**
     * Process Authorize.Net Request Recurring
     *
     *---------------------------------------------------------------- */
    public function processAuthorizeNetRequestRecur($req)
    {
        //check authorize.net supported or not
        if ($this->isSupported) {
            $res = [];
            if ($this->configItem['testMode'] == 'true') {
                $environment = "SANDBOX";
            } else {
                $environment = "PRODUCTION";
            }

            $refId = 'ref' . time();

            // Create a Customer Profile Request
            //  1. (Optionally) create a Payment Profile
            //  2. (Optionally) create a Shipping Profile
            //  3. Create a Customer Profile (or specify an existing profile)
            //  4. Submit a CreateCustomerProfile Request
            //  5. Validate Profile ID returned
            $cardExpiryYearMonth = $req['expyear'].'-'.$req['expmonth'];

            // Set credit card information for payment profile
            $creditCard = new AnetAPI\CreditCardType();
            $creditCard->setCardNumber($req['cardnumber']);
            $creditCard->setExpirationDate($cardExpiryYearMonth);
            $creditCard->setCardCode($req['cvv']);
            $paymentCreditCard = new AnetAPI\PaymentType();
            $paymentCreditCard->setCreditCard($creditCard);

            // Create the Bill To info for new payment type
            $billTo = new AnetAPI\CustomerAddressType();
            $billTo->setFirstName($req['first_name']);
            $billTo->setLastName($req['last_name']);
            $billTo->setCompany($req['business_name']);
//            $billTo->setAddress($req['address']);
//            $billTo->setCity($req['city']);
//            $billTo->setState($req['state']);
//            $billTo->setZip($req['zip']);
            $billTo->setCountry("USA");
            $billTo->setPhoneNumber($req['phone']);
//            $billTo->setfaxNumber("999-999-9999");

            // Create a customer shipping address
//            $customerShippingAddress = new AnetAPI\CustomerAddressType();
//            $customerShippingAddress->setFirstName("James");
//            $customerShippingAddress->setLastName("White");
//            $customerShippingAddress->setCompany("Addresses R Us");
//            $customerShippingAddress->setAddress(rand() . " North Spring Street");
//            $customerShippingAddress->setCity("Toms River");
//            $customerShippingAddress->setState("NJ");
//            $customerShippingAddress->setZip("08753");
//            $customerShippingAddress->setCountry("USA");
//            $customerShippingAddress->setPhoneNumber("888-888-8888");
//            $customerShippingAddress->setFaxNumber("999-999-9999");
//
//            // Create an array of any shipping addresses
//            $shippingProfiles[] = $customerShippingAddress;


            // Create a new CustomerPaymentProfile object
            $paymentProfile = new AnetAPI\CustomerPaymentProfileType();
            $paymentProfile->setCustomerType('individual');
            $paymentProfile->setBillTo($billTo);
            $paymentProfile->setPayment($paymentCreditCard);
            $paymentProfiles[] = $paymentProfile;


            // Create a new CustomerProfileType and add the payment profile object
            $customerProfile = new AnetAPI\CustomerProfileType();
            $customerProfile->setDescription($req['payer_email']);
            $customerProfile->setMerchantCustomerId("M_" . time());
            $customerProfile->setEmail($req['payer_email']);
            $customerProfile->setPaymentProfiles($paymentProfiles);
//            $customerProfile->setShipToList($shippingProfiles);


            // Assemble the complete transaction request
            $request = new AnetAPI\CreateCustomerProfileRequest();
            $request->setMerchantAuthentication($this->merchantAuthentication);
            $request->setRefId($refId);
            $request->setProfile($customerProfile);

            // Create the controller and get the response
            $controller = new AnetController\CreateCustomerProfileController($request);
            $response = $controller->executeWithApiResponse(constant("\\net\authorize\api\constants\ANetEnvironment::$environment"));

            if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
//                echo "Succesfully created customer profile : " . $response->getCustomerProfileId() . "\n";
                $paymentProfiles = $response->getCustomerPaymentProfileIdList();
//                echo "SUCCESS: PAYMENT PROFILE ID : " . $paymentProfiles[0] . "\n";
            } else {
//                echo "ERROR :  Invalid response\n";
                $errorMessages = $response->getMessages()->getMessage();
                $res['status'] = 'error';
                $res['err_code'] = $errorMessages[0]->getCode();
                $res['msg'] = $errorMessages[0]->getText();
                return $res;
//                echo "Response : " . $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText() . "\n";
            }

            $customerProfileId = $response->getCustomerProfileId();
            $customerPaymentProfileId = $paymentProfiles[0];
            $res['customer_profile_id'] = $customerProfileId;
            $res['customer_payment_profile_id'] = $customerPaymentProfileId;


//            $orderData['cus_id'] = $customerProfileId;
//            $orderData['cus_pay_id'] = $customerPaymentProfileId;
//            dd($orderData);
//
//            return $orderData;

            sleep(10);

            // Set the transaction's refId
            $refId = 'ref' . time();

            // Subscription Type Info
            $subscription = new AnetAPI\ARBSubscriptionType();
            $subscription->setName($req['plan_name']);

            $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
            $interval->setLength($req['plan_interval']);
            $interval->setUnit($req['plan_unit']);

            $paymentSchedule = new AnetAPI\PaymentScheduleType();
            $paymentSchedule->setInterval($interval);
            $paymentSchedule->setStartDate(new DateTime(my_date_format()));
            $paymentSchedule->setTotalOccurrences("9999");
            $paymentSchedule->setTrialOccurrences("0");

            $subscription->setPaymentSchedule($paymentSchedule);
            $amount = $req['amount'];
            $subscription->setAmount($amount);
            $subscription->setTrialAmount("0.00");

            $profile = new AnetAPI\CustomerProfileIdType();
            $profile->setCustomerProfileId($customerProfileId);
            $profile->setCustomerPaymentProfileId($customerPaymentProfileId);
//            $profile->setCustomerProfileId('1515592452');
//            $profile->setCustomerPaymentProfileId('1513417526');
//            $profile->setCustomerAddressId($customerAddressId);

            $subscription->setProfile($profile);

            $request = new AnetAPI\ARBCreateSubscriptionRequest();
            $request->setmerchantAuthentication($this->merchantAuthentication);
            $request->setRefId($refId);
            $request->setSubscription($subscription);
            $controller = new AnetController\ARBCreateSubscriptionController($request);
            $response = $controller->executeWithApiResponse(constant("\\net\authorize\api\constants\ANetEnvironment::$environment"));

            if (($response != null) && ($response->getMessages()->getResultCode() == "Ok") )
            {
//                echo "SUCCESS: Subscription ID : " . $response->getSubscriptionId() . "\n";
                $res['status'] = 'success';
                $res['subscription_id'] = $response->getSubscriptionId();

            }
            else
            {
//                echo "ERROR :  Invalid response\n";
                $errorMessages = $response->getMessages()->getMessage();
//                echo "Response : " . $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText() . "\n";
                $res['status'] = 'error';
                $res['err_code'] = $errorMessages[0]->getCode();
                $res['msg'] = $errorMessages[0]->getText();
            }

            return $res;

        } else {
            //throw exception
            throw new Exception('As of now Authorize.Net does not support PHP 7.4 and above.');
        }
    }




    /**
     * Process Authorize.Net Request
     *
     *---------------------------------------------------------------- */
    public function processAuthorizeNetRequest($req)
    {
        //check authorize.net supported or not
        if ($this->isSupported) {

            if ($this->configItem['testMode'] == true) {
                $environment = "SANDBOX";
            } else {
                $environment = "PRODUCTION";
            }

            // Set the transaction's refId
            $refId = 'ref' . time();

            $amount = $req['amount'];
            $statusMsg = $error = '';
            $ordStatus = 'error';
            $orderData = [
                'order_id' => $req['order_id'],
                'amount' => $amount,
                'paymentOption' => 'authorize-net'
            ];

            $cardExpiryYearMonth = $req['expyear'].'-'.$req['expmonth'];
            // Create the payment data for a credit card
            $creditCard = new AnetAPI\CreditCardType();
            $creditCard->setCardNumber($req['cardnumber']);
            $creditCard->setExpirationDate($cardExpiryYearMonth);
            $creditCard->setCardCode($req['cvv']);

            // Add the payment data to a paymentType object
            $paymentOne = new AnetAPI\PaymentType();
            $paymentOne->setCreditCard($creditCard);

            // Create order information
            $order = new AnetAPI\OrderType();
            $order->setDescription($req['item_name']);

            // Set the customer's identifying information
            $customerData = new AnetAPI\CustomerDataType();
            $customerData->setType($this->configItem['type']);
            $customerData->setEmail($req['payer_email']);

            // Create a transaction
            $transactionRequestType = new AnetAPI\TransactionRequestType();
            $transactionRequestType->setTransactionType($this->configItem['txnType']);
            $transactionRequestType->setAmount($amount);
            $transactionRequestType->setOrder($order);
            $transactionRequestType->setPayment($paymentOne);
            $transactionRequestType->setCustomer($customerData);
            $request = new AnetAPI\CreateTransactionRequest();
            $request->setMerchantAuthentication($this->merchantAuthentication);
            $request->setRefId($refId);
            $request->setTransactionRequest($transactionRequestType);
            $controller = new AnetController\CreateTransactionController($request);
            $response = $controller->executeWithApiResponse(constant("\\net\authorize\api\constants\ANetEnvironment::$environment"));

            if ($response != null) {
                // Check to see if the API request was successfully received and acted upon
                if ($response->getMessages()->getResultCode() == "Ok") {
                    // Since the API request was successful, look for a transaction response
                    // and parse it to display the results of authorizing the card
                    $tresponse = $response->getTransactionResponse();

                    if ($tresponse != null && $tresponse->getMessages() != null) {
                        // Transaction info
                        $orderData['transaction_id'] = $tresponse->getTransId();
                        $orderData['payment_status'] = $response->getMessages()->getResultCode();
                        $orderData['payment_response'] = $tresponse->getResponseCode();
                        $orderData['auth_code'] = $tresponse->getAuthCode();
                        $orderData['message_code'] = $tresponse->getMessages()[0]->getCode();
                        $orderData['message_desc'] = $tresponse->getMessages()[0]->getDescription();

                        $ordStatus = 'success';
                        $statusMsg = 'Your Payment has been Successful!';
                    } else {
                        if ($tresponse->getErrors() != null) {
                            $error .= " Error Message : " . $tresponse->getErrors()[0]->getErrorText() . "<br/>";
                        }
                        $statusMsg = $error;
                    }
                    // Or, print errors if the API request wasn't successful
                } else {
                    $tresponse = $response->getTransactionResponse();

                    if ($tresponse != null && $tresponse->getErrors() != null) {
                        $error .= " Error Message : " . $tresponse->getErrors()[0]->getErrorText() . "<br/>";
                    } else {
                        $error .= " Error Message : " . $response->getMessages()->getMessage()[0]->getText() . "<br/>";
                    }
                    $statusMsg = $error;
                }
            } else {
                $statusMsg =  "Transaction Failed! No response returned";
            }

            $orderData['status'] = $ordStatus;
            $orderData['message'] = $statusMsg;

            return $orderData;

        } else {
            //throw exception
            throw new Exception('As of now Authorize.Net does not support PHP 7.4 and above.');
        }
    }

    public function cancelSubscription($subscriptionId)
    {
        if ($this->isSupported) {

            if ($this->configItem['testMode'] == true) {
                $environment = "SANDBOX";
            } else {
                $environment = "PRODUCTION";
            }
            // Set the transaction's refId
            $refId = 'ref' . time();

            $request = new AnetAPI\ARBCancelSubscriptionRequest();
            $request->setMerchantAuthentication($this->merchantAuthentication);
            $request->setRefId($refId);
            $request->setSubscriptionId($subscriptionId);

            $controller = new AnetController\ARBCancelSubscriptionController($request);

            $response = $controller->executeWithApiResponse(constant("\\net\authorize\api\constants\ANetEnvironment::$environment"));

            $res = [];
            if (($response != null) && ($response->getMessages()->getResultCode() == "Ok"))
            {
                $res['status'] = 'success';
                $successMessages = $response->getMessages()->getMessage();
                //            echo "SUCCESS : " . $successMessages[0]->getCode() . "  " .$successMessages[0]->getText() . "\n";

            }
            else
            {
                $errorMessages = $response->getMessages()->getMessage();
                //                echo "Response : " . $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText() . "\n";
                $res['status'] = 'error';
                $res['err_code'] = $errorMessages[0]->getCode();
                $res['msg'] = $errorMessages[0]->getText();
                //            echo "ERROR :  Invalid response\n";
                //            $errorMessages = $response->getMessages()->getMessage();
                //            echo "Response : " . $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText() . "\n";

            }

            return $res;

        } else {
            //throw exception
            throw new Exception('As of now Authorize.Net does not support PHP 7.4 and above.');
        }

    }

    function updateSubscription($req)
    {
        //check authorize.net supported or not
        if ($this->isSupported) {
        
            if ($this->configItem['testMode'] == true) {
                $environment = "SANDBOX";
            } else {
                $environment = "PRODUCTION";
            }
            // Set the transaction's refId
            $refId = 'ref' . time();

            $subscription = new AnetAPI\ARBSubscriptionType();
            // $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
            // $interval->setLength($req['plan_interval']);
            // $interval->setUnit($req['plan_unit']);

            $paymentSchedule = new AnetAPI\PaymentScheduleType();
            // $paymentSchedule->setInterval($interval);

            $subscription->setPaymentSchedule($paymentSchedule);
            $amount = $req['amount'];
            $subscription->setAmount($amount);


            if($req['is_edit_card'] == 1) {
                $creditCard = new AnetAPI\CreditCardType();
                $creditCard->setCardNumber($req['cardnumber']);
                $cardExpiryYearMonth = $req['expyear'].'-'.$req['expmonth'];
                $creditCard->setExpirationDate($cardExpiryYearMonth);
                $creditCard->setCardCode($req['cvv']);
                $payment = new AnetAPI\PaymentType();
                $payment->setCreditCard($creditCard);
                $subscription->setPayment($payment);
            }


            //set profile information
            // $profile = new AnetAPI\CustomerProfileIdType();
            // $profile->setCustomerProfileId("121212");
            // $profile->setCustomerPaymentProfileId("131313");
            // $profile->setCustomerAddressId("141414");


            //set customer profile information
            //$subscription->setProfile($profile);
            
            $request = new AnetAPI\ARBUpdateSubscriptionRequest();
            $request->setMerchantAuthentication($this->merchantAuthentication);
            $request->setRefId($refId);
            $request->setSubscriptionId($req['order_id']);
            $request->setSubscription($subscription);
            $controller = new AnetController\ARBUpdateSubscriptionController($request);

            $response = $controller->executeWithApiResponse(constant("\\net\authorize\api\constants\ANetEnvironment::$environment"));
            
            $res = [];
            if (($response != null) && ($response->getMessages()->getResultCode() == "Ok") )
            {
    //                echo "SUCCESS: Subscription ID : " . $response->getSubscriptionId() . "\n";
                $res['status'] = 'success';
                // $res['subscription_id'] = $response->getSubscriptionId();

            }
            else
            {
    //                echo "ERROR :  Invalid response\n";
                $errorMessages = $response->getMessages()->getMessage();
    //                echo "Response : " . $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText() . "\n";
                $res['status'] = 'error';
                $res['err_code'] = $errorMessages[0]->getCode();
                $res['msg'] = $errorMessages[0]->getText();
            }

            return $res;
            
        } else {
            //throw exception
            throw new Exception('As of now Authorize.Net does not support PHP 7.4 and above.');
        }

      }



}