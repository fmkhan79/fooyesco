<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Product name : FoodMob
 * Date : 28 - June - 2020
 * Author : TheDevs
 * Menu model handles all the database queries of Menu
 */
class Menu_model extends Base_model
{
    // DEFAULT CONSTRUCTOR. FOR INITIALIZING THE TABLE NAME
    function __construct()
    {
        parent::__construct();
        $this->table = "food_menus";
    }

    // GET ALL THE FOOD MENUS
    public function get_all()
    {
        $this->db->order_by("id", "desc");
        $menus = $this->db->get($this->table);
        return $this->merger($menus);
    }

    // GET MENU BY ID
    public function get_by_id($id)
    {
        $this->db->where('id', $id);
        $menu = $this->db->get($this->table);
        return $this->merger($menu, true);
    }

    // GET MENU BY CONDITIONS ARRAY
    public function get_menu_by_condition($conditions = [])
    {
        foreach ($conditions as $key => $value) {
            if (!is_null($value)) {
                if (is_array($value)) {
                    if (count($value)) {
                        $this->db->where_in($key, $value);
                    } else {
                        return array();
                    }
                } else {
                    $this->db->where($key, $value);
                }
            }
        }

        $menus = $this->db->get($this->table);
        return $this->merger($menus);
    }

    // MERGER FUNCTION IS FOR MERGING NECESSARY DATA
    public function merger($query_obj, $is_single_row = false)
    {
        if (!$is_single_row) {
            $menus = $query_obj->result_array();
            foreach ($menus as $key => $menu) {
                $category_data = $this->category_model->get_by_id($menu['category_id']);
                $restaurant_data = $this->restaurant_model->get_by_id($menu['restaurant_id']);
                $menus[$key]['category_name']  = $category_data['name'];
                $menus[$key]['restaurant_name']  = $restaurant_data['name'];
            }

            return $menus;
        } else {
            $menu = $query_obj->row_array();
            $category_data = $this->category_model->get_by_id($menu['category_id']);
            $menu['category_name']  = $category_data['name'];
            $restaurant_data = $this->restaurant_model->get_by_id($menu['restaurant_id']);
            $menu['restaurant_name']  = $restaurant_data['name'];
            return $menu;
        }
    }

    // STORE MENU DATA
    public function store()
    {
        $restaurants = (isset($_POST['restaurant_id']) && !empty($_POST['restaurant_id'])) ? sanitize_array($this->input->post('restaurant_id')) : array();
        if (!count($restaurants)) {
            error(get_phrase("you_have_to_choose_at_least_one_restaurant"), site_url("menu/create"));
        }

        // GET THUMBNAIL FOR ONE TIME. IT DOES NOT WORK INSIDE FOREACH LOOP.
        $gallery_data = $this->store_gallery_data();

        // FOREACH LOOP FOR MULTIPLE RESTAURANTS
        foreach ($restaurants as $restaurant) {
            $restaurant_data['restaurant_id'] = required($restaurant);
            $basic_data = $this->store_basic_data();
            $data = array_merge($restaurant_data, $basic_data, $gallery_data);
            $data['created_at'] = strtotime(date('D, d-M-Y'));
            $data['nutrition_fact'] = json_encode(array());
            $this->db->insert($this->table, $data);
        }

        return true;
    }

    // UPDATE MENU DATA
    public function update()
    {
        $menu_id = required(sanitize($this->input->post('id')));
        $type = required(sanitize($this->input->post('type')));

        // DYNAMIC FUNCTION CALLING
        $dynamic_function_name = "update_" . $type;
        $data = $this->$dynamic_function_name($menu_id);
        $data['updated_at'] = strtotime(date('D, d-M-Y'));

        $this->db->where('id', $menu_id);
        $this->db->update($this->table, $data);
        return true;
    }

    // STORE MENU'S BASIC DATA
    public function store_basic_data()
    {
        $data['name'] = required(sanitize($this->input->post('name')));
        $data['category_id'] = required(sanitize($this->input->post('category_id')));
        $data['availability'] = isset($_POST['availability']) ? 1 : 0;
        $data['slug'] = slugify(sanitize($this->input->post('name')));

        $menu_price = required(sanitize($this->input->post('per_menu_price')));
        $menu_discount_flag = isset($_POST['per_menu_discount_flag']) ? 1 : 0;
        $menu_discounted_price = sanitize($this->input->post('per_menu_discounted_price'));

        $data['servings'] = 'menu';
        $data['has_discount'] = json_encode(array('menu' => $menu_discount_flag));
        $data['price'] = json_encode(array('menu' => $menu_price));
        $data['discounted_price'] = json_encode(array('menu' => $menu_discounted_price));

        return $data;
    }

