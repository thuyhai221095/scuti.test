<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TblUserRole;
use App\Models\TblMember;
use App\Http\Requests\UserRoleRequest;
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
    public function store(UserRoleRequest $request)
    {
        DB::beginTransaction();
        try {
            $user_role = TblUserRole::create($request->all());
            DB::commit();
            return Response::json([
                'errors' => false,
                'msg' => 'Add new successfully'
            ], 201);
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
    public function update(UserRoleRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $user_role = TblUserRole::find($id);
            $user_role->update($request->all());
            DB::commit();
            $detail_new = TblUserRole::with('member')->where('project_id', $user_role->project_id)->get();
            return Response::json([
                'errors' => false,
                'data'  => $detail_new,
                'msg' => 'Update successfully'
            ], 201);
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
