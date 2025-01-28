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



    public function updateDiscountCodeCart(){
        $promo_code = $this->input->post('promo_code');
        $discount = $this->input->post('discount');
        // var_dump(strlen($promo_code) === 0,  gettype($discount), $discount === '-1');
        $user_id =  $this->input->post('userId'); // Assuming you are using session for user authentication
        // echo $promo_code . $discount .$user_id;
        if ($promo_code && $discount && $user_id) {
            $this->cart_model->updateDiscountCodeToCart($promo_code, $discount, $user_id);
            echo "Discount code and discount updated successfully.";
        } elseif(strlen($promo_code) === 0 &&  $discount === '-1') {
            $this->cart_model->updateDiscountCodeToCart(null, null, $user_id);
            echo "Discount code and discount removed successfully.";
        }
         else {
            echo "Invalid data provided.";
        }
    }

    public function isPromoApplied(){
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
    
    public function checkPromoCode() {
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
            // echo print_r($row);

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
        print_r($order_code);
      
        $this->cart_model->order_placing_mail($order_code);
        // $this->session->sess_destroy();
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

    public function session_destroy() {
        $user_id = $this->session->userdata('user_id');

        // die();
        
        // Load the user model
        $this->load->model('User_model');
        
        if ($this->User_model->is_guest($user_id) == 1){
        $this->session->sess_destroy();
        // Optionally return a response
        echo json_encode(['status' => 'success']);
        }
    }

    // add_to_cart method add items to the cart
    function add_to_cart()
    {
       
        if ($this->cart_model->add_to_cart()) {
            echo sanitize($this->cart_model->total_cart_items());
            return true;
        } else {
            echo "multi_restaurant";
        }
    }

    // Update method is responsible for Updating the restaurant types
    function update_cart()
    {
        $updated_price = $this->cart_model->update_cart();
        echo $updated_price;
    }

    function reload_cart_summary()
    {
        $this->load->view(frontend('cart/summary'));
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

    public function get_order_summary(){
        $data['sub_total'] =  currency(sanitize($this->cart_model->get_total_menu_price()));
        // $data['total_delivery_charge'] =  currency(sanitize($this->cart_model->get_total_delivery_charge()));
        $data['total_delivery_charge'] =  0;
        $data['vat_charges'] =  currency(sanitize($this->cart_model->get_vat_amount()));
        $data['grand_total'] =  currency(sanitize($this->cart_model->get_grand_total()));
        $data['total_service_price'] = currency(sanitize($this->cart_model->get_service_amount()));
        echo json_encode($data);
    }
}