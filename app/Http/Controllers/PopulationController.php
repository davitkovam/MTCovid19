<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class PopulationController extends Controller
{
    
    public static function list()
    {
        return DB::select("select * from population");

    }
    public static function regija($reg)
    {
        if($reg =="Vkupno")
        {
            return 2081000;
        }
        
        $populationDatabase= DB::select("select prebivalstvo from population where Regija='{$reg}';");
        $pop=0;
         foreach ($populationDatabase as $population):
            foreach ($population as $p):
                $pop= $p;
            endforeach;
        endforeach;
        return $pop;
    }
} 
