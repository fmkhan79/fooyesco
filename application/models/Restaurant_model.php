<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 10 - June - 2020
 * Author : TheDevs
 * User model handles all the database queries of Users
 */

class Restaurant_model extends Base_model
{
    function __construct()
    {

        parent::__construct();
        $this->table = "restaurants";
    }

    /**
     * GET ALL THE RESTAURANTS WITHOUT ANY CONDITIONS
     *
     */
    public function get_all($limit = false)
    {
        $this->db->order_by("id", "desc");
        if ($limit) {
            $this->db->limit($limit);
        }
        return $this->db->get($this->table)->result_array();
    }

    /**
     * GET RESTAURANT USING ID WITHOUT ANY CONDITIONS
     *
     */
    public function get_by_id($id)
    {
        $this->db->where('id', $id);
        $restaurants = $this->db->get($this->table);
        return $this->merger($restaurants, true);
    }

    /**
     * GET RESTAURANT USING CONDTIONS
     *
     * @param array $conditions
     */
    public function get_restaurants_by_condition($conditions = [])
    {
        foreach ($conditions as $key => $value) {
            if (!is_null($value)) {
                if (is_array($value)) {
                    $this->db->where_in($key, $value);
                } else {
                    $this->db->where($key, $value);
                }
            }
        }
        $this->db->order_by("id", "desc");
        return $this->db->get($this->table)->result_array();
    }

    public function get_all_approved()
    {
        if ($this->logged_in_user_role == "owner") {
            $this->db->where('owner_id', $this->logged_in_user_id);
        }
        $this->db->where('status', 1);
        $this->db->order_by("id", "desc");
        $restaurants = $this->db->get($this->table);
        return $this->merger($restaurants);
    }

    public function get_all_pending()
    {
        if ($this->logged_in_user_role == "owner") {
            $this->db->where('owner_id', $this->logged_in_user_id);
        }
        $this->db->where('status', 0);
        $this->db->order_by("id", "desc");
        $restaurants = $this->db->get($this->table);
        return $this->merger($restaurants);
    }

    // FETCH ALL THE RELATED DATA WITH RESTAURANT
    public function merger($query_obj, $is_single_row = false)
    {
        if (!$is_single_row) {
            $restaurants = $query_obj->result_array();
            foreach ($restaurants as $key => $restaurant) {
                $restaurant_owner_data = !empty($restaurant['owner_id']) ? $this->user_model->get_user_by_id($restaurant['owner_id']) : array();
                $restaurants[$key]['owner_name']  = isset($restaurant_owner_data['name']) ? $restaurant_owner_data['name'] : "";
                $restaurants[$key]['owner_email'] = isset($restaurant_owner_data['email']) ? $restaurant_owner_data['email'] : "";
                $restaurants[$key]['owner_phone'] = isset($restaurant_owner_data['phone']) ? $restaurant_owner_data['phone'] : "";
            }

            return $restaurants;
        } else {
            $restaurant = $query_obj->row_array();
            $restaurant_owner_data = !empty($restaurant['owner_id']) ? $this->user_model->get_user_by_id($restaurant['owner_id']) : array();
            $restaurant['owner_name']  = isset($restaurant_owner_data['name']) ? $restaurant_owner_data['name'] : "";
            $restaurant['owner_email'] = isset($restaurant_owner_data['email']) ? $restaurant_owner_data['email'] : "";
            $restaurant['owner_phone'] = isset($restaurant_owner_data['phone']) ? $restaurant_owner_data['phone'] : "";
            return $restaurant;
        }
    }

