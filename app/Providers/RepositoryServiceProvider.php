<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\{
    IUser,
    IArticle,
    IFollow
};
use App\Repositories\Eloquent\{
    UserRepository,
    ArticleRepository,
    FollowRepository
};

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(IUser::class, UserRepository::class);
        $this->app->bind(IArticle::class, ArticleRepository::class);
        $this->app->bind(IFollow::class, FollowRepository::class);
    }
}
