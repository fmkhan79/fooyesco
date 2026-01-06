<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 25 - July - 2020
 * Author : TheDevs
 * Cart Controller controlls the task for a Cart
 */

include 'Base.php';
class Cart extends Base
{



    public function updateDiscountCodeCart()
    {
        $promo_code = $this->input->post('promo_code');
        $discount = $this->input->post('discount');
        // var_dump(strlen($promo_code) === 0,  gettype($discount), $discount === '-1');
        $user_id =  $this->input->post('userId'); // Assuming you are using session for user authentication
        // echo $promo_code . $discount .$user_id;
        if ($promo_code && $discount && $user_id) {
            $this->cart_model->updateDiscountCodeToCart($promo_code, $discount, $user_id);
            echo "Discount code and discount updated successfully.";
        } elseif (strlen($promo_code) === 0 &&  $discount === '-1') {
            $this->cart_model->updateDiscountCodeToCart(null, null, $user_id);
            echo "Discount code and discount removed successfully.";
        } else {
            echo "Invalid data provided.";
        }
    }

    public function isPromoApplied()
    {
        // getDiscountCodeToCart
        // $promo_code = $this->input->post('promo_code');
        // $user_id = $this->input->post('userId'); // Assuming you are using session for user authentication

        $response = $this->cart_model->getDiscountCodeToCart();
        if (!empty($response)) {
            echo json_encode($response);
            return true;
        }
        return false;
    }

