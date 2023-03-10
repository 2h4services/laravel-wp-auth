<?php

namespace twoh4services\LaravelWpAuth\Providers;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use twoh4services\LaravelWpAuth\Client\WordPressApiClient;
use twoh4services\LaravelWpAuth\DTO\UserResponse;
use function App\Providers\dd;
use function App\Providers\env;

class WordPressUserProvider  implements  UserProvider
{
    protected WordPressApiClient $wordpressClient;

    public function __construct()
    {
        $this->wordpressClient = new WordPressApiClient(
            \env('WP_API_URL'),
        );

    }

    public function getModel()
    {
        return User::class;
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    protected function cacheKey($identifier):string {
        return __CLASS__ . $identifier;
    }
    public function retrieveById($identifier)
    {
        $user = Cache::get(
            $this->cacheKey($identifier)
        );
        if( $user ){
            return (new User())
                ->forceFill($user);
        }

        //must login
    }

    public function retrieveByToken($identifier, $token)
    {
        $user = $this->retrieveById($identifier);
        if( ! $user ){
            $r = $this->wordpressClient->get('/wp-json/wp/v2/me');
            return $this->userFactory($r);
        }

    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        //???
        dd(__LINE__);
        // TODO: Implement updateRememberToken() method.
    }

    public function retrieveByCredentials(array $credentials)
    {
        $r = $this->wordpressClient->getToken($credentials['email'], $credentials['password']);
        return $this->userFactory($r);
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        //Recheck token?
        Auth::setUser($user);
        return $this->retrieveById($user->id);

    }


    protected function userFactory(array $data) : User
    {
        $user =  ( new UserResponse(
            Arr::only($data,[
                'token',
                'ID',
                'user_email'
            ])
        ) )
            ->toModel();
        Cache::put($this->cacheKey($user->getAuthIdentifier()),$user->toArray(),9000);

        return  $user;
    }

}