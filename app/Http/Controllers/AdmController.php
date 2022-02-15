<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Candidate;
use App\Deficiency;
use App\Banner;
use App\AboutUs;
use App\OurNumbers;
use App\OurTeam;
use App\HelpContact;
use App\Job;
use App\JobTemplate;
use App\Tag;
use App\Unit;
use App\Field;
use App\User;
use App\Exportable;
use App\Permission;
use App\Requisition;
use App\Role;
use App\State;
use App\StateMail;
use App\Video;
use App\Subscribed;
use App\Subscriber;
use App\Mail\StateChange;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AdmController extends Controller
{

    protected function jobTemplateValidator(array $data)
    {
        return Validator::make($data, [
            'field_id' => ['required', 'integer', 'gte:1'],
        ],[
            'field_id.required'=>'É necessário selecionar uma área para a vaga.',
            'field_id.integer'=>'É necessário selecionar uma área para a vaga.',
            'field_id.gte'=>'É necessário selecionar uma área para a vaga.',
        ]);
    }

    protected function jobValidator(array $data)
    {
        return Validator::make($data, [
            'field_id' => ['required', 'integer', 'gte:1'],
            'unit_id' => ['required', 'integer', 'gte:1'],
        ],[
            'field_id.required'=>'É necessário selecionar uma área para a vaga.',
            'field_id.integer'=>'É necessário selecionar uma área para a vaga.',
            'field_id.gte'=>'É necessário selecionar uma área para a vaga.',
            'unit_id.required'=>'É necessário selecionar uma unidade para a vaga.',
            'unit_id.integer'=>'É necessário selecionar uma unidade para a vaga.',
            'unit_id.gte'=>'É necessário selecionar uma unidade para a vaga.',
        ]);
    }

    protected function candidateValidator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required'],
        ],[
            'email.required'=>'É necessário informar o e-mail.',
        ]);
    }

    protected function userValidator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ],[
            'email.unique'=>'E-mail já cadastrado',
            'name.required'=>'Nome é necessário',
            'naem.max'=>'Nome excede limite de caracteres',
            'password.min'=>'Senha deve ter no mínimo 8 caracteres',
        ]);
    }

    public function templateFromJob(Request $request){

    }

    public function jobFromTemplate(Request $request){
        
    }

    public function getAvailableJobs(){
        $jobs=Job::
        with(['unit','field'])
        ->get()
        ->toJson();
        return $jobs;
    }

    public function addTag(Request $request){
        if (!empty($request->name)){
            $tag = new Tag;
            $tag->name=strtolower($request->name);
            $tag->save();
        }

		return redirect('/adm/tags/');
    }

    public function config(Request $request) {
        $banners=Banner::get();
        return view('adm.config')->with([
            'banners'=>$banners,
        ]);
    }

    public function helpContactsCreate(Request $request){
        $data=new HelpContact;
        $arr=$request->toArray();
        unset($arr['_token']);

        foreach ($arr as $k=>$value){
            $data->{$k}=$value;
        }
        $data->save();
		return redirect('/adm/help-contacts/');
    }

    public function helpContactsDestroy(Request $request){
        HelpContact::whereIn('id',explode(",",$request->ids))->delete();
    }

    public function resetPass(Request $request){
        $users=User::whereIn('id',explode(",",$request->ids))->get();
        $newpass=Hash::make('12345678');
        foreach($users as $user){
            $user->password=$newpass;
            $user->save();
        }
    }

    public function helpContactsToggle(Request $request){
        $contacts=HelpContact::whereIn('id',explode(",",$request->ids))->get();
        foreach($contacts as $contact){
            $contact->status=!$contact->status;
            $contact->save();
        }
    }

    public function helpContactsList(Request $request){
        $data=HelpContact::paginate(15);
        $active_inactive=[
            'Inativo',
            'Ativo'
        ];
        return view('adm.help_contacts')->with([
            'data'=>$data,
            'active_inactive'=>$active_inactive
        ]);
    }

    public function configData(Request $request){
        $data['about_us']=AboutUs::first();
        $data['our_numbers']=OurNumbers::orderBy('created_at','desc')->get();
        foreach($data['our_numbers'] as $k=>$d)
            $data['our_numbers'][$k]->removal=0;
        $data['our_team']=OurTeam::orderBy('created_at','desc')->get();
        $data['video']=Video::first();
        return json_encode($data);
    }

    public function saveOtherConf(Request $request){
        $arr=$request->all();
        $which=$arr['which'];

        if ($which=='about_us'){
            $data=json_decode($arr['data'],true);

            $id=$data['id'];
            unset($data['id']);
        
            if ($request->hasFile('testimonial_author_picture')){
                $extension=$request->testimonial_author_picture->extension();
                $background_filename=date('U').".".$extension;
                $tmp=$request->testimonial_author_picture->path();
                copy($tmp, $_SERVER['DOCUMENT_ROOT'].'/img/'.$background_filename);
                $data['testimonial_author_picture']=$background_filename;
            }    
            DB::table($which)->where('id','=',$id)->update($data);
        }
        else if ($which=='our_numbers'){
            $data=json_decode($arr['data'],true);
            foreach($data as $d){
                if (!empty($d['removal']) && $d['removal']==1)
                    DB::table($which)->where('id','=',$d['id'])->delete();
                else if (empty($d['id'])){
                    unset($d['id']);
                    DB::table($which)->insert($d);
                }
                else{
                    $id=$d['id'];
                    unset($d['removal']);
                    unset($d['id']);
                    DB::table($which)->where('id','=',$id)->update($d);
                }
            }
        }
        else if ($which=='our_team'){
            $data=json_decode($arr['data'],true);
            foreach($data as $k=>$d){
                $save_data=$d;
                if ($request->hasFile('team_pic_picker_'.$k)){
                    $picture_var='team_pic_picker_'.$k;

                    $extension=$request->{$picture_var}->extension();
                    $background_filename=$k.date('U').".".$extension;
                    $tmp=$request->{$picture_var}->path();

                    copy($tmp, $_SERVER['DOCUMENT_ROOT'].'/img/'.$background_filename);

                    $save_data['picture']='/img/'.$background_filename;
                }
                if (!empty($d['removal']) && $d['removal']==1)
                    DB::table($which)->where('id','=',$d['id'])->delete();
                else if (empty($d['id'])){
                    unset($save_data['id']);
                    DB::table($which)->insert($save_data);
                }
                else{
                    $id=$d['id'];
                    unset($save_data['removal']);
                    unset($save_data['id']);
                    DB::table($which)->where('id','=',$id)->update($save_data);
                }
            }
        }
        else if ($which=='video'){
            $data=json_decode($arr['data'],true);

            $id=$data['id'];
            unset($data['id']);
        
            if ($request->hasFile('video_picture')){
                $extension=$request->video_picture->extension();
                $background_filename=date('U').".".$extension;
                $tmp=$request->video_picture->path();
                copy($tmp, $_SERVER['DOCUMENT_ROOT'].'/img/'.$background_filename);
                $data['face']=$background_filename;
            }    
            DB::table($which)->where('id','=',$id)->update($data);
        }

    }

    public function recruiting (Request $request){

        $schooling_grades=[
            '' => 'Não definido',
            'professional' => 'Profissionalizante',
            'technology' => 'Tecnólogo',
            'technician' => 'Técnico',
            'graduation' => 'Graduação',
            'postgrad' => 'Pós Graduação',
            'masters' => 'Mestrado',
            'doctor' => 'Doutorado',
            'phd' => 'PHD',        ];

        $schooling_status=[
            'complete'=>'Concluído',
            'coursing'=>'Cursando',
            'incomplete'=>'Incompleto',
        ];

        return view('adm.recruiting')->with([
            'schooling_grades'=>$schooling_grades,
            'schooling_status'=>$schooling_status,
        ]);
    }

    public function exportCandidates (Request $request){
        $arr=$request->all();
        $candidates=explode(",",$arr['candidates']);
        foreach($candidates as $candidate){
            $exportable= new Exportable;
            $exportable->candidate_id=$candidate;
            $exportable->save();
        }
    }

    public function subscribeCandidatesToJob (Request $request){
        $arr=$request->all();
        $candidates=explode(",",$arr['candidates']);
        $job=$arr['job'];
        $state = State::where('id','=',1)->first();
        foreach($candidates as $candidate){
            $subscribed = new Subscribed;
            $subscribed->candidate_id=$candidate;
            $subscribed->job_id=$job;
            $subscribed->save();

            DB::connection('mysql')->table('subscribed_has_states')->insert(
                [
                    'subscribed_id'=>$subscribed->id,
                    'state_id'=>$state->id,
                ]
            );
        }
    }

    public function addSubscriptionState(Request $request){
        $state = State::where('name','like',$request->status."%")->first();
        $subscribed = Subscribed::
        where('candidate_id','=',$request->candidate_id)
        ->where('job_id','=',$request->job_id)
        ->where('active','=',1)
        ->first();

        DB::connection('mysql')->table('subscribed_has_states')->insert(
            [
                'subscribed_id'=>$subscribed->id,
                'state_id'=>$state->id,
            ]
        );
        $state_mail=DB::connection('mysql')->table('states_mails_states')->select('mail_id')->where('state_id','=',$state->id)->first();

        if(!empty($state_mail)){
            $candidate=Candidate::where('id','=',$request->candidate_id)->first();
            $job=Job::where('id','=',$request->job_id)->first();
            Mail::to($candidate->email,$candidate->name)->send(new StateChange($candidate,$job,$state));
        }

        //Se contratado, altera outros inscritos na vaga para não-selecionado
        if (strtolower(trim($request->status))=='contratado'){
            $thejob= Job::where("id",'=',$request->job_id)->first();
            Requisition::where("cod_rqu_senior",'=',$thejob->cod_rqu_senior)
            ->update(['status'=>0]);

            $requisitions = Requisition::where('cod_senior','=',$thejob->cod_senior)->where('status','=','1')->get()->toArray();
            if (!empty($requisitions) && count($requisitions)>0){
                $thejob->cod_rqu_senior=$requisitions[0]['cod_rqu_senior'];
                //$thejob->start=$requisitions[0]['start'];
                //$thejob->end=$requisitions[0]['end'];
                $thejob->unit_id=$requisitions[0]['unit_id'];
                $thejob->created_at=$requisitions[0]['created_at'];
                $thejob->save();
            }
            else {
                Job::where("id",'=',$request->job_id)
                ->update(['status'=>0]);

                $other_subscribed=Subscribed::
                where('job_id','=',$request->job_id)
                ->where('candidate_id','!=',$request->candidate_id)
                ->where('active','=',1)
                ->whereDoesntHave('states', function ($query) {
                    $query->where('state_id','=',2);
                })
                ->get();

                foreach ($other_subscribed as $sub){
                    DB::connection('mysql')->table('subscribed_has_states')->insert(
                        [
                            'subscribed_id'=>$sub->id,
                            'state_id'=>2,
                        ]
                    );
                }    
            }
        }

        return '';
    }

    public function updateSubscriptionNote(Request $request){
        $subscribed=Subscribed::where('id','=',$request->subscription['id'])->first();
        $subscribed->notes=$request->subscription['notes'];
        $subscribed->save();
        return '';
    }

    public function recruitingData (Request $request){

       /* $data['candidates']=Candidate::orderBy('updated_at','desc')
        ->when(!empty($request->filters['direct']['candidates']), function ($query) use ($request) {
            foreach($request->filters['direct']['candidates'] as $type_filter=>$filter_data){
                if ($type_filter=='like'){
                    foreach($filter_data as $key=>$value){
                        $query->where($key,'like',$value);
                    }
                }
                else if ($type_filter=='in'){
                    foreach($filter_data as $key=>$value){
                        $query->whereIn($key,explode(",",$value));
                    }
                }
            }
        })
        ->get()->toArray();*/
        $directLikeDone=0;
        $deepLikeDone=0;

        $date_filter_start=Carbon::now('America/Sao_Paulo')->subMonths(4)->startOfDay()->format('Y-m-d');
        $date_filter_end=Carbon::tomorrow('America/Sao_Paulo')->startOfDay()->format('Y-m-d');

        $data['jobs']=Job::orderBy('updated_at','desc')
        ->when(!empty($request->filters['jobs']['direct']), function ($query) use ($request,$directLikeDone) {
            foreach($request->filters['jobs']['direct'] as $type_filter=>$filter_data){
                if ($type_filter=='like'){
                    foreach($filter_data as $key=>$value){
                        if ($value != "" && !$directLikeDone){
                            $query->where($key,'like',"%".$value."%");
                            $directLikeDone=1;
                        }
                        else if ($value != "")
                            $query->orWhere($key,'like',"%".$value."%");
                    }
                }
                else if ($type_filter=='in'){
                    foreach($filter_data as $key=>$value){
                        if ($value != "" && is_array($value))
                            $query->whereIn($key,$value);
                        else if (!is_array($value) && $value!="")
                            $query->whereIn($key,[$value]);
                    }
                }
                else if ($type_filter=='gt'){
                    foreach($filter_data as $key=>$value){
                        if($value!=''){
                            $query->where($key,'>=',$value);
                            $directLikeDone=1;
                        }
                    }
                }
                else if ($type_filter=='lt'){
                    foreach($filter_data as $key=>$value){
                        if($value!=''){
                            $query->where($key,'<=',$value);
                            $directLikeDone=1;
                        }
                    }
                }
                else if ($type_filter=='btw'){
                    foreach($filter_data as $key=>$value){
                        if($value!=''){
                            $query->whereBetween($key,$value);
                            $directLikeDone=1;
                        }
                    }
                }
            }
        })
        ->when(!empty($request->filters['jobs']['mustHave']), function($query) use ($request){
            $query->with($request->filters['jobs']['mustHave']);
            foreach($request->filters['jobs']['mustHave'] as $relation){
                $query->has($relation);
            }
        })
        ->when(!empty($request->filters['jobs']['deep']), function ($query) use ($request,$deepLikeDone,$directLikeDone) {
            $arr_deep_filters=[];
            foreach($request->filters['jobs']['deep'] as $relation=>$filters){
                $arr_deep_filters[$relation]=function ($inquery) use ($filters,$deepLikeDone,$directLikeDone){
                    foreach($filters as $type_filter=>$filter_data){
                        if ($type_filter=='mustHave'){
                            $inquery->with(array_keys($filter_data));
                            foreach($filter_data as $deep_relation => $deep_filter){
                                $inquery->whereHas($deep_relation, function ($subquery) use ($deep_filter,$deepLikeDone,$directLikeDone){
                                    foreach($deep_filter as $deep_filter_type => $deep_filter_data){
                                        if ($deep_filter_type=='like'){
                                            foreach($deep_filter_data as $key=>$value){
                                                if ($value != "" && !empty($deepLikeDone)){
                                                    $subquery->where($key,'like',"%".$value."%");
                                                    $deepLikeDone=1;
                                                }
                                                else if ($value!="")
                                                    $subquery->orWhere($key,'like',"%".$value."%");
                                            }
                                        }
                                        else if ($deep_filter_type=='in'){
                                            foreach($deep_filter_data as $key=>$value){
                                                if ($value != "")
                                                    $subquery->whereIn($key,$value);
                                            }
                                        }
                                    }
                                });
                            }
                        }
                        else {
                            if ($type_filter=='like'){
                                foreach($filter_data as $key=>$value){
                                    if ($value != "" && !empty($deepLikeDone)){
                                        $inquery->where($key,'like',"%".$value."%");
                                        $deepLikeDone=1;
                                    }
                                    else if ($value!=""){
                                        $inquery->orWhere($key,'like',"%".$value."%");
                                    }
                                }
                            }
                            else if ($type_filter=='in'){
                                foreach($filter_data as $key=>$value){
                                    if ($value != "")
                                        $inquery->whereIn($key,$value);
                                }
                            }
                        }
                    }
                };
            };
            $query->with($arr_deep_filters);
        })
        ->with(['tags','subscribers','subscribers.interests','subscribers.experience','field','unit'])
        ->withCount(['subscriptions as subscription_amount'=>function ($query) {$query->where('active','=',1);}])
        ->withCount(['requisitions as requisition_amount'=>function ($query) {$query->where('status','=',1);}])
        ->orderByRaw('subscription_amount desc')
        ->get()->toArray();

        $data['states'] = State::all()->toArray();
        $data['units']  = Unit::all()->toArray();
        $data['fields'] = Field::all()->toArray();
        $data['date_filter_start']=$date_filter_start;
        $data['date_filter_end']=$date_filter_end;

        return json_encode($data);
    }

    public function bannersList (Request $request){
        $banners=Banner::orderBy("order","asc")->orderBy('created_at','desc')->orderBy('active_to','desc')->orderBy('active_from','desc')->paginate();
        return $banners;
    }

    public function deleteBanner (Request $request){
        $banner=Banner::where('id','=',$request['banner_id'])->delete();
        return '';
    }

    public function updateBanner (Request $request){
        $arr=$request->all();
        unset($arr['_token']);
        $banner_data=json_decode($arr['banner'],true);
        $banner = new Banner;
        if (!empty($banner_data['id']))
            $banner=Banner::where('id','=',$banner_data['id'])->first();

        foreach ($banner_data as $k=>$d){
            $banner->{$k}=$d;
        }
        if ($request->hasFile('background_file')){
            $extension=$request->background_file->extension();
            $background_filename=date('U').".".$extension;
	    	$tmp=$request->background_file->path();
	    	copy($tmp, $_SERVER['DOCUMENT_ROOT'].'/img/'.$background_filename);
            $banner->background='/img/'.$background_filename;
        }

        $banner->save();        
    }

    public function saveBanners (Request $request){
        $arr=$request->all();
        unset($arr['_token']);
        $banners=json_decode($arr['banners'],true);
        foreach ($banners as $a){
            $banner = new Banner;
            if (!empty($a['id']))
                $banner=Banner::where('id','=',$a['id'])->first();
            unset($a['id']);

            foreach ($a as $k=>$d){
                $banner->{$k}=$d;
            }

            $banner->save();
        }
		return '';
    }

    public function getUnits (){
        $data=Unit::all()->toJson();
        return $data;
    }

    public function getFields (){
        $data=Field::all()->toJson();
        return $data;
    }

    public function fieldsList (Request $request){
        $data=Field::
        when(!empty($request->search),function($query) use ($request) {
            $query->where('name','like',"%$request->search%");
            $query->orWhere('description','like',"%$request->search%");
        })
        ->paginate(15);

        return view('adm.fields.list')->with(
            [
                'data'=>$data,
                'search'=>$request->search,
            ]
        );
    }

    public function statesMailsList (Request $request){
        $data=StateMail::
        when(!empty($request->search),function($query) use ($request) {
            $query->where('name','like',"%$request->search%");
        })
        ->paginate(15);

        return view('adm.states_mails.list')->with(
            [
                'data'=>$data,
                'search'=>$request->search,
            ]
        );
    }

    public function rolesList (Request $request){
        $data=Role::
        when(!empty($request->search),function($query) use ($request) {
            $query->where('name','like',"%$request->search%");
        })
        ->paginate(15);

        return view('adm.roles.list')->with(
            [
                'data'=>$data,
                'search'=>$request->search,
            ]
        );
    }

    public function unitsList (Request $request){
        $data=Unit:: when(!empty($request->search),function($query) use ($request) {
            $query->where('name','like',"%$request->search%");
            $query->orWhere('address','like',"%$request->search%");
        })
        ->paginate(15);

        return view('adm.units.list')->with(
            [
                'data'=>$data,
                'search'=>$request->search,
            ]
        );
    }

    public function statesList (Request $request){
        $data=State:: when(!empty($request->search),function($query) use ($request) {
            $query->where('name','like',"%$request->search%");
        })
        ->paginate(15);

        return view('adm.states.list')->with(
            [
                'data'=>$data,
                'search'=>$request->search,
            ]
        );
    }

    public function jobsList (Request $request){
        $data=Job:: when(!empty($request->search),function($query) use ($request) {
            $query->where('name','like',"%$request->search%");
            $query->orWhere('description','like',"%$request->search%");
        })
        ->when(!empty($request->filter_created_at_start), function ($query) use ($request) {
            $query->where('created_at','>=',$request->filter_created_at_start);
        })
        ->when(!empty($request->filter_created_at_end), function ($query) use ($request) {
            $query->where('created_at','<=',$request->filter_created_at_end);
        })
        ->when(!empty($request->filter_status),function ($query) use ($request) {
            $query->whereIn('status',$request->filter_status);
        })
        ->when(!empty($request->filter_unit),function ($query) use ($request) {
            $query->where('unit_id','=',$request->filter_unit);
        })
        ->orderBy('id','desc')
        ->with(['unit'])
        ->paginate(15);

        $units=Unit::all();

        $filter_status=[];
        if (!empty($request->filter_status))
            $filter_status=$request->filter_status;

        return view('adm.jobs.list')->with(
            [
                'data'=>$data,
                'search'=>$request->search,
                'units'=>$units,
                'filter_created_at_end'=>$request->filter_created_at_end,
                'filter_created_at_start'=>$request->filter_created_at_start,
                'filter_status'=>$filter_status,
                'filter_unit'=>$request->filter_unit,
            ]
        );
    }

    public function jobsTemplatesList (Request $request){
        $data=JobTemplate::when(!empty($request->search),function($query) use ($request) {
            $query->where('name','like',"%$request->search%");
            $query->orWhere('description','like',"%$request->search%");
        })
        ->when(!empty($request->filter_created_at_start), function ($query) use ($request) {
            $query->where('created_at','>=',$request->filter_created_at_start);
        })
        ->when(!empty($request->filter_created_at_end), function ($query) use ($request) {
            $query->where('created_at','<=',$request->filter_created_at_end);
        })
        ->when(!empty($request->filter_field),function ($query) use ($request) {
            $query->where('field_id','=',$request->filter_field);
        })
        ->paginate(15);

        $filter_status=[];
        if (!empty($request->filter_status))
            $filter_status=$request->filter_status;


        $fields=Field::all();

        return view('adm.jobs_templates.list')->with(
            [
                'data'=>$data,
                'search'=>$request->search,
                'fields'=>$fields,
                'filter_field'=>$request->filter_field,
                'filter_created_at_end'=>$request->filter_created_at_end,
                'filter_created_at_start'=>$request->filter_created_at_start,
                'filter_status'=>$filter_status,
            ]
        );
    }

    public function subscribersList (Request $request){
        $data=Subscriber:: when(!empty($request->search),function($query) use ($request) {
            $query->where('email','like',"%$request->search%");
        })
        ->paginate(15);

        if (empty($request->export)){
            return view('adm.subscribers.list')->with(
                [
                    'data'=>$data,
                    'search'=>$request->search,
                ]
            );
        }
    	else{
		    $headers = array(
		        "Content-type" => "text/csv; charset=UTF-8",
		        "Content-Disposition" => "attachment; filename=file.csv",
		        "Pragma" => "no-cache",
		        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
		        "Expires" => "0"
		    );
		    $columns = Array("Email");

	        $file = fopen(public_path('newsletter.csv'), 'w');
	        fputcsv($file, $columns);
	        foreach ($data as $d){
	        	fputcsv($file,array(
	        		$d->email,
	        	));
	        }
		    fclose($file);
		    return response()->download(public_path('newsletter.csv'), 'newsletter.csv', $headers);
    	}

    }

    public function tagsList (Request $request){
        $data=Tag:: when(!empty($request->search),function($query) use ($request) {
            $query->where('name','like',"%$request->search%");
        })
        ->paginate(15);

        return view('adm.tags')->with(
            [
                'data'=>$data,
                'search'=>$request->search,
            ]
        );
    }

    private function mask($val, $mask) {
        $maskared = '';
        $max=strlen($mask)-1;
        $k=0;

        for ($i = 0; $i<=$max; $i++) {
            if($mask[$i] == '#') {
                if(isset($val[$k]))
                    $maskared .= $val[$k++];
            }
            else {
                if(isset($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }


    public function candidatePrint ($id){
        $data=Candidate::where('id','=',$id)->with(['experience','interests','schooling','defici'])->first();
        $language_levels=[
            'basic'=>'Básico',
            'intermediary'=>'Intermediário',
            'advanced'=>'Avançado',
            'natural'=>'Fluente',
        ];

        $civil_states=[
            'Solteiro',
            'Casado',
            'Divorciado',
            'Viuvo',
            'Concubinato',
            'Separado',
            'Uniao Estavel',
            'Outros',
        ];

        $schooling_grades=[
            '' => 'Não definido',
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
            ''=>'Não definido',
            'fundamental'=>'Fundamental',
            'highschool'=>'Médio',
            'technical'=>'Técnico',
            'superior'=>'Superior',
        ];

        $course_status=[
            ''=>'Não definido',
            'complete'=>'completo',
            'coursing'=>'cursando',
            'incomplete'=>'Incompleto',
        ];

        $yes_no=[
            '0'=>'Não',
            '1'=>'Sim'
        ];

        $work_periods=[
            '1'=>'1º Turno',
            '2'=>'2º Turno',
            '3'=>'3º Turno',
            '4'=>'Horário comercial',
        ];

        return view('adm.candidates.print')->with([
            'data'=>$data,
            'civil_states'=>$civil_states,
            'course_status'=>$course_status,
            'schooling_grades'=>$schooling_grades,
            'schooling_formation'=>$schooling_formation,
            'language_levels'=>$language_levels,
            'work_periods'=>$work_periods,
            'yes_no'=>$yes_no,
            'carbon'=>new Carbon,
            'mask'=>function ($a,$b)  { return  $this->mask($a,$b); },
        ]);
    }

    public function candidateView ($id){
        $data=['viewed'=>1];
        DB::table('candidates')->where('id','=',$id)->update($data);
    }

    public function candidatesList (Request $request){

        $data=Candidate::
        select('candidates.*','exportables.status as exportado')
        ->when(!empty($request->search),function($query) use ($request) {
            $query->where( function ($query) use ($request){
                $query->where('candidates.name','like',"%$request->search%");
                $query->orWhere('cpf','like',"%$request->search%");
                $query->orWhere('email','like',"%$request->search%");
                $query->orWhere('phone','like',"%$request->search%");
            });
        })
        ->when(!empty($request->searchAddress),function($query) use ($request) {
            $query->where( function ($query) use ($request){
                $query->where('address_street','like',"%$request->searchAddress%");
                $query->orWhere('address_city','like',"%$request->searchAddress%");
                $query->orWhere('address_state','like',"%$request->searchAddress%");
                $query->orWhere('address_country','like',"%$request->searchAddress%");
            });
        })
        ->when(!empty($request->searchInterests),function($query) use ($request) {
            $query->leftJoin('candidates_tags','candidates_tags.candidate_id','=','candidates.id');
            $query->leftJoin('tags','tags.id','=','candidates_tags.tag_id');
            $query->where( function ($query) use ($request){
                $query->where('skills','like',"%$request->searchInterests%");
                $query->orWhere('others','like',"%$request->searchInterests%");
                $query->orWhere('tags.name','like',"%$request->searchInterests%");
            });
        })
        ->when(!empty($request->searchExperiences),function($query) use ($request) {
            $query->leftJoin('experience','experience.candidate_id','=','candidates.id');
            $query->where( function ($query) use ($request){
                $query->where('experience.activities','like',"%$request->searchExperiences%");
                $query->orWhere('experience.job','like',"%$request->searchExperiences%");
            });
        })
        ->when(!empty($request->filter_updated_at_start), function ($query) use ($request) {
            $query->where('candidates.updated_at','>=',$request->filter_updated_at_start);
        })
        ->when(!empty($request->filter_updated_at_end), function ($query) use ($request) {
            $query->where('candidates.updated_at','<=',$request->filter_updated_at_end);
        })
        ->when(!empty($request->filter_dob_start), function ($query) use ($request) {
            $query->where('candidates.dob','>=',$request->filter_dob_start);
        })
        ->when(!empty($request->filter_dob_end), function ($query) use ($request) {
            $query->where('candidates.dob','<=',$request->filter_dob_end);
        })
        ->distinct()
        ->with(['Schooling','Experience'])
        ->withCount('subscriptions as subscription_amount')
        ->leftJoin('subscribed','subscribed.candidate_id','=','candidates.id')
        ->leftJoin('exportables','exportables.candidate_id','=','candidates.id')
        ->orderBy('candidates.updated_at','desc')
        ->orderBy('subscribed.created_at','desc')
        ->paginate(15);
        
        $viewed_list=array_map(function($arr){
            if($arr['viewed'])
                return $arr['id'];
            else
                return false;
        },$data->toArray()['data']);

        $viewed_list=implode(",",$viewed_list);
        
        $schooling_grades=[
            '' => 'Não definido',
            'professional' => 'Profissionalizante',
            'technology' => 'Tecnólogo',
            'technician' => 'Técnico',
            'graduation' => 'Graduação',
            'postgrad' => 'Pós Graduação',
            'masters' => 'Mestrado',
            'doctor' => 'Doutorado',
            'phd' => 'PHD',
        ];

        $schooling_status=[
            'complete'=>'Concluído',
            'coursing'=>'Cursando',
            'incomplete'=>'Incompleto',
        ];

        $export_states=[
            'Pendente',
            'Exportado'
        ];

        $data_list=[];
        foreach ($data as $cand){
            array_push($data_list,['id'=>$cand->id]);
        }

        return view('adm.candidates.list')->with(
            [
                'data'=>$data,
                'data_list'=>$data_list,
                'search'=>$request->search,
                'searchAddress'=>$request->searchAddress,
                'searchInterests'=>$request->searchInterests,
                'searchExperiences'=>$request->searchExperiences,
                'export_states'=>$export_states,
                'schooling_grades'=>$schooling_grades,
                'schooling_status'=>$schooling_status,
                'filter_updated_at_end'=>$request->filter_updated_at_end,
                'filter_updated_at_start'=>$request->filter_updated_at_start,
                'filter_dob_start'=>$request->filter_dob_start,
                'filter_dob_end'=>$request->filter_dob_end,
                'viewed_list'=>$viewed_list,
            ]
        );

    }

    public function usersList (Request $request){
        $logged_in=Auth::user();
        $data=User::leftJoin('model_has_roles','model_has_roles.model_id','=','users.id')
        ->when(!empty($request->filter_role),function($query) use ($request) {
            $query->where('model_has_roles.role_id','=',$request->filter_role);
        })
        ->when(!empty($request->search),function($query) use ($request) {
            $query->where('name','like',"%$request->search%");
            $query->orWhere('email','like',"%$request->search%");
        })
        ->paginate(15);

        $roles=Role::all();

        return view('adm.users.list')->with(
            [
                'data'=>$data,
                'search'=>$request->search,
                'logged_id'=>$logged_in->id,
                'roles'=>$roles,
                'filter_role'=>$request->filter_role,
            ]
        );
    }

    public function fieldsCreate (Request $request) {
        $data=new Field;
        return view('adm.fields.edit')->with(
            [
                'data'=>$data,
            ]
        );

    }

    public function statesMailsCreate (Request $request) {
        $data=new StateMail;
        $states=State::all();
        $linked_states=[];
        $all_states=[];
        foreach($states as $state){
            array_push($all_states,$state['id']);
        }
        return view('adm.states_mails.edit')->with(
            [
                'data'=>$data,
                'linked_states'=>$linked_states,
                'states'=>$states,
                'all_states'=>$all_states,
            ]
        );

    }

    public function rolesCreate (Request $request) {
        $data=new Role;
        $permissions = Permission::where('id','>','2')->orderBy('desc')->get();
        return view('adm.roles.edit')->with(
            [
                'data'=>$data,
                'permissions'=>$permissions,
                'selected_permissions'=>[],
            ]
        );

    }

    public function statesCreate (Request $request) {
        $data=new State;
        return view('adm.states.edit')->with(
            [
                'data'=>$data,
            ]
        );

    }

    public function unitsCreate (Request $request) {
        $data=new Unit;
        return view('adm.units.edit')->with(
            [
                'data'=>$data,
            ]
        );

    }

    public function jobsTemplatesCreate (Request $request) {
        $data=new JobTemplate;
        $fields=Field::all();
        $units=Unit::all();
        $tags=Tag::all();

        if (!empty($request->job)){
            $job=Job::where('id','=',$request->job)->with(['tags'])->first()->toArray();
            foreach ($job as $k => $job_data){
                if ($k!='id')
                    $data[$k]=$job_data;
            }
        }

        return view('adm.jobs_templates.edit')->with(
            [
                'data'=>$data,
                'fields'=>$fields,
                'units'=>$units,
                'tags'=>$tags,
            ]
        );
    }

    public function jobsCreate (Request $request) {
        $data=new Job;
        $fields=Field::all();
        $units=Unit::all();
        $tags=Tag::all();
        $requisition_status=[
            'Fechada',
            'Aberta'
        ];

        if (!empty($request->template)){
            $template=JobTemplate::where('id','=',$request->template)->with(['tags','requisitions', 'requisitions.unit'])->first()->toArray();
            foreach ($template as $k => $template_data){
                if ($k!='id')
                    $data[$k]=$template_data;
            }
        }

        return view('adm.jobs.edit')->with(
            [
                'data'=>$data,
                'fields'=>$fields,
                'units'=>$units,
                'tags'=>$tags,
                'requisition_status'=>$requisition_status,
            ]
        );
    }

    public function tagsCreate (Request $request) {
        $data=new Tag;
        return view('adm.tags.edit')->with(
            [
                'data'=>$data,
            ]
        );
    }

    public function candidatesCreate (Request $request) {
        $data=new Candidate;
        $states=State::all();
        $deficiencies = Deficiency::all();

        $schooling_grades=[
            '' => 'Não definido',
            'professional' => 'Profissionalizante',
            'technology' => 'Tecnólogo',
            'technician' => 'Técnico',
            'graduation' => 'Graduação',
            'postgrad' => 'Pós Graduação',
            'masters' => 'Mestrado',
            'doctor' => 'Doutorado',
            'phd' => 'PHD',
        ];

        $schooling_status=[
            'complete'=>'Concluído',
            'coursing'=>'Cursando',
            'incomplete'=>'Incompleto',
        ];

        return view('adm.candidates.edit')->with(
            [
                'data'=>$data,
                'states'=>$states,
                'deficiencies'=>$deficiencies,
                'schooling_status'=>$schooling_status,
                'schooling_grades'=>$schooling_grades,
            ]
        );
    }

    public function usersCreate (Request $request) {
        $data=new User;
        $roles=Role::where('id','!=',2)->get();
        return view('adm.users.edit')->with(
            [
                'data'=>$data,
                'roles'=>$roles,
            ]
        );
    }

    public function fieldsEdit ($id) {
        $data=Field::where('id','=',$id)->first();
        return view('adm.fields.edit')->with(
            [
                'data'=>$data,
            ]
        );
    }

    public function statesMailsEdit ($id) {
        $data=StateMail::where('id','=',$id)->with('states')->first();
        $states=$data->states->toArray();
        $all_states=State::all();
        $linked_states=[];
        foreach($states as $state){
            array_push($linked_states,$state['id']);
        }
        return view('adm.states_mails.edit')->with(
            [
                'data'=>$data,
                'linked_states'=>$linked_states,
                'all_states'=>$all_states,
            ]
        );
    }

    public function rolesEdit ($id) {
        $data=Role::where('id','=',$id)->with(['permissions'])->first();
        $selected_permissions=Array();
        foreach($data->permissions->toArray() as $perm){
            array_push($selected_permissions,$perm['id']);
        }
        $permissions = Permission::where('id','>','2')->orderBy('desc')->get();

        return view('adm.roles.edit')->with(
            [
                'data'=>$data,
                'permissions'=>$permissions,
                'selected_permissions'=>$selected_permissions,
            ]
        );
    }

    public function statesEdit ($id) {
        $data=State::where('id','=',$id)->first();
        return view('adm.states.edit')->with(
            [
                'data'=>$data,
            ]
        );
    }

    public function unitsEdit ($id) {
        $data=Unit::where('id','=',$id)->first();
        return view('adm.units.edit')->with(
            [
                'data'=>$data,
            ]
        );
    }

    public function jobsTemplatesEdit (Request $request) {
        $id=$request->id;
        $data=JobTemplate::where('id','=',$id)->first();
        $units=Unit::all();
        $fields=Field::all();
        $tags=Tag::all();

        if (!empty($request->job)){
            $job=Job::where('id','=',$request->job)->with(['tags'])->first()->toArray();
            foreach ($job as $k => $job_data){
                if ($k!='id')
                    $data[$k]=$job_data;
            }
        }

        return view('adm.jobs_templates.edit')->with(
            [
                'data'=>$data,
                'units'=>$units,
                'fields'=>$fields,
                'tags'=>$tags,
            ]
        );
    }

    public function jobsEdit (Request $request) {
        $id=$request->id;
        $data=Job::where('id','=',$id)->with(['tags','requisitions', 'requisitions.unit'])->first();
        $units=Unit::all();
        $fields=Field::all();
        $tags=Tag::all();
        $requisition_status=[
            'Fechada',
            'Aberta'
        ];

        if (!empty($request->template)){
            $template=JobTemplate::where('id','=',$request->template)->first()->toArray();
            foreach ($template as $k => $template_data){
                if ($k!='id')
                    $data[$k]=$template_data;
            }
        }

        return view('adm.jobs.edit')->with(
            [
                'data'=>$data,
                'units'=>$units,
                'fields'=>$fields,
                'tags'=>$tags,
                'requisition_status'=>$requisition_status,
            ]
        );
    }

    public function tagsEdit ($id) {
        $data=Tag::where('id','=',$id)->first();
        return view('adm.tags.edit')->with(
            [
                'data'=>$data,
            ]
        );
    }

    public function candidatesEdit ($id) {
        $data=Candidate::where('id','=',$id)->with(['subscriptions','subscriptions.subscriptions','subscriptions.subscriptions.states','langs'])->first();
        $states=State::all();
        $deficiencies = Deficiency::all();

        $schooling_grades=[
            '' => 'Não definido',
            'professional' => 'Profissionalizante',
            'technology' => 'Tecnólogo',
            'technician' => 'Técnico',
            'graduation' => 'Graduação',
            'postgrad' => 'Pós Graduação',
            'masters' => 'Mestrado',
            'doctor' => 'Doutorado',
            'phd' => 'PHD',        ];

        $schooling_status=[
            'complete'=>'Concluído',
            'coursing'=>'Cursando',
            'incomplete'=>'Incompleto',
        ];

        $schooling_formation=[
            ''=>'Não definido',
            'fundamental'=>'Fundamental',
            'highschool'=>'Médio',
            'technical'=>'Técnico',
            'superior'=>'Superior',
        ];

        if (empty($data->updated_at))
            $data->updated_at='2021-01-01';

        return view('adm.candidates.edit')->with(
            [
                'data'=>$data,
                'states'=>$states,
                'deficiencies'=>$deficiencies,
                'schooling_grades'=>$schooling_grades,
                'schooling_formation'=>$schooling_formation,
                'schooling_status'=>$schooling_status,
                'carbon'=>new Carbon,
            ]
        );
    }

    public function usersEdit ($id) {
        $data=User::where('id','=',$id)->first();
        $roles=Role::where('id','!=',2)->get();
        return view('adm.users.edit')->with(
            [
                'data'=>$data,
                'roles'=>$roles,
            ]
        );
    }

    public function fieldsDestroy (Request $request) {
        Field::whereIn('id',explode(",",$request->ids))->delete();
        return;
    }


    public function statesMailsDestroy (Request $request) {
        StateMail::whereIn('id',explode(",",$request->ids))->delete();
        return;
    }

    public function rolesDestroy (Request $request) {
        Role::whereIn('id',explode(",",$request->ids))->delete();
        return;
    }

    public function statesDestroy (Request $request) {
        State::whereIn('id',explode(",",$request->ids))->delete();
        return;
    }

    public function unitsDestroy (Request $request) {
        Unit::whereIn('id',explode(",",$request->ids))->delete();
        return;
    }

    public function jobsDestroy (Request $request) {
        Job::whereIn('id',explode(",",$request->ids))->delete();
        return;
    }

    public function jobsTemplatesDestroy (Request $request) {
        JobTemplate::whereIn('id',explode(",",$request->ids))->delete();
        return;
    }

    public function subscribersDestroy (Request $request) {
        Subscriber::whereIn('id',explode(",",$request->ids))->delete();
        return;
    }

    public function tagsDestroy (Request $request) {
        DB::table('jobs_templates_tags')->whereIn('tag_id',explode(",",$request->ids))->delete();
        DB::table('jobs_tags')->whereIn('tag_id',explode(",",$request->ids))->delete();
        DB::table('candidates_tags')->whereIn('tag_id',explode(",",$request->ids))->delete();
        Tag::whereIn('id',explode(",",$request->ids))->delete();
        return;
    }

    public function candidatesDestroy (Request $request) {
        $subs=Subscribed::whereIn('candidate_id',explode(",",$request->ids))->get();
        foreach ($subs as $sub){
            DB::table('subscribed_has_states')->where('subscribed_id','=',$sub->id)->delete();
        }
        Subscribed::whereIn('candidate_id',explode(",",$request->ids))->delete();
        Candidate::whereIn('id',explode(",",$request->ids))->delete();
        return;
    }

    public function usersDestroy (Request $request) {
        User::whereIn('id',explode(",",$request->ids))->delete();
        DB::table('model_has_roles')->whereIn('model_id',explode(",",$request->ids))->delete();
        return;
    }

    public function statesSave (Request $request) {
        $data=new State;
        $arr=$request->toArray();
        unset($arr['_token']);

        if(!empty($arr['id']))
            $data=State::where('id','=',$arr['id'])->first();

        foreach ($arr as $k=>$value){
            $data->{$k}=$value;
        }
        $data->save();
		return redirect('/adm/states/');
    }

    public function fieldsSave (Request $request) {
        $data=new Field;
        $arr=$request->toArray();
        unset($arr['_token']);

        if(!empty($arr['id']))
            $data=Field::where('id','=',$arr['id'])->first();

        foreach ($arr as $k=>$value){
            $data->{$k}=$value;
        }
        $data->save();
		return redirect('/adm/fields/');
    }

    public function statesMailsSave (Request $request) {
        $data=new StateMail;
        $arr=$request->toArray();
        $linked_states=[];
        if (!empty($arr['states'])){
            $linked_states=$arr['states'];
            unset($arr['states']);
        }
        unset($arr['_token']);

        if ($request->header_type=='image' && $request->hasFile('header_value')){
            $extension=$request->header_value->extension();
            $header_file='h'.rand(0,100).date('U').".".$extension;
	    	$tmp=$request->header_value->path();
	    	copy($tmp, $_SERVER['DOCUMENT_ROOT'].'/img/'.$header_file);
            $arr['header_value']='/img/'.$header_file;
        }

        if ($request->body_type=='image' && $request->hasFile('body_value')){
            $extension=$request->body_value->extension();
            $body_file='b'.rand(0,100).date('U').".".$extension;
	    	$tmp=$request->body_value->path();
	    	copy($tmp, $_SERVER['DOCUMENT_ROOT'].'/img/'.$body_file);
            $arr['body_value']='/img/'.$body_file;
        }

        if ($request->footer_type=='image' && $request->hasFile('footer_value')){
            $extension=$request->footer_value->extension();
            $footer_file='f'.rand(0,100).date('U').".".$extension;
	    	$tmp=$request->footer_value->path();
	    	copy($tmp, $_SERVER['DOCUMENT_ROOT'].'/img/'.$footer_file);
            $arr['footer_value']='/img/'.$footer_file;
        }


        if(!empty($arr['id']))
            $data=StateMail::where('id','=',$arr['id'])->first();

        foreach ($arr as $k=>$value){
            $data->{$k}=$value;
        }
        $data->save();
        
        DB::table('states_mails_states')->where('mail_id','=',$data->id)->delete();
        foreach($linked_states as $state){
            DB::table('states_mails_states')->insert(['mail_id'=>$data->id,'state_id'=>$state]);
        }

		return redirect('/adm/states-mails/');
    }

    public function viewMail($id){
        $data=StateMail::where('id','=',$id)->first();
        return view('adm.states_mails.mail')->with([
            'data'=>$data,
        ]);
    }

    public function rolesSave (Request $request) {
        $data=new Role;
        $arr=$request->toArray();
        unset($arr['_token']);

        if(!empty($arr['id']))
            $data=Role::where('id','=',$arr['id'])->first();

        $data->name=$arr['name'];
        $data->guard_name='web';
        $data->save();

        DB::table('role_has_permissions')->where('role_id','=',$data->id)->delete();
        foreach($arr['permissions'] as $permission){
            DB::table('role_has_permissions')->insert(['role_id'=>$data->id,'permission_id'=>$permission]);
        }

		return redirect('/adm/roles/');
    }

    public function unitsSave (Request $request) {
        $data=new Unit;
        $arr=$request->toArray();
        unset($arr['_token']);

        if(!empty($arr['id']))
            $data=Unit::where('id','=',$arr['id'])->first();

        foreach ($arr as $k=>$value){
            $data->{$k}=$value;
        }
        $data->save();
		return redirect('/adm/units/');
    }

    public function jobsTemplatesSave (Request $request) {

        $data=new JobTemplate;
        $arr=$request->toArray();
       
        $tags=json_decode($arr['tags'],true);
        $validator = $this->jobTemplateValidator($request->all())->validate();
           
        if(!is_array($validator) && $validator->fails())
            return Redirect::back()->withErrors($validator)->withInput($request->all());

        if ($request->hasFile('picture')){
            $extension=$request->picture->extension();
            $picture_filename=date('U').".".$extension;
	    	$tmp=$request->picture->path();
	    	copy($tmp, $_SERVER['DOCUMENT_ROOT'].'/img/'.$picture_filename);
            $arr['picture']='/img/'.$picture_filename;
        }

        unset($arr['_token']);
        unset($arr['tags']);
        if(!empty($arr['id']))
            $data=JobTemplate::where('id','=',$arr['id'])->first();

        foreach ($arr as $k=>$value){
            $data->{$k}=$value;
        }
        $data->save();


        DB::table('jobs_templates_tags')->where('job_id','=',$data->id)->delete();
        if (!empty($tags)){
            foreach($tags as $data_tag){
                if (empty($data_tag['id']) || $data_tag['id']=='null' || $data_tag['id']==null){
                    $tag = new Tag;
                    $tag->name=strtolower($data_tag['name']);
                    $tag->save();
                }
                else {
                    $tag=Tag::where('id','=',$data_tag['id'])->first();
                }
                DB::table('jobs_templates_tags')->insert(['job_id'=>$data->id,'tag_id'=>$tag->id]);
            }
        }

		return redirect('/adm/jobs-templates/');
    }

    public function jobsSave (Request $request) {

        $data=new Job;
        $arr=$request->toArray();
       
        $tags=json_decode($arr['tags'],true);
        $validator = $this->jobValidator($request->all())->validate();
           
        if(!is_array($validator) && $validator->fails())
            return Redirect::back()->withErrors($validator)->withInput($request->all());
        
        if ($request->hasFile('picture')){
            $extension=$request->picture->extension();
            $picture_filename=date('U').".".$extension;
	    	$tmp=$request->picture->path();
	    	copy($tmp, $_SERVER['DOCUMENT_ROOT'].'/img/'.$picture_filename);
            $arr['picture']='/img/'.$picture_filename;
        }


        unset($arr['_token']);
        unset($arr['tags']);
        if(!empty($arr['id']))
            $data=Job::where('id','=',$arr['id'])->first();

        foreach ($arr as $k=>$value){
            $data->{$k}=$value;
        }
        $data->save();


        DB::table('jobs_tags')->where('job_id','=',$data->id)->delete();
        if (!empty($tags)){
            foreach($tags as $data_tag){
                if (empty($data_tag['id']) || $data_tag['id']=='null' || $data_tag['id']==null){
                    $tag = new Tag;
                    $tag->name=strtolower($data_tag['name']);
                    $tag->save();
                }
                else {
                    $tag=Tag::where('id','=',$data_tag['id'])->first();
                }
                DB::table('jobs_tags')->insert(['job_id'=>$data->id,'tag_id'=>$tag->id]);
            }
        }

		return redirect('/adm/jobs/');
    }

    public function tagsSave (Request $request) {
        $data=new Tag;
        $arr=$request->toArray();
        unset($arr['_token']);

        if(!empty($arr['id']))
            $data=Tag::where('id','=',$arr['id'])->first();

        foreach ($arr as $k=>$value){
            $data->{$k}=$value;
        }
        $data->save();
		return redirect('/adm/tags/');
    }

    public function candidatesSave (Request $request) {
        $data=new Candidate;
        $arr=$request->toArray();

        $validator = $this->candidateValidator($request->all())->validate();
        if(!is_array($validator) && $validator->fails())
            return Redirect::back()->withErrors($validator)->withInput($request->all());

        unset($arr['_token']);
        unset($arr['schooling']);
        unset($arr['experience']);

        if(!empty($arr['id']))
            $data=Candidate::where('id','=',$arr['id'])->first();

        foreach ($arr as $k=>$value){
            $data->{$k}=$value;
        }
        $data->save();
		return redirect('/adm/candidates/');
    }

    public function usersSave (Request $request) {
        $user=new User; 
        $arr=$request->toArray();
        $role=$arr['role'];
    
        unset($arr['_token']);
        unset($arr['role']);

        $validator = $this->userValidator($request->all())->validate();
           
        if(!is_array($validator) && $validator->fails())
            return Redirect::back()->withErrors($validator)->withInput($request->all());

        if(!empty($arr['id']))
            $user=User::where('id','=',$arr['id'])->first();

        foreach ($arr as $k=>$value){
            if ($k=='password' && empty($value))
                continue;
            else if ($k=='password')
                $value=Hash::make($value);
            $user->{$k}=$value;
        }
        $user->save();
        DB::table('model_has_roles')->where('model_id','=',$user->id)->delete();
        DB::table('model_has_roles')->insertOrIgnore([['role_id'=>$role,'model_id'=>$user->id,'model_type'=>'App\User']]);
        Cache::flush();
		return redirect('/adm/users/');
    }

}
