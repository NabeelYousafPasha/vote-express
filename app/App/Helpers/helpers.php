<?php

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
/**
 * Created by PhpStorm.
 * User: CreatyDev
 * Date: 12/29/2017
 * Time: 1:30 AM
 */
CONST CONTESTANT_IMAGE_PATH = 'public/uploads/contestants';

if (!function_exists('on_page')) {
    /**
     * Check's whether request url/route matches passed link
     *
     * @param $link
     * @param string $type
     * @return null
     */
    function on_page($link, $type = "name")
    {
        switch ($type) {
            case "url":
                $result = ($link == request()->fullUrl());
                break;

            default:
                $result = ($link == request()->route()->getName());
        }

        return $result;
    }
}

if (!function_exists('exists_in_filter_key')) {
    /**
     * Appends passed value if condition is true
     *
     * @param $key
     * @param $value
     * @return null
     */
    function exists_in_filter_key($key, $value = null)
    {
        return collect(explode("&", $key))->contains($value);
    }
}

if (!function_exists('join_in_filter_key')) {
    /**
     * Appends passed value if condition is true
     *
     * @param $value
     * @return null
     */
    function join_in_filter_key(...$value)
    {
        //remove empty values
        $value = array_filter($value, function ($item) {
            return isset($item);
        });

        return collect($value)->implode('&');
    }
}

if (!function_exists('remove_from_filter_key')) {
    /**
     * Appends passed value if condition is true
     *
     * @param $key
     * @param $oldValues
     * @param $value
     * @return null
     */
    function remove_from_filter_key($key, $oldValues, $value)
    {
        $newValues = array_diff(
            array_values(
                explode("&", $oldValues)
            ), [
            $value, 'page'
        ]);

        if (count($newValues) == 0) {
            array_except(request()->query(), [$key, 'page']);

            return null;
        }

        return collect($newValues)->implode('&');
    }
}

if (!function_exists('return_if')) {
    /**
     * Appends passed value if condition is true
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function return_if($condition, $value)
    {

        if ($condition) {
            return $value;
        }
    }
}

// Custom Helpers by Nisar Ahmed
if (!function_exists('unique_string')) {
    /**
     * Generate Unique String with Model
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function unique_string($table,$key, $length)
    {   
        $unique_id = \Illuminate\Support\Str::random($length);
        $d = \DB::table($table)->where($key,$unique_id)->first();
        if($d){
            $this->unique_string($table,$key,$length);
        }else{
            return $unique_id;
        }

    }
}


if (!function_exists('text_format')) {
    /**
     * // Check if Property Exists then Echo it
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function text_format($val)
    {   
        return str_replace('_', ' ', ucwords($val));
    }
}


if (!function_exists('basic_form_fields')) {
    /**
     * // Check if Property Exists then Echo it
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function basic_form_fields()
    {   
        echo '{"_id":"57aa1d2a5b7a477b002717fe","machineName":"examples:example","modified":"2017-05-09T15:55:13.060Z","title":"Example","display":"form","type":"form","name":"example","path":"example","project":"5692b91fd1028f01000407e3","created":"2016-08-09T18:12:58.126Z","owner":"554806425867f4ee203ea861","submissionAccess":[{"type":"create_all"},{"type":"read_all"},{"type":"update_all"},{"type":"delete_all"},{"type":"create_own","roles":["5692b920d1028f01000407e6"]},{"type":"read_own"},{"type":"update_own"},{"type":"delete_own"}],"access":[{"type":"read_all","roles":["5692b920d1028f01000407e4","5692b920d1028f01000407e5","5692b920d1028f01000407e6"]}],"components":[{"html":"<h2>Contest Heading</h2><p>Some details and instruction goes here...</p>","label":"Content","refreshOnChange":false,"tableView":false,"key":"content","type":"content","input":false},{"input":"false","columns":[{"components":[{"tabindex":"1","input":"true","tableView":"true","label":"First Name","key":"firstName","placeholder":"Enter your first name","type":"textfield","hideOnChildrenHidden":false}],"width":"6","offset":"0","push":"0","pull":"0","size":"md"},{"components":[{"tabindex":"2","input":"true","tableView":"true","label":"Last Name","key":"lastName","placeholder":"Enter your last name","type":"textfield","hideOnChildrenHidden":false}],"width":"6","offset":"0","push":"0","pull":"0","size":"md"}],"type":"columns","key":"columns","tableView":"false","label":"Columns"},{"input":"false","columns":[{"components":[{"label":"Email","placeholder":"Enter your email address","tabindex":"3","spellcheck":true,"tableView":"true","calculateServer":false,"key":"email1","type":"email","input":"true","hideOnChildrenHidden":false}],"width":"6","offset":"0","push":"0","pull":"0","size":"md"},{"components":[{"tabindex":"4","input":"true","tableView":"true","label":"Phone Number","key":"phoneNumber1","placeholder":"Enter your phone number","type":"phoneNumber","hideOnChildrenHidden":false}],"width":"6","offset":"0","push":"0","pull":"0","size":"md"}],"type":"columns","key":"columns1","tableView":"false","label":"Columns"},{"tabindex":"6","input":"true","label":"Submit","tableView":"false","key":"submit","disableOnInvalid":"true","type":"button"}]}';
    }
}

if (!function_exists('custom_file_upload')) {
    /**
     * // Check if Property Exists then Echo it
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function custom_file_upload($file,$path = 'uploads',$slug = null, $default = 'default.jpg')
    {   
        if(isset($file)){
            $currentDate = Carbon::now()->toDateString();
            $image_name = $slug.'-'.$currentDate.'.'.$file->getClientOriginalExtension();
              $path = Storage::putFileAs(
                    $path, $file, $image_name
                );
              if($path){
                return $image_name;
              }
        }else{
            return $default;
        }
        // if(isset($file)){
        //     $currentDate = Carbon::now()->toDateString();
        //     $image_name = $slug ?? uniqid().'-'.$currentDate.$file->getClientOriginalExtension();

        //     if(!Storage::disk('public')->exists($path)){
        //         Storage::disk('public')->makeDirectory($path);
        //     }

        //     Storage::disk('public')->put($path.'/'.$image_name, $file);

        //     return $image_name;

        // }else{
        //     return $image_name = $default;
        // }
    }
}

// Check if Property Exists

// End Custom Helpers Nisar Ahmed

// Custom Helpers by Tallal Jamshed
if (!function_exists('changeSubscriptionEndDate')) {
    /**
     * Gold and Premium Subscription Ends after trail and first payment. to make them onetimepayment
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function changeSubscriptionEndDate()
    {   
        dd(auth()->user());
    }
}