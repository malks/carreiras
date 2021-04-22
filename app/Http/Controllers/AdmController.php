<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Candidate;
use App\Job;
use App\Tag;
use App\Unit;
use App\Field;

class AdmController extends Controller
{

    public function config(Request $request) {

    }

    public function fieldsList (Request $request){
        $data=Field::paginate(15);

        return view('adm.fields.list')->with(
            [
                'data'=>$data,
                'search'=>$request->search,
            ]
        );

    }

    public function unitsList (Request $request){
        $data=Unit::get();
    }

    public function jobsList (Request $request){
        $data=Job::get();
    }

    public function tagsList (Request $request){
        $data=Tag::get();
    }

    public function candidatesList (Request $request){
        $data=Candidate::get();
    }

    public function usersList (Request $request){
        $data=User::leftJoin('candidates','candidates.user_id','=','id')->whereNull('candidates.id')->get();
    }

    public function fieldsCreate (Request $request) {

    }

    public function unitsCreate (Request $request) {

    }

    public function jobsCreate (Request $request) {

    }

    public function tagsCreate (Request $request) {

    }

    public function candidatesCreate (Request $request) {

    }

    public function usersCreate (Request $request) {

    }

    public function fieldsEdit ($id) {
        $data=Field::where('id','=',$id)->first();
        return view('adm.fields.edit')->with(
            [
                'data'=>$data,
            ]
        );
    }

    public function unitsEdit (Request $request) {

    }

    public function jobsEdit (Request $request) {

    }

    public function tagsEdit (Request $request) {

    }

    public function candidatesEdit (Request $request) {

    }

    public function usersEdit (Request $request) {

    }

    public function fieldsDestroy (Request $request) {
        Field::whereIn('id',explode(",",$request->ids))->delete();
        return;
    }

    public function unitsDestroy (Request $request) {

    }

    public function jobsDestroy (Request $request) {

    }

    public function tagsDestroy (Request $request) {

    }

    public function candidatesDestroy (Request $request) {

    }

    public function usersDestroy (Request $request) {

    }

    public function fieldsSave (Request $request) {

    }

    public function unitsSave (Request $request) {

    }

    public function jobsSave (Request $request) {

    }

    public function tagsSave (Request $request) {

    }

    public function candidatesSave (Request $request) {

    }

    public function usersSave (Request $request) {

    }

}
