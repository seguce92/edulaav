<?php

namespace App\Http\Controllers\Api\Lms;

use App\Entities\Lms\Task;
use App\Resources\Resource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Lms\TaskStoreRequest;

class TaskController extends Controller
{
    protected $entity;

    public function __construct () {
        $this->entity = app(Task::class);
    }

    public function show ($id) {
        $data = $this->entity->with('topic.teacher')->find(hashid_decode($id));

        $data = collect([
            'id'    =>  hashid_encode($data->id),
            'title' =>  $data->title,
            'content'   =>  $data->content,
            'points'    =>  $data->points,
            'date'      =>  $data->date,
            'time'      =>  $data->time,
            'type'      =>  $data->type,
            'created_at'    =>  $data->created_at->translatedFormat('l d, F'),
            'teacher'   =>  $data->topic->teacher->full_name,
            'array_files'   =>  json_decode($data->array_files),
            'topic_id'  =>  hashid_encode($data->topic_id),
            'designation_id'    =>  hashid_encode($data->designation_id)
        ]);

        $STATUS_CODE = $data ? 200 : 404;

        return (new Resource($data))
            ->response()
            ->setStatusCode($STATUS_CODE);
    }

    public function store (TaskStoreRequest $request) {
        $data = $this->entity;
        $data->title = $request->title;
        $data->content = $request->content;
        $data->topic_id = hashid_decode($request->topic_id);
        $data->designation_id = hashid_decode($request->designation_id);
        $data->points = $request->points;
        $data->date = $request->date;
        $data->time = $request->time;
        $data->type = $request->type;
        $data->array_files = json_encode($request->array_files);

        $STATUS_CODE = $data->save() ? 201 : 503;

        return (new Resource($data))
            ->response()
            ->setStatusCode($STATUS_CODE);
    }

    public function update (TaskStoreRequest $request, $id) {
        $data = $this->entity->find(hashid_decode($id));
        $data->title = $request->title;
        $data->content = $request->content;
        $data->topic_id = hashid_decode($request->topic_id);
        $data->designation_id = hashid_decode($request->designation_id);
        $data->points = $request->points;
        $data->date = $request->date;
        $data->time = $request->time;
        $data->array_files = json_encode($request->array_files);

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
