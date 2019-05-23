<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\TblProject;
use App\Models\TblUserRole;
use Yajra\Datatables\Datatables;
use Response;
use DB;
use PhpParser\Node\Stmt\Label;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = TblProject::with('users')->orderBy('created_at', 'DESC');
        $data = TblProject::filterInput($data, 'name', 'name', $request);
        $data = TblProject::filterInput($data, 'type', 'type', $request);
        $data = TblProject::filterInput($data, 'status', 'status', $request);
        $data = TblProject::filterDate($data, 'deadline', 'deadline', $request);
        $data->get();
        return Datatables::of($data)
        ->editColumn('deadline', function ($u) {
            return date('d-m-Y', strtotime($u->deadline));
        })
        ->editColumn('status', function ($u) {
            $class = '';
            switch ($u->status) {
                case 'planned':
                    $class = 'label-info';
                    break;
                case 'onhold':
                    $class = 'label-default';
                    break;
                case 'doing':
                    $class = 'label-primary';
                    break;
                case 'done':
                    $class = 'label-success';
                    break;
                case 'cancelled':
                    $class = 'label-danger';
                    break;
                default:
                    $class = '';
                    break;
            }
            return '<Label class="label '.$class.'">'.$u->status.'</Label>';
        })
        ->editColumn('contacts', function ($u) {
            $user = $u->users;
            $img = [];
            foreach ($user as $value) {
                $avatar = 'default.png';
                if ($value->avatar) {
                    $avatar = $value->avatar;
                }
                $img[] = '<img 
                    title="'.$value->name.'" 
                    src="'.url('avatars').'/'.$avatar.'" 
                    class="avatar"/>';
            }
            return implode(' ', $img);
        })
        ->escapeColumns([])
        ->addColumn('action', function ($u) {
            $action[] = '
                <a 
                    id="' . $u->id . '" 
                    titlle="Update" 
                    onclick="openProject('.$u->id.')" 
                    class="btn btn-sm btn-primary">
                    <i class="glyphicon glyphicon-edit"></i>
                </a>';
            $action[] = '
                <a 
                    id="' . $u->id . '" 
                    titlle="Add Member" 
                    onclick="openMemberProject('.$u->id.')" 
                    class="btn btn-sm btn-success">
                    <i class="glyphicon glyphicon-plus-sign"></i>
                </a>';

            $action[] = '
                <a 
                    id="' . $u->id . '" 
                    titlle="Detail" 
                    onclick="detailProject('.$u->id.')" 
                    class="btn btn-sm btn-info">
                    <i class="glyphicon glyphicon-info-sign"></i>
                </a>';
            
            $action[] = '
                <a 
                    id="' . $u->id . '"  
                    titlle="Delete" 
                    onclick="deleteProject('.$u->id.')" 
                    class="btn btn-sm btn-danger">
                    <i class="glyphicon glyphicon-trash"></i>
                </a>';
            return implode(' ', $action);
        })
        ->make(true);
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
    public function store(ProjectRequest $request)
    {
        DB::beginTransaction();
        try {
            $input = $request->all();
            if (isset($request->deadline)) {
                $input['deadline'] = date("Y-m-d", strtotime($request->deadline));
            }
            $project = TblProject::create($input);
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
        return TblProject::find($id);
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
    public function update(ProjectRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $project = TblProject::find($id);
            $input = $request->all();
            if (isset($request->deadline)) {
                $input['deadline'] = date("Y-m-d", strtotime($request->deadline));
            }
            $project->update($input);
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

    public function detailProject($id)
    {
        $data = TblUserRole::with('member')->where('project_id', $id)->get();
        return $data;
    }

    public function destroy($id)
    {
        $data = TblProject::find($id);
        $data->delete();
        return Response::json([
            'errors' => false,
            'msg' => 'Delete successfully'
        ], 200);
    }
}
