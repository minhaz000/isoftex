<?php

namespace Webkul\Shop\Http\Controllers;

use Webkul\Shop\Http\Controllers\Controller;
use Webkul\Core\Repositories\SliderRepository;
use Webkul\Product\Repositories\SearchRepository;

class HomeController extends Controller
{
    /**
     * Slider repository instance.
     *
     * @var \Webkul\Core\Repositories\SliderRepository
     */
    protected $sliderRepository;

    /**
     * Search repository instance.
     *
     * @var \Webkul\Core\Repositories\SearchRepository
     */
    protected $searchRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Core\Repositories\SliderRepository  $sliderRepository
     * @param  \Webkul\Product\Repositories\SearchRepository  $searchRepository
     * @return void
     */
    public function __construct(
        SliderRepository $sliderRepository,
        SearchRepository $searchRepository
    ) {
        $this->sliderRepository = $sliderRepository;

        $this->searchRepository = $searchRepository;

        parent::__construct();
    }

    /**
     * Loads the home page for the storefront.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $host = request()->getHttpHost(); 
        $premittedHost =  "127.0.0.1:8000";

      if($host === $premittedHost) {


        $sliderData = $this->sliderRepository->getActiveSliders();
        return view($this->_config['view'], compact('sliderData'));
    }
    else{
        return"this site only permitted ".$premittedHost." <br/> but you are using".$host;
    }
    }

    /**
     * Loads the home page for the storefront if something wrong.
     *
     * @return \Exception
     */
    public function notFound()
    {
        abort(404);
    }

    /**
     * Upload image for product search with machine learning.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload()
    {
        return $this->searchRepository->uploadSearchImage(request()->all());
    }
}
