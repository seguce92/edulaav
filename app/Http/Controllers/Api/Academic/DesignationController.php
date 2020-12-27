<?php

namespace App\Http\Controllers\Api\Academic;

use App\User;
use App\Resources\Resource;
use Illuminate\Http\Request;
use App\Entities\Academic\Room;
use App\Entities\Academic\Subject;
use App\Entities\Academic\Parallel;
use App\Http\Controllers\Controller;
use App\Entities\Academic\Designation;
use App\Http\Requests\Academic\DesignationStoreRequest;

class DesignationController extends Controller
{
    protected $entity;
    protected $rows;

    public function __construct () {
        $this->entity = app(Designation::class);
    }

    public function index(Request $request)
    {
        $year = $request->year ? $request->year : \Carbon\Carbon::now()->year;

        $data = Room::with(['user', 'grade', 'parallel', 'designations.teacher', 'designations.subject'])->where('is_enabled', 1)->get()->map(function ($item) use($year) {
            
            $designations = $item->designations->where('year', $year)->map(function ($d) {
                return collect([
                    'id'    =>  hashid_encode($d->id),
                    'title' =>  $d->subject->title,
                    'teacher'   =>  $d->teacher->full_name
                ]);
            });

            return collect([
                'id'    =>  hashid_encode($item->id),
                'title' =>  $item->grade->title.' '.$item->parallel->title,
                'designations'  =>  $designations,
                'total' => count($designations)
            ]);
        });

        return (new Resource($data));
    }

    public function getData(Request $request) {
        
        $room = Room::with(['grade', 'parallel'])->find(hashid_decode($request->room_id));

        $teachers = User::where('is_active', 1)->where('role', 'teacher')->get()->map(function ($item) {
            return collect([
                'id'    =>  hashid_encode($item->id),
                'name'  =>  $item->full_name
            ]);
        });

        $subjects = Subject::where('is_enabled', 1)->where('grade_id', $room->grade_id)->get()->map(function ($item){
            return collect([
                'id'    =>  hashid_encode($item->id),
                'title' =>  $item->title,
                'code'  =>  $item->code
            ]);
        });

        $room = 

        $data = collect([
            'subjects'  =>  $subjects,
            'teachers'  =>  $teachers,
            'room'      =>  $room->grade->title.' '.$room->parallel->title
        ]);

        return (new Resource($data));
    }

    public function show ($id) {
        $data = $this->entity->with(['user', 'room.grade', 'room.parallel', 'subject', 'teacher'])
            ->find(hashid_decode($id));

        $data = collect([
            'room'  =>  $data->room->grade->title.' '.$data->room->parallel->title,
            'subject'   =>  $data->subject->title,
            'teacher'   =>  $data->teacher->full_name
        ]);

        return (new Resource($data));
    }

    public function store (DesignationStoreRequest $request) {

        if ( ! $this->exist($request) ) {
            $data = $this->entity;
            $data->room_id      =   hashid_decode($request->room_id);
            $data->subject_id   =   hashid_decode($request->subject_id);
            $data->teacher_id   =   hashid_decode($request->teacher_id);
            $data->year         =   $request->year;
            $data->user_id  =   \Auth::id();
            $STATUS_CODE    =   $data->save() ? 201 : 503;
        } else {
            $data = collect([
                'message'   =>  'Lo siento no se pudo registrar la información. Ya existe un registro con la misma información.',
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
        $data->subject_id   =   hashid_decode($request->subject_id);
        $data->teacher_id   =   hashid_decode($request->teacher_id);
        $data->user_id  =   \Auth::id();
        $STATUS_CODE    =   $data->save() ? 201 : 503;
        
        return (new Resource($data))
            ->response()
            ->setStatusCode($STATUS_CODE);
    }

    public function destroy ($id) {

        $data = $this->entity->find(hashid_decode($id));

        $STATUS_CODE = $data->delete() ? 201 : 503;

        return (new Resource($data))
            ->response()
            ->setStatusCode($STATUS_CODE);
    }

    private function exist ($request) {
        if ( $this->entity->where('year', $request->year)
            ->where('room_id', hashid_decode($request->room_id))
            ->where('subject_id', hashid_decode($request->subject_id))
            ->first() )
            return true;

        return false;
    }
}
