<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Checkout_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
    }

    // VALIDATE PAYPAL PAYMENT AFTER PAYING
    public function paypal_payment($paymentID = "")
    {
        $paypal_keys = get_payment_settings('paypal');
        $paypal_data = json_decode($paypal_keys);

        if ($paypal_data[0]->mode == 'sandbox') {
            $paypalURL       = 'https://api.sandbox.paypal.com/v1/';
        } else {
            $paypalURL       = 'https://api.paypal.com/v1/';
        }

        if ($paypal_data[0]->mode == 'sandbox') {
            $paypalClientID = $paypal_data[0]->sandbox_client_id;
            $paypalSecret   = $paypal_data[0]->sandbox_secret_key;
        } else {
            $paypalClientID = $paypal_data[0]->production_client_id;
            $paypalSecret   = $paypal_data[0]->production_secret_key;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $paypalURL . 'oauth2/token');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $paypalClientID . ":" . $paypalSecret);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        $response = curl_exec($ch);
        curl_close($ch);

        if (empty($response)) {
            return false;
        } else {
            $jsonData = json_decode($response);
            $curl = curl_init($paypalURL . 'payments/payment/' . $paymentID);
            curl_setopt($curl, CURLOPT_POST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . $jsonData->access_token,
                'Accept: application/json',
                'Content-Type: application/xml'
            ));
            $response = curl_exec($curl);
            curl_close($curl);

            // Transaction data
            $result = json_decode($response);

            // CHECK IF THE PAYMENT STATE IS APPROVED OR NOT
            if ($result && $result->state == 'approved') {
                return true;
            } else {
                return false;
            }
        }
    }


    // VALIDATING STRIPE PAYMENT
    public function stripe_payment($session_id)
    {
        $stripe_keys = get_payment_settings('stripe');
        // var_dump($stripe_keys); die();
        $values = json_decode($stripe_keys);
        if ($values[0]->testmode == 'on') {
            $public_key = $values[0]->public_key;
            $secret_key = $values[0]->secret_key;
        } else {
            $public_key = $values[0]->public_live_key;
            $secret_key = $values[0]->secret_live_key;
        }

        // Stripe API configuration
        define('STRIPE_API_KEY', $secret_key);
        define('STRIPE_PUBLISHABLE_KEY', $public_key);

        $status_msg = '';
        $transaction_id = '';
        $paid_amount = '';
        $paid_currency = '';
        $payment_status = '';

        // Check whether stripe checkout session is not empty
        if ($session_id != "") {
            // Include Stripe PHP library
            require_once APPPATH . 'libraries/Stripe/init.php';

            // Set API key
            \Stripe\Stripe::setApiKey(STRIPE_API_KEY);

            // Fetch the Checkout Session to display the JSON result on the success page
            try {
                $checkout_session = \Stripe\Checkout\Session::retrieve($session_id);
            } catch (Exception $e) {
                $api_error = "no error";
                $api_error = $e->getMessage();
            }

            if (empty($api_error) && $checkout_session) {
                // Retrieve the details of a PaymentIntent
                try {
                    $intent = \Stripe\PaymentIntent::retrieve($checkout_session->payment_intent);
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    $api_error = $e->getMessage();
                }

                // Retrieves the details of customer
                try {
                    // Create the PaymentIntent
                    $customer = \Stripe\Customer::retrieve($checkout_session->customer);
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    $api_error = $e->getMessage();
                }

                if (empty($api_error) && $intent) {
                    // Check whether the charge is successful
                    if ($intent->status == 'succeeded') {
                        // Customer details
                        $name = $customer->name;
                        $email = $customer->email;

                        // Transaction details
                        $transaction_id = $intent->id;
                        $paid_amount = ($intent->amount / 100);
                        $paid_currency = $intent->currency;
                        $payment_status = $intent->status;

                        // If the order is successful
                        if ($payment_status == 'succeeded') {
                            $status_msg = site_phrase("Your_Payment_has_been_Successful");
                        } else {
                            $status_msg = site_phrase("Your_Payment_has_failed");
                        }
                    } else {
                        $status_msg = site_phrase("Transaction_has_been_failed");;
                    }
                } else {
                    $status_msg = site_phrase("Unable_to_fetch_the_transaction_details") . ' ' . $api_error;
                }

                $status_msg = 'success';
            } else {
                $status_msg = site_phrase("Transaction_has_been_failed") . ' ' . $api_error;
            }
        } else {
            $status_msg = site_phrase("Invalid_Request");
        }

        $response['status_msg'] = $status_msg;
        $response['transaction_id'] = $transaction_id;
        $response['paid_amount'] = $paid_amount;
        $response['paid_currency'] = $paid_currency;
        $response['payment_status'] = $payment_status;
        $response['stripe_session_id'] = $session_id;
        $response['payment_method'] = 'stripe';

        return $response;
    }
    // INSERT TO PAYMENT TABLE
    public function cash_on_delivery()
    {
        $data['amount_to_pay'] = $this->cart_model->get_grand_total();
        $data['amount_paid'] = 0;
        $data['payment_method'] = "cash_on_delivery";
        $data['data'] = json_encode([]);
        $data['created_at'] = strtotime(date('D, d-M-Y'));

        $order_code = $this->order_model->confirm();
        $data['order_code'] = $order_code;

        $this->db->insert('payment', $data);

        // if($order_type == "collection")
        //     $order_type = "pickup";
          
        $order_type = isset($_POST['order_type']) && $_POST['order_type'] == "collection" && get_order_settings('pickup_order') ? "pickup" : "delivery";
    
        // print_r($order_type);
        // die();

        if ($order_type == "pickup") {
            $order_data  = $this->order_model->get_by_code($order_code);
            $grand_total = $data['amount_to_pay'] - $order_data['total_delivery_charge'];
            $updater = ['order_type' => $order_type, 'total_delivery_charge' => 0, 'grand_total' => $grand_total, 'driver_id' => null];
        } else {
            
            $billing_data =  $this->session->userdata('billing');
            $json_billing_data = json_encode($billing_data);


            $address_data = $this->session->userdata('address');
            $json_address_data = json_encode($address_data);
            $updater = ['order_type' => $order_type,'billing'=> $json_billing_data,'address'=> $json_address_data];
        }
        $this->db->where('code', $order_code);
        //billing data is inserting here
        $this->db->update('orders', $updater);
        return true;
    }

    // INSERT TO PAYMENT TABLE
    public function paid_with_paypal($order_type, $amount_paid, $address_id, $paymentID, $paymentToken, $payerID)
    {
        // CHECK IF THE PAYMENT ID IS DUPLICATE
        $check_duplication = $this->db->get_where('payment', array('identifier' => $paymentID))->num_rows();
        if ($check_duplication > 0) {
            error(site_phrase('invalid_payment'), site_url('cart'));
        }
        // IF THE PAYMENT ID IS UNIQUE
        $data['amount_to_pay'] = $this->cart_model->get_grand_total();
        $data['amount_paid'] = $amount_paid;
        $data['payment_method'] = "paypal";
        $data['identifier'] = $paymentID;
        $data['data'] = json_encode(['payment_id' => $paymentID, 'payment_token' => $paymentToken, 'payer_id' => $payerID]);
        $data['created_at'] = strtotime(date('D, d-M-Y'));

        $order_code = $this->order_model->confirm($address_id);
        $data['order_code'] = $order_code;

        $this->db->insert('payment', $data);

        $order_type = isset($order_type) && $order_type == "pickup" && get_order_settings('pickup_order') ? "pickup" : "delivery";
        if ($order_type == "pickup") {
            $updater = ['order_type' => $order_type, 'driver_id' => null];
        } else {
            $updater = ['order_type' => $order_type];
        }
        $this->db->where('code', $order_code);
        $this->db->update('orders', $updater);
        return true;
    }

    // INSERT TO PAYMENT TABLE
    public function paid_with_stripe($address_id, $order_type, $stripe_payment_data)
    {
        // CHECK IF THE PAYMENT ID IS DUPLICATE
        $check_duplication = $this->db->get_where('payment', array('identifier' => $stripe_payment_data['stripe_session_id']))->num_rows();
        if ($check_duplication > 0) {
            error(site_phrase('invalid_payment'), site_url('cart'));
        }
        // IF THE PAYMENT ID IS UNIQUE
        $data['amount_to_pay'] = $this->cart_model->get_grand_total();
        $data['amount_paid'] = $stripe_payment_data['paid_amount'];
        $data['payment_method'] = "stripe";
        $data['identifier'] = $stripe_payment_data['stripe_session_id'];
        $data['data'] = json_encode(['transaction_id' => $stripe_payment_data['transaction_id'], 'paid_currency' => $stripe_payment_data['paid_currency'], 'stripe_session_id' => $stripe_payment_data['stripe_session_id']]);
        $data['created_at'] = strtotime(date('D, d-M-Y'));

        // This is creating a new order row. 
        $order_code = $this->order_model->confirm($address_id);

        $data['order_code'] = $order_code;

        $this->db->insert('payment', $data);

        $order_type = isset($order_type) && $order_type == "pickup" && get_order_settings('pickup_order') ? "pickup" : "delivery";
        if ($order_type == "pickup") {
            $updater = ['order_type' => $order_type, 'driver_id' => null];
        } else {
                
            $billing_data =  $this->session->userdata('billing');
            $json_billing_data = json_encode($billing_data);


            $address_data = $this->session->userdata('address');
            $json_address_data = json_encode($address_data);
            $updater = ['order_type' => $order_type,'billing'=> $json_billing_data,'address'=> $json_address_data];

            // $updater = ['order_type' => $order_type];
        }
        $this->db->where('code', $order_code);
        $this->db->update('orders', $updater);

        return true;
    }
}
