<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class WorldController extends Controller
{
    //
    public static function getCountries()
    {
        $countriesDatabase=DB::select("Select Country from covid_19_world_worldometers;");
        $countries=[];
        foreach ($countriesDatabase as $r):
            foreach ($r as $a):
                array_push($countries, $a);
            endforeach;
        endforeach;
        return $countries;
    }
    public static function getTotalCases($country)
    {
        $casesDatabase=DB::select("Select Total_Cases from covid_19_world_worldometers where country = '{$country}';");
        $c=0;
        foreach ($casesDatabase as $cases):
            foreach ($cases as $case):
                $c= $case;
            endforeach;
        endforeach;
        return $c;
    }

    public static function getNewCases($country)
    {
        $casesDatabase=DB::select("Select New_Cases from covid_19_world_worldometers where country = '{$country}';");
        $c=0;
        foreach ($casesDatabase as $cases):
            foreach ($cases as $case):
                $c= $case;
            endforeach;
        endforeach;
        if ($c=="None")
        {
            $c="0";
        }
        $cas = (int) $c;
        return $cas;
    }
    public static function getNewDeaths($country)
    {
        $deathsDatabase=DB::select("Select New_Deaths from covid_19_world_worldometers where country = '{$country}';");
        $c=0;
        foreach ($deathsDatabase as $cases):
            foreach ($cases as $case):
                $c= $case;
            endforeach;
        endforeach;
        if ($c=="None")
        {
            $c="0";
        }
        $cas = (int) $c;
        return $cas;
    }
    public static function getTotalDeaths($country)
    {
        $deathsDatabase=DB::select("Select Total_Deaths from covid_19_world_worldometers where country = '{$country}';");
        $c=0;
        foreach ($deathsDatabase as $cases):
            foreach ($cases as $case):
                $c= $case;
            endforeach;
        endforeach;
        if ($c=="None")
        {
            $c="0";
        }
        $cas = (int) $c;
        return $cas;
    }
    public static function getPerMilCases($country)
    {
        $deathsDatabase=DB::select("Select Cases_1M from covid_19_world_worldometers where country = '{$country}';");
        $c=0;
        foreach ($deathsDatabase as $cases):
            foreach ($cases as $case):
                $c= $case;
            endforeach;
        endforeach;
        if ($c=="None")
        {
            $c="0";
        }
        $cas = (int) $c;
        return $cas;
    }






   
} 
