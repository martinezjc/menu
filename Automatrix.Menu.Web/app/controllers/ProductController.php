<?php
use Illuminate\Support\Facades\Cache;

class ProductController extends BaseController
{
	public function index($id)
	{
		$currentUser = Session::get ( 'UserSessionInfo' );
		
		$products = DB::table('Products')
							 ->join('ProductBase', 'Products.ProductBaseId', '=', 'ProductBase.ProductBaseId')
							 ->join('Company', 'ProductBase.CompanyId', '=', 'Company.id')
							 ->leftjoin('PlansProducts', 'Products.id', '=', 'PlansProducts.ProductId')
							 ->where('Products.DealerId', '=', $id)
		                     ->orderBy('Added', 'desc')
		                     ->orderBy('PlansProducts.Order', 'asc')
							 ->get(array('Products.id as ProductId',
							 			 'Products.DealerId', 
							 			 'Products.Bullets',
							 			 'Company.CompanyName',
							 			 'ProductBase.ProductName', 
							 			 'Products.DisplayName',
							 			 'Products.Cost',
							 		     'Products.SellingPrice',
							 			 DB::raw('CAST(ISNULL(PlansProducts.ProductId, 0) AS BIT) AS Added')));
		
		return \View::make ( 'product.index' )
                        ->with('dealerId', $id)
                        ->with ( 'products', $products )
                        ->with( 'currentUser', $currentUser )
                        ->with( 'title', 'Products' );
	}
	
	public function view($id, $productId)
	{
		$currentUser = Session::get ( 'UserSessionInfo' );
        $companies = DB::select(DB::raw("SELECT id, CompanyName FROM Company"));
        
        // TODO: Combine the second query and the fourth query seems like is the same filter.
        $companySelected = DB::select(DB::raw("  SELECT CompanyId 
                                                    FROM ProductBase 
        	                                        WHERE ProductBaseId = ( SELECT ProductBaseId 
                                                                            FROM Products 
        	                                      	                     WHERE id = " . $productId . ")"));
        
        $products = DB::select(DB::raw("SELECT ProductBaseId, ProductName FROM ProductBase WHERE CompanyId = " . $companySelected[0]->CompanyId));
        
        $productSelected = DB::select(DB::raw("SELECT ProductBaseId FROM Products WHERE id = " . $productId));
        
        $product = DB::table('Products')->where('id', '=', $productId)->first();

        $arrayBullets = array();
        if ($product->Bullets) {
            $arrayBullets = explode(',', $product->Bullets);
        }
        
        $optionsXML = simplexml_load_file("js/SelectParams.xml");
        $terms = $optionsXML->xpath("//ProductBase[@Id=" . $product->ProductBaseId . "]/terms");
        $types = $optionsXML->xpath("//ProductBase[@Id=" . $product->ProductBaseId . "]/types");
        $deductibles = $optionsXML->xpath("//ProductBase[@Id=" . $product->ProductBaseId . "]/deductibles");
        $terms = json_encode($terms);
        $terms = json_decode($terms, true);
        $types = json_encode($types);
        $types = json_decode($types, true);
        $deductibles = json_encode($deductibles);
        $deductibles = json_decode($deductibles, true);
        
        if($product->UseRangePricing)
        {
            $data = DB::table("ProductPrice")->where('ProductId', '=', $productId)
                ->orderBy('PricingType', 'ASC')
                ->orderBy('TermFrom', 'ASC')
                ->orderBy('TermTo', 'ASC')
                ->get();
            
            // Currently we only support 3 ranges the array must be filled by default
            
            $prices = array();
            
            if(count($data) > 0)
            {
                foreach ($data as $row)
                {
                    if(! array_key_exists($row->PricingType, $prices))
                        $prices[$row->PricingType] = array();
                    
                    $prices[$row->PricingType][] = $row;
                }
                
                $prices["Ranges"] = array();
                $prices["SellingPrice"] = array();
                
                // Read any of the items of the list to get the ranges and the pricing
                foreach ($prices["Gap Lease"] as $item)
                {
                    $range = new stdClass();
                    $range->TermFrom = $item->TermFrom;
                    $range->TermTo = $item->TermTo;
                    
                    $prices["Ranges"][] = $range;
                    $prices["SellingPrice"][] = $item->SellingPrice;
                }
            }
            else
            {
                $default = new stdClass();
                $default->TermFrom = "";
                $default->TermTo = "";
                $default->PricingCost = "";
                $default->SellingPrice = "";
                
                $prices["Ranges"] = array(
                    $default,
                    $default,
                    $default
                );
                $prices["Gap Lease"] = array(
                    $default,
                    $default,
                    $default
                );
                $prices["Gap Balloon"] = array(
                    $default,
                    $default,
                    $default
                );
                $prices["Gap Purchase"] = array(
                    $default,
                    $default,
                    $default
                );
                $prices["SellingPrice"] = array(
                    0,
                    0,
                    0
                );
            }
            
            $product->prices = $prices;
        }
        
		return \View::make('product.edit' )
                            ->with( 'dealerId', $product->DealerId )
                            ->with('companySelected', $companySelected[0]->CompanyId)
                            ->with('productSelected', $productSelected[0]->ProductBaseId)
							->with( 'companies', $companies )
							->with('products', $products)
							->with( 'arrayBullets', $arrayBullets )					
							->with( 'product', $product )
							->with('terms', $terms)
                            ->with('types', $types)
                            ->with('deductibles', $deductibles)
							->with( 'currentUser', $currentUser )
							->with( 'title', 'Edit product' );
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
