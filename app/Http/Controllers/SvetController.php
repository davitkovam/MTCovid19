<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class SvetController extends Controller
{
    public static function getCaseCountryDate($country, $date)
    {
        $datum=date_format(date_create_from_format('Y-m-d', $date), 'd-m-y');
        //return $datum;
        $countriesDatabase=DB::select("Select total_cases_per_million from svet where iso_code = '{$country}' and datum = '{$datum}';");
        $rez=0;
        foreach ($countriesDatabase as $r):
            foreach ($r as $a):
                $rez=$a;
            endforeach;
        endforeach;
        return $rez;
    }
    public static function getTable()
    {
        //return $datum;
        $tabela=[];
        $countriesDatabase=DB::select("Select iso_code, datum, total_cases_per_million from svet;");
        $rez=0;
        foreach ($countriesDatabase as $r):
            $zemja="";
            $data="";
            $slucai=0;
            foreach ($r as $a):
                if($zemja == "")
                {
                    $zemja=$a;
                }
                elseif($data == "")
                {
                    $data=$a;
                }
                elseif ($a)
                {
                    $slucai=$a;

                }
            endforeach;
            if (date_create_from_format('d-m-y', $data))
            {
                $data=date_format(date_create_from_format('d-m-y', $data), 'Y-m-d');
                array_push($tabela, array($zemja, $data, $slucai));
            }
           // array_push($tabela, array(date_create_from_format('d-m-y', $data), $data));
            
        endforeach;
        return $tabela;
    }
    public static function getTableActualCases()
    {
        //return $datum;
        $tabela=[];
        $countriesDatabase=DB::select("Select iso_code, datum, total_cases from svet;");
        $rez=0;
        foreach ($countriesDatabase as $r):
            $zemja="";
            $data="";
            $slucai=0;
            foreach ($r as $a):
                if($zemja == "")
                {
                    $zemja=$a;
                }
                elseif($data == "")
                {
                    $data=$a;
                }
                elseif ($a)
                {
                    $slucai=$a;

                }
            endforeach;
            if (date_create_from_format('d-m-y', $data))
            {
                $data=date_format(date_create_from_format('d-m-y', $data), 'Y-m-d');
                array_push($tabela, array($zemja, $data, $slucai));
            }
           // array_push($tabela, array(date_create_from_format('d-m-y', $data), $data));
            
        endforeach;
        return $tabela;
    }
    public static function getTableActualDeaths()
    {
        //return $datum;
        $tabela=[];
        $countriesDatabase=DB::select("Select iso_code, datum, total_deaths from svet;");
        $rez=0;
        foreach ($countriesDatabase as $r):
            $zemja="";
            $data="";
            $slucai=0;
            foreach ($r as $a):
                if($zemja == "")
                {
                    $zemja=$a;
                }
                elseif($data == "")
                {
                    $data=$a;
                }
                elseif ($a)
                {
                    $slucai=$a;

                }
            endforeach;
            if (date_create_from_format('d-m-y', $data))
            {
                $data=date_format(date_create_from_format('d-m-y', $data), 'Y-m-d');
                array_push($tabela, array($zemja, $data, $slucai));
            }
           // array_push($tabela, array(date_create_from_format('d-m-y', $data), $data));
            
        endforeach;
        return $tabela;
    }
    public static function getTableDeaths()
    {
        //return $datum;
        $tabela=[];
        $countriesDatabase=DB::select("Select iso_code, datum, total_deaths_per_million from svet;");
        $rez=0;
        foreach ($countriesDatabase as $r):
            $zemja="";
            $data="";
            $slucai=0;
            foreach ($r as $a):
                if($zemja == "")
                {
                    $zemja=$a;
                }
                elseif($data == "")
                {
                    $data=$a;
                }
                elseif ($a)
                {
                    $slucai=$a;

                }
            endforeach;
            if (date_create_from_format('d-m-y', $data))
            {
                $data=date_format(date_create_from_format('d-m-y', $data), 'Y-m-d');
                array_push($tabela, array($zemja, $data, $slucai));
            }
           // array_push($tabela, array(date_create_from_format('d-m-y', $data), $data));
            
        endforeach;
        return $tabela;
    }
    public static function getIsos()
    {
        $isosDatabase=DB::select("Select iso_code From svet;");
        $isos=[];
        foreach ($isosDatabase as $r):
            foreach ($r as $a):
                if (!in_array($a, $isos))
                {
                    array_push($isos, $a);
                }
                
            endforeach;
        endforeach;
        return $isos;
    }

} 