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

        //$products = Products::paginate(5);
		
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
    	$currentUser = Session::get ( 'UserSessionInfo' );
    	$companies = DB::select(DB::raw("SELECT id, CompanyName FROM Company"));
        $products = DB::select(DB::raw("SELECT ProductBaseId, ProductName FROM ProductBase WHERE CompanyId = " . $companies[0]->id));

		return \View::make('product.create' )
                        ->with('dealerId', $id)
                        ->with('products', $products)
                        ->with('companies', $companies)
                        ->with('currentUser', $currentUser)
                        ->with('title', 'Add new product');
    }

    public function create()
    {
        $rangePricing = Input::get('rangePricing');
        $rangePricingData = Input::get('PricingArray');
        $UserSessionInfo = Session::get('UserSessionInfo');
        $ProductBaseId = Input::get('ProductBaseId');
        $ProductName = Input::get('ProductName');
        $CompanyId = Input::get('CompanyId');
        $DisplayName = Input::get('displayName');
        $ProductDescription = Input::get('ProductDescription');
        $Term = Input::get('Term');
        $Deductible = Input::get('Deductible');
        $VehiclePlan = Input::get('VehiclePlan');
        $Mileage = Input::get('Mileage');
        $TireRotation = Input::get('TireRotation');
        $Interval = Input::get('Interval');
        $IsTaxable = Input::get('IsTaxable');
        $Type = Input::get('Type');
        $Bullet1 = Input::get('bulletPoint1');
        $Bullet2 = Input::get('bulletPoint2');
        $Bullet3 = Input::get('bulletPoint3');
        $Bullet4 = Input::get('bulletPoint4');
        $Bullet5 = Input::get('bulletPoint5');
        $UsingWebService = Input::get('UsingWebService');
        $Disclaimer = Input::get('disclaimer');
        $Cost = Input::get('cost');
        $SellingPrice = Input::get('sellingPrice');
        $UseType = Input::get('UseType');
        $UseTerm = Input::get('UseTerm');
        $UseDeductible = Input::get('UseDeductible');
        $UseVehiclePlan = Input::get('UseVehiclePlan');
        $UseMileage = Input::get('UseMileage');
        $UseTireRotation = Input::get('UseTireRotation');
        $UseInterval = Input::get('UseInterval');
        $BrochureWidth = Input::get('BrochureWidth');
        $BrochureHeight = Input::get('BrochureHeight');
        $BrochureImage = Input::get('BrochureImage');
        $Bullets = $Bullet1 . ',' . $Bullet2 . ',' . $Bullet3 . ',' . $Bullet4 . ',' . $Bullet5;
        
        if($rangePricing == 1)
        {
            $UseRangePricing = true;
        }
        else
        {
            $UseRangePricing = false;
        }
        
        if($BrochureImage == '')
        {
            $id = DB::table('Products')->insertGetId(array(
                'ProductBaseId' => $ProductBaseId,
                'ProductName' => $ProductName,
                'DealerId' => $UserSessionInfo->DealerId,
                'DisplayName' => $DisplayName,
                'Bullets' => $Bullets,
                'Cost' => $Cost,
                'ProductDescription' => $ProductDescription,
                'SellingPrice' => $SellingPrice,
                'BrochureHeight' => $BrochureHeight,
                'BrochureWidth' => $BrochureWidth,
                'UsingWebService' => $UsingWebService,
                'Term' => $Term,
                'Type' => $Type,
                'Deductible' => $Deductible,
                'VehiclePlan' => $VehiclePlan,
                'Mileage' => $Mileage,
                'TireRotation' => $TireRotation,
                'Interval' => $Interval,
                'IsTaxable' => $IsTaxable,
                'UseTerm' => $UseTerm,
                'UseType' => $UseType,
                'UseDeductible' => $UseDeductible,
                'UseVehiclePlan' => $UseVehiclePlan,
                'UseMileage' => $UseMileage,
                'UseTireRotation' => $UseTireRotation,
                'UseInterval' => $UseInterval,
                'UseRangePricing' => $UseRangePricing
            ));
        }
        else
        {
            $id = DB::table('Products')->insertGetId(array(
                'ProductBaseId' => $ProductBaseId,
                'ProductName' => $ProductName,
                'DealerId' => $UserSessionInfo->DealerId,
                'DisplayName' => $DisplayName,
                'Bullets' => $Bullets,
                'Cost' => $Cost,
                'ProductDescription' => $ProductDescription,
                'SellingPrice' => $SellingPrice,
                'UsingWebService' => $UsingWebService,
                'BrochureHeight' => $BrochureHeight,
                'BrochureWidth' => $BrochureWidth,
                'BrochureImage' => $BrochureImage,
                'Term' => $Term,
                'Type' => $Type,
                'Deductible' => $Deductible,
                'VehiclePlan' => $VehiclePlan,
                'Mileage' => $Mileage,
                'TireRotation' => $TireRotation,
                'Interval' => $Interval,
                'IsTaxable' => $IsTaxable,
                'UseTerm' => $UseTerm,
                'UseType' => $UseType,
                'UseDeductible' => $UseDeductible,
                'UseVehiclePlan' => $UseVehiclePlan,
                'UseMileage' => $UseMileage,
                'UseTireRotation' => $UseTireRotation,
                'UseInterval' => $UseInterval,
                'UseRangePricing' => $UseRangePricing
            ));
        }
        
        foreach ($rangePricingData as $range => $RangeInfo)
        {
            foreach ($RangeInfo as $rangeData)
            {
                $empty = $this->verifyArray($rangeData, 'PricingCost');
            }
        }
        
        if($rangePricing == 1)
        {
            if($empty == false)
            {
                $this->insertPrices($id, $rangePricingData);
            }
        }
        
        return $id;
    }

    public function update()
    {
        $UserSessionInfo = Session::get('UserSessionInfo');
        $ProductId = Input::get('ProductId');
        $rangePricing = Input::get('rangePricing');
        $rangePricingData = Input::get('PricingArray');
        $ProductBaseId = Input::get('ProductBaseId');
        $ProductName = Input::get('ProductName');
        $DisplayName = Input::get('displayName');
        $ProductDescription = Input::get('ProductDescription');
        $Term = Input::get('Term');
        $Deductible = Input::get('Deductible');
        $VehiclePlan = Input::get('VehiclePlan');
        $Mileage = Input::get('Mileage');
        $TireRotation = Input::get('TireRotation');
        $Interval = Input::get('Interval');
        $IsTaxable = Input::get('IsTaxable');
        $Type = Input::get('Type');
        $UsingWebService = Input::get('UsingWebService');
        $Bullet1 = Input::get('bulletPoint1');
        $Bullet2 = Input::get('bulletPoint2');
        $Bullet3 = Input::get('bulletPoint3');
        $Bullet4 = Input::get('bulletPoint4');
        $Bullet5 = Input::get('bulletPoint5');
        $BrochureImage = Input::get('BrochureImage');
        $Disclaimer = Input::get('disclaimer');
        $Cost = Input::get('cost');
        $SellingPrice = Input::get('sellingPrice');
        $UseType = Input::get('UseType');
        $UseTerm = Input::get('UseTerm');
        $UseDeductible = Input::get('UseDeductible');
        $BrochureWidth = Input::get('BrochureWidth');
        $BrochureHeight = Input::get('BrochureHeight');
        $UseVehiclePlan = Input::get('UseVehiclePlan');
        $UseMileage = Input::get('UseMileage');
        $UseTireRotation = Input::get('UseTireRotation');
        $UseInterval = Input::get('UseInterval');
        $isId = false;
        $Bullets = $Bullet1 . ',' . $Bullet2 . ',' . $Bullet3 . ',' . $Bullet4 . ',' . $Bullet5;
        
        $ProductUpdated = DB::table('Products')->where('id', $ProductId)->update(array(
            'ProductBaseId' => $ProductBaseId,
            'ProductName' => $ProductName,
            'DealerId' => $UserSessionInfo->DealerId,
            'DisplayName' => $DisplayName,
            'ProductDescription' => $ProductDescription,
            'Bullets' => $Bullets,
            'Cost' => $Cost,
            'UsingWebService' => $UsingWebService,
            'SellingPrice' => $SellingPrice,
            'BrochureHeight' => $BrochureHeight,
            'BrochureWidth' => $BrochureWidth,
            'BrochureImage' => $BrochureImage,
            'Term' => $Term,
            'Type' => $Type,
            'Deductible' => $Deductible,
            'VehiclePlan' => $VehiclePlan,
            'Mileage' => $Mileage,
            'TireRotation' => $TireRotation,
            'Interval' => $Interval,
            'IsTaxable' => $IsTaxable,
            'UseTerm' => $UseTerm,
            'UseType' => $UseType,
            'UseRangePricing' => $rangePricing,
            'UseDeductible' => $UseDeductible,
            'UseVehiclePlan' => $UseVehiclePlan,
            'UseMileage' => $UseMileage,
            'UseTireRotation' => $UseTireRotation,
            'UseInterval' => $UseInterval
        ));
        
        return "The product info has been updated";
    }

    public function insertRangePricing()
    {
        $ProductId = Input::get('ProductId');
        $rangePricing = Input::get('rangePricing');
        $rangePricingData = Input::get('PricingArray');
        $ProductBaseId = Input::get('ProductBaseId');
        $Type = Input::get('Type');
        // Always delete from product price this will guarrantee we don't leave any garbage in the table
        // TODO: it should only be deleted when the product is GAP
        if($ProductBaseId == 11)
        {
            DB::table("ProductPrice")->where('ProductId', '=', $ProductId)->delete();
        }
        
        if($ProductBaseId == 11)
        {
            foreach ($rangePricingData as $range => $RangeInfo)
            {
                foreach ($RangeInfo as $rangeData)
                {
                    $empty = $this->verifyArray($rangeData, 'PricingCost');
                }
            }
            
            if($rangePricing == 1)
            {
                $ProductUpdated = DB::table('Products')->where('id', $ProductId)->update(array(
                    'UseRangePricing' => $rangePricing,
                    'UsingWebService' => 0,
                    'Type' => $Type
                ));
                if($empty == false)
                {
                    $this->insertPrices($ProductId, $rangePricingData);
                }
            }
        }
    }

    private function verifyArray($array, $key)
    {
        if(array_key_exists($key, $array))
        {
            if($array[$key] == 'NaN')
            {
                return true;
            }
        }
    }

    private function insertPrices($productId, $prices)
    {
        foreach ($prices as $rows)
        {
            foreach ($rows as $row)
            {
                $result = DB::table('ProductPrice')->insert(array(
                    'ProductId' => $productId,
                    'TermFrom' => $row['TermFrom'],
                    'TermTo' => $row['TermTo'],
                    'PricingType' => $row['PricingType'],
                    'PricingCost' => $row['PricingCost'],
                    'SellingPrice' => $row['SellingPrice']
                ));
            }
        }
    }

    function delete($id ,$productId) 
    {
    	$DeletePrices = DB::table('ProductPrice')->where('ProductId', '=', $productId)->delete();
        $DeletedBullet = DB::table('ProductDetail')->where('ProductId', '=', $productId)->delete();
        $DeletedProduct = DB::table('PlansProducts')->where('ProductId', '=', $productId)->delete();
        $DeletedProduct2 = DB::table('Products')->where('id', '=', $productId)->delete();
        
        return Redirect::to('dealers/' . $id . '/products');
    }
}
