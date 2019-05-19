<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\TblUserRole;
use App\Models\TblMember;
use Validator;
use Response;
use DB;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = array(
                'project' => 'required',
                'member' => 'required',
                'role' => 'required'
            );
            $msg = [];
            $validator = Validator::make(Input::all(), $rules, $msg);
            if ($validator->fails()) {
                return Response::json(array(
                    'errors' => $validator->getMessageBag()->toArray()
                ));
            } else {
                $data = new TblUserRole();
                $data->project_id = $request->project;
                $data->member_id = $request->member;
                $data->role = $request->role;
                $data->save();
                DB::commit();
                return Response::json([
                    'errors' => false,
                    'msg' => 'Add new successfully'
                ], 201);
            }
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = TblUserRole::where('project_id', $id)->pluck('member_id')->toArray();
        $data = TblMember::whereNotIn('id', $users)->get();
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $rules = array(
                'role' => 'required'
            );
            $msg = [];
            $validator = Validator::make(Input::all(), $rules, $msg);
            if ($validator->fails()) {
                return Response::json(array(
                    'errors' => $validator->getMessageBag()->toArray()
                ));
            } else {
                $data = TblUserRole::find($id);
                $data->role = $request->role;
                $data->update();
                $detail_new = TblUserRole::with('member')->where('project_id', $data->project_id)->get();
                DB::commit();
                return Response::json([
                    'errors' => false,
                    'data'  => $detail_new,
                    'msg' => 'Update successfully'
                ], 201);
            }
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = TblUserRole::find($id);
        $data->delete();
        $detail_new = TblUserRole::with('member')->where('project_id', $data->project_id)->get();
        return Response::json([
            'errors' => false,
            'data' => $detail_new,
            'msg' => 'Delete successfully'
        ], 200);
    }
}
