<?php

namespace App\Repositories;


use App\Entities\Archivo;
use App\Validators\ArchivoValidator;
use App\Presenters\ArchivoPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ArchivoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ArchivoRepositoryEloquent extends BaseRepository implements ArchivoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Archivo::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ArchivoValidator::class;
    }


    public function presenter()
    {
        return ArchivoPresenter::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
