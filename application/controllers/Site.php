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
        $host = get_subdomain();
        $checkSlugInDb = $this->restaurant_model->find_slug($host);

        if($checkSlugInDb){    
            $page_data['reviews_count'] = 0;

            $page_data['restaurant_details'] = $this->restaurant_model->get_by_slug($host);
            $page_data['page_name']          = 'restaurant/index';
            $page_data['page_title']         = site_phrase("restaurant", true);

            
            $restaurant_id = $page_data['restaurant_details']['id'];
            
            if (isset($restaurant_id) && trim($restaurant_id) !== '') {
                // print_r($restaurant_id)
                $page_data['reviews_count'] = count($this->review_model->get_by_restaurantr_id($restaurant_id));
            }

            $this->load->view(frontend('index'), $page_data);
            return;
        }
        

        $page_data['page_name']        = 'home/index';
        $page_data['page_title']       = site_phrase("home", true);
        $page_data['featured_cuisines'] = $this->cuisine_model->get_featured_cuisine();
        $page_data['popular_restaurants'] = $this->restaurant_model->get_popular_restaurants(9);
        $page_data['featured_restaurants'] = $this->restaurant_model->get_all(6);
        $page_data['cuisines']    = $this->cuisine_model->get_all();
        $page_data['categories'] = $this->category_model->get_featured_categories();
        $page_data['test'] = $this->cuisine_model->get_all(1);

        $this->load->view(frontend('index'), $page_data);
    }

    // RESTAURANT FUNCTION IS RESPONSIBLE FOR SHOWING THE RESTAURANT DETAILS PAGE
    function restaurant($slug = '', $id = '')
    {

        $page_data['reviews_count'] = 0;

        $page_data['restaurant_details'] = $this->restaurant_model->get_by_id($id);
        $page_data['page_name']          = 'restaurant/index';
        $page_data['page_title']         = site_phrase("restaurant", true);

        // print_r($page_data);
        if (isset($restaurant_id) && trim($restaurant_id) !== '') {
            // print_r($restaurant_id)
            $page_data['reviews_count'] = count($this->review_model->get_by_restaurantr_id($restaurant_id));
        }

        $this->load->view(frontend('index'), $page_data);
    }

   // THIS FUNCTION IS RESPONSIBLE FOR RETURNING THE POUP BODY WITH THE SELCTED MENU
    function selected_menu($menuid){
        $data["menuid"] = $menuid;
        $this->load->view("frontend/default/menu/_selected_menu",$data);
    }

    function selected_cat_items($maincatid,$option = null){
        $data["option"] = $option;
        $data["maincatid"] = $maincatid;
        $this->load->view("frontend/default/menu/_sub_catagories_and_items.php",$data);
    }


    function selected_cat_items_summary(){
        $this->load->view("frontend/default/restaurant/ordersummary.php");
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
    public function terms_of_use() {
         $host = get_subdomain();
        $checkSlugInDb = $this->restaurant_model->find_slug($host);

        if($checkSlugInDb){

            $page_data['restaurant_details'] = $this->restaurant_model->get_by_slug($host);
            $page_data['page_name'] = 'terms_of_use/index';
            $page_data['page_title'] = site_phrase("terms_of_use", true);
            $this->load->view(frontend('index'), $page_data);
            return;
        }
        $page_data['page_name'] = 'terms_of_use/index';
        $page_data['page_title'] = site_phrase("terms_of_use", true);
        $this->load->view(frontend('index'), $page_data);
    }
    /**
     * THIS FUNCTION IS RESPONSIBLE FOR SHOWING THE ABOUT US PAGE
     *
     * @return void
     */
    public function become_a_partner() {
        $page_data['page_name'] = 'become_a_partner/index';
        $page_data['page_title'] = site_phrase("become_a_partner", true);
        $this->load->view(frontend('index'), $page_data);
    }
    /**
     * THIS FUNCTION IS RESPONSIBLE FOR SHOWING THE ABOUT US PAGE
     *
     * @return void
     */
public function contact_us() {
    $host = get_subdomain();
    $page_data['reCaptcha'] = $this->settings_model->get_system_recaptcha();
    $page_data['page_name'] = 'contact_us/index';
    $page_data['page_title'] = site_phrase("contact_us", true);

    try {
        if ($host !== 'fooyes' && $host !== 'staging') {
            $checkSlugInDb = $this->restaurant_model->find_slug($host);
            if ($checkSlugInDb) {
                $page_data['restaurant'] = $this->restaurant_model->get_by_slug($host);
            }
        }
        $this->load->view(frontend('index'), $page_data);
    } catch (Exception $e) {
        log_message('error', 'Contact Us Error: ' . $e->getMessage());
        $this->session->set_flashdata('error', 'An error occurred. Please try again later.');
        $this->load->view(frontend('index'), $page_data);
    }
}
    /**
     * THIS FUNCTION IS RESPONSIBLE FOR SHOWING THE ABOUT US PAGE
     *
     * @return void
     */
    public function about_us() {
        $page_data['page_name'] = 'about_us/index';
        $page_data['page_title'] = site_phrase("about_us", true);
        $this->load->view(frontend('index'), $page_data);
    }

    /**
     * THIS FUNCTION IS RESPONSIBLE FOR SHOWING THE HOW TO ORDER
     *
     * @return void
     */
    public function how_to_order()
    {
        $page_data['page_name']        = 'how_to_order/index';
        $page_data['page_title']       = 'How to Order';
        $this->load->view(frontend('index'), $page_data);
    }

    /**
     * THIS FUNCTION IS RESPONSIBLE FOR SHOWING THE PRIVACY POLICY PAGE
     *
     * @return void
     */
    public function privacy_policy()
    {
        $host = get_subdomain();

        // default null rakhen
        $page_data['restaurant_details'] = null;

        if ($host != 'fooyes' && $host != 'staging') {
            $checkSlugInDb = $this->restaurant_model->find_slug($host);

            if ($checkSlugInDb) {
                $page_data['restaurant_details'] = $this->restaurant_model->get_by_slug($host);
            }
        }

        $page_data['page_name']  = 'privacy_policy/index';
        $page_data['page_title'] = site_phrase("privacy_policy", true);
        $this->load->view(frontend('index'), $page_data);
    }


    /**
     * THIS FUNCTION IS RESPONSIBLE FOR SHOWING THE TERMS AND CONDITIONS PAGE
     *
     * @return void
     */
    public function terms_and_conditions()
    {
        $host = get_subdomain();
        $checkSlugInDb = $this->restaurant_model->find_slug($host);

        if($checkSlugInDb){

            $page_data['restaurant_details'] = $this->restaurant_model->get_by_slug($host);
            $page_data['page_name']        = 'terms_and_conditions/index';
            $page_data['page_title']       = site_phrase("terms_and_conditions", true);
            $this->load->view(frontend('index'), $page_data);
            return;
        }

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

    public function get_menu_info($menu_id) {
    $menu = $this->menu_model->get_by_id($menu_id);
    $response = [
        'price' => json_decode($menu['price'])->menu,
        'has_variant' => $menu['has_variant']
    ];
    echo json_encode($response);
}

public function get_restaurants_by_category($category_id)
{
    $category_id = sanitize($category_id);

    // Us category ka naam nikaalo
    $category = $this->db->get_where('food_categories', ['id' => $category_id])->row_array();
    $category_name = $category ? $category['name'] : 'Category';

    // Us category ke menus nikaalo
    $menus = $this->menu_model->get_menu_by_condition([
        'category_id' => $category_id
    ]);

    $uniqueRestaurants = array();

    if (!empty($menus)) {
        foreach ($menus as $menu) {
            $restId = $menu['restaurant_id'];
            if (!isset($uniqueRestaurants[$restId])) {
                $uniqueRestaurants[$restId] = [
                    'data' => $this->restaurant_model->get_by_id($restId),
                    'category_name' => $category_name
                ];
            }
        }
    }

    // Agar koi restaurant nahi mila
    if (empty($uniqueRestaurants)) {
        echo '<p class="text-center text-muted">No restaurants found for this category.</p>';
        return;
    }

    // Restaurants ka HTML cards return karo
    foreach ($uniqueRestaurants as $restaurantInfo) {
        $restaurant = $restaurantInfo['data'];
        $catName = $restaurantInfo['category_name'];
        ?>
        <div class="card grid-item restaurant-card col-lg-3 col-md-6 mb-lg-0 mb-5">
            <div class="order-img-box main-img">
                <a href="<?php echo site_url('site/restaurant/' . sanitize(rawurlencode($restaurant['slug'])) . '/' . sanitize($restaurant['id'])); ?>">
                    <img src="<?php echo base_url('uploads/restaurant/thumbnail/' . sanitize($restaurant['thumbnail'])); ?>" alt="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="250" height="250" viewBox="0 0 250 250" fill="none">
                        <circle cx="125.035" cy="124.965" r="116.153" transform="rotate(178.687 125.035 124.965)"
                            stroke="url(#paint0_linear_33_536)" stroke-width="16"></circle>
                        <defs>
                            <linearGradient id="paint0_linear_33_536" x1="131.787" y1="144.132" x2="131.787"
                                y2="280.046" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#F57484" stop-opacity="0"></stop>
                                <stop offset="1" stop-color="#FDC55E"></stop>
                            </linearGradient>
                        </defs>
                    </svg>
                </a>
            </div>
            <div class="restaurant-body text-center">
                <h3><?php echo sanitize($restaurant['name']); ?></h3>
                <h6><?php echo sanitize($catName); ?></h6>
                <p><?php echo sanitize($restaurant['name']); ?> provides different products in <?php echo sanitize($catName); ?>.</p>
            </div>
            <a class="btn btn-danger"
                href="<?php echo site_url('site/restaurant/' . sanitize(rawurlencode($restaurant['slug'])) . '/' . sanitize($restaurant['id']) . '/#' . strtolower(str_replace(' ', '-', $catName))); ?>">Explore Menu</a>
        </div>
        <?php
    }
}



}

/* End of file Site.php */
