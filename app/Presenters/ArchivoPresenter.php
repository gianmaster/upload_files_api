<?php

namespace App\Presenters;

use App\Transformers\ArchivoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ArchivoPresenter
 *
 * @package namespace App\Presenters;
 */
class ArchivoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ArchivoTransformer();
    }
}
