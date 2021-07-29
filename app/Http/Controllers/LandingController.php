<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\AboutUs;
use App\Candidate;
use App\Deficiency;
use App\Banner;
use App\Experience;
use App\News;
use App\OurNumbers;
use App\Job;
use App\OurTeam;
use App\Video;
use App\Schooling;
use App\Subscribed;
use App\Field;
use App\Unit;
use App\State;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
        $data=Candidate::where('user_id','=',$logged_in->id)->with(['Schooling','Experience'])->first();
        $deficiencies = Deficiency::all();
        $schooling_grades=[
            'technology' => 'Tecnólogo',
            'technician' => 'Técnico',
            'graduation' => 'Graduação',
            'postgrad' => 'Pós Graduação',
            'masters' => 'Mestrado',
            'doctor' => 'Doutorado',
            'phd' => 'PHD',
        ];

        $schooling_formation=[
            'fundamental'=>'Fundamental',
            'highschool'=>'Médio',
            'technical'=>'Técnico',
            'superior'=>'Superior',
        ];

        $schooling_status=[
            'complete'=>'Concluído',
            'coursing'=>'Cursando',
            'incomplete'=>'Incompleto',
        ];

        if (empty($data->schooling)){
            $data->schooling = new Schooling;
        }
        
        return view('profile')->with([
            'data'=>$data,
            'logged_in'=>$logged_in,
            'deficiencies'=>$deficiencies,
            'schooling_grades'=>$schooling_grades,
            'schooling_status'=>$schooling_status,
            'schooling_formation'=>$schooling_formation,
        ]);
    }

    public function saveProfile(Request $request){
        $dados=$request->input();
        $logged_in=Auth::user();

        if (!empty($dados['id']))
            $candidate=Candidate::where('id','=',$dados['id'])->first();
        else
            $candidate=new Candidate;

        $schoolings=json_decode($dados['schoolings'],true);
        $excluded_schoolings=json_decode($dados['excluded_schoolings'],true);
        $experiences=json_decode($dados['experiences'],true);
        $excluded_experiences=json_decode($dados['excluded_experiences'],true);

        Schooling::whereIn('id',$excluded_schoolings)->delete();
        Experience::whereIn('id',$excluded_experiences)->delete();

    	unset($dados['_token']);
        unset($dados['id']);
        unset($dados['schoolings']);
        unset($dados['excluded_schoolings']);
        unset($dados['experiences']);
        unset($dados['excluded_experiences']);
        unset($dados['experience']);
        foreach($dados as $k => $d){
            $candidate->{$k}=$d;
        }
        $candidate->user_id=$logged_in->id;
        $candidate->save();

        foreach ($schoolings as $schooling_data){
            if (!empty($schooling_data['id']))
                $schooling = Schooling::where('id','=',$schooling_data['id'])->first();
            else
                $schooling = new Schooling;
            
            unset($schooling_data['id']);
            unset($schooling_data['created_at']);
            unset($schooling_data['updated_at']);
            $schooling_data['candidate_id']=$candidate->id;
            foreach($schooling_data as $k=>$d){
                $schooling->{$k}=$d;
            }
            $schooling->save();
        }

        foreach ($experiences as $experience_data){
            if (!empty($experience_data['id']))
                $experience = Experience::where('id','=',$experience_data['id'])->first();
            else
                $experience = new Experience;
            
            unset($experience_data['id']);
            unset($experience_data['created_at']);
            unset($experience_data['updated_at']);
            $experience_data['candidate_id']=$candidate->id;
            foreach($experience_data as $k=>$d){
                $experience->{$k}=$d;
            }
            $experience->save();
        }

        return "";
    }

    public function jobsList(){
        $logged_in=Auth::user();
        $candidate=Candidate::where('user_id','=',$logged_in->id)->with(['subscriptions'])->first();
        $subscriptions = $candidate->subscriptions;
        $jobs = Job::where('status','=',1)->with(['tags','field'])->orderBy('created_at','desc')->get();
        $fields = Field::get();
        $units = Unit::get();
        $user_id=0;
        if ($logged_in)
            $user_id=$logged_in->id;
        return view('candidate_jobs')->with([
            'jobs'=>$jobs,
            'fields'=>$fields,
            'units'=>$units,
            'logged_in'=>$logged_in,
            'user_id'=>$user_id,
            'subscriptions'=>$subscriptions,
            'candidate_id'=>$candidate->id,
        ]);
    }

    public function candidateSubscriptions() {
        $logged_in=Auth::user();
        $candidate=Candidate::where('user_id','=',$logged_in->id)->with(['subscriptions'])->first();
        $jobs = Job::where('status','=',1)->with(['tags','field'])->orderBy('created_at','desc')->get();
        $fields = Field::get();
        $units = Unit::get();

        $subscriptions = $candidate->subscriptions;
        $user_id=0;
        if ($logged_in)
            $user_id=$logged_in->id;

        return view('candidate_subscriptions')->with([
            'jobs'=>$jobs,
            'subscriptions'=>$subscriptions,
            'logged_in'=>$logged_in,
            'user_id'=>$user_id,
            'fields'=>$fields,
            'units'=>$units,
            'candidate_id'=>$candidate->id,
        ]);
    }

    public function applyForJob(Request $request){
        $subscribed = new Subscribed;
        $subscribed->job_id=$request->job_id;
        $subscribed->candidate_id=$request->candidate_id;
        $subscribed->save();
        DB::connection('mysql')->table('subscribed_has_states')->insert(
            [
                'subscribed_id'=>$subscribed->id,
                'state_id'=>1,
            ]
        );
        return '';
    }

    public function cancelApplication(Request $request){
        $subscribed = Subscribed::where('job_id','=',$request->job_id)->where('candidate_id','=',$request->candidate_id)->first();
        DB::connection('mysql')->table('subscribed_has_states')->where('subscribed_id','=',$subscribed->id)->delete();
        $subscribed->delete();
        return '';
    }

}