    // THIS METHOD WILL SAVE ONLY THE RESTAURANT BASIC DATA
    public function store()
    {
        $data['name']       = required(sanitize($this->input->post('restaurant_name')));
        $data['slug']       = slugify($data['name']);
        $cuisine            = (isset($_POST['cuisine']) && !empty($_POST['cuisine'])) ? sanitize_array($this->input->post('cuisine')) : array();
        $data['cuisine']    = json_encode(array_map('intval', $cuisine));
        $data['created_at'] = strtotime(date('D, d-M-Y'));
        $data['status']     = $this->logged_in_user_role == 'admin' ? 1 : 0;

        if ($this->logged_in_user_role == "owner") {
            $data['owner_id'] = $this->logged_in_user_id;
        }

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    // PARENT FUNCTION FOR UPDATING A RESTAURANT
    public function update($section)
    {
        $id = required(sanitize($this->input->post('id')));
        // AUTHORIZATION IS A HELPER METHOD WHICH IS RESPONSIBLE FOR AUTHORIZING OPERATION
        if (has_access($this->table, $id)) {
            $dynamic_function_name = "update_" . $section;
            return $this->$dynamic_function_name();
        }
        return false;
    }

    // UPDATE BASIC INFOS FOR A RESTAURANT
    public function update_basic()
    {
        $id = required(sanitize($this->input->post('id')));
        $data['name']     = required(sanitize($this->input->post('restaurant_name')));
        $data['restaurant_about']     = $this->input->post('restaurant_about');
        $data['slug']     = slugify($data['name']);
        $cuisine = (isset($_POST['cuisine']) && !empty($_POST['cuisine'])) ? $this->input->post('cuisine') : array();
        $data['cuisine']  = json_encode(array_map('intval', $cuisine));
        $data['updated_at'] = strtotime(date('D, d-M-Y'));
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        return true;
    }

    // UPDATE ADDRESS AND PHONE INFOS FOR A RESTAURANT
    public function update_address()
    {
        $id = $this->input->post('id');
        $data['address']    = sanitize($this->input->post('restaurant_address'));
        $data['latitude']   = sanitize($this->input->post('restaurant_latitude'));
        $data['longitude']  = sanitize($this->input->post('restaurant_longitude'));
        $data['phone']      = sanitize($this->input->post('restaurant_phone'));
        $data['website']    = sanitize($this->input->post('restaurant_website_link'));
        $data['updated_at'] = strtotime(date('D, d-M-Y'));
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        return true;
    }

    // UPDATE OWNER INFOS FOR A RESTAURANT
    public function update_owner()
    {
        $id = required(sanitize($this->input->post('id')));

        // OWNER CAN BE UPDATED BY ADMIN ONLY
        if ($this->logged_in_user_role != "admin") {
            error(get_phrase('you_are_not_authorized_for_this_action'), site_url('restaurant'));
        }

        if (isset($_POST['restaurant_owner_type']) && !empty($_POST['restaurant_owner_type']) && $this->input->post('restaurant_owner_type') == 'new') { // FOR NEW RESTAURANT OWNER
            $restaurant_owner_data['name']     = sanitize($this->input->post('restaurant_owner_name'));
            $restaurant_owner_data['email']    = sanitize($this->input->post('restaurant_owner_email'));
            $restaurant_owner_data['password'] = sha1($this->input->post('restaurant_owner_password'));
            $restaurant_owner_data['role_id']  = 3; // RESTAURANT OWNER ROLE
            $restaurant_owner_data['status']   = 1;

            if (email_duplication($restaurant_owner_data['email'])) {
                $this->db->insert('users', $restaurant_owner_data);
                $data['owner_id'] = $this->db->insert_id();

                // INSERT USER ID IN THE CUSTOMER TABLE
                $owner_data['user_id'] = $data['owner_id'];
                $this->db->insert('customers', $owner_data);

                $this->db->where('id', $id);
                $this->db->update($this->table, $data);
            }

            return true;
        } elseif (isset($_POST['restaurant_owner_type']) && !empty($_POST['restaurant_owner_type']) && $this->input->post('restaurant_owner_type') == 'existing') { // FOR EXISTING RESTAURANT OWNER
            $data['owner_id'] = sanitize($this->input->post('restaurant_owner_id'));
            $this->db->where('id', $id);
            $this->db->update($this->table, $data);

            // BECOME A RESTAURANT OWNER IF HE / SHE IS A CUSTOMER
            $this->owner_model->become_restaurant_owner($data['owner_id']);

            return true;
        } else { // ERROR
            return false;
        }
    }

    // UPDATE DELIVERY DATA FOR A RESTAURANT
    public function update_delivery()
    {
        $id = required(sanitize($this->input->post('id')));
        $data['delivery_charge']     = sanitize($this->input->post('delivery_charge'));
        $data['maximum_time_to_deliver'] = sanitize($this->input->post('maximum_time_to_deliver'));
        $data['free_range'] = sanitize($this->input->post('free_range'));
        $data['maximum_range'] = sanitize($this->input->post('maximum_range'));
        $data['rate_per_mile'] = sanitize($this->input->post('rate_per_mile'));

        if (get_order_settings('pickup_order') && !get_order_settings('multi_restaurant_order') && isset($_POST['support_pickup_order']) && $_POST['support_pickup_order'] == 1) {
            $data['support_pickup_order'] = 1;
        } else {
            $data['support_pickup_order'] = 0;
        }
        
        $data['updated_at'] = strtotime(date('D, d-M-Y'));
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        return true;
    }

    // UPDATE SCHEDULE DATA FOR A RESTAURANT
    public function update_schedule()
    {
        $id = required(sanitize($this->input->post('id')));
        $days = ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
        $schedule = array();
        foreach ($days as $day) {
            if ($this->input->post($day . '_opening_is_closed')) {
                $schedule[$day . '_opening'] = "closed";
                $schedule[$day . '_closing'] = "closed";
            } else {
                $schedule[$day . '_opening'] = sanitize($this->input->post($day . '_opening')) ? sanitize($this->input->post($day . '_opening')) : "closed";
                $schedule[$day . '_closing'] = sanitize($this->input->post($day . '_closing')) ? sanitize($this->input->post($day . '_closing')) : "closed";
            }
        }

        $data['schedule'] = json_encode($schedule);
        $data['updated_at'] = strtotime(date('D, d-M-Y'));
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        return true;
    }

    // UPDATE SEO DATA FOR A RESTAURANT
    public function update_seo()
    {
        $id = required(sanitize($this->input->post('id')));
        $data['seo_tags']     = sanitize($this->input->post('seo_tags'));
        $data['seo_description']     = sanitize($this->input->post('seo_description'));
        $data['updated_at'] = strtotime(date('D, d-M-Y'));
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        return true;
    }

    // UPDATE GALLERY AND THUMBNAIL INFOS FOR A RESTAURANT
    public function update_gallery()
    {
        $id = required(sanitize($this->input->post('id')));
        $previous_data = $this->get_by_id($id);

        $previous_gallery_images = empty($previous_data['gallery']) ? ['placeholder.png', 'placeholder.png', 'placeholder.png', 'placeholder.png', 'placeholder.png', 'placeholder.png'] : json_decode($previous_data['gallery']);

        if (!empty($_FILES['restaurant_thumbnail']['name'])) {
            $data['thumbnail']  = $this->upload('restaurant/thumbnail', $_FILES['restaurant_thumbnail'], $previous_data["thumbnail"]);
        }


        for ($counter = 1; $counter <= 6; $counter++) {
            if (!empty($_FILES["restaurant_gallery_$counter"]['name'])) {
                $previous_gallery_images[$counter - 1]  = $this->upload('restaurant/gallery', $_FILES["restaurant_gallery_$counter"], $previous_gallery_images[$counter - 1] ? $previous_gallery_images[$counter - 1] : NULL);
            }
        }

        $data['gallery'] = json_encode($previous_gallery_images);
        $data['updated_at'] = strtotime(date('D, d-M-Y'));

        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        return true;
    }

    // UPDATE RESTARAURANT STATUS
    public function update_status($id)
    {
        // AUTHORIZATION IS A HELPER METHOD WHICH IS RESPONSIBLE FOR AUTHORIZING OPERATION
        if (has_access($this->table, $id)) {
            $previous_data = $this->get_by_id($id);
            if ($previous_data['status']) {
                $data['status'] = 0;
            } else {
                $data['status'] = 1;
            }

            $this->db->where('id', $id);
            $this->db->update($this->table, $data);
            return true;
        }
        return false;
    }

    // IN WHICH RESTAURANTS A PARTICULAR CUISINE BELONGS
    public function get_restaurants_by_cuisine($cuisine_id)
    {
        $restaurants = $this->db->get_where($this->table, ['status' => 1])->result_array();
        foreach ($restaurants as $key => $restaurant) {
            $available_cuisines = json_decode($restaurant['cuisine'], true);
            if (!in_array($cuisine_id, $available_cuisines)) {
                unset($restaurants[$key]);
            }
        }

        return $restaurants;
    }

    // GET POPULAR RESTAURANTS. THIS BASICALLY CHECKS THE TOP RESTAURANTS BY RATINGS
    public function get_popular_restaurants($limit = false)
    {
        if ($limit) {
            $this->db->limit($limit);
        }
        $this->db->where('status', 1);
        $this->db->order_by('rating', 'desc');
        $obj = $this->db->get($this->table);
        return $this->merger($obj);
    }

    /**
     * GET PLAIN RESTAURANT IDS AS A NUMERIC ARRAY LIKE [1,2,3,4]
     *
     * @return array
     */
    public function get_approved_restaurant_ids_by_owner_id($owner_id)
    {
        $restaurant_ids = [];
        $restaurants = $this->db->get_where('restaurants', ['status' => 1, 'owner_id' => $owner_id])->result_array();
        foreach ($restaurants as $restaurant) {
            if (!in_array($restaurant['id'], $restaurant_ids)) {
                array_push($restaurant_ids, $restaurant['id']);
            }
        }
        return $restaurant_ids;
    }

    /**
     * GET ALL THE RESTAURANT ID AGAINST A COOK ID
     *
     * @param INT $user_id
     * @return void
     */
    public function get_approved_restaurant_ids_by_cook_id($user_id)
    {
        $restaurant_ids = array();
        $cook_details = $this->db->get_where('cooks', ['user_id' => $user_id])->result_array();
        foreach ($cook_details as $cook) {
            if (!in_array($cook['restaurant_id'], $restaurant_ids)) {
                array_push($restaurant_ids, $cook['restaurant_id']);
            }
        }
        return $restaurant_ids;
    }

    /**
     * GET PLAIN RESTAURANT IDS AS A NUMERIC ARRAY LIKE [1,2,3,4]
     *
     * @return array
     */
    public function get_pending_restaurant_ids_by_owner_id($owner_id)
    {
        $restaurant_ids = [];
        $restaurants = $this->db->get_where('restaurants', ['status' => 0, 'owner_id' => $owner_id])->result_array();
        foreach ($restaurants as $key => $restaurant) {
            if (!in_array($restaurant['id'], $restaurant_ids)) {
                array_push($restaurant_ids, $restaurant['id']);
            }
        }
        return $restaurant_ids;
    }


    /**
     * FILTER RESTAURANTS FOR FRONTEND
     */
    public function filter_restaurant_frontend() {
        // Get the search parameters (latitude, longitude, and others if needed)
        $cuisine = nuller(sanitize($this->input->get('cuisine')));
        $category = nuller(sanitize($this->input->get('category')));
        $search_string = nuller(sanitize($this->input->get('query')));
        $lat = nuller(sanitize($this->input->get('latitude_1'))); // Latitude of the location you're filtering for
        $lng = nuller(sanitize($this->input->get('longitude_1'))); // Longitude of the location you're filtering for
    
        // print_r("<br>" . "<br>". "<br>"."Given Latitude: " . $lat . "<br>");
        // print_r("Given Longitude: " . $lng . "<br>");
    
        $filtered_restaurant_ids = array();
        
        // Retrieve all restaurants
        $query = $this->db->get($this->table)->result_array();
        
        // Iterate over each restaurant to calculate the distance and filter
        foreach ($query as $row) {
            $restaurant_id = $row['id'];
            $restaurant_latitude = $row['latitude']; // Restaurant's latitude
            $restaurant_longitude = $row['longitude']; // Restaurant's longitude
            $maximum_range = $row['maximum_range']; // Restaurant's max delivery range
    
            // print_r("Restaurant Max Range: " . $maximum_range . " miles<br>");
    
            // Calculate the distance between the provided point (lat, lng) and the restaurant
            $distance = $this->get_distance($lat, $lng, $restaurant_latitude, $restaurant_longitude);
            
            // Print calculated distance for debugging
            // print_r("Calculated Distance: " . $distance . " miles<br>");
    
            // If the restaurant is within the maximum delivery range, include it
            if ($distance <= $maximum_range) {
                // print_r("heu");
                if (!in_array($restaurant_id, $filtered_restaurant_ids)) {
                    array_push($filtered_restaurant_ids, $restaurant_id);
                }
            }
        }
    
        // Print filtered restaurant IDs for debugging
        print_r("Filtered Restaurant IDs: ");
        print_r($filtered_restaurant_ids);
    
        // Return the filtered restaurant IDs within range
        return $filtered_restaurant_ids;
    }

public function get_distance($lat1, $lng1, $lat2, $lng2) {
    // Radius of Earth in miles
    define("EARTH_RADIUS", 3958.8);

    // Convert degrees to radians
    $lat1 = deg2rad($lat1);
    $lng1 = deg2rad($lng1);
    $lat2 = deg2rad($lat2);
    $lng2 = deg2rad($lng2);

    // Differences between latitudes and longitudes
    $dlat = $lat2 - $lat1;
    $dlon = $lng2 - $lng1;

    // Haversine formula to calculate the distance
    $a = sin($dlat / 2) * sin($dlat / 2) +
         cos($lat1) * cos($lat2) * 
         sin($dlon / 2) * sin($dlon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    // Calculate distance in miles
    return EARTH_RADIUS * $c;
}

    // public function filter_restaurant_frontend()
    // {
    //     $cuisine    = nuller(sanitize($this->input->get('cuisine')));
    //     $category   = nuller(sanitize($this->input->get('category')));
    //     $search_string   = nuller(sanitize($this->input->get('query')));
    //     $lat   = nuller(sanitize($this->input->get('latitude_1')));
    //     $lng   = nuller(sanitize($this->input->get('longitude_1')));



    //     $filtered_restaurant_ids = array();
    //     $restaurant_ids_have_cuisine = array();
    //     $restaurant_ids_have_category = array();
    //     $restaurant_ids_have_search_string = array();

    //     if ($category) {
    //         $this->db->distinct();
    //         $this->db->select('restaurant_id');
    //         $query = $this->db->get_where('food_menus', ['category_id' => $category])->result_array();
    //         foreach ($query as $row) {
    //             if (!in_array($row['restaurant_id'], $restaurant_ids_have_category)) {
    //                 array_push($restaurant_ids_have_category, $row['restaurant_id']);
    //             }
    //         }
    //     }

    //     if ($cuisine) {
    //         $query = $this->db->get_where($this->table, ['status' => 1])->result_array();
    //         foreach ($query as $row) {
    //             $cuisines = json_decode($row['cuisine']);
    //             if (in_array($cuisine, $cuisines)) {
    //                 if (!in_array($row['id'], $restaurant_ids_have_cuisine)) {
    //                     array_push($restaurant_ids_have_cuisine, $row['id']);
    //                 }
    //             }
    //         }
    //     }

    //     if ($category && $cuisine && !$search_string) {
    //         if (count($restaurant_ids_have_category) && count($restaurant_ids_have_cuisine)) {
    //             $filtered_restaurant_ids = array_intersect($restaurant_ids_have_cuisine, $restaurant_ids_have_category);
    //         }
    //     } elseif (!$category && !$cuisine && !$search_string) {
    //         $query = $this->db->get_where($this->table, ['status' => 1])->result_array();
    //         foreach ($query as $row) {
    //             if (!in_array($row['id'], $filtered_restaurant_ids)) {
    //                 array_push($filtered_restaurant_ids, $row['id']);
    //             }
    //         }
    //     } elseif ($category && !$cuisine && !$search_string) {
    //         $filtered_restaurant_ids = $restaurant_ids_have_category;
    //     } elseif (!$category && $cuisine && !$search_string) {
    //         $filtered_restaurant_ids = $restaurant_ids_have_cuisine;
    //     } elseif ($search_string) {
    //         $this->db->select('id');
    //         $this->db->like('address', $search_string, 'both');
    //         $this->db->or_like('latitude', $lat, 'both');
    //         $this->db->or_like('longitude', $lng, 'both');
    //         $query = $this->db->get($this->table)->result_array();
    //         foreach ($query as $row) {
    //             if (!in_array($row['id'], $filtered_restaurant_ids)) {
    //                 array_push($filtered_restaurant_ids, $row['id']);
    //             }
    //         }

    //     }
    //     return $filtered_restaurant_ids;
    // }
}
