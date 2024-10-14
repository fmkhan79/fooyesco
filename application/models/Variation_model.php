<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 23 - August - 2020
 * Author : TheDevs
 * Variation model handles all the database queries of menu variation
 */

class Variation_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
    }


    /**
     *  CREATE OR UPDATE VARIATION OPTIONS
     */

    public function save_sub_variant($action = "create")
    {
        $data['menu_id'] = required(sanitize($this->input->post('menu_id')));
        $data['variant_option_id'] = required(sanitize($this->input->post('variant_option_id')));
        //  $data['options'] = required(trim(strtolower(str_replace('-', ' ', sanitize($this->input->post('options'))))));

        //  if ($this->menu_model->authentication($data['menu_id'])) {
        if ($action == "create") {
            $this->db->insert('variant_sub_options', $data);
            return $this->db->insert_id();
        }
        //  } else {
        //      error(get_phrase("you_are_not_authorized"), site_url('menu'));
        //  }
    }


    public function update_sub_variant()
    {
        $data[required(sanitize($this->input->post('variation_attr_name')))] = required(sanitize($this->input->post('variation_attr_value')));
        //  $data['variation_item_id'] = required(sanitize($this->input->post('variation_item_id')));
        //  $data['options'] = required(trim(strtolower(str_replace('-', ' ', sanitize($this->input->post('options'))))));


        $variation_item_id = required(sanitize($this->input->post('variation_item_id')));
        $this->db->where('id', $variation_item_id);
        $this->db->update('variant_sub_options', $data);
        return true;

    }

    // create a duplicate of sub variant with items
    public function duplicate_sub_variant()
    {
        $variation_id = required(sanitize($this->input->post('variation_id')));
        // Get the data of the existing row based on the given ID
        $this->db->where('id', $variation_id);
        $query = $this->db->get('variant_options'); // replace 'your_table_name' with the actual name of your table

        if ($query->num_rows() > 0) {
            $row_data = $query->row_array();

            // Remove the primary key from the data (assuming 'id' is the primary key)
            unset($row_data['id']);

            // Insert the new row with the same data
            $this->db->insert('variant_options', $row_data); // replace 'your_table_name' with the actual name of your table

            // Get the ID of the newly inserted row if needed
            $new_row_id = $this->db->insert_id();

            // $new_row_id now contains the ID of the newly inserted row




            

              if($this->duplicate_variant_sub_variant($variation_id,$new_row_id)){
                var_dump("came out");
              }


        }


        return true;
    }



    public function duplicate_variant_sub_variant($variation_id, $new_row_id)
    {

        // Given values
        $original_variant_option_id = $variation_id; // replace with your actual value
        $new_variant_option_id = $new_row_id;      // replace with your new value

        // Select the rows based on the original variant_option_id
        $this->db->where('variant_option_id', $original_variant_option_id);
        $query = $this->db->get('variant_sub_options'); // replace 'your_table_name' with your actual table name

        if ($query->num_rows() > 0) {

           
            foreach ($query->result_array() as $row) {
                // Modify the data with the new variant_option_id

               
                $row['variant_option_id'] = $new_variant_option_id;

                // Remove the primary key if needed (assuming 'id' is the primary key)
                $old_sub_variant_option_id = $row['id'];
                unset($row['id']);


                // var_dump($row);
                // Insert the new row with the modified data
                 $this->db->insert('variant_sub_options', $row);
                // Get the ID of the newly inserted row if needed
                $new_row_id = $this->db->insert_id();

               
                 $this->duplicate_sub_variant_items($old_sub_variant_option_id,$new_row_id);

            }

            
        }

    }

    public function duplicate_sub_variant_items($variation_item_id, $new_row_id)
    {
        // Given values
        $original_variant_option_id = $variation_item_id; // replace with your actual value
        $new_variant_option_id = $new_row_id;      // replace with your new value


        
        // Select the rows based on the original variant_option_id
        $this->db->where('variant_option_id', $original_variant_option_id);
        $query = $this->db->get('variants'); // replace 'your_table_name' with your actual table name

        if ($query->num_rows() > 0) {
            
            foreach ($query->result_array() as $row) {
                // Modify the data with the new variant_option_id
                $row['variant_option_id'] = $new_variant_option_id;

                // Remove the primary key if needed (assuming 'id' is the primary key)
                unset($row['id']);

                // Insert the new row with the modified data
                $this->db->insert('variants', $row);
            }
        }
    }

    public function delete_sub_variant()
    {
        $variation_item_id = required(sanitize($this->input->post('data_variation_sub_id')));
        $this->db->where('id', $variation_item_id);
        $this->db->delete('variant_sub_options');
        return true;
    }


    /**
     *  CREATE OR UPDATE VARIATION OPTIONS
     */

    public function save_item($action = "create")
    {
        $data['menu_id'] = required(sanitize($this->input->post('menu_id')));
        $data['variant_option_id'] = required(sanitize($this->input->post('variant_option_id')));
        //  $data['options'] = required(trim(strtolower(str_replace('-', ' ', sanitize($this->input->post('options'))))));

        if ($this->menu_model->authentication($data['menu_id'])) {
            if ($action == "create") {
                $this->db->insert('variants', $data);
                return $this->db->insert_id();
            } else {
                $menu_option_id = required(sanitize($this->input->post('menu_option_id')));
                $this->db->where('id', $menu_option_id);
                $this->db->update('variants', $data);
                return true;
            }
        } else {
            error(get_phrase("you_are_not_authorized"), site_url('menu'));
        }
    }



    public function delete_item()
    {
        $variation_item_id = sanitize($this->input->post('data_item_id'));
        $this->db->where('id', $variation_item_id);
        $this->db->delete('variants');
        return true;

    }


    public function update_item()
    {
        $data[required(sanitize($this->input->post('variation_attr_name')))] = required(sanitize($this->input->post('variation_attr_value')));
        //  $data['variation_item_id'] = required(sanitize($this->input->post('variation_item_id')));
        //  $data['options'] = required(trim(strtolower(str_replace('-', ' ', sanitize($this->input->post('options'))))));


        $variation_item_id = required(sanitize($this->input->post('variation_item_id')));
        $this->db->where('id', $variation_item_id);
        $this->db->update('variants', $data);
        return true;

    }


    /**
     *  CREATE OR UPDATE VARIATION OPTIONS
     */

    public function save_options($action)
    {
        $data['menu_id'] = required(sanitize($this->input->post('menu_id')));
        $data['name'] = required(sanitize($this->input->post('name')));
        $data['price'] = sanitize($this->input->post('price'));
        // $data['options'] = required(trim(strtolower(str_replace('-', ' ', sanitize($this->input->post('options'))))));

        if ($this->menu_model->authentication($data['menu_id'])) {
            if ($action == "create") {
                $this->db->insert('variant_options', $data);
                return true;
            } else {
                $menu_option_id = required(sanitize($this->input->post('menu_option_id')));
                $this->db->where('id', $menu_option_id);
                $this->db->update('variant_options', $data);
                return true;
            }
        } else {
            error(get_phrase("you_are_not_authorized"), site_url('menu'));
        }
    }

    /**
     * DELETE MENU OPTIONS
     */

    public function delete_options($menu_option_id)
    {
        $menu_options = $this->db->get_where('variant_options', ['id' => $menu_option_id])->row_array();
        if ($this->menu_model->authentication($menu_options['menu_id'])) {
            $this->db->where('id', $menu_option_id);
            $this->db->delete('variant_options');
            return true;
        } else {
            error(get_phrase("you_are_not_authorized"), site_url('menu'));
        }
    }

    /**
     *  GET VARIATION OPTIONS
     */

    public function get_options($menu_id)
    {
        $menu_options = $this->db->get_where('variant_options', ['menu_id' => $menu_id])->result_array();
        return $menu_options;
    }


    /**
     *  GET VARIATION SUB OPTIONS
     */

    public function get_sub_options($variant_option_id)
    {
        $this->db->order_by("id", "asc");
        $variant_sub_options = $this->db->get_where('variant_sub_options', ['variant_option_id' => $variant_option_id])->result_array();
        return $variant_sub_options;
    }



    /**
     *  GET VARIATION SUB OPTION ITEMS
     */

    public function get_sub_option_items($variant_sub_option_id)
    {
        $this->db->order_by("id", "asc");
        $variant_sub_option_items = $this->db->get_where('variants', ['variant_option_id' => $variant_sub_option_id])->result_array();
        return $variant_sub_option_items;
    }

    public function get_variant_name_by_id($variant_id)
    {
        $this->db->select('variant');
        $variant = $this->db->get_where('variants', ['id' => $variant_id])->row_array();
        return $variant ? $variant['variant'] : null;
    }

    // variant_options name
    public function get_variant_sub_options_name_by_id($variant_option_id)
    {
        $this->db->select('name');
        $variant_option = $this->db->get_where('variant_sub_options', ['id' => $variant_option_id])->row_array();
        return $variant_option ? $variant_option['name'] : null;
    }



    /**
     *  GET VARIATION OPTIONS BY ID
     */

     public function get_options_by_id($id, $bypass_authentication = false)
     {
         $menu_options = $this->db->get_where('variant_options', ['id' => $id])->row_array();
         if ($bypass_authentication || $this->menu_model->authentication($menu_options['menu_id'])) {
             return $menu_options;
         } else {
             error(get_phrase("you_are_not_authorized"), site_url('menu'));
         }
     }


    /**
     * THIS FUNCTION TOGGLES FLAG OF MENU VARIANT FIELD
     */
    public function toggle_menu_variant()
    {
        $menu_id = required(sanitize($this->input->post('menu_id')));
        $has_variant = required(sanitize($this->input->post('has_variant')));
        if ($this->menu_model->authentication($menu_id)) {
            $this->db->where('id', $menu_id);
            $this->db->update('food_menus', ['has_variant' => $has_variant]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * THIS FUNCTION GETS ALL THE MENU VARIANTS
     */
    public function get_variants($menu_id)
    {
        $variants = $this->db->get_where('variants', ['menu_id' => $menu_id])->result_array();
        if ($this->menu_model->authentication($menu_id)) {
            return $variants;
        } else {
            return array();
        }
    }

    /**
     * THIS FUNCTION GETS ALL THE MENU VARIANTS
     */
    public function get_variant_options($menu_id)
    {
        $variants = $this->db->get_where('variant_options', ['menu_id' => $menu_id])->result_array();
        if ($this->menu_model->authentication($menu_id)) {
            return $variants;
        } else {
            return array();
        }
    }


    public function get_variant_options_items($menu_id)
    {
        $variants = $this->db->get_where('variants', ['variant_option_id' => $menu_id])->result_array();
        // if ($this->menu_model->authentication($menu_id)) {
        return $variants;
        // } else {
        // return array();
        // }
    }

    /**
     *  CREATE OR UPDATE VARIATION
     */

    public function save_variant($action)
    {
        $data['menu_id'] = required(sanitize($this->input->post('menu_id')));
        $data['price'] = required(sanitize($this->input->post('variant_price')));
        $variants = $this->input->post('menu_variation_options');
        $variants = array_map('strtolower', $variants);
        sort($variants);
        $data['variant'] = required(trim(sanitize(implode(",", $variants))));

        if ($this->menu_model->authentication($data['menu_id'])) {
            if ($action == "create") {
                $previous_data = $this->db->get_where('variants', array('menu_id' => $data['menu_id'], 'variant' => $data['variant']));
                if ($previous_data->num_rows() == 0) {
                    $this->db->insert('variants', $data);
                } else {
                    $previous_data = $previous_data->row_array();
                    $menu_variant_id = $previous_data['id'];
                    $this->db->where('id', $menu_variant_id);
                    $this->db->update('variants', $data);
                }

                return true;
            } else {
                $previous_data = $this->db->get_where('variants', array('menu_id' => $data['menu_id'], 'variant' => $data['variant']));
                if ($previous_data->num_rows() == 0) {
                    $menu_variant_id = required(sanitize($this->input->post('menu_variant_id')));
                    $this->db->where('id', $menu_variant_id);
                    $this->db->update('variants', $data);
                } else {
                    $previous_data = $previous_data->row_array();
                    $menu_variant_id = $previous_data['id'];
                    $this->db->where('id', $menu_variant_id);
                    $this->db->update('variants', $data);
                }
                return true;
            }
        } else {
            error(get_phrase("you_are_not_authorized"), site_url('menu'));
        }
    }

    /**
     * DELETE MENU VARIANT
     */

    public function delete_variant($menu_variant_id)
    {
        $menu_variants = $this->db->get_where('variants', ['id' => $menu_variant_id])->row_array();
        if ($this->menu_model->authentication($menu_variants['menu_id'])) {
            $this->db->where('id', $menu_variant_id);
            $this->db->delete('variants');
            return true;
        } else {
            error(get_phrase("you_are_not_authorized"), site_url('menu'));
        }
    }

    /**
     *  GET VARIATION BY ID
     */

    public function get_variant_by_id($id)
    {
        $menu_variant = $this->db->get_where('variants', ['id' => $id])->row_array();
        if ($this->menu_model->authentication($menu_variant['menu_id'])) {
            return $menu_variant;
        } else {
            error(get_phrase("you_are_not_authorized"), site_url('menu'));
        }
    }
}
