<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OauthClientRepository;
use App\Entities\OauthClient;
use App\Validators\OauthClientValidator;

/**
 * Class OauthClientRepositoryEloquent
 * @package namespace App\Repositories;
 */
class OauthClientRepositoryEloquent extends BaseRepository implements OauthClientRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OauthClient::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
