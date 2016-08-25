<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\CatalogoCreateRequest;
use App\Http\Requests\CatalogoUpdateRequest;
use App\Repositories\CatalogoRepository;
use App\Validators\CatalogoValidator;


class CatalogosController extends Controller
{

    /**
     * @var CatalogoRepository
     */
    protected $repository;

    /**
     * @var CatalogoValidator
     */
    protected $validator;

    public function __construct(CatalogoRepository $repository, CatalogoValidator $validator)
    {
        $this->middleware('cors');
        $this->repository = $repository;
        $this->validator  = $validator;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $catalogos = $this->repository->all();

        return response()->json($catalogos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CatalogoCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CatalogoCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $catalogo = $this->repository->create($request->all());

            $response = [
                'message' => 'Catalogo created.',
                $catalogo->toArray(),
            ];

            return response()->json($response);

        } catch (ValidatorException $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->getMessageBag()
            ]);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $catalogo = $this->repository->find($id);

        return response()->json($catalogo);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $catalogo = $this->repository->find($id);

        return $catalogo;

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  CatalogoUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(CatalogoUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $catalogo = $this->repository->update($id, $request->all());

            $response = [
                'message' => 'Catalogo updated.',
                $catalogo->toArray(),
            ];

            return response()->json($response);

        } catch (ValidatorException $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->getMessageBag()
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        return response()->json([
            'message' => 'Catalogo deleted.',
            'deleted' => $deleted,
        ]);
    }


    public function getItems($id){
        $items = $this->repository->find($id);
        if($items['data']['items']){
            return response()->json(array('data' => $items['data']['items']));
        }
        return response()->json(array('data' => []));
    }
}
