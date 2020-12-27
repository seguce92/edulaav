<?php

namespace App\Http\Controllers\Api\Learn;

use App\Resources\Resource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Academic\Designation;

class RoomController extends Controller
{
    protected $entity;
    protected $rows;

    public function __construct () {
        $this->entity = app(Designation::class);
    }

    public function index(Request $request)
    {
        $year = \Carbon\Carbon::now()->year;

        $data = $this->entity->with(['room.grade', 'room.suscriptions', 'room.parallel', 'subject'])
            ->where('year', $year)
            ->where('is_enabled', 1)
            ->where('teacher_id', \Auth::id())
            ->get()->map(function ($item) {
                return collect([
                    'id'    =>  hashid_encode($item->id),
                    'title' =>  $item->subject->title,
                    'parallel'  =>  $item->room->parallel->title,
                    'room'  =>  $item->room->grade->title.' '.$item->room->parallel->title,
                    'students'  =>  count($item->room->suscriptions)
                ]);
            });

        return (new Resource($data));
    }

    public function show ($id) {
        $data = $this->entity->with(['room.parallel', 'room.suscriptions', 'room.grade', 'subject', 'teacher'])->find(hashid_decode($id));
        
        $data = collect([
            'room'  =>  $data->room->grade->title.' '.$data->room->parallel->title,
            'teacher'   =>  $data->teacher->full_name,
            'subject'   =>  $data->subject->title,
            'students'  =>  count($data->room->suscriptions)
        ]);

        return (new Resource($data));
    }

    public function store (DesignationStoreRequest $request) {

        if ( ! $this->exist($request) ) {
            $data = $this->entity;
            $data->parallel_id  =   $request->parallel_id;
            $data->grade_id     =   $request->grade_id;
            $data->subject_id   =   $request->subject_id;
            $data->teacher_id   =   $request->teacher_id;
            $data->year         =   $request->year;
            $data->user_id  =   \Auth::id();
            $STATUS_CODE    =   $data->save() ? 201 : 503;
        } else {
            $data = collect([
                'message'   =>  'Lo siento no se pudo registrar la información, Ya existe un registro con la misma información.',
                'status'    =>  205
            ]);

            $STATUS_CODE = 205;
        }
        
        return (new Resource($data))
            ->response()
            ->setStatusCode($STATUS_CODE);
    }

    public function update (Request $request, $id) {
        $data = $this->entity->find($id);
        $data->parallel_id  =   $request->parallel_id;
        $data->grade_id     =   $request->title;
        $data->subject_id   =   $request->subject_id;
        $data->teacher_id   =   $request->teacher_id;
        $data->year         =   $request->year;
        $data->user_id  =   \Auth::id();
        $STATUS_CODE    =   $data->save() ? 201 : 503;
        
        return (new Resource($data))
            ->response()
            ->setStatusCode($STATUS_CODE);
    }
}
