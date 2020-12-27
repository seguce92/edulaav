<?php

namespace App\Http\Controllers\Api\Academic;

use App\Resources\Resource;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Entities\Academic\Grade;
use App\Entities\Academic\Document;
use App\Http\Controllers\Controller;
use App\Http\Requests\Academic\DocumentStoreRequest;

class DocumentController extends Controller
{
    protected $entity;

    public function __construct () {
        $this->entity = app(Document::class);
    }

    public function getGrades (Request $request) {
        $data = Grade::with('documents')->where('is_enabled', 1)->get()->map(function ($g) use ($request) {
            return collect([
                'id'    =>  hashid_encode($g->id),
                'code'  =>  $g->code,
                'title' =>  $g->title,
                'documents' =>  $g->documents->where('year', $request->year)->count()
            ]);
        });

        return (new Resource($data));
    }

    public function index (Request $request) {

        $grade = Grade::find(hashid_decode($request->grade_id));

        $data = $this->entity->with('user')->where('grade_id', $grade->id)->where('year', $request->year)->get()->map(function ($d) {
            return collect([
                'id'        =>  hashid_encode($d->id),
                'title'     =>  $d->title,
                'content'   =>  $d->content,
                'file_name' =>  $d->file_name,
                'extension' =>  Str::afterLast($d->file_name, '.'),
                'user'      =>  $d->user->full_name,
                'show'      =>  false
            ]);
        });

        $data = collect([
            'grade'     =>  $grade->title,
            'documents' =>  $data
        ]);

        return (new Resource($data));
    }

    public function show ($id) {

        $data = $this->entity->find(hashid_decode($id));

        $STATUS_CODE = $data ? 200 : 404;

        return (new Resource($data))
            ->response()
            ->setStatusCode($STATUS_CODE);
    }

    public function store (DocumentStoreRequest $request) {
        $data = $this->entity;
        $data->title = $request->title;
        $data->content = $request->content;
        $data->file_name = $request->file_name;
        $data->year = $request->year;
        $data->user_id = \Auth::id();
        $data->grade_id = hashid_decode($request->grade_id);

        $STATUS_CODE = $data->save() ? 201 : 503;

        return (new Resource($data))
            ->response()
            ->setStatusCode($STATUS_CODE);
    }

    public function update (DocumentStoreRequest $request, $id) {
        $data = $this->entity->find(hashid_decode($id));
        $data->title = $request->title;
        $data->content = $request->content;
        $data->file_name = $request->file_name;

        $STATUS_CODE = $data->save() ? 201 : 503;

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
}
