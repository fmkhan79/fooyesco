<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 07 - July - 2020
 * Author : TheDevs
 * Settings model handles all the database queries of settings related data
 */

class submission_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
    }

    public function submit_contact_form($submitData)
    {
        return $this->db->insert('submissions', $submitData);
    }


}
