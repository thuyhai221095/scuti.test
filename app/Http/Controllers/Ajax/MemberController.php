<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\TblMember;
use App\Http\Requests\MemberRequest;
use DB;
use Response;
use App\Models\TblMember as AppTblMember;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = TblMember::orderBy('created_at', 'DESC');
        $data = TblMember::filterInput($data, 'name', 'name', $request);
        $data = TblMember::filterInput($data, 'phone', 'phone', $request);
        $data = TblMember::filterInput($data, 'position', 'position', $request);
        $data = TblMember::filterDate($data, 'date_of_birth', 'date_of_birth', $request);
        $data = $data->get();
        return Datatables::of($data)
        ->editColumn('date_of_birth', function ($u) {
            return date('d-m-Y', strtotime($u->date_of_birth));
        })
        ->editColumn('avatar', function ($u) {
            $avatar = 'default.png';
            if ($u->avatar) {
                $avatar = $u->avatar;
            }
            $img[] = '<img title="'.$u->name.'" src="'.url('avatars').'/'.$avatar.'" class="avatar"/>';
            return implode(' ', $img);
        })
        ->escapeColumns([])
        ->addColumn('action', function ($u) {
            $action = [];
            $action[] = '
                <a id="' . $u->id . '" 
                    title="Update member" 
                    onclick="openMember(' . $u->id . ')" 
                    class="btn btn-xs btn-primary">
                        <i class="glyphicon glyphicon-edit"></i>
                </a>';
            
            $action[] = '
                <a 
                    id="' . $u->id . '" 
                    title="Delete member" 
                    onclick="deleteMember(' . $u->id . ')" 
                    class="btn btn-xs btn-danger">
                    <i class="glyphicon glyphicon-trash"></i>
                </a>';
            return implode(' ', $action);
        })
        ->make(true);
        return Datatables::of(TblMember::query())->make(true);
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
    public function store(MemberRequest $request)
    {
        DB::beginTransaction();
        try {
            $input = $request->all();
            $input['date_of_birth'] = date("Y-m-d", strtotime($request->date_of_birth));
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar')->store('', 'public');
                $input['avatar'] = $file;
            }
            $member = TblMember::create($input);
            DB::commit();
            return response([
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
        $data = TblMember::find($id);
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
    public function update(MemberRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $member = TblMember::find($request->id);
            $input = $request->all();
            $input['date_of_birth'] = date("Y-m-d", strtotime($request->date_of_birth));
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar')->store('', 'public');
                $input['avatar'] = $file;
            }
            $member->update($input);
            DB::commit();
            return Response::json([
                'errors' => false,
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
        $data = TblMember::find($id);
        $data->delete();
        return Response::json([
            'errors' => false,
            'msg' => 'Delete successfully'
        ], 200);
    }
}
