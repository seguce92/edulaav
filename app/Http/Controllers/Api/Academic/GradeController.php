<?php

namespace App\Http\Controllers\Api\Academic;

use App\Resources\Resource;
use Illuminate\Http\Request;
use App\Entities\Academic\Grade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Academic\GradeStoreRequest;
use App\Http\Requests\Academic\GradeUpdateRequest;

class GradeController extends Controller
{
    protected $entity;

    public function __construct () {
        $this->entity = app(Grade::class);
    }

    public function index(Request $request)
    {
        $data = $this->entity->with('user')->get();

        return (new Resource($data));
    }

    public function show ($id) {
        $data = $this->entity->with(['user', 'parallels'])->find($id);

        return (new Resource($data));
    }

    public function store (GradeStoreRequest $request) {
        $data = $this->entity;
        $data->code     =   strtoupper($request->code);
        $data->title    =   $request->title;
        $data->user_id  =   \Auth::id();
        $STATUS_CODE    =   $data->save() ? 201 : 503;
        
        return (new Resource($data))
            ->response()
            ->setStatusCode($STATUS_CODE);
    }

    public function update (GradeUpdateRequest $request, $id) {
        $data = $this->entity->find($id);
        $data->code     =   strtoupper($request->code);
        $data->title    =   $request->title;
        $STATUS_CODE    =   $data->save() ? 201 : 503;
        
        return (new Resource($data))
            ->response()
            ->setStatusCode($STATUS_CODE);
    }

    public function destroy ($id) {

    }
}
