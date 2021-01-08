<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class EntryController extends Controller
{
    //
    public static function getRegions()
    {
        $regionsDatabase=DB::select("Select COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'nijz';");
        $regions=[];
        foreach ($regionsDatabase as $r):
            foreach ($r as $a):
                array_push($regions, $a);
            endforeach;
        endforeach;
        unset($regions[0]);
        return $regions;
    }
    public static function getDates()
    {
        $datesDatabase=DB::select("Select data from nijz;");
        $dates=[];
        foreach ($datesDatabase as $day):
            foreach ($day as $a):
                array_push($dates, $a);
            endforeach;
        endforeach;
        return $dates;

    }
    public static function getCases($region, $day)
    {
        $c=0;
        $casesDatabase = DB::select("Select {$region} from nijz where data = '{$day}';");
         foreach ($casesDatabase as $cases):
            foreach ($cases as $case):
                $c= $case;
            endforeach;
        endforeach;
        return $c;
    }
    public static function getSmrti($region, $day)
    {
        if ($region == "Tujina")
        {
            return 0;
        }
        $day=date_format(date_create_from_format('Y-m-d', $day),'d-m-y' );
        $c=0;
        $casesDatabase = DB::select("Select {$region} from smrtslo where data = '{$day}';");
         foreach ($casesDatabase as $cases):
            foreach ($cases as $case):
                $c= $case;
            endforeach;
        endforeach;
        return $c;
    }
    public static function getDictionary()
    {
        $regions=EntryController::getRegions();
        $dates=EntryController::getDates();

        $array=[];
        foreach($dates as $day):
            $daily=[];
            foreach($regions as $region):
                $cases=EntryController::getCases($region, $day);
                $daily[$region] = $cases;
            endforeach;
            $array[$day] = $daily;
        endforeach;


        return $array;



    }
    public static function list()
    {
        return DB::select("select * from nijz");

    }
    public static function regija($reg)
    {
        
        return DB::select("select data, $reg from nijz");
    }
} 
