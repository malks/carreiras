<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AboutUs;
use App\Banner;
use App\News;
use App\OurNumbers;
use App\OurTeam;
use App\Video;
use Illuminate\Support\Carbon;

class LandingController extends Controller
{
    
    public function index (){
        $start_date=Carbon::now('America/Sao_Paulo')->startOfDay()->format('Y-m-d H:i:s')->setTimezone('UTC');
        $final_date=Carbon::now('America/Sao_Paulo')->endOfDay()->format('Y-m-d H:i:s')->setTimezone('UTC');

        Banner::where('active_from','<=',$start_date)->where('active_to','>=',$final_date)->get();
    }

}
