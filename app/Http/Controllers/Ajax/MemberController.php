<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\TblMember;
use App\Http\Requests\MemberRequest;
use DB, Auth;
use Response;
use App\Services\MemberService;

class MemberController extends Controller
{
    protected $members;

    public function __construct(MemberService $members)
    {
        $this->members = $members;
    }
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
        ->escapeColumns(['infomation', 'name', 'action', 'phone', 'date_of_birth', 'position'])
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
            $this->members->create($request->all());
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
            $this->members->update($id, $request->all());
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
        $user = Auth::user();
        $member = TblMember::find($id);
        // $this->authorize('delete', $member);
        if ($user->can('delete', $member)) {
            $this->members->destroy($id);
            return Response::json([
                'errors' => false,
                'msg' => 'Delete successfully'
            ], 200);
        } else {
            return Response::json([
                'errors' => false,
                'msg' => 'No Role'
            ], 401);
        }
       
       
    }
}
