<?php

namespace App\Providers;

//use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Author;
use App\Models\Book;
use App\Models\BookIssue;
use App\Models\BookReturn;
use App\Models\Reader;
use App\Policies\ResourcePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Політики моделі => політика.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Author::class    => ResourcePolicy::class,
        Book::class      => ResourcePolicy::class,
        Reader::class    => ResourcePolicy::class,
        BookIssue::class => ResourcePolicy::class,
        BookReturn::class=> ResourcePolicy::class,
    ];

    /**
     * Реєстрація політик.
     */
    public function boot(): void
    {
        // Виклик батьківського методу, щоб зареєструвати політики
        parent::registerPolicies();

        // Можна додати додаткові Gate, якщо потрібно:
        // Gate::define('manage-users', fn($user) => $user->isAdmin());
    }
}
