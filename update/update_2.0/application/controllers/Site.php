<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 14 - July - 2020
 * Author : TheDevs
 * Site Controller controlls the The Frontend Stuffs
 */

include 'Base.php';
class Site extends Base
{

    // INDEX FUNCTION IS RESPONSIBLE FOR SHOWING INDEX PAGE
    function index()
    {
        $page_data['page_name']        = 'home/index';
        $page_data['page_title']       = site_phrase("home", true);
        $page_data['featured_cuisines'] = $this->cuisine_model->get_featured_cuisine();
        $page_data['popular_restaurants'] = $this->restaurant_model->get_popular_restaurants(9);
        $page_data['categories'] = $this->category_model->get_featured_categories();
        $this->load->view(frontend('index'), $page_data);
    }

    // RESTAURANT FUNCTION IS RESPONSIBLE FOR SHOWING THE RESTAURANT DETAILS PAGE
    function restaurant($slug = "", $restaurant_id = "")
    {
        $page_data['restaurant_details'] = $this->restaurant_model->get_by_id($restaurant_id);
        $page_data['page_name']          = 'restaurant/index';
        $page_data['page_title']         = site_phrase("restaurant", true);
        $this->load->view(frontend('index'), $page_data);
    }

    // THIS FUNCTION IS RESPONSIBLE FOR SHOWING POPULAR RESTAURANT LIST
    function restaurants($type = "")
    {
        $page_data['cuisine']    = isset($_GET['cuisine']) ? sanitize($_GET['cuisine']) : "all";
        $page_data['category']   = isset($_GET['category']) ? sanitize($_GET['category']) : "all";
        if (empty($type) || $type == "popular") {
            $page_title = empty($type) ? site_phrase('restaurants', true) : site_phrase('popular_restaurants', true);
            $page_header = site_phrase('popular_restaurants');
            $order_by = 'rating';
            $condition['status'] = 1;
            $restaurants = $this->restaurant_model->get_popular_restaurants();
        } elseif ($type == "recent") {
            $page_title = site_phrase('recently_added_restaurants', true);
            $page_header = site_phrase('recently_added_restaurants');
            $order_by = 'id';
            $condition['status'] = 1;
            $restaurants = $this->restaurant_model->get_all_approved();
        } elseif ($type == "filter") {
            $page_title = site_phrase('filtered_restaurants', true);
            $page_header = site_phrase('filtered_restaurants');
            $order_by = 'rating';
            $restaurants = $this->restaurant_model->filter_restaurant_frontend(); // IT RETURNS ALL THE FILTERED RESTAURANT'S IDS
            $condition['id'] = $restaurants;
        }
        /**PAGINATION STARTS**/
        $total_rows = count($restaurants);
        $page_size = 15;
        $pagination_url = empty($type) ? site_url('site/restaurants') : site_url('site/restaurants/' . $type);
        $config = pagintaion($total_rows, $page_size, $pagination_url);
        $current_page = sanitize($this->input->get('page', 0));
        $this->pagination->initialize($config);

        $page_data['restaurants'] = $this->restaurant_model->merger($this->restaurant_model->paginate($page_size, $current_page, $condition, $order_by));
        /**PAGINATION ENDS**/

        $page_data['total_rows']  = $total_rows;
        $page_data['cuisines']    = $this->cuisine_model->get_all();
        $page_data['categories']  = $this->category_model->get_all();
        $page_data['page_name']   = 'restaurants/index';
        $page_data['page_header'] = $page_header;
        $page_data['page_title']  = $page_title;
        $page_data['type']        = $type;
        $this->load->view(frontend('index'), $page_data);
    }

    /**
     * THIS FUNCTION IS RESPONSIBLE FOR SHOWING THE ABOUT US PAGE
     *
     * @return void
     */
    public function about_us()
    {
        $page_data['page_name']        = 'about_us/index';
        $page_data['page_title']       = site_phrase("about_us", true);
        $this->load->view(frontend('index'), $page_data);
    }

    /**
     * THIS FUNCTION IS RESPONSIBLE FOR SHOWING THE PRIVACY POLICY PAGE
     *
     * @return void
     */
    public function privacy_policy()
    {
        $page_data['page_name']        = 'privacy_policy/index';
        $page_data['page_title']       = site_phrase("privacy_policy", true);
        $this->load->view(frontend('index'), $page_data);
    }

    /**
     * THIS FUNCTION IS RESPONSIBLE FOR SHOWING THE TERMS AND CONDITIONS PAGE
     *
     * @return void
     */
    public function terms_and_conditions()
    {
        $page_data['page_name']        = 'terms_and_conditions/index';
        $page_data['page_title']       = site_phrase("terms_and_conditions", true);
        $this->load->view(frontend('index'), $page_data);
    }

    /**
     * THIS FUNCTION IS RESPONSIBLE FOR SWITCHING LANGUAGE FROM FRONTEND
     *
     * @return void
     */
    public function site_language()
    {
        $selected_language = sanitize($this->input->post('language'));
        $this->session->set_userdata('language', $selected_language);
        echo true;
    }
}

/* End of file Site.php */
