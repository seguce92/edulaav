<?php

namespace App\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        \Carbon\Carbon::setLocale(config('app.locale'));
        \Faker\Factory::create('es_ES');

        Paginator::defaultView('vendor.pagination.default');

        Paginator::defaultSimpleView('vendor.pagination.default');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::macro('search', function ($attributes, string $searchTerm) {
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach (Arr::wrap($attributes) as $attribute) {
                    $query->when(
                        Str::contains($attribute, '.'),
                        function (Builder $query) use ($attribute, $searchTerm) {
                            [$relationName, $relationAttribute] = explode('.', $attribute);
        
                            $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $searchTerm) {
                                $query->where($relationAttribute, 'LIKE', "%{$searchTerm}%");
                            });
                        },
                        function (Builder $query) use ($attribute, $searchTerm) {
                            $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                        }
                    );
                }
            });
        
            return $this;
        });

        Builder::macro('findByHashid', function (Builder $builder, $hashid) {
			$id = $builder->getModel()->hashidToId($hashid);

			return $builder->find($id);
		});

		Builder::macro('findByHashidOrFail', function (Builder $builder, $hashid)
		{
			$id = $builder->getModel()->hashidToId($hashid);

			return $builder->findOrFail($id);
		});

        View::composer('*', function ($view) {
            $view->with('settings', $this->getSettings());
        });
    }

    private function getSettings () {
        $data =  collect([
            'name'          =>  config('seguce92.data.name'),
            'description'   =>  config('seguce92.data.desccription'),
            'logo'          =>  config('seguce92.data.logo'),
            'sigla'         =>  strtoupper(config('seguce92.data.sigla')),
            'db'    =>  collect([
                'delete'    =>  config('seguce92.data.db.delete'),
                'forceDetele'   =>  config('seguce92.data.db.forceDelete')
            ]),
            'service'   =>  collect([
                'api'   =>  config('seguce92.data.service.api'),
                'assets'    =>  config('seguce92.data.service.assets'),
                'vtoken'    =>  config('seguce92.data.service.vtoken')
            ]),
            'ui'    =>  collect([
                'markdown'  =>  config('seguce92.data.ui.markdown'),
                'videoroom' =>  config('seguce92.data.ui.videoroom')
            ]),
            'filemanager'   =>  collect([
                'byUser'        =>  config('seguce92.data.filemanager.byUser'),
                'maxFilesize'   =>  config('seguce92.data.filemanager.maxFilesize'), // MB,
                'maxFiles'      =>  config('seguce92.data.filemanager.maxFiles'),
                'acceptedFiles' =>  config('seguce92.data.filemanager.acceptedFiles')  
            ])
        ]);

        return $data;
    }
}
