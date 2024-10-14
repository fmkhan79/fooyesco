<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Product name : FoodMob
* Date : 18 - July - 2020
* Author : TheDevs
* Updater Controller controlls all the application update related data
*/

include 'Authorization.php';
class Updater extends Authorization
{

    /**
    * CONSTRUCTOR CHECKS IF REQUIRED USER IS LOGGED IN
    */
    public function __construct()
    {
        parent::__construct();
        authorization(['admin'], true);
    }
    /**THE BELOW FUNCTION IS RESPONSIBLE FOR UPDATING THE APP**/
    function update()
    {
        // Create update directory.
        $dir = 'update';
        if (!is_dir($dir))
        mkdir($dir, 0777, true);

        $zipped_file_name = $_FILES["updater_zip"]["name"];
        $path = 'update/' . $zipped_file_name;

        move_uploaded_file($_FILES["updater_zip"]["tmp_name"], $path);

        // Unzip uploaded update file and remove zip file.
        $zip = new ZipArchive;
        $res = $zip->open($path);
        if ($res === TRUE) {
            $zip->extractTo('update');
            $zip->close();
            unlink($path);
        }else{
            $this->session->set_flashdata('error_message', get_phrase('make_sure').' Zip Extension '.get_phrase('is_enabled_on_your_server'));
            redirect(site_url('settings/system'), 'refresh');
        }

        $unzipped_file_name = substr($zipped_file_name, 0, -4);
        $str = file_get_contents('./update/' . $unzipped_file_name . '/update_config.json');
        $json = json_decode($str, true);

        if ($json['require_version'] != get_system_settings('version')){
            $this->session->set_flashdata('error_message', get_phrase('please_update_version').' '.$json['require_version'].' '.get_phrase('first'));
            redirect(site_url('settings/system'), 'refresh');
        }

        // Create new directories.
        if (!empty($json['directory'])) {
            foreach ($json['directory'] as $directory) {
                if (!is_dir($directory['name']))
                mkdir($directory['name'], 0777, true);
            }
        }

        // Create/Replace new files.
        if (!empty($json['files'])) {
            foreach ($json['files'] as $file)
            copy($file['root_directory'], $file['update_directory']);
        }

        // CREATE OR REPLACE NEW LIBRARIES
        if (!empty($json['libraries'])) {
            foreach ($json['libraries'] as $libraries){
                copy($libraries['root_directory'], $libraries['update_directory']);

                //Unzip zip file and remove zip file.
                $library_path = $libraries['update_directory'];

                // PATH OF EXTRACTING LIBRARY FILE
                $library_path_array = explode('/', $library_path);
                array_pop($library_path_array);
                $extract_to = implode('/', $library_path_array);
                $library_zip = new ZipArchive;
                $library_result = $library_zip->open($library_path);
                if ($library_result === TRUE) {
                    $library_zip->extractTo($extract_to);
                    $library_zip->close();
                }else{
                    $this->session->set_flashdata('error_message', get_phrase('make_sure').' Zip Extension '.get_phrase('is_enabled_on_your_server'));
                    redirect(site_url('settings/system'), 'refresh');
                }
                unlink($library_path);
            }
        }

        // RUN UPDATER FOR DATABASE
        require './update/' . $unzipped_file_name . '/update_script.php';

        $this->session->set_flashdata('flash_message', get_phrase('application_updated_successfully'));
        redirect(site_url('settings/system'), 'refresh');
    }
}
