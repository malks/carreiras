<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Candidate;
use App\Banner;
use App\AboutUs;
use App\OurNumbers;
use App\OurTeam;
use App\Job;
use App\Tag;
use App\Unit;
use App\Field;
use App\State;
use App\Subscribed;
use Illuminate\Support\Facades\DB;

class AdmController extends Controller
{

    public function config(Request $request) {
        $banners=Banner::get();
        return view('adm.config')->with([
            'banners'=>$banners,
        ]);
    }

    public function recruiting (Request $request){
        return view('adm.recruiting');
    }

    public function addSubscriptionState(Request $request){
        $state = State::where('name','like',"%".$request->status."%")->first();
        $subscribed = Subscribed::
        where('candidate_id','=',$request->candidate_id)
        ->where('job_id','=',$request->job_id)
        ->first();
        DB::connection('mysql')->table('subscribed_has_states')->insert(
            [
                'subscribed_id'=>$subscribed->id,
                'state_id'=>$state->id,
            ]
        );
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

        $data['jobs']=Job::orderBy('updated_at','desc')
        ->when(!empty($request->filters['jobs']['direct']), function ($query) use ($request) {
            $directLikeDone=0;
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
            }
        })
        ->when(!empty($request->filters['jobs']['mustHave']), function($query) use ($request){
            $query->with($request->filters['jobs']['mustHave']);
            foreach($request->filters['jobs']['mustHave'] as $relation){
                $query->has($relation);
            }
        })
        ->when(!empty($request->filters['jobs']['deep']), function ($query) use ($request) {
            foreach($request->filters['jobs']['deep'] as $relation=>$filters){
                $deepLikeDone=0;
                $query->with([$relation=>function ($inquery) use ($filters){
                    foreach($filters as $type_filter=>$filter_data){
                        if ($type_filter=='mustHave'){
                            $inquery->with(array_keys($filter_data));
                            foreach($filter_data as $deep_relation => $deep_filter){
                                $inquery->whereHas($deep_relation, function ($subquery) use ($deep_filter){
                                    foreach($deep_filter as $deep_filter_type => $deep_filter_data){
                                        if ($deep_filter_type=='like'){
                                            foreach($deep_filter_data as $key=>$value){
                                                if ($value != "" && !$deepLikeDone){
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
                                    if ($value != "" && !$deepLikeDone){
                                        $inquery->where($key,'like',"%".$value."%");
                                        $deepLikeDone=1;
                                    }
                                    else if ($value!="")
                                        $inquery->orWhere($key,'like',"%".$value."%");
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
                }]);
            }
        })
        ->with(['subscribers','tags','field','unit'])
        ->withCount('subscriptions as subscription_amount')
        ->get()->toArray();

        $data['states'] = State::all()->toArray();
        $data['units']  = Unit::all()->toArray();
        $data['fields'] = Field::all()->toArray();

        return json_encode($data);
    }

    public function bannersList (Request $request){
        $banners=Banner::orderBy("order","asc")->orderBy('created_at','desc')->orderBy('active_to','desc')->orderBy('active_from','desc')->paginate();
        return $banners;
    }

    public function updateBanner (Request $request){
        $arr=$request->all();
        unset($arr['_token']);
        $banner_data=json_decode($arr['banner'],true);
        $banner=Banner::where('id','=',$banner_data['id'])->first();

        unset($banner_data['id']);
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
            $banner=Banner::where('id','=',$a['id'])->first();
            unset($a['id']);

            foreach ($a as $k=>$d){
                $banner->{$k}=$d;
            }

            $banner->save();
        }
		return "";
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
        ->paginate(15);

        return view('adm.jobs.list')->with(
            [
                'data'=>$data,
                'search'=>$request->search,
            ]
        );
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

    public function candidatesList (Request $request){
        $data=Candidate::
        when(!empty($request->search),function($query) use ($request) {
            $query->where('name','like',"%$request->search%");
            $query->orWhere('cpf','like',"%$request->search%");
            $query->orWhere('phone','like',"%$request->search%");
            $query->orWhere('address','like',"%$request->search%");
            $query->orWhere('city','like',"%$request->search%");
            $query->orWhere('state','like',"%$request->search%");
            $query->orWhere('country','like',"%$request->search%");
        })
        ->with(['Schooling','Experience'])
        ->paginate(15);

        $schooling_grades=[
            'technology' => 'Tecnólogo',
            'graduation' => 'Graduação',
            'postgrad' => 'Pós Graduação',
            'masters' => 'Mestrado',
            'doctor' => 'Doutorado',
            'phd' => 'PHD',
        ];

        return view('adm.candidates.list')->with(
            [
                'data'=>$data,
                'search'=>$request->search,
                'schooling_grades'=>$schooling_grades,
            ]
        );

    }

    public function usersList (Request $request){
        $data=User::leftJoin('candidates','candidates.user_id','=','id')->whereNull('candidates.id')->get();
    }

    public function fieldsCreate (Request $request) {
        $data=new Field;
        return view('adm.fields.edit')->with(
            [
                'data'=>$data,
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

    public function jobsCreate (Request $request) {
        $data=new Job;
        return view('adm.jobs.edit')->with(
            [
                'data'=>$data,
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
        return view('adm.candidates.edit')->with(
            [
                'data'=>$data,
            ]
        );
    }

    public function usersCreate (Request $request) {
        $data=new User;
        return view('adm.users.edit')->with(
            [
                'data'=>$data,
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

    public function jobsEdit ($id) {
        $data=Job::where('id','=',$id)->first();
        return view('adm.jobs.edit')->with(
            [
                'data'=>$data,
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
        $data=Candidate::where('id','=',$id)->first();

        $schooling_grades=[
            'technology' => 'Tecnólogo',
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
                'schooling_grades'=>$schooling_grades,
                'schooling_status'=>$schooling_status,
            ]
        );
    }

    public function usersEdit ($id) {
        $data=Unit::where('id','=',$id)->first();
        return view('adm.users.edit')->with(
            [
                'data'=>$data,
            ]
        );
    }

    public function fieldsDestroy (Request $request) {
        Field::whereIn('id',explode(",",$request->ids))->delete();
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

    public function tagsDestroy (Request $request) {
        Tag::whereIn('id',explode(",",$request->ids))->delete();
        return;
    }

    public function candidatesDestroy (Request $request) {
        Candidate::whereIn('id',explode(",",$request->ids))->delete();
        return;
    }

    public function usersDestroy (Request $request) {
        User::whereIn('id',explode(",",$request->ids))->delete();
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

    public function jobsSave (Request $request) {
        $data=new Job;
        $arr=$request->toArray();
        unset($arr['_token']);

        if(!empty($arr['id']))
            $data=Job::where('id','=',$arr['id'])->first();

        foreach ($arr as $k=>$value){
            $data->{$k}=$value;
        }
        $data->save();
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
        unset($arr['_token']);

        if(!empty($arr['id']))
            $data=Candidate::where('id','=',$arr['id'])->first();

        foreach ($arr as $k=>$value){
            $data->{$k}=$value;
        }
        $data->save();
		return redirect('/adm/candidates/');
    }

    public function usersSave (Request $request) {
        $data=new User;
        $arr=$request->toArray();
        unset($arr['_token']);

        if(!empty($arr['id']))
            $data=User::where('id','=',$arr['id'])->first();

        foreach ($arr as $k=>$value){
            $data->{$k}=$value;
        }
        $data->save();
		return redirect('/adm/users/');

    }

}
