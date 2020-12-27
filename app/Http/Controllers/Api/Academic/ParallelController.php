<?php

namespace App\Http\Controllers\Api\Academic;

use App\Resources\Resource;
use Illuminate\Http\Request;
use App\Entities\Academic\Parallel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Academic\ParallelStoreRequest;
use App\Http\Requests\Academic\ParallelUpdateRequest;

class ParallelController extends Controller
{
    protected $entity;

    public function __construct () {
        $this->entity = app(Parallel::class);
    }

    public function index(Request $request)
    {
        $data = $this->entity->with('user')
            ->where('grade_id', $request->grade);

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

    public function show ($id) {
        $data = $this->entity->with(['user', 'grade'])->find($id);

        return (new Resource($data));
    }

    public function store (ParallelStoreRequest $request) {
        $data = $this->entity;
        $data->code     =   strtoupper($request->code);
        $data->title    =   $request->title;
        $data->grade_id =   $request->grade_id;
        $data->user_id  =   \Auth::id();
        $STATUS_CODE    =   $data->save() ? 201 : 503;
        
        return (new Resource($data))
            ->response()
            ->setStatusCode($STATUS_CODE);
    }

    public function update (ParallelUpdateRequest $request, $id) {
        $data = $this->entity->find($id);
        $data->code     =   strtoupper($request->code);
        $data->title    =   $request->title;
        $data->grade_id =   $request->grade_id;
        $STATUS_CODE    =   $data->save() ? 201 : 503;
        
        return (new Resource($data))
            ->response()
            ->setStatusCode($STATUS_CODE);
    }

    public function destroy ($id) {

    }
}
