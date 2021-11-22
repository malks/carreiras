<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\AboutUs;
use App\Address;
use App\Candidate;
use App\Deficiency;
use App\Banner;
use App\Experience;
use App\News;
use App\OurNumbers;
use App\Job;
use App\Language;
use App\OurTeam;
use App\Video;
use App\Schooling;
use App\Subscribed;
use App\Subscriber;
use App\Field;
use App\Mail\Register;
use App\Mail\Help;
use App\Unit;
use App\User;
use App\State;
use App\Tag;
use App\HelpContact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class LandingController extends Controller
{
    
    public function index (Request $request,Response $response){
        $logged_in=Auth::user();
        $user_id=0;
        $candidate_id=0;
        $role='';
        $subscriptions=Array();

        if (!empty($logged_in)){
            $user_id=$logged_in->id;
            $role=User::where('id','=',$user_id)->with('roles')->first()->roles[0]->name;
            $candidate_helper=Candidate::where('user_id','=',$logged_in->id)->first();
            if (!empty($candidate_helper))
                $candidate_id=$candidate_helper->id;
            $subscriptions=Subscribed::where('candidate_id','=',$candidate_id)->get()->toArray();
        }

        $start_date=Carbon::parse(Carbon::now('America/Sao_Paulo')->startOfDay()->format('Y-m-d H:i:s'))->setTimezone('UTC');
        $final_date=Carbon::parse(Carbon::now('America/Sao_Paulo')->endOfDay()->format('Y-m-d H:i:s'))->setTimezone('UTC');
        $today=Carbon::now('America/Sao_Paulo')->startOfDay()->format('Y-m-d');

        $banners=Banner::where('active_from','<=',$start_date)->where('active_to','>=',$final_date)->orderBy('order','asc')->get();
        $fields=Field::all();
        $units=Unit::all();
        $about_us=AboutUs::where('id','=',1)->first();

        $our_numbers=OurNumbers::where('active_from','<=',$start_date)->where('active_to','>=',$final_date)->take(12)->get();
        $total_numbers=count($our_numbers);
        $total_numbers = ($total_numbers>0) ? $total_numbers : 1;

        $our_team = OurTeam::where('active_from','<=',$start_date)->where('active_to','>=',$final_date)->get();
        $our_team_count = count($our_team);
        $our_team_count = ($our_team_count>0) ? $our_team_count : 1;

        $video = Video::where('active','=',1)->first();

        //$jobs = Job::where('status','=',1)->where('start','<=',$today)->where('end','>=',$today)->with(['tags','field'])->orderBy('created_at','desc')->get();
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
                'units'=>$units,
                'subscriptions'=>$subscriptions,
                'fields'=>$fields,
                'logged_in'=>$logged_in,
                'user_id'=>$user_id,
                'candidate_id'=>$candidate_id,
                'role'=>$role,
            ]
        );
    }

    public function access(){
        return view('access');
    }

    public function buscaCep(Request $request) {
        $req_cep=str_replace(["-","."],"",$request->cep);
        $address = Address::where('zip','=',$req_cep)->first();
        if (empty($address)){
            $response=Http::get("https://viacep.com.br/ws/{$req_cep}/json/");
            $vals=json_decode($response,true);

            $address=new Address;
            $address->zip=str_replace(["-","."],"",$vals['cep']);
            $address->city=$vals['localidade'];
            $address->state=$vals['uf'];
            $address->street=$vals['logradouro'];
            $address->district=$vals['bairro'];
            $address->complement=$vals['complemento'];

            $address->save();
        }
        if (!empty($address))
            $address=$address->toJson();

        return $address;
    }

    public function landingData(){

        $logged_in=Auth::user();
        $user_id=0;
        $candidate_id=0;
        $role='';
        $subscriptions=Array();

        if (!empty($logged_in)){
            $user_id=$logged_in->id;
            $role=User::where('id','=',$user_id)->with('roles')->first()->roles[0]->name;
            $candidate_helper=Candidate::where('user_id','=',$logged_in->id)->first();
            if (!empty($candidate_helper))
                $candidate_id=$candidate_helper->id;
            $subscriptions=Subscribed::where('candidate_id','=',$candidate_id)->get()->toArray();
        }

        $start_date=Carbon::parse(Carbon::now('America/Sao_Paulo')->startOfDay()->format('Y-m-d H:i:s'))->setTimezone('UTC');
        $final_date=Carbon::parse(Carbon::now('America/Sao_Paulo')->endOfDay()->format('Y-m-d H:i:s'))->setTimezone('UTC');
        $fields=Field::all();
        $units=Unit::all();
        $jobs = Job::where('status','=',1)->with(['tags','field'])->orderBy('created_at','desc')->get();

        $data['fields']=$fields;
        $data['units']=$units;
        $data['jobs']=$jobs;
        $data['subscriptions']=$subscriptions;

        return json_encode($data,true);
    }

    public function newsletterSubscribe(Request $request){
        $subscriber=new Subscriber;
        $subscriber->email=$request->email;
        $subscriber->save();
		return '';
    }

    public function policy() {
        $logged_in=Auth::user();
        return view('policy')->with([
            'logged_in'=>$logged_in,
        ]);
    }

    public function help(){
        $logged_in=Auth::user();
        return view('help')->with([
            'logged_in'=>$logged_in,
        ]);
    }

    public function sendHelp(Request $request){
        $logged_in=Auth::user();
        $data=$request->all();
        if ($request->hasFile('contact_file')){
            $extension=$request->contact_file->extension();
            $attachment=date('U').".".$extension;
            $tmp=$request->contact_file->path();
            copy($tmp, $_SERVER['DOCUMENT_ROOT'].'/files/'.$attachment);
            $data['attachment']=$attachment;
        }
        $to=array_map(function ($arr) { return $arr['email']; }, HelpContact::where('status','=',1)->get()->toArray());
        Mail::to($to)->send(new Help($data));
        return view('help_success')->with([
            'logged_in'=>$logged_in,
        ]);
    }

    public function profile(){
        $logged_in=Auth::user();
        $data=Candidate::where('user_id','=',$logged_in->id)->with(['Schooling','Experience','interests','langs'])->first();
        if (empty($data))
            $data=new Candidate;
        $deficiencies = Deficiency::all();
        $languages=Language::all();
        $selected_languages=$data->langs->toArray();
        $tags = Tag::all();
        $schooling_grades=[
            'professional' => 'Profissionalizante',
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
            $schooling = new Schooling;
            $data->schooling=$schooling;
        }
        $data['prefered_work_period']=explode(",",$data['prefered_work_period']);
        
        return view('profile')->with([
            'tags'=>$tags,
            'data'=>$data,
            'logged_in'=>$logged_in,
            'deficiencies'=>$deficiencies,
            'languages'=>$languages,
            'schooling_grades'=>$schooling_grades,
            'schooling_status'=>$schooling_status,
            'schooling_formation'=>$schooling_formation,
            'selected_languages'=>$selected_languages,
        ]);
    }

    public function saveProfile(Request $request){
        $dados=$request->input();
        $logged_in=Auth::user();

/*

Titulos de campos de questionario para sincronizar com senior

$arr['worked_earlier_at_lunelli']="1. Trabalhou anteriormente na Lunelli?";
$arr['lunelli_earlier_work_period_start']="1.a. Início";
$arr['lunelli_earlier_work_period_end']="1.b. Fim";
$arr['time_living_in_sc']="2. Há quanto tempo vive em Santa Catarina?";
$arr['cities_lived_before']="3. Em que cidades viveu anteriormente?";
$arr['living_with']="4. Mora com Quem?";
$arr['living_with_professions']="5. Qual a profissão das pessoas que moram com você?";
$arr['spouse_job']="6. Como pretende se deslocar até a empresa?";
$arr['last_time_doctor']="7. Quando foi pela última vez ao médico?";
$arr['last_time_doctor_reason']="7.a. Qual foi o motivo?";
$arr['surgery']="8. Ja passou por alguma cirurgia?";
$arr['surgery_reason']="8.a. Qual foi o motivo?";
$arr['hospitalized']="9. Já ficou internado(a) por algum motivo?";
$arr['hospitalized_reason']="9.a. Qual foi o motivo? Quanto Tempo?";
$arr['work_accident']="10. Já sofreu acidente de trabalho? ";
$arr['work_accident_where']="10.a. Quando e qual empresa?";
$arr['positive_personal_characteristics']="11. Cite características pessoais que você considera positivas: ";
$arr['personal_aspects_for_betterment']="12. Cite aspectos pessoais que você acredita que poderiam ser melhorados: ";
$arr['lunelli_family']="13. Possui parentes ou conhecidos que trabalham na Lunelli? Informe o nome:";
$arr['pretended_salary']="14. Pretensão salarial (mensal) em reais:";
$arr['worked_without_ctp']="15. Já trabalhou sem registro em carteira?";
$arr['worked_without_ctp_job']="15.a. Onde?";
$arr['worked_without_ctp_how_long']="15.b. Quanto tempo?";
$arr['previous_work_legal_action']="16. Possui alguma questão trabalhista?";
$arr['previous_work_legal_action_business']="16.a. Com qual empresa?";
$arr['previous_work_legal_action_reason']="16.b. Qual o motivo?";
$arr['professional_dream']="17. Qual o seu sonho profissional?";
$arr['who_are_you']="18. Resumidamente escreva quem é você:";
$arr['professional_motivation']="19. O que o motiva profissionalmente?";
$arr['what_irritates_you']="20. O que o irrita?";

*/


        if (!empty($dados['id']))
            $candidate=Candidate::where('id','=',$dados['id'])->first();
        else
            $candidate=new Candidate;

        $selected_languages=json_decode($dados['selected_languages'],true);
        $schoolings=json_decode($dados['schoolings'],true);
        $excluded_schoolings=json_decode($dados['excluded_schoolings'],true);
        $experiences=json_decode($dados['experiences'],true);
        $excluded_experiences=json_decode($dados['excluded_experiences'],true);
        $interests=json_decode($dados['interests'],true);

        Schooling::whereIn('id',$excluded_schoolings)->delete();
        Experience::whereIn('id',$excluded_experiences)->delete();

    	unset($dados['_token']);
        unset($dados['id']);
        unset($dados['schoolings']);
        unset($dados['excluded_schoolings']);
        unset($dados['experiences']);
        unset($dados['excluded_experiences']);
        unset($dados['experience']);
        unset($dados['interests']);
        unset($dados['selected_languages']);

        $dados['cpf'] = substr(str_replace(['.','-',',','_','!',';'],'',$dados['cpf']),0,11);
        $dados['pis'] = substr(str_replace(['.','-',',','_','!',';'],'',$dados['pis']),0,11);
        $dados['rg'] = substr(str_replace(['.','-',',','_','!',';'],'',$dados['rg']),0,16);
        if (!empty($dados['weight']))
            $dados['weight'] = substr(str_replace(['.','-',',','_','!',';'],'',$dados['weight']),0,6);
        if (!empty($dados['height']))
            $dados['height'] = substr(str_replace(['.','-',',','_','!',';'],'',$dados['height']),0,5);
        if (!empty($dados['work_card']))
            $dados['work_card'] = substr(str_replace(['.','-',',','_','!',';'],'',$dados['work_card']),0,9);
        if (!empty($dados['work_card_series']))
            $dados['work_card_series'] = substr(str_replace(['.','-',',','_','!',';'],'',$dados['work_card_series']),0,5);
        if (!empty($dados['work_card_digit']))
            $dados['work_card_digit'] = substr(str_replace(['.','-',',','_','!',';'],'',$dados['work_card_digit']),0,2);
        if (!empty($dados['elector_card']))
            $dados['elector_card'] = substr(str_replace(['.','-',',','_','!',';'],'',$dados['elector_card']),0,13);
        if (!empty($dados['veteran_card']))
            $dados['veteran_card'] = substr(str_replace(['.','-',',','_','!',';'],'',$dados['veteran_card']),0,13);
        $dados['cid'] = str_replace(['.','-',',','_','!',';'],'',$dados['cid']);
        if (!empty($dados['prefered_work_period']))
            $dados['prefered_work_period']=implode(",",$dados['prefered_work_period']); 
        else
            $dados['prefered_work_period']=""; 
        

        foreach($dados as $k => $d){
            $candidate->{$k}=$d;
        }
        $candidate->user_id=$logged_in->id;
        $candidate->save();

        DB::table('candidates_tags')->where('candidate_id','=',$candidate->id)->delete();
        foreach($interests as $interest){
            if (empty($interest['id']) || $interest['id']=='null' || $interest['id']==null){
                $tag = new Tag;
                $tag->name=strtolower($interest['name']);
                $tag->save();
            }
            else {
                $tag=Tag::where('id','=',$interest['id'])->first();
            }
            DB::table('candidates_tags')->insert(['candidate_id'=>$candidate->id,'tag_id'=>$tag->id]);
        }

        DB::table('candidate_languages')->where(['candidate_id'=>$candidate->id])->delete();
        foreach ($selected_languages as $lang){
            DB::table('candidate_languages')->insert(['candidate_id'=>$candidate->id,'language_id'=>$lang['id'],'level'=>$lang['pivot']['level']]);
        }

        $new_schoolings=[];
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

            $schooling->start=$schooling_data['start'];
            $schooling->end=$schooling_data['end'];
            array_push($new_schoolings,$schooling->toArray());
        }

        $new_experiences=[];
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
            $experience->admission=$experience_data['admission'];
            $experience->demission=$experience_data['demission'];
            array_push($new_experiences,$experience->toArray());
        }

        return json_encode(['experiences'=>$new_experiences,'schoolings'=>$new_schoolings],true);
    }

    public function jobsList(){
        $logged_in=Auth::user();
        if (!empty($logged_in))
            $candidate=Candidate::where('user_id','=',$logged_in->id)->first();
        else
            $candidate = new Candidate;

        $candidate_id="";
        if (!empty($candidate)){
            $subscriptions = Subscribed::where('candidate_id','=',$candidate->id)->with(['states'=>function ($states_query) {
                $states_query->where('candidate_visible','=','1');
            }])->get();
            $candidate_id=$candidate->id;
        }
        else
            $subscriptions = Array();

        $today=Carbon::now('America/Sao_Paulo')->startOfDay()->format('Y-m-d');

        $jobs = Job::where('status','=',1)->with(['tags','field'])->orderBy('created_at','desc')->get();
        //$jobs = Job::where('status','=',1)->where('start','<=',$today)->where('end','>=',$today)->with(['tags','field'])->orderBy('created_at','desc')->get();
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
            'candidate_id'=>$candidate_id,
        ]);
    }

    public function candidateSubscriptions() {
        $logged_in=Auth::user();
        $candidate=Candidate::where('user_id','=',$logged_in->id)->with(['subscriptions'])->first();
        $jobs = Job::where('status','=',1)->with(['tags','field'])->orderBy('created_at','desc')->get();
        $fields = Field::get();
        $units = Unit::get();

        $candidate_id=0;
        if (!empty($candidate)){
            $subscriptions = Subscribed::where('candidate_id','=',$candidate->id)->with(['states'=>function ($states_query) {
                $states_query->where('candidate_visible','=','1');
            }])->get();
            $candidate_id=$candidate->id;
        }
        else
            $subscriptions = Array();
            
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
            'candidate_id'=>$candidate_id,
        ]);
    }

    public function applyForJob(Request $request){
        $subscribed = new Subscribed;
        $subscribed->job_id=$request->job_id;
        $subscribed->candidate_id=$request->candidate_id;
        $subscribed->obs=$request->obs;
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
