<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 28 - August - 2020
 * Author : TheDevs
 * Report model handles all the database queries of Report
 */

class Report_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
    }

    public function get_commission_details($restaurant_id)
    {
        $dynamic_function_name = "get_commission_details_as_" . $this->logged_in_user_role;
        return $this->$dynamic_function_name($restaurant_id);
    }


    public function get_commission_details_as_admin($restaurant_id)
    {
        $this->db->order_by("id", "desc");
        return $this->db->get_where('commission_details', ['restaurant_id' => $restaurant_id])->result_array();
    }

    public function get_commission_details_as_owner($restaurant_id)
    {
        $this->db->order_by("id", "desc");
        return $this->db->get_where('commission_details', ['restaurant_id' => $restaurant_id])->result_array();
    }

    public function filter_commissions()
    {
        $dynamic_function_name = "filter_commissions_as_" . $this->logged_in_user_role;
        return $this->$dynamic_function_name();
    }

    /**
     * GET ALL REPORTS AS ADMIN
     */
    public function filter_commissions_as_admin()
    {
        $conditions['restaurant_id'] = (isset($_GET['restaurant_id']) && $_GET['restaurant_id'] != "all") ? sanitize($_GET['restaurant_id']) : null;
        return $this->get_by_condition($conditions, 'paid_commissions');
    }

    /**
     * GET ALL REPORTS AS OWNER
     */
    public function filter_commissions_as_owner()
    {
        $approved_restaurant_ids = $this->restaurant_model->get_approved_restaurant_ids_by_owner_id($this->logged_in_user_id);
        $approved_restaurant_ids = count($approved_restaurant_ids) > 0 ? $approved_restaurant_ids : [null];

        $conditions['restaurant_id'] = (isset($_GET['restaurant_id']) && $_GET['restaurant_id'] != "all") ? $_GET['restaurant_id'] : $approved_restaurant_ids;
        return $this->get_by_condition($conditions, 'paid_commissions');
    }

    /**
     * GET ALL REPORTS AS COOK
     */
    public function filter_commissions_as_cook()
    {
        $approved_restaurant_ids = $this->restaurant_model->get_approved_restaurant_ids_by_cook_id($this->logged_in_user_id);
        $approved_restaurant_ids = count($approved_restaurant_ids) > 0 ? $approved_restaurant_ids : [null];

        $conditions['restaurant_id'] = (isset($_GET['restaurant_id']) && $_GET['restaurant_id'] != "all") ? $_GET['restaurant_id'] : $approved_restaurant_ids;
        return $this->get_by_condition($conditions, 'paid_commissions');
    }

    /**
     * GET ALL REPORTS AS ADMIN
     */
    public function filter_admin_commissions()
    {
        // CHECK DATE RANGE
        if (isset($_GET['date_range']) && !empty($_GET['date_range'])) {
            $date_range                   = sanitize($this->input->get('date_range'));
            $date_range                   = explode(" - ", $date_range);
            $conditions['date_added >='] = strtotime($date_range[0] . ' 00:00:01');
            $conditions['date_added <=']   = strtotime($date_range[1] . ' 23:59:59');
        } else {
            $first_day_of_month = "1 " . date("M") . " " . date("Y") . ' 00:00:01';
            $last_day_of_month = date("t") . " " . date("M") . " " . date("Y") . ' 23:59:59';
            $conditions['date_added >=']   = strtotime($first_day_of_month);
            $conditions['date_added <=']     = strtotime($last_day_of_month);
        }

        return $this->get_by_condition($conditions, 'commission_details');
    }

    /**
     * GET TOATL REVENUE OF ADMIN
     */
    public function filter_and_get_total_admin_commissions()
    {
        // CHECK DATE RANGE
        if (isset($_GET['date_range']) && !empty($_GET['date_range'])) {
            $date_range                   = sanitize($this->input->get('date_range'));
            $date_range                   = explode(" - ", $date_range);
            $conditions['date_added >='] = strtotime($date_range[0] . ' 00:00:01');
            $conditions['date_added <=']   = strtotime($date_range[1] . ' 23:59:59');
        } else {
            $first_day_of_month = "1 " . date("M") . " " . date("Y") . ' 00:00:01';
            $last_day_of_month = date("t") . " " . date("M") . " " . date("Y") . ' 23:59:59';
            $conditions['date_added >=']   = strtotime($first_day_of_month);
            $conditions['date_added <=']     = strtotime($last_day_of_month);
        }

        $this->db->select_sum('admin_commission');
        foreach ($conditions as $key => $value) {
            if ($value && $value != null) {
                if (is_array($value)) {
                    $this->db->where_in($key, $value);
                } else {
                    $this->db->where($key, $value);
                }
            }
        }
        $total_admin_commission = $this->db->get('commission_details')->row()->admin_commission;
        return $total_admin_commission > 0 ? $total_admin_commission : 0;
    }


    /**
     * THIS FUNCTION RETURNS THE TOTAL PAYABLE COMMISSION FOR A SPECIFIC RESTAURANT
     *
     * @param [INT] $restaurant_id
     * @return INT
     */
    public function get_total_payable_commission($restaurant_id)
    {
        $total_commission = 0;
        $this->db->select_sum('owner_commission');
        $this->db->where('restaurant_id', $restaurant_id);
        $total_commission = $this->db->get('commission_details')->row()->owner_commission;
        return $total_commission;
    }

    /**
     * THIS FUNCTION RETURNS THE TOTAL PAID COMMISSION FOR A SPECIFIC RESTAURANT
     *
     * @param [INT] $restaurant_id
     * @return INT
     */
    public function get_total_paid_commission($restaurant_id)
    {
        $this->db->where('restaurant_id', $restaurant_id);
        $total_commission = $this->db->get('paid_commissions')->row_array();
        return $total_commission['paid_amount'] > 0 ? $total_commission['paid_amount'] : 0;
    }

    // GET DATA BY A CONDITION ARRAY
    public function get_by_condition($conditions, $table)
    {
        $this->db->order_by("id", "desc");
        foreach ($conditions as $key => $value) {
            if (!is_null($value)) {
                if (is_array($value)) {
                    $this->db->where_in($key, $value);
                } else {
                    $this->db->where($key, $value);
                }
            }
        }
        return $this->db->get($table)->result_array();
    }

    /**
     * THIS FUNCTION DEVIDES COMMISSION BETWEEN ADMIN AND RESTAURANT OWNER
     *
     * @param [STRING] $order_code
     * @return void
     */
    public function devide_commission($order_code)
    {
        $admin_details = $this->user_model->get_admin_details();

        //FIRST GET ALL THE RESTAURANT IDS
        $this->db->distinct();
        $this->db->select('restaurant_id');
        $query = $this->db->get_where('order_details', ['order_code' => $order_code])->result_array();

        foreach ($query as $key => $row) {
            $restaurant_details = $this->restaurant_model->get_by_id($row['restaurant_id']);

            /* GET TOTAL MENU PRICE */
            $this->db->select_sum('total');
            $total_menu_bill = $this->db->get_where('order_details', ['order_code' => $order_code, 'restaurant_id' => $row['restaurant_id']])->row()->total;

            /* MENU PRICE WITH DELIVERY CHARGE */
            $sub_total = $total_menu_bill + delivery_charge($row['restaurant_id']);

            /* VAT */
            $vat_percentage = get_delivery_settings('vat');
            $total_vat = round(($sub_total * $vat_percentage) / 100);

            /* GRAND TOTAL WITH VAT */
            $grand_total = $sub_total + $total_vat;

            if ($restaurant_details['owner_id'] == $admin_details['id']) {
                $report_data['admin_commission'] = $grand_total;
                $report_data['owner_commission'] = 0;
            } else {
                $restaurant_revenue_percentage = get_delivery_settings('restaurant_revenue');
                $restaurant_revenue = round(($grand_total * $restaurant_revenue_percentage) / 100);
                $report_data['admin_commission'] = $grand_total - $restaurant_revenue;
                $report_data['owner_commission'] = $restaurant_revenue;
            }

            $report_data['restaurant_id'] = $row['restaurant_id'];
            $report_data['order_code'] = $order_code;
            $report_data['total_bill'] = $grand_total;
            $report_data['date_added'] = strtotime(date('D, d-M-Y H:i:s'));
            $this->db->insert('commission_details', $report_data);


            /* INSERT INTO PAID COMMISSION TABLE AS EMPTY ROW */
            $paid_commission_previous_data_checker = $this->db->get_where('paid_commissions', ['restaurant_id' => $row['restaurant_id']]);
            if ($paid_commission_previous_data_checker->num_rows() == 0) {
                $this->db->insert('paid_commissions', ['restaurant_id' => $row['restaurant_id']]);
            }
        }
    }

    public function pay_to_restaurant_owner()
    {
        $restaurant_id = required(sanitize($this->input->post('restaurant_id')));
        $amount_to_pay = required(sanitize($this->input->post('amount_to_pay')));
        $restaurant_details = $this->db->get_where('restaurants', ['id' => $restaurant_id, 'status' => 1]);
        if ($restaurant_details->num_rows() > 0) {
            $total_paid_commission = $this->get_total_paid_commission($restaurant_id);
            $total_payable_commission = $this->get_total_payable_commission($restaurant_id);
            $due_amount = $total_payable_commission - $total_paid_commission;
            if (!$amount_to_pay || $amount_to_pay > $due_amount) {
                error(get_phrase('invalid_amount_to_pay'), site_url('report'));
            } else {
                $paid_commission_previous_data = $this->db->get_where('paid_commissions', ['restaurant_id' => $restaurant_id])->row_array();
                $new_paid_commission_amount = $total_paid_commission + $amount_to_pay;
                $data['paid_amount'] = $new_paid_commission_amount;
                $this->db->where('restaurant_id', $restaurant_id);
                $this->db->update('paid_commissions', $data);
                return true;
            }
        } else {
            error(get_phrase('invalid_restaurant_id'), site_url('report'));
        }
    }
}
