<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 31 - July - 2021
 * Author : TheDevs
 * Ingredient model handles all the database queries of Menu Ingredient
 */

class Ingredient_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "ingredients";
    }

    /**
     * GET ALL INGREDIENTS
     */
    public function get_all()
    {
        $this->db->order_by("id", "desc");
        return $this->db->get($this->table)->result_array();
    }

    /**
     * GET INGREDIENTS BY ID
     */
    public function get_by_id($id)
    {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row_array();
    }

    /**
     * THIS FUNCTION 
     *
     * @return array
     */
    public function get_ingredients($restaurant_id = "")
    {
        if ($this->logged_in_user_role == "owner") {
            $restaurant_ids = $this->restaurant_model->get_approved_restaurant_ids_by_owner_id($this->logged_in_user_id);
            if (count($restaurant_ids)) {
                if (!empty($restaurant_id)) {
                    if (in_array($restaurant_id, $restaurant_ids)) {
                        $this->db->where('restaurant_id', $restaurant_id);
                    } else {
                        return array();
                    }
                } else {
                    $this->db->where_in('restaurant_id', $restaurant_ids);
                }
            } else {
                return array();
            }
        } else {
            if (!empty($restaurant_id)) {
                $this->db->where('restaurant_id', $restaurant_id);
            }
        }
        return $this->db->get($this->table)->result_array();
    }

    /**
     * GET DATA BY A CONDITION ARRAY
     */
    public function get_by_condition($conditions = [])
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
        return $this->db->get($this->table)->result_array();
    }

    /**
     * STORING INGREDIENT
     */
    public function store()
    {
        $data['ingredient_name'] = required(sanitize($this->input->post('ingredient_name')));
        $data['restaurant_id']   = required(sanitize($this->input->post('restaurant_id')));
        $data['unit']            = required(sanitize($this->input->post('unit')));
        $data['unit_price']      = required(sanitize($this->input->post('unit_price')));

        if ($this->logged_in_user_role == "owner") {
            $restaurant_ids = $this->restaurant_model->get_approved_restaurant_ids_by_owner_id($this->logged_in_user_id);
            if (!in_array($data['restaurant_id'], $restaurant_ids)) {
                return false;
            }
        }
        $this->db->insert($this->table, $data);
        return true;
    }

    /**
     * UPDATING INGREDIENT
     */
    public function update()
    {
        $id = required(sanitize($this->input->post('id')));
        $data['ingredient_name'] = required(sanitize($this->input->post('ingredient_name')));
        $data['restaurant_id']   = required(sanitize($this->input->post('restaurant_id')));
        $data['unit']            = required(sanitize($this->input->post('unit')));
        $data['unit_price']      = required(sanitize($this->input->post('unit_price')));

        if ($this->logged_in_user_role == "owner") {
            $restaurant_ids = $this->restaurant_model->get_approved_restaurant_ids_by_owner_id($this->logged_in_user_id);
            if (!in_array($data['restaurant_id'], $restaurant_ids)) {
                return false;
            }
        }

        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        return true;
    }

    /**
     * STORING,UPDTING OR DELETING MENU INGREDIENT
     *
     * @param string $action
     * @param string $row_id
     * @return int
     */
    public function update_menu_ingredient($action = "add", $row_id = "")
    {
        if (isset($_POST['menu_id']) && !empty($_POST['menu_id'])) {
            $menu_id = sanitize($this->input->post('menu_id'));
        } else {
            $menu_ingredient_details = $this->get_menu_ingredients_by_id($row_id);
            $menu_id = $menu_ingredient_details['menu_id'];
        }

        if ($this->menu_model->authentication($menu_id)) {
            if ($action == "delete") {
                $this->db->where('id', $row_id);
                $this->db->delete('menu_ingredients');
                return json_encode(['menu_id' => $menu_id, 'status' => true]);
            } else {
                $data['menu_id'] = required($menu_id);
                $data['ingredient_id'] = required(sanitize($this->input->post('ingredient_id')));
                $data['quantity_added'] = sanitize($this->input->post('quantity_added')) > 0 ? sanitize($this->input->post('quantity_added')) : 0;

                $ingredient_details = $this->get_by_id($data['ingredient_id']);
                $data['ingredient_amount'] = number_format((float)($ingredient_details['unit_price'] * $data['quantity_added']), 2, '.', '');
                if ($action == "add") {
                    $previous_record = $this->db->get_where('menu_ingredients', ['menu_id' => $menu_id, 'ingredient_id' => $data['ingredient_id']])->num_rows();
                    if ($previous_record > 0) {
                        return json_encode(['menu_id' => $menu_id, 'status' => false]);
                    } else {
                        $this->db->insert('menu_ingredients', $data);
                        return json_encode(['menu_id' => $menu_id, 'status' => true]);
                    }
                } else {
                    $this->db->where('menu_id', $menu_id);
                    $this->db->where('ingredient_id', $data['ingredient_id']);
                    $this->db->where('id !=', $row_id);
                    $previous_record = $this->db->get('menu_ingredients')->num_rows();
                    if ($previous_record > 0) {
                        return json_encode(['menu_id' => $menu_id, 'status' => false]);
                    } else {
                        $this->db->where('id', $row_id);
                        $this->db->update('menu_ingredients', $data);
                        return json_encode(['menu_id' => $menu_id, 'status' => true]);
                    }
                }
            }
        }

        return json_encode(['menu_id' => false, 'status' => false]);
    }

    /**
     * THIS FUNCTION RETURNS ALL THE INGREDIENTS FOR A CERTAIN MENU
     *
     * @param int $menu_id
     * @return object
     */
    public function get_menu_ingredients($menu_id)
    {
        return $this->db->get_where('menu_ingredients', ['menu_id' => $menu_id]);
    }

    /**
     * THIS FUNCTION RETURNS A SINGLE ROW INGREDIENTS FOR A CERTAIN MENU
     *
     * @param int $menu_ingredient_id
     * @return array
     */
    public function get_menu_ingredients_by_id($menu_ingredient_id)
    {
        return $this->db->get_where('menu_ingredients', ['id' => $menu_ingredient_id])->row_array();
    }

    /**
     * THIS FUNCTION WILL DO THE QUERY FOR INGREDIENT REPORT DATA
     */
    public function report()
    {
        $dynamic_function_name = "filter_report_as_" . $this->logged_in_user_role;
        return $this->$dynamic_function_name();
    }

    public function filter_report_as_owner($order_placed_at_start = "", $order_placed_at_end = "")
    {
        // CHECK DATE RANGE
        if (empty($order_placed_at_start) && empty($order_placed_at_end)) {
            if (isset($_GET['date_range']) && !empty($_GET['date_range'])) {
                $date_range                   = sanitize($this->input->get('date_range'));
                $date_range                   = explode(" - ", $date_range);
                $order_placed_at_start = strtotime($date_range[0] . ' 00:00:01');
                $order_placed_at_end   = strtotime($date_range[1] . ' 23:59:59');
            } else {
                $day = date('w');
                $starting_date = date('d M Y', strtotime('-' . $day . ' days')) . ' 00:00:01';
                $ending_date = date('d M Y', strtotime('+' . (6 - $day) . ' days')) . ' 23:59:59';
                $order_placed_at_start = strtotime($starting_date);
                $order_placed_at_end = strtotime($ending_date);
            }
        }


        // AT FIRST CHECK IF THE OWNER HAS ANY RESTAURANT
        $restaurant_ids = $this->restaurant_model->get_approved_restaurant_ids_by_owner_id($this->logged_in_user_id);
        if (count($restaurant_ids)) {
            // CHECK RESTAURANT SELECTION
            $restaurant_id = nuller(sanitize($this->input->get('restaurant_id')));
            if ($restaurant_id && in_array($restaurant_id, $restaurant_ids)) {
                $codes = $this->order_model->get_order_code_by_restaurant_id($restaurant_id);
            } else {
                $codes = $this->order_model->get_order_code_by_restaurant_id($restaurant_ids);
            }
            if (count($codes)) {
                $this->db->where_in('code', $codes);
            } else {
                return array();
            }
        } else {
            return array();
        }

        // DO THE QUERY TO GET MENU IDS
        $this->db->where('order_placed_at >=', $order_placed_at_start);
        $this->db->where('order_placed_at <=', $order_placed_at_end);
        $this->db->where('order_status', 'delivered');

        $this->db->select('code');

        $query = $this->db->get('orders')->result_array();

        $order_codes = array();
        foreach ($query as $key => $row) {
            if (!in_array($row['code'], $order_codes)) {
                array_push($order_codes, $row['code']);
            }
        }

        // NO ORDER PLACED
        if (count($order_codes) == 0) {
            return array();
        }

        $this->db->group_by('menu_id');
        $this->db->select('menu_id');
        $this->db->select_sum('quantity');
        $this->db->where_in('order_code', $order_codes);
        $menu_id_and_quantity = $this->db->get('order_details')->result_array();

        // GET THE INGREDIENT REPORT
        $report = array();
        foreach ($menu_id_and_quantity as $row) {
            $ingredient_details = $this->db->get_where('menu_ingredients', ['menu_id' => $row['menu_id']])->result_array();
            foreach ($ingredient_details as $ingredient_detail) {

                if (isset($report[$ingredient_detail['ingredient_id']]) && !empty($report[$ingredient_detail['ingredient_id']])) {
                    $report[$ingredient_detail['ingredient_id']] = array(
                        'quantity_added' => $report[$ingredient_detail['ingredient_id']]['quantity_added'] + ($ingredient_detail['quantity_added'] * $row['quantity']),
                        'ingredient_amount' => $report[$ingredient_detail['ingredient_id']]['ingredient_amount'] + ($ingredient_detail['ingredient_amount'] * $row['quantity'])
                    );
                } else {
                    $report[$ingredient_detail['ingredient_id']] = array(
                        'quantity_added' => $ingredient_detail['quantity_added'] * $row['quantity'],
                        'ingredient_amount' => $ingredient_detail['ingredient_amount'] * $row['quantity']
                    );
                }
            }
        }

        return $report;
    }

    private function filter_report_as_admin()
    {
        // CHECK DATE RANGE
        if (isset($_GET['date_range']) && !empty($_GET['date_range'])) {
            $date_range                   = sanitize($this->input->get('date_range'));
            $date_range                   = explode(" - ", $date_range);
            $order_placed_at_start = strtotime($date_range[0] . ' 00:00:01');
            $order_placed_at_end   = strtotime($date_range[1] . ' 23:59:59');
        } else {
            $day = date('w');
            $starting_date = date('d M Y', strtotime('-' . $day . ' days')) . ' 00:00:01';
            $ending_date = date('d M Y', strtotime('+' . (6 - $day) . ' days')) . ' 23:59:59';
            $order_placed_at_start = strtotime($starting_date);
            $order_placed_at_end = strtotime($ending_date);
        }

        // CHECK RESTAURANT SELECTION
        $restaurant_id = nuller(sanitize($this->input->get('restaurant_id')));
        if ($restaurant_id) {
            $codes = $this->order_model->get_order_code_by_restaurant_id($restaurant_id);
            if (count($codes) > 0) {
                $this->db->where_in('code', $codes);
            } else {
                return array();
            }
        }

        // DO THE QUERY TO GET MENU IDS
        $this->db->where('order_placed_at >=', $order_placed_at_start);
        $this->db->where('order_placed_at <=', $order_placed_at_end);
        $this->db->where('order_status', 'delivered');

        $this->db->select('code');

        $query = $this->db->get('orders')->result_array();

        $order_codes = array();
        foreach ($query as $key => $row) {
            if (!in_array($row['code'], $order_codes)) {
                array_push($order_codes, $row['code']);
            }
        }

        // NO ORDER PLACED
        if (count($order_codes) == 0) {
            return array();
        }

        $this->db->group_by('menu_id');
        $this->db->select('menu_id');
        $this->db->select_sum('quantity');
        $this->db->where_in('order_code', $order_codes);
        $menu_id_and_quantity = $this->db->get('order_details')->result_array();

        // GET THE INGREDIENT REPORT
        $report = array();
        foreach ($menu_id_and_quantity as $row) {
            $ingredient_details = $this->db->get_where('menu_ingredients', ['menu_id' => $row['menu_id']])->result_array();
            foreach ($ingredient_details as $ingredient_detail) {

                if (isset($report[$ingredient_detail['ingredient_id']]) && !empty($report[$ingredient_detail['ingredient_id']])) {
                    $report[$ingredient_detail['ingredient_id']] = array(
                        'quantity_added' => $report[$ingredient_detail['ingredient_id']]['quantity_added'] + ($ingredient_detail['quantity_added'] * $row['quantity']),
                        'ingredient_amount' => $report[$ingredient_detail['ingredient_id']]['ingredient_amount'] + ($ingredient_detail['ingredient_amount'] * $row['quantity'])
                    );
                } else {
                    $report[$ingredient_detail['ingredient_id']] = array(
                        'quantity_added' => $ingredient_detail['quantity_added'] * $row['quantity'],
                        'ingredient_amount' => $ingredient_detail['ingredient_amount'] * $row['quantity']
                    );
                }
            }
        }

        return $report;
    }
}