    public function checkPromoCode()
    {
        // Get promo code and amount from AJAX request
        $promoCode = $this->input->post('promo_code');
        $amount = $this->input->post('amount');

        // Current date
        $currentDate = date('Y-m-d');

        // Query to check if the promo code is valid
        $this->db->select('discount_percentage, amount_limit');
        $this->db->from('offers');
        $this->db->where('promo_code', $promoCode);
        $this->db->where('start_date <=', $currentDate);
        $this->db->where('end_date >=', $currentDate);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();

            $discountPercentage = $row->discount_percentage;

            // Check if order amount is greater than or equal to amount limit
            // Assuming 'amount_limit' is a column in the 'offers' table
            // You may need to adjust this part based on your database schema
            $amountLimit = $row->amount_limit;
            if ($amount >= $amountLimit) {
                // Promo code is valid, send back the discount percentage
                echo $discountPercentage;
            } else {
                echo "Order amount is less than the required amount for this promo code.";
            }
        } else {
            echo "Invalid promo code.";
        }
    }
    // SENDING ORDER PLACING MAILS FROM THIS FUNCTION
    public function order_placing_mail($order_code)
    {

        $this->cart_model->order_placing_mail($order_code);
        // $this->session->sess_destroy();
    }

    public function cancel_order_frontend($order_code)
    
    {
        $is_valid = $this->order_model->is_valid($order_code);
        if (!$is_valid) {
            error(get_phrase('nothing_found'), site_url('orders'));
        }

        $response = $this->order_model->cancel($order_code);
        if ($response) {
            $this->db->set('customer_cancel', 1);       
            $this->db->set('no_response', 0);     
              $this->db->set('read_status', 1);             
             $this->db->set('order_status', 'canceled');     
            $this->db->where('code', $order_code);
            $this->db->update('orders');

            success(get_phrase('order_canceled_successfully'), site_url());
        } else {
            error(get_phrase('the_order_can_not_be_canceled'), site_url('orders/details/' . $order_code));
        }
     
    }

    function damn()
    {
        echo $this->session->userdata('user_id');
    }

    function check_customer_login()
    {
        if (!$this->session->userdata('customer_login') && !$this->session->userdata('owner_login')) {
            return false;
        }
        return true;
    }
    // index function responsible for showing the index page.
    function index()
    {

        // redirect('/site/restaurant/chilli-hut-march/3');
        // $user_id = $this->session->userdata('user_id'); // or null for guest
        //    die();

        $user_id = $this->session->userdata('user_id');

        // die();

        // Load the user model
        $this->load->model('User_model');
        // $guest_check = $this->User_model->is_guest($user_id) == 1;
        // $this->session->set_userdata($guest_check);

        if ($this->User_model->is_guest($user_id) == 1) {
            $page_data['page_name']  = 'cart/index';
            $page_data['page_title'] = get_phrase("your_cart", true);
            $this->load->view(frontend('index'), $page_data);

            //  $this->session->sess_destroy();

        } else {
            $page_data['page_name']  = 'cart/index';
            $page_data['page_title'] = get_phrase("your_cart", true);
            $this->load->view(frontend('index'), $page_data);
        }
    }

    // public function session_destroy() {
    //     $user_id = $this->session->userdata('user_id');

    //     // die();

    //     // Load the user model
    //     $this->load->model('User_model');

    //     if ($this->User_model->is_guest($user_id) == 1){
    //     $this->session->sess_destroy();
    //     // Optionally return a response
    //     echo json_encode(['status' => 'success']);
    //     }
    // }

    // add_to_cart method add items to the cart
    function add_to_cart()
    {


        $user_id = $this->session->userdata('user_id');
        $session_id = session_id();

        // Set visited_at with Europe/London timezone
        $dt = new DateTime('now', new DateTimeZone('Europe/London'));
        $visited_at = $dt->format('Y-m-d H:i:s');

        $ip_address = $this->get_user_ip();

        $user_agent = $_SERVER['HTTP_USER_AGENT'];


        $this->db->insert('cart_visits', [
            'user_id' => $user_id,
            'session_id' => $session_id,
            'visited_at' => $visited_at,
            'ip_address'   => $ip_address, // <-- new field
            'user_agent'   => $user_agent, // <-- new field
            'info_add' => 0,
            'order_placed' => 0,
            'name_add' => 0

        ]);

        if ($this->cart_model->add_to_cart()) {
            echo sanitize($this->cart_model->total_cart_items());
            return true;
        } else {
            echo "multi_restaurant";
        }
    }

    private function get_user_ip()
    {
        $ip = '';

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // Could contain multiple IPs: client, proxy1, proxy2...
            $ip_list = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = trim($ip_list[0]); // First one is the real client IP
        } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        // Handle localhost during testing
        if ($ip === '::1') {
            $ip = '127.0.0.1';
        }

        return $ip;
    }


    // Update method is responsible for Updating the restaurant types
    function update_cart()
    {
        $updated_price = $this->cart_model->update_cart();
        echo $updated_price;
    }

    function reload_cart_summary()
    {
        return true;
    }

    // Delete method is responsible for storing data
    function delete($id)
    {

        $response = $this->cart_model->delete($id);
        if ($response) {
            success(get_phrase('item_deleted_successfully'), site_url('cart'));
        } else {
            error(get_phrase('an_error_occurred'), site_url('cart'));
        }
    }

    // GET MENU DETAILS INCLUDING VARIANTS
    public function get_menu_details_with_variants_and_addons()
    {
        $response = $this->cart_model->get_menu_details_with_variants_and_addons();
        echo $response;
    }

    public function set_delivery_charges()
    {   
        $charges = $this->input->post('delivery_charges');
        $this->session->set_userdata('delivery_charges', $charges);
    }

    // public function get_order_summary()
    // {

    //     $order_type = isset($_POST['order_type']) ? sanitize($_POST['order_type']) : '';

    //     $subtotal = sanitize($this->cart_model->get_total_menu_price());
    //     $serviceCharge = sanitize($this->cart_model->get_service_amount());
    //     $bagCharges = number_format((float) sanitize($this->cart_model->get_bag_charges($order_type)), 2, '.', '');
    //     $discountedAmount = number_format((float) sanitize($this->cart_model->get_discounted_amount($order_type)), 2, '.', '');

    //     $data['sub_total'] =  currency($subtotal);


    //     $data['total_service_price'] = currency($serviceCharge);

    //     $data['bag_price'] = currency($bagCharges);

    //     $data['total_discount_applied'] = $this->cart_model->get_total_discount_applied_percentage($order_type) . "%";
    //     $data['discounted_amount']  =  currency($discountedAmount);

    //     $data['grand_total'] = currency($subtotal + $serviceCharge + $bagCharges - $discountedAmount);

    //     echo json_encode($data);
    // }

    public function get_order_summary()
{
    $order_type = isset($_POST['order_type']) ? sanitize($_POST['order_type']) : '';
    $deliveryCharge = $this->session->userdata('delivery_charges');
    $subtotal = sanitize($this->cart_model->get_total_menu_price());
    $serviceCharge = sanitize($this->cart_model->get_service_amount());
    $bagCharges = number_format((float) sanitize($this->cart_model->get_bag_charges($order_type)), 2, '.', '');

    // ✅ Load restaurant ID (from session or order)
    $restaurant_id = $this->session->userdata('restaurant_id');

    // Promo session check
    $promo = $this->session->userdata('applied_promo');
    $promo_discount = 0;
    $discountedAmount = 0;
    $discountLabel = '0%';

    if (!empty($promo) && isset($promo['discount'])) {
        $discountLabel = $promo['discount'] . '%';
        $promo_discount = ($subtotal * $promo['discount']) / 100;

        if ($promo['add_on_by_default'] == true) {
            $this->session->set_userdata('is_online_discount_checked', true);

            // ✅ Pass restaurant_id to get_discounted_amount
            $discountedAmount = (float) sanitize($this->cart_model->get_discounted_amount($order_type, $restaurant_id));

            // ✅ Include restaurant discount label
            $discountLabel .= ' + ' . $this->cart_model->get_total_discount_applied_percentage($order_type, $restaurant_id) . '%';
        }

    } else {
        // ✅ Pass restaurant_id here too
        $discountedAmount = number_format((float) sanitize($this->cart_model->get_discounted_amount($order_type, $restaurant_id)), 2, '.', '');
        $discountLabel = $this->cart_model->get_total_discount_applied_percentage($order_type, $restaurant_id) . "%";
    }

    $totalDiscount = $discountedAmount + $promo_discount;
    $grandTotal = $subtotal + $serviceCharge + $bagCharges + $deliveryCharge - $totalDiscount;

    $data = [
        'sub_total' => currency($subtotal),
        'total_service_price' => currency($serviceCharge),
        'bag_price' => currency($bagCharges),
        'total_discount_applied' => $discountLabel,
        'discounted_amount' => currency($totalDiscount),
        'grand_total' => currency($grandTotal, 2)
    ];

    echo json_encode($data);
}


}
