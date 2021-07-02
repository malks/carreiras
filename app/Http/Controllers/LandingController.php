<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\AboutUs;
use App\Candidate;
use App\Deficiency;
use App\Banner;
use App\News;
use App\OurNumbers;
use App\Job;
use App\OurTeam;
use App\Video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class LandingController extends Controller
{
    
    public function index (Request $request,Response $response){
        $logged_in=Auth::user();
        $start_date=Carbon::parse(Carbon::now('America/Sao_Paulo')->startOfDay()->format('Y-m-d H:i:s'))->setTimezone('UTC');
        $final_date=Carbon::parse(Carbon::now('America/Sao_Paulo')->endOfDay()->format('Y-m-d H:i:s'))->setTimezone('UTC');

        $banners=Banner::where('active_from','<=',$start_date)->where('active_to','>=',$final_date)->orderBy('order','asc')->get();
        $about_us=AboutUs::where('id','=',1)->first();

        $our_numbers=OurNumbers::where('active_from','<=',$start_date)->where('active_to','>=',$final_date)->take(12)->get();
        $total_numbers=count($our_numbers);
        $total_numbers = ($total_numbers>0) ? $total_numbers : 1;

        $our_team = OurTeam::where('active_from','<=',$start_date)->where('active_to','>=',$final_date)->get();
        $our_team_count = count($our_team);
        $our_team_count = ($our_team_count>0) ? $our_team_count : 1;

        $video = Video::where('active','=',1)->first();

        $jobs = Job::where('status','=',1)->with(['tags','field'])->orderBy('created_at','desc')->get();
        return view('welcome')->with(
            [
                'banners'=>$banners,
                'about_us'=>$about_us,
                'our_numbers'=>$our_numbers,
                'our_team'=>$our_team,
                'our_team_count'=>$our_team_count,
                'total_numbers'=>$total_numbers,
                'video'=>$video,
                'jobs'=>$jobs,
                'logged_in'=>$logged_in,
            ]
        );
    }


    public function profile(){
        $logged_in=Auth::user();
        $data=Candidate::where('user_id','=',$logged_in->id)->first();
        $deficiencies = Deficiency::all();
        return view('profile')->with([
            'data'=>$data,
            'logged_in'=>$logged_in,
            'deficiencies'=>$deficiencies,
        ]);
    }

    public function saveProfile(Request $request){
        $dados=$request->input();
        $candidate=Candidate::where('id','=',$dados['id'])->first();
    	unset($dados['_token']);
        unset($dados['id']);

        foreach($dados as $k => $d){
            $candidate->{$k}=$d;
        }

        $candidate->save();
        return "";
    }
}
