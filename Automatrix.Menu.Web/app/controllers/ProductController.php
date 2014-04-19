<?php
use Illuminate\Support\Facades\Cache;

class ProductController extends BaseController
{
    /**
	 * Product Repository
	 * @var Product
	 */
	protected $product;
    
	public function __construct(Product $product)
	{
		$this->product = $product;
	}

	
	public function index()
	{
		// TODO: Add code here for listing the products	
	}
	
	public function view($id)
	{
		$companies = DB::table ( 'Company' )->get();
		$product = DB::table ( 'Products' )->where ( 'id', '=', $id )->first ();
		
		return \View::make('product.edit' )
                            ->with('dealerId', $product->DealerId)
							->with('companies', $companies )							
							->with('product', $product );
	}
    
    public function add($id)
    {
        $companies = DB::table ( 'Company' )->get();
		
		return \View::make('product.edit' )
                        ->with('dealerId', $id)
                        ->with('product', new Product())
                        ->with('companies', $companies);
    }
}
