<?php

namespace App\Http\Controllers\Api\Core;

use App\User;
use App\Resources\Resource;
use Illuminate\Http\Request;
use App\Entities\Core\Information;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Core\StudentStoreRequest;
use App\Http\Requests\Core\StudentUpdateRequest;

class StudentController extends Controller
{
    protected $entity;

    public function __construct () {
        $this->entity = app(User::class);
    }

    public function index(Request $request)
    {
        $data = $this->entity->with(['information'])->where('role', 'student');

        if ( $request->q )
            $data = $data->search($this->entity->searchable(), $request->q);

        $data = $data->orderBy('created_at', 'desc');
        if ( $request->perPage ) {
            $data = $data->paginate($request->perPage)
                ->onEachSide(1);
        } else {
            $data = $data->get();
        }

        return (new Resource($data));
    }

    public function show ($id) {
        $data = $this->entity->with(['information'])->find($id);

        return (new Resource($data));
    }

    public function store (StudentStoreRequest $request) {
        $data = $this->entity;
        $data->name     =   $request->name;
        $data->lastname =   $request->lastname;
        $data->email    =   $request->email;
        $data->password =   Hash::make('password');
        $data->role     =   'student';
        $STATUS_CODE    =   $data->save() ? 201 : 503;

        if ( $STATUS_CODE === 201 ) {
            $infor = Information::create([
                'ci'    =>  $request->ci,
                'rude'  =>  $request->rude,
                'birthday'      =>  $request->birthday,
                'father_name'   =>  $request->father_name,
                'mother_name'   =>  $request->mother_name,
                'phone'         =>  $request->phone,
                'adress'        =>  $request->adress,
                'birthday'      =>  $request->birthday,
                'site'          =>  $request->site,
                'gender'        =>  $request->gender,
                'procedent'     =>  $request->procedent,
                'father_occupation' =>  $request->father_occupation,
                'mother_occupation' =>  $request->mother_occupation, 
                'father_email'      =>  $request->father_email,
                'mother_email'      =>  $request->mother_email,
                'father_phone'      =>  $request->father_phone,
                'mother_phone'      =>  $request->mother_phone,
                'tutor_phone'       =>  $request->tutor_phone, 
                'tutor_email'       =>  $request->tutor_email,
                'size'              =>  $request->size,
                'medic'             =>  $request->medic,
                'blood_type'        =>  $request->blood_type,
                'user_id'       =>  $data->id
            ]);
        }
        
        return (new Resource($data))
            ->response()
            ->setStatusCode($STATUS_CODE);
    }

    public function update (StudentUpdateRequest $request, $id) {
        $data = $this->entity->find($id);
        $data->name     =   $request->name;
        $data->lastname =   $request->lastname;
        $data->email    =   $request->email;
        $STATUS_CODE    =   $data->save() ? 201 : 503;

        if ( $STATUS_CODE === 201 ) {
            $infor = $data->information->update([
                'ci'    =>  $request->ci,
                'rude'  =>  $request->rude,
                'birthday'      =>  $request->birthday,
                'father_name'   =>  $request->father_name,
                'mother_name'   =>  $request->mother_name,
                'phone'         =>  $request->phone,
                'adress'        =>  $request->adress,
                'birthday'      =>  $request->birthday,
                'site'          =>  $request->site,
                'gender'        =>  $request->gender,
                'procedent'     =>  $request->procedent,
                'father_occupation' =>  $request->father_occupation,
                'mother_occupation' =>  $request->mother_occupation, 
                'father_email'      =>  $request->father_email,
                'mother_email'      =>  $request->mother_email,
                'father_phone'      =>  $request->father_phone,
                'mother_phone'      =>  $request->mother_phone,
                'tutor_phone'       =>  $request->tutor_phone, 
                'tutor_email'       =>  $request->tutor_email,
                'size'              =>  $request->size,
                'medic'             =>  $request->medic,
                'blood_type'        =>  $request->blood_type,
                'adress'        =>  $request->adress
            ]);
        }
        
        return (new Resource($data))
            ->response()
            ->setStatusCode($STATUS_CODE);
    }

    public function destroy (Request $request, $id) {
        $data = $this->entity->find($id);
        $STATUS_CODE = $data->update([
            'is_active'    =>  $request->status ? 1 : 0
        ]) ? 201 : 503;

        return (new Resource($data))
            ->response()
            ->setStatusCode($STATUS_CODE);
    }
}
