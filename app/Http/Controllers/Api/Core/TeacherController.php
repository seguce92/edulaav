<?php

namespace App\Http\Controllers\Api\Core;

use App\User;
use App\Resources\Resource;
use Illuminate\Http\Request;
use App\Entities\Core\Information;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Core\TeacherStoreRequest;
use App\Http\Requests\Core\TeacherUpdateRequest;

class TeacherController extends Controller
{
    protected $entity;

    public function __construct () {
        $this->entity = app(User::class);
    }

    public function index(Request $request)
    {
        $data = $this->entity->with(['information'])
            ->where('role', 'teacher');

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

    public function store (TeacherStoreRequest $request) {
        $data = $this->entity;
        $data->name = $request->name;
        $data->lastname = $request->lastname;
        $data->email = $request->email;
        $data->password = Hash::make('password');
        $data->role     = 'teacher';
        $STATUS_CODE = $data->save() ? 201 : 503;

        if ( $STATUS_CODE === 201 ) {
            $infor = Information::create([
                'ci'    =>  $request->ci,
                'birthday'  =>  $request->birthday,
                'work_from' =>  $request->work_from,
                'user_id'   =>  $data->id
            ]);
        }
        
        return (new Resource($data))
            ->response()
            ->setStatusCode($STATUS_CODE);
    }

    public function update (TeacherUpdateRequest $request, $id) {
        $data = $this->entity->find($id);
        $data->name = $request->name;
        $data->lastname = $request->lastname;
        $data->email = $request->email;
        $STATUS_CODE = $data->save() ? 201 : 503;

        if ( $STATUS_CODE === 201 ) {
            $data->information->update([
                'ci'    =>  $request->ci,
                'birthday'  =>  $request->birthday,
                'work_from' =>  $request->work_from,
                'user_id'   =>  $data->id
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
