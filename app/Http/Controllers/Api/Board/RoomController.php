<?php

namespace App\Http\Controllers\Api\Board;

use Carbon\Carbon;
use App\Resources\Resource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Academic\Designation;
use App\Entities\Academic\Suscription;

class RoomController extends Controller
{
    protected $entity;

    public function __construct () {
        $this->entity = app(Suscription::class);
    }

    public function index (Request $request) {
        $rooms = $this->entity->where('year', Carbon::now()->year)
            ->where('is_enabled', 1)
            ->where('student_id', \Auth::id())->get()->pluck('room_id');

        $data = Designation::with(['room.grade', 'room.suscriptions', 'room.parallel', 'subject'])
            ->where('year', Carbon::now()->year)
            ->where('is_enabled', 1)
            ->whereIn('room_id', $rooms)->get()->map(function ($item) {
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

    public function show($id) {

    }
}
