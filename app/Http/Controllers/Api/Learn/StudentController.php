<?php

namespace App\Http\Controllers\Api\Learn;

use App\Resources\Resource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Academic\Designation;
use App\Entities\Academic\Suscription;

class StudentController extends Controller
{
    protected $entity;

    public function __construct () {
        $this->entity = app(Suscription::class);
    }

    public function index (Request $request) {
        $designation = Designation::find(hashid_decode($request->room));

        $data = $this->entity->with('student.information')
            ->where('room_id', $designation->room_id)->get()->map(function ($item) {
                return collect([
                    'lastname'  =>  $item->student->lastname,
                    'name'      =>  $item->student->name,
                    'ci'        =>  $item->student->information->ci,
                    'rude'      =>  $item->student->information->rude,
                    'email'     =>  $item->student->email,
                    'is_birthday'   =>  $item->student->information->birthday->isBirthday(),
                    'avatar'    =>  $item->student->avatar,
                ]);
            });

        return (new Resource($data));
    }
}
