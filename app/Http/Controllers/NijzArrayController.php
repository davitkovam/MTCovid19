<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class NijzArrayController extends Controller
{
    //
   public static function getCasesOnDateInRegion($array, $date, $region)
   {
       return $array[$date][$region];

   }
   public static function getCasesUntilDateInRegion($array, $date, $region)
   {
       $rez=0;
       $dates=EntryController::getDates();
       for ($i=0;$i<sizeof($dates);$i++)
       {
           $rez+=$array[$dates[$i]][$region];
           if($dates[$i]==$date)
           {
               return $rez;
           }
       }
       return "Oops";
   }
   public static function splitArrayInTwo($array)
   {
       
   }
} 