    // UPDATING BASIC DATA
    public function update_basic($menu_id)
    {
        $data['name'] = required(sanitize($this->input->post('name')));
        $data['category_id'] = required(sanitize($this->input->post('category_id')));
        $data['availability'] = isset($_POST['availability']) ? 1 : 0;
        $data['slug'] = slugify(sanitize($this->input->post('name')));
        $data['restaurant_id'] = required(sanitize($this->input->post('restaurant_id')));
        return $data;
    }
    // STORE MENU'S DETAILS DATA LIKE ITEMS, MENU DETAILS AND NUTRITION FACTS
    public function update_details($menu_id)
    {
        $data['items'] = sanitize($this->input->post('items'));
        $data['details'] = sanitize($this->input->post('details'));

        // NUTRITION SECTION
        $nutrition_key = sanitize_array($this->input->post('nutrition_key'));
        $nutrition_value = sanitize_array($this->input->post('nutrition_value'));

        foreach ($nutrition_key as $key => $key) {
            $nutrition_fact[$nutrition_key[$key]] = $nutrition_value[$key];
        }
        $data['nutrition_fact'] = json_encode($nutrition_fact);

        // WARNING SECTION
        $warnings = sanitize_array($this->input->post('warning'));
        $warnings_as_array = array();
        foreach ($warnings as $warning) {
            if (isset($warning) && !empty($warning)) {
                array_push($warnings_as_array, $warning);
            }
        }
        $warnings_as_array = count($warnings_as_array) ? $warnings_as_array : array("");
        $data['warnings'] = json_encode($warnings_as_array);

        return $data;
    }


    // STORE MENU'S IMAGE DATA
    public function store_gallery($menu_id = "")
    {
        if (empty($menu_id)) {
            if (isset($_FILES['food_menu_thumbnail']['name'])) {
                $data['thumbnail']  = $this->upload('menu', $_FILES['food_menu_thumbnail']);
            } else {
                $data['thumbnail']  = "placeholder.png";
            }
        }

        return $data;
    }

    // UPDATE MENU IMAGE DATA
    public function update_gallery($menu_id)
    {
        $previous_data = $this->get_by_id($menu_id);
        if (!empty($_FILES['food_menu_thumbnail']['name'])) {
            $data['thumbnail']  = $this->upload('menu', $_FILES['food_menu_thumbnail'], $previous_data["thumbnail"]);
        } else {
            $data['thumbnail']  = $previous_data["thumbnail"];
        }

        return $data;
    }

    // UPDATE MENU PRICE DATA
    public function update_price($menu_id)
    {
        $menu_price = required(sanitize($this->input->post('per_menu_price')));
        $menu_discount_flag = isset($_POST['per_menu_discount_flag']) ? 1 : 0;
        $menu_discounted_price = sanitize($this->input->post('per_menu_discounted_price'));

        $data['servings'] = 'menu';
        $data['has_discount'] = json_encode(array('menu' => $menu_discount_flag));
        $data['price'] = json_encode(array('menu' => $menu_price));
        $data['discounted_price'] = json_encode(array('menu' => $menu_discounted_price));
        return $data;
    }
    // menu authentication
    public function authentication($menu_id, $user_id = "")
    {
        if (empty($user_id)) {
            $user_id = $this->logged_in_user_id;
        }
        $menu_details = $this->get_by_id($menu_id);
        $restaurant_details = $this->restaurant_model->get_by_id($menu_details['restaurant_id']);
        if ($this->logged_in_user_role == "admin" || $restaurant_details['owner_id'] == $user_id) {
            return true;
        }
        return false;
    }

    // STORE MENU'S IMAGE DATA
    public function store_gallery_data()
    {
        $data['thumbnail']  = $this->upload('menu', $_FILES['food_menu_thumbnail']);
        return $data;
    }
}

/* End of file Menu_model.php */
