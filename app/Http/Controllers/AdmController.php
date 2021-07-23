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

class AdmController extends Controller
{

    public function config(Request $request) {
        $banners=Banner::get();
        return view('adm.config')->with([
            'banners'=>$banners,
        ]);
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
