<?php

namespace App\Http\Controllers\Api\Academic;

use App\User;
use App\Resources\Resource;
use Illuminate\Http\Request;
use App\Entities\Academic\Room;
use App\Entities\Academic\Grade;
use App\Entities\Academic\Parallel;
use App\Http\Controllers\Controller;
use App\Entities\Academic\Suscription;
use App\Http\Requests\Academic\RoomStoreRequest;

class RoomController extends Controller
{
    protected $entity;

    public function __construct () {
        $this->entity = app(Room::class);
    }

    public function index(Request $request)
    {
        $year = $request->year ? $request->year : \Carbon\Carbon::now()->year;

        $data = Grade::with(['user', 'rooms', 'rooms.suscriptions', 'rooms.parallel', 'rooms.designations', 'rooms.grade'])
            ->where('is_enabled', 1)->get()->map(function ($item) use($year) {
    
            $rooms = $item->rooms->where('year', $year)->map(function ($room) {
                return collect([
                    'id'    =>  hashid_encode($room->id),
                    'group' =>  $room->grade->title.' '.$room->parallel->title,
                    'adviser'   =>  $room->adviser ? $room->adviser->full_name : '',
                    'designations'  =>  count($room->designations),
                    'students'      =>  count($room->suscriptions)
                ]);
            });

            return collect([
                'id'    =>  hashid_encode($item->id),
                'title' =>  $item->title,
                'code'  =>  $item->code,
                'rooms' =>  $rooms,
                'total' => count($rooms)
            ]);
        });

        return (new Resource($data));
    }

    public function getData(Request $request) {

        $grade = Grade::find(hashid_decode($request->grade_id));

        $parallels = Parallel::where('is_enabled', 1)->where('grade_id', $grade->id)->get()->map(function ($item) {
            return collect([
                'id'    =>  hashid_encode($item->id),
                'title' =>  strtoupper($item->title)
            ]);
        });

        $teachers = User::where('is_active', 1)->where('role', 'teacher')->get()->map(function ($item) {
            return collect([
                'id'    =>  hashid_encode($item->id),
                'name'  =>  $item->full_name
            ]);
        });

        $data = collect([
            'grade'     =>  $grade->title,
            'parallels' =>  $parallels,
            'teachers'  =>  $teachers
        ]);

        return (new Resource($data));
    }

    public function students (Request $request, $id) {
        $data = Suscription::with(['student.information'])->where('room_id', hashid_decode($id));

        if ( $request->q )
            $data = $data->search($this->entity->searchable(), $request->q);

        if ( $request->perPage ) {
            $data = $data->paginate($request->perPage)
                ->onEachSide(1);
        } else {
            $data = $data->get();
        }

        return (new Resource($data));
    }

    public function storeStudent (Request $request) {
        $room = hashid_decode($request->room_id);
        $year = $request->year;
        foreach ( $request->students as $student ) {
            $data = Suscription::create([
                'student_id'    =>  hashid_decode($student),
                'room_id'       =>  $room,
                'year'          =>  $year,
                'user_id'       =>  \Auth::id()
            ]);
            
        }
        
        return (new Resource($data))
            ->response()
            ->setStatusCode(201);
    }

    public function deleteStudent ($id) {
        $data = Suscription::find($id);

        $STATUS_CODE = $data->delete() ? 201 : 503;

        return (new Resource($data))
            ->response()
            ->setStatusCode($STATUS_CODE);
    }

    public function getStudents ($id) {

        $suscriptions = Suscription::where('room_id', hashid_decode($id))
            ->get()->pluck('student_id')->toArray();

        $data = User::with('information')
            ->whereNotIn('id', $suscriptions)
            ->where('role', 'student')->where('is_active', 1)->get()->map(function ($item) {
            return collect([
                'id'    =>  hashid_encode($item->id),
                'name'  =>  $item->full_name,
                'ci'    =>  $item->information->ci,
                'rude'  =>  $item->information->rude
            ]);
        });

        return (new Resource($data));
    }

    public function show ($id) {
        $data = $this->entity->with(['user', 'parallel', 'grade', 'adviser'])->find(hashid_decode($id));

        $data = collect([
            'id'        =>  $id,
            'grade_id'  =>  hashid_encode($data->grade->id),
            'title'     =>  $data->grade->title.' '.$data->parallel->title,
            'parallel_id'   =>  hashid_encode($data->parallel_id),
            'adviser_id'    =>  $data->adviser_id ? hashid_encode($data->adviser->id) : 'nan',
        ]);

        return (new Resource($data));
    }

    public function store (RoomStoreRequest $request) {

        if ( ! $this->exist($request) ) {
            $data = $this->entity;
            $data->parallel_id  =   hashid_decode($request->parallel_id);
            $data->grade_id     =   hashid_decode($request->grade_id);
            $data->adviser_id   =   $request->adviser_id != 'nan' ? hashid_decode($request->adviser_id) : null;
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

    public function update (RoomStoreRequest $request, $id) {
        $data = $this->entity->find(hashid_decode($id));
        $data->parallel_id  =   hashid_decode($request->parallel_id);
        $data->adviser_id   =   $request->adviser_id != 'nan' ? hashid_decode($request->adviser_id) : null;
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
            ->where('grade_id', hashid_decode($request->grade_id))
            ->where('parallel_id', hashid_decode($request->parallel_id))
            ->first() )
            return true;

        return false;
    }
}
