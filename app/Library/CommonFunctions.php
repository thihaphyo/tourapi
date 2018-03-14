<?php
/**
 * Created by PhpStorm.
 * User: phyo
 * Date: 3/7/18
 * Time: 1:33 PM
 */

namespace App\Library;


class CommonFunctions
{
    /**
     * Common Redirect Function
     * @param $View
     * @param $master_array
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function  Redirect($View,$master_array)
    {
        return View($View,$master_array);
    }

    /**
     * To Change DateFormat
     * @param $date
     * @return string
     */
    public function ChangeDateFormat($date)
    {
        $date_arr = explode('/',$date);
        $new_date = $date_arr[2].'/'.$date_arr[0].'/'.$date_arr[1];

        return $new_date;
    }


    public static function GenerateChart($lava,$chartType,$chartName,$chartContainer)
    {
        return $lava->render($chartType, $chartName, $chartContainer);
    }
}