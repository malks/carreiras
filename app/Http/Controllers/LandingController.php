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

    public function access(Request $request){
        $redirectback="";
        if (!empty($request->query()['afterlogin'])){
            $redirectback=$request->query()['afterlogin'];
        }
        return view('access')->with([
            'redirectback'=>$redirectback
        ]);
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
        if (!empty($request->email)){
            $subscriber=new Subscriber;
            $subscriber->email=$request->email;
            $subscriber->save();    
        }
		return '';
    }

    public function policy() {
        $logged_in=Auth::user();
        $role="";
        if (!empty($logged_in)){
            $role=User::where('id','=',$logged_in->id)->with('roles')->first()->roles[0]->name;
        }
        return view('policy')->with([
            'role'=>$role,
            'logged_in'=>$logged_in,
        ]);
    }

    public function help(){
        $logged_in=Auth::user();
        $role="";
        if (!empty($logged_in)){
            $role=User::where('id','=',$logged_in->id)->with('roles')->first()->roles[0]->name;
        }
        return view('help')->with([
            'logged_in'=>$logged_in,
            'role'=>$role,
        ]);
    }

    public function sendHelp(Request $request){
        $logged_in=Auth::user();

        $user_ip=str_replace("'","",$request->ip());
        
        $quota_expired=DB::table('mail_control')->where('ip','=',$user_ip)->where('last_sent','=',date("Y-m-d"))->first();

        if (!empty($quota_expired)){
            return redirect('/');
        }

        DB::table('mail_control')->updateOrInsert(['ip'=>$user_ip],['ip'=>$user_ip,'last_sent'=>date("Y-m-d")]);

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

    private function normalize($str) {
        $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
        $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
        return str_replace($a, $b, $str);
    }

    private function varsContents($lang,$what){
        $content=[
            'es'=>[
                'boolean'=>[
                    '0'=>'No',
                    '1'=>'Si'
                ],
                'schooling_grades'=>[
                    'professional' => 'Profesionalización',
                    'technology' => 'Tecnólogo',
                    'technician' => 'Técnico',
                    'graduation' => 'graduado universitario',
                    'postgrad' => 'graduado universitario',
                    'masters' => 'Maestría',
                    'doctor' => 'Doctorado',
                    'phd' => 'Doctor',
                ],
                'schooling_formation'=>[
                    'fundamental'=>'Fundamental',
                    'highschool'=>'Medio',
                    'technical'=>'Técnico',
                    'superior'=>'Más alto',
                ],
                'schooling_status'=>[
                    'complete'=>'Concluido',
                    'coursing'=>'Estudiando',
                    'incomplete'=>'Incompleto',        
                ],
                'logradouros'=>[
                    'r' => 'Calle',
                    'est' => 'La carretera',
                    'rod' => 'Camino',
                    'av' => 'Avenida',
                    'srv' => 'Esclavitud',
                    'tv' => 'plato',
                    'o' => 'Colina',
                    'vl' => 'Callejón',
                    'q' => 'Bloquear',
                    'esm' => 'Municipal',
                    'pc' => 'Cuadrado'
                ],
                'civil_states'=>[
                    '1' =>'Soltero',
                    '2' =>'Casado',
                    '3' =>'Divorciado',
                    '4' =>'Viudo',
                    '5' =>'Concubinato',
                    '6' =>'Separado',
                    '7' =>'Unidad',
                    '8' =>'Otros',        
                ],
                'work_periods'=>[
                    '1'=>'1er turno',
                    '2'=>'2do turno',
                    '3'=>'3er turno',
                    '4'=>'Horario comercial',
                ],
                'language_levels'=>[
                    'basic'=>'Básico',
                    'intermediary'=>'Intermediario',
                    'advanced'=>'Avanzado',
                    'natural'=>'Con fluidez',
                ]
            ],
            'ptbr'=>[
                'boolean'=>[
                    '0'=>'Não',
                    '1'=>'Sim'
                ],
                'schooling_grades'=>[
                    'professional' => 'Profissionalizante',
                    'technology' => 'Tecnólogo',
                    'technician' => 'Técnico',
                    'graduation' => 'Graduação',
                    'postgrad' => 'Pós Graduação',
                    'masters' => 'Mestrado',
                    'doctor' => 'Doutorado',
                    'phd' => 'PHD',
                ],
                'schooling_formation'=>[
                    'fundamental'=>'Fundamental',
                    'highschool'=>'Médio',
                    'technical'=>'Técnico',
                    'superior'=>'Superior',
        
                ],
                'schooling_status'=>[
                    'complete'=>'Concluído',
                    'coursing'=>'Cursando',
                    'incomplete'=>'Incompleto',        
                ],
                'logradouros'=>[
                    'r' => 'Rua',
                    'est' => 'Estrada',
                    'rod' => 'Rodovia',
                    'av' => 'Avenida',
                    'srv' => 'Servidao',
                    'tv' => 'Travessa',
                    'o' => 'Outeiro',
                    'vl' => 'Viela',
                    'q' => 'Quadra',
                    'esm' => 'Estrada Municipal',
                    'pc' => 'Praça',        
                ],
                'civil_states'=>[
                    '1' =>'Solteiro',
                    '2' =>'Casado',
                    '3' =>'Divorciado',
                    '4' =>'Viuvo',
                    '5' =>'Concubinato',
                    '6' =>'Separado',
                    '7' =>'Uniao',
                    '8' =>'Outros',        
                ],
                'work_periods'=>[
                    '1'=>'1º Turno',
                    '2'=>'2º Turno',
                    '3'=>'3º Turno',
                    '4'=>'Horário Comercial',
                ],
                'language_levels'=>[
                    'basic'=>'Básico',
                    'intermediary'=>'Intermediário',
                    'advanced'=>'Avançado',
                    'natural'=>'Fluente',
                ]
            ]
        ];
        $ret=[];
        if (!empty($content[$lang][$what]))
            $ret=$content[$lang][$what];
        return $ret;
    }

    public function profile(){
        $lang='ptbr';
        if (!empty($_COOKIE['lang']))
            $lang=$_COOKIE['lang'];
        $logged_in=Auth::user();
        $role="";
        if (!empty($logged_in)){
            $role=User::where('id','=',$logged_in->id)->with('roles')->first()->roles[0]->name;
        }
        $data=Candidate::where('user_id','=',$logged_in->id)->with(['Schooling','Experience','interests','langs'])->first();
        if (empty($data))
            $data=new Candidate;
        $deficiencies = Deficiency::all();
        $languages=Language::all();
        $selected_languages=$data->langs->toArray();
        $tags = Tag::all();

        $logradouros=$this->varsContents($lang,'logradouros');
        $civil_states=$this->varsContents($lang,'civil_states');
        $schooling_status=$this->varsContents($lang,'schooling_status');
        $schooling_grades=$this->varsContents($lang,'schooling_grades');
        $schooling_formation=$this->varsContents($lang,'schooling_formation');
        $work_periods=$this->varsContents($lang,'work_periods');
        $language_levels=$this->varsContents($lang,'language_levels');
        $bools=$this->varsContents($lang,'boolean');

        if (empty($data->schooling)){
            $schooling = new Schooling;
            $data->schooling=$schooling;
        }
        if (empty($data->experience)||count($data->experience)==0){
            $experience = [ 
                'business'=>'', 
                'job'=>'', 
                'activities'=>'', 
                'current_job'=>false, 
                'admission'=>'', 
                'demission'=>'', 
            ];
            $arrexp=[$experience,$experience,$experience];
            for ($i=0;$i<count($arrexp);$i++){
                $arrexp[$i]['hash']=substr(hash('sha256',date('U').rand(0,250)),0,15);
            }
            $data->experience=$arrexp;
        }
        $data['prefered_work_period']=explode(",",$data['prefered_work_period']);
        
        return view('profile')->with([
            'curlang'=>$lang,
            'tags'=>$tags,
            'role'=>$role,
            'data'=>$data,
            'logged_in'=>$logged_in,
            'deficiencies'=>$deficiencies,
            'languages'=>$languages,
            'civil_states'=>$civil_states,
            'schooling_grades'=>$schooling_grades,
            'schooling_status'=>$schooling_status,
            'schooling_formation'=>$schooling_formation,
            'selected_languages'=>$selected_languages,
            'logradouros'=>$logradouros,
            'work_periods'=>$work_periods,
            'language_levels'=>$language_levels,
            'bools'=>$bools,
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

        $filename=date('U');

        if ($request->hasFile('picture')){
            if (!empty($candidate->picture) && file_exists($_SERVER['DOCUMENT_ROOT'].$candidate->picture)){
                unlink($_SERVER['DOCUMENT_ROOT'].$candidate->picture);
            }
            $extension=$request->picture->extension();
            $candidate->picture='/avatars/'.$filename.'.'.$extension;

            $tmp=$request->picture->path();
            copy($tmp, $_SERVER['DOCUMENT_ROOT'].$candidate->picture);
        }

        if ($request->hasFile('uploaded_cv')){
            if (!empty($candidate->uploaded_cv) && file_exists($_SERVER['DOCUMENT_ROOT'].$candidate->uploaded_cv)){
                unlink($_SERVER['DOCUMENT_ROOT'].$candidate->uploaded_cv);
            }
            $extension=$request->uploaded_cv->extension();
            $candidate->uploaded_cv='/cvs/'.$filename.'.'.$extension;

            $tmp=$request->uploaded_cv->path();
            copy($tmp, $_SERVER['DOCUMENT_ROOT'].$candidate->uploaded_cv);
        }

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
        if(!empty($dados['picture']))
            unset($dados['picture']);
        if(!empty($dados['uploaded_cv']))
            unset($dados['uploaded_cv']);

        $dados['cpf'] = substr(str_replace(['.','-',',','_','!',';'],'',$dados['cpf']),0,11);
        if(!empty($dados['pis']))
            $dados['pis'] = substr(str_replace(['.','-',',','_','!',';'],'',$dados['pis']),0,11);
        if(!empty($dados['rg']))
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
            $dados['elector_card'] = substr(str_replace(['.','-',',','_','!',';',' '],'',$dados['elector_card']),0,16);
        if (!empty($dados['veteran_card']))
            $dados['veteran_card'] = substr(str_replace(['.','-',',','_','!',';'],'',$dados['veteran_card']),0,13);
        $dados['cid'] = str_replace(['.','-',',','_','!',';'],'',$dados['cid']);
        if (!empty($dados['prefered_work_period']))
            $dados['prefered_work_period']=implode(",",$dados['prefered_work_period']); 
        else
            $dados['prefered_work_period']=""; 
        
        $normalize_fields=['name','address_state','address_country','address_city','addres_district','address_street','address_complement','rg_emitter','natural_city','natural_state','natural_country','spouse_name','mother_name','father_name'];

        //FIXME VER SE TEM COMO CORRIGIR PARA DEIXAR NULO OU EM BRANCO
        if (empty($dados['father_dob']))
            $dados['father_dob']='01/01/1900';
        if (empty($dados['arrival_date']))
            $dados['arrival_date']='01/01/1900';
        if (empty($dados['mother_dob']))
            $dados['mother_dob']='01/01/1900';
        if (empty($dados['dob']))
            $dados['dob']='01/01/1900';
        if (empty($dados['lunelli_earlier_work_period_start']))
            $dados['lunelli_earlier_work_period_start']='01/01/1900';
        if (empty($dados['lunelli_earlier_work_period_end']))
            $dados['lunelli_earlier_work_period_end']='01/01/1900';
        if (empty($dados['last_time_doctor']))
            $dados['last_time_doctor']='01/01/1900';
        if (empty($dados['visa_expiration']))
            $dados['visa_expiration']='01/01/1900';


        foreach($dados as $k => $d){
            if (in_array($k,$normalize_fields))
                $candidate->{$k}=$this->normalize($d);
            else
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

            if(!empty($schooling_data['start']))
                $schooling->start=$schooling_data['start'];
            else
                $schooling->start='1900-01-01';

            if(!empty($schooling_data['end']))
                $schooling->end=$schooling_data['end'];
            else
                $schooling->end='1900-02-01';

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
            if (empty($experience->business) && empty($experience->job) && empty($experience->activities))
                continue;

            if(!empty($experience_data['admission']))
                $experience->admission=$experience_data['admission'];
            else
                $experience->admission='1900-01-01';

            if(!empty($experience_data['demission']))
                $experience->demission=$experience_data['demission'];
            else
                $experience->demission='1900-02-01';

            $experience->save();

            array_push($new_experiences,$experience->toArray());
        }

        return json_encode(['experiences'=>$new_experiences,'schoolings'=>$new_schoolings],true);
    }

    public function jobDetail($id){
        $lang='ptbr';
        if (!empty($_COOKIE['lang']))
            $lang=$_COOKIE['lang'];
        $logged_in=Auth::user();
        $user_id=0;
        $role="";
        $candidate=null;
        $subscribed=null;
        if (!empty($logged_in)){
            $role=User::where('id','=',$logged_in->id)->with('roles')->first()->roles[0]->name;
            $user_id=$logged_in->id;
            $candidate = Candidate::where('user_id','=',$logged_in->id)->first();
            $subscribed = Subscribed::where('candidate_id','=',$candidate->id)->where('job_id','=',$id)->first();
        }
        $job = Job::select('*')
        ->with(['tags','field','unit'])
        ->find($id);

        return view('job_detail')->with([
            'data'=>$job,
            'logged_in'=>$logged_in,
            'candidate'=>$candidate,
            'role'=>$role,
            'subscribed'=>$subscribed,
        ]);
    }

    public function jobsList(){
        $lang='ptbr';
        if (!empty($_COOKIE['lang']))
            $lang=$_COOKIE['lang'];
        $logged_in=Auth::user();
        $role="";
        if (!empty($logged_in)){
            $role=User::where('id','=',$logged_in->id)->with('roles')->first()->roles[0]->name;
        }
        if (!empty($logged_in))
            $candidate=Candidate::where('user_id','=',$logged_in->id)->first();
        else
            $candidate = new Candidate;

        $candidate_id="";
        if (!empty($candidate)){
            $subscriptions = Subscribed::where('candidate_id','=',$candidate->id)->where('active','=',1)->with(['states'=>function ($states_query) {
                $states_query->where('candidate_visible','=','1');
            }])->get();
            $candidate_id=$candidate->id;
        }
        else
            $subscriptions = Array();

        $today=Carbon::now('America/Sao_Paulo')->startOfDay()->format('Y-m-d');

        $jobs = Job::select('*')->addSelect(DB::Raw('(select city from units where units.id=jobs.unit_id) as unitcity'))->where('status','=',1)->with(['tags','field','unit'])->orderBy('unitcity','asc')->orderBy('name','asc')->get();
        //$jobs = Job::where('status','=',1)->where('start','<=',$today)->where('end','>=',$today)->with(['tags','field'])->orderBy('created_at','desc')->get();
        $fields = Field::get();
        $units = Unit::get();
        $user_id=0;
        if ($logged_in)
            $user_id=$logged_in->id;
        return view('candidate_jobs')->with([
            'curlang'=>$lang,
            'jobs'=>$jobs,
            'role'=>$role,
            'fields'=>$fields,
            'units'=>$units,
            'logged_in'=>$logged_in,
            'user_id'=>$user_id,
            'subscriptions'=>$subscriptions,
            'candidate_id'=>$candidate_id,
            'talent_bank'=>(isset($candidate->talent_bank)) ? ($candidate->talent_bank) : 0,
        ]);
    }

    public function candidateSubscriptions() {
        $lang='ptbr';
        if (!empty($_COOKIE['lang']))
            $lang=$_COOKIE['lang'];
        $logged_in=Auth::user();
        $role="";
        if (!empty($logged_in)){
            $role=User::where('id','=',$logged_in->id)->with('roles')->first()->roles[0]->name;
        }

        $candidate=Candidate::where('user_id','=',$logged_in->id)->with(['subscriptions'])->first();
        $jobs = Job::where('status','=',1)->with(['tags','field','unit'])->orderBy('created_at','desc')->get();
        $fields = Field::get();
        $units = Unit::get();

        $candidate_id=0;
        if (!empty($candidate)){
            $subscriptions = Subscribed::where('candidate_id','=',$candidate->id)
            ->with(['states'=>function ($states_query) {
                $states_query->where('candidate_visible','=','1');
            }])
            ->whereHas('job',function($query){
                $query->where('status','=','1');
            })
            ->get();
            $candidate_id=$candidate->id;
        }
        else
            $subscriptions = Array();
            
        $user_id=0;
        if ($logged_in)
            $user_id=$logged_in->id;

        return view('candidate_subscriptions')->with([
            'curlang'=>$lang,
            'jobs'=>$jobs,
            'role'=>$role,
            'subscriptions'=>$subscriptions,
            'logged_in'=>$logged_in,
            'user_id'=>$user_id,
            'fields'=>$fields,
            'units'=>$units,
            'candidate_id'=>$candidate_id,
        ]);
    }

    public function changeTalentBank($id){
        $candidate=Candidate::find($id);
        $candidate->talent_bank=!$candidate->talent_bank;
        $candidate->save();
        return $candidate->talent_bank;
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
