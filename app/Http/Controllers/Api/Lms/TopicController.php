<?php

namespace App\Http\Controllers\Api\Lms;

use App\Entities\Lms\Topic;
use App\Resources\Resource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Lms\TopicStoreRequest;

class TopicController extends Controller
{
    protected $entity;

    public function __construct () {
        $this->entity = app(Topic::class);
    }

    public function index(Request $request)
    {
        $data = $this->entity->with(['designation', 'teacher', 'tasks'])
            ->where('designation_id', hashid_decode($request->designation))
            ->orderBy('created_at', 'desc')
            ->get()->map(function ($item) {

                $tasks = $item->tasks->sortByDesc('created_at')->map(function ($task) {
                    return collect([
                        'id'    =>  hashid_encode($task->id),
                        'title' =>  $task->title,
                        'date'  =>  $task->date,
                        'time'  =>  $task->time,
                        'created'   =>  $task->created_at->format('d-m-y'),
                        'type'  =>  $task->type
                    ]);
                });

                return collect([
                    'id'    =>  hashid_encode($item->id),
                    'title' =>  $item->title,
                    'tasks' =>  $tasks
                ]);
            });

        return (new Resource($data));
    }

    public function list(Request $request)
    {
        $data = $this->entity->with(['designation', 'teacher'])
            ->where('designation_id', hashid_decode($request->designation))
            ->get()->map(function ($item) {
                return collect([
                    'id'    =>  hashid_encode($item->id),
                    'title' =>  $item->title
                ]);
            });

        return (new Resource($data));
    }

    public function show ($id) {
        $data = $this->entity->find(hashid_decode($id));

        $data = collect([
            'id'    =>  hashid_encode($data->id),
            'title' =>  $data->title,
            'designation_id'    =>  hashid_encode($data->designation_id),
            'created'   =>  $data->created_at->format('d/m/Y H:m:s'),
        ]);

        return (new Resource($data));
    }

    public function store (TopicStoreRequest $request) {
        $data = $this->entity;
        $data->title            =   $request->title;
        $data->designation_id   =   hashid_decode($request->designation_id);
        $data->teacher_id       =   \Auth::id();
        $STATUS_CODE            =   $data->save() ? 201 : 503;
        
        return (new Resource($data))
            ->response()
            ->setStatusCode($STATUS_CODE);
    }

    public function update (TopicStoreRequest $request, $id) {
        $data = $this->entity->find(hashid_decode($id));
        $data->title    =   $request->title;
        $STATUS_CODE    =   $data->save() ? 201 : 503;
        
        return (new Resource($data))
            ->response()
            ->setStatusCode($STATUS_CODE);
    }

    public function destroy ($id) {
        $data = $this->entity->find(hashid_decode($id));

        $STATUS_CODE = $data->tasks->count() == 0 && $data->delete() ? 201 : 204;

        return (new Resource($data))
            ->response()
            ->setStatusCode($STATUS_CODE);
    }
}
