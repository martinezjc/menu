<?php
use Illuminate\Support\Facades\Cache;

class PlanController extends BaseController
{
    /**
     * Product Repository
     *
     * @var Product
     */
    protected $Product;
    protected $SessionWebService;

    /**
     * The layout that should be used for responses.
     */
    protected $layout = 'layouts.plan';

    public function __construct(Product $Product)
    {
        $this->Product = $Product;
    }

	
	public function index()
	{

		// Variable
		$URLSession = new stdClass();
        $arrayProductsFailure = array();
        $arrayProductsMatchingRateFail = array();
        $param = Input::get('Deal');


        ## -----------  Access validations -------------------------##

        if($param != ''){
            $URLSession->uri = URL::current() . '/?Deal=' .$param;
        }else{
            $URLSession->uri = 'home';
        }

        // Verify if this var is necessary
        Session::put('URLSession', $URLSession);

        $UserSessionInfo = Session::get('UserSessionInfo');
        if(empty($UserSessionInfo->Username))
        {
            $LastURL = 'home';
            return Redirect::to('login')->with('LastURL', $LastURL);
        }


         ## -----------  Get Setting for current dealer -------------------------##
        
        $settings = DB::table('Dealer')->where('DealerId', '=', $UserSessionInfo->DealerId)->first();

        // if empty settings redirect to another page
        if (!$settings) {
        	//redirect to config settings
        	if(! (empty($UserSessionInfo->DealerId)))
            {
                return Redirect::to('settings-page');
            }
            //Only application admin can enter here.
            else
            {
                return Redirect::to('dealer-settings');
            }
        }

        # Variable
        $taxRate = $settings->TaxRate;
        $settings->IsPDF = 0; // use for choose webservice URL in getproxy function
        $EmptyDeal = 0;
        $deal = new Deal();

        if (!empty($param)) {        	
        	try {
        		$response = file_get_contents($settings->URL . $param);

        		$response = str_replace('"', '', $response);
        		$response = str_replace('{', '', $response);
        		$response = str_replace('}', '', $response);
        		$response = explode(',', $response);
        		foreach ($response as $lineNum => $line)
        		{
        			list ($key, $value) = explode(":", $line);
        			$newArray[$key] = $value;
        		}

        		$deal->Deal = $newArray[$settings->Deal];
    			$deal->BeginningOdometer = round($newArray[$settings->BeginningOdometer]);
                $deal->VIN = $newArray[$settings->Vin]; // TODO: Read VIN from database configuration
                $deal->Year = $newArray[$settings->Year];
                $deal->Make = $newArray[$settings->Make];
                $deal->Model = $newArray[$settings->Model];
                $deal->Trim = $newArray[$settings->Trim];
                $deal->FinancedAmount = $newArray[$settings->FinancedAmount];
                $deal->APR = $newArray[$settings->APR];
                $deal->Term = $newArray[$settings->Term];
                $deal->DownPayment = $newArray[$settings->DownPayment];
                $deal->FirstName = $newArray[$settings->FirstNameParameter];
                $deal->MiddleName = $newArray[$settings->MiddleNameParameter];
                $deal->LastName = $newArray[$settings->LastNameParameter];
                $deal->Address1 = $newArray[$settings->Address1];
                $deal->Address2 = $newArray[$settings->Address2];
                $deal->City = $newArray[$settings->City];
                $deal->State = $newArray[$settings->State];
                $deal->StateCode = $newArray[$settings->StateCode];
                $deal->ZipCode = $newArray[$settings->ZipCode];
                $deal->Country = $newArray[$settings->Country];
                $deal->CountryCode = $newArray[$settings->CountryCode];
                $deal->Telephone = $newArray[$settings->Telephone];
                $deal->Email = $newArray[$settings->Email];
                try
                {
                	$deal->BasePayment = $newArray[$settings->BasePayment];
                }
                catch (Exception $e)
                {
                }
                $deal->Buyer = $newArray[$settings->Buyer];
                $deal->CoBuyer = $newArray[$settings->CoBuyer];
                
                $deal->LienHolderName = $newArray[$settings->LienHolderName];
                $deal->LienHolderAddress = $newArray[$settings->LienHolderAddress];
                $deal->LienHolderCountry = $newArray[$settings->LienHolderCountry];
                $deal->LienHolderCity = $newArray[$settings->LienHolderCity];
                $deal->LienHolderState = $newArray[$settings->LienHolderState];
                $deal->LienHolderZip = $newArray[$settings->LienHolderZip];

                $deal->LienHolderEmail = $newArray[$settings->LienHolderEmail];
                $deal->LienHolderPhone = $newArray[$settings->LienHolderPhone];
                $deal->LienHolderFax = $newArray[$settings->LienHolderFax];
                $deal->LienHolderType = $newArray[$settings->LienHolderType];
                $deal->LienHolderContact = $newArray[$settings->LienHolderContact];
                
                $deal->Disclosure = $settings->Disclosure;
                $deal->DealerLogo = $settings->DealerLogo;
                $deal->DealerName = $settings->DealerName;
                
                $deal->SalesPrice = $newArray[$settings->VehiclePurchasePrice];
                $deal->VehiclePurchaseDate = $newArray[$settings->VehiclePurchaseDate];

                $deal->TaxRate = $taxRate;
                
                $EmptyDeal = 1;
                $BeginningOdometer = $deal->BeginningOdometer;
                Session::put('WebServiceInfo', $deal);
        		
        	} catch (Exception $e) {
        		echo $e; 
                echo "<br>";
        	}
        }


   		##---------------- Get Product info for display --------------- ##

        #verify if this var is necessary
   		$data = array();
            
        $products = DB::table('Products')->join('PlansProducts', 'Products.id', '=', 'PlansProducts.ProductId')
            ->join('ProductBase', 'Products.ProductBaseId', '=', 'ProductBase.ProductBaseId')
            ->where('PlansProducts.DealerId', '=', $UserSessionInfo->DealerId)
            ->where('Products.DealerId', '=', $UserSessionInfo->DealerId)
            ->orderBy('PlansProducts.Order', 'asc')
            //->get(); 
            ->get(array(
                "Products.id",
                "Products.ProductBaseId",
                "Products.DealerId",
                "Products.DisplayName",
                "Products.ProductDescription",
                "Products.IsTaxable",
                "Products.SellingPrice",
                "Products.UsingWebService",
                "Products.Bullets",
                "Products.BrochureImage",
                "Products.BrochureHeight",
                "Products.BrochureWidth",
                "Products.UseTerm",
                "Products.UseType",
                "Products.UseDeductible",
                "Products.UseTireRotation",
                "Products.UseInterval",
                "Products.UseRangePricing",
                "Products.VehiclePlan",
                "Products.Type",
                "Products.Term",
                "Products.Deductible",
                "Products.Mileage",
                "Products.TireRotation",
                "Products.Interval",
                "ProductBase.CompanyId",
                "ProductBase.ProductName",
                "ProductBase.ProductType",
                "PlansProducts.ProductId"
            ));
        
        #verify if all data are necessary
        $rangePricing = DB::table('ProductPrice')->get();

        #variables
        $productRates = array();
        $productRatesFull = array();
        $proxies = array();
        $proxy = null;
        $key = null;

        $FailWebservice = new stdClass();
        $FailWebservice->flag = 0;
        $FailWebservice->message = '';
        $FailWebservice->failureProductRates = array();
        $FailWebservice->failMatchingRate = array();


        ##---------------- Call remote webservice to get product information  --------------- ##

        if ($EmptyDeal == 1) {
        	
        	Session::put('settings', $settings);
        	foreach ($products as $product) {
        		try {

        			##---------------- Product using webservice  --------------- ##
        			if ($product->UsingWebService) {
    				    # read name of product in case fail
                        $FailWebservice->product = $product->DisplayName;
                        $key = "key" . $product->CompanyId;                        
                        $proxy = $this->getProxy($settings, $product);
                        $proxies[$key] = $proxy;

                        $CodeResult = DB::table('SettingsTable')->where('CompanyId', '=', $product->CompanyId)
                        ->where('DealerId', '=', $product->DealerId)
                        ->first(array("DealerCode"));
                        
                        # Execute request to get pricing
                        $rates = $this->getProductDetail($proxy, $product, $deal, $CodeResult->DealerCode, 0, 0, 0);
                                                    
                        
                        ##------  US Warranty Products ------ ##
                        if ($product->CompanyId == 1) {
                        	$productRates["product" . $product->id] = $this->getProductRates($product, $rates);
                            $productRatesFull["product" . $product->id] = $rates;

                            // Check if is possible to get the matching rate from the webservice response
	                        $rateIndex = $this->getMatchingRate($product, $rates);
	                        $rate = $rateIndex[0];
	                        $product->OrderNumber = $rateIndex[1];

	                        if ( $rateIndex[2] == 0 ) {
	                            array_push($arrayProductsMatchingRateFail, array('ProductId'=> $product->ProductId, 'Message' => "The response didn't match the default values."));
	                        }

	                       if(($product->ProductBaseId == 2 || $product->ProductBaseId == 4)&& $product->OrderNumber == 0){
	                            $product->Type = $rate['CoverageDesc'];
	                            $product->Term = $rate['MonthTerm'];
	                            $product->Mileage = (int)$rate['MileageTerm'];
	                            if (array_key_exists('Deductible', $rate)) {
	                                $product->Deductible = $rate['Deductible'];
	                            }
	                            if(array_key_exists('Interval', $rate))
	                            {
	                                $product->Interval = $rate['Interval'];
	                            }
	                            if(array_key_exists('TiresMileageInterval', $rate))
	                            {
	                                $product->TireRotation = $rate['TiresMileageInterval'];
	                            }	                            
	                        }

	                        $product->SellingPrice = (float) str_replace(',', '', $rate['FiledAmount']);
                        }
                        ##------ Protective  Products ------ ##
                        if ($product->CompanyId == 2) {
                        	$rates = $rates['GetRatesResult']['Automobiles']['AutomobileRateQuoteResponse']['AutomobileRateQuotes'];
                        	$productRates["product" . $product->id] = $this->getProductRates($product, $rates);
                            $productRatesFull["product" . $product->id] = $rates;

                            // Check if is possible to get the matching rate from the webservice response
                            if($product->ProductBaseId == 11){
                                $product->Term = $deal->Term;
                            }
                            $rateIndex = $this->getMatchingRate($product, $rates);
                            $rate = $rateIndex[0];
                            $product->OrderNumber = $rateIndex[1];

                            if ( $rateIndex[2] == 0 ) {
                                array_push($arrayProductsMatchingRateFail, array('ProductId'=> $product->ProductId, 'Message' => "The response didn't match the default values."));
                            }

                            if($product->ProductBaseId == 12 )
                            {
                                $product->Type = $rate['Coverage'];
                                $product->Term = $rate['CoverageTermMonths'];
                                $product->Mileage = $rate['CoverageTermMiles'];
                                $product->Deductible = $rate['Deductible'];
                            }

                            $product->SellingPrice = (float) str_replace(',', '', $rate['RetailPrice']);

                        }
                        ##------  Road Vantage Products ------ ##
                        if ($product->CompanyId == 3) {
                        	# code...
                        }
        			}

        			##---------------- Product using range pricing  --------------- ##
        			if($product->UseRangePricing == 1)
                        {
                            $key = "key" . $product->CompanyId;
                            $proxy = $this->getProxy($settings, $product);
                            $proxies[$key] = $proxy;
                            
                            $CodeResult = DB::table('SettingsTable')->where('CompanyId', '=', $product->CompanyId)
                            ->where('DealerId', '=', $product->DealerId)
                            ->first(array("DealerCode"));
                            
                            // Execute request to get pricing
                            $rates = $this->getProductDetail($proxy, $product, $deal, $CodeResult->DealerCode, 0, 0, 0);                            
                            $product->UsingWebService = 1;
                            $data = array();
                            
                            if(! (empty($deal->Term))){
                                $product->Term = $deal->Term;
                            }
                            
                            $index = 0;
                            foreach ($rangePricing as $key => $rangePricingValue)
                            {

                                $temp = array();
                                if($product->id == $rangePricingValue->ProductId){
                                    $temp['Term'] = $rangePricingValue->TermTo;
                                    $temp['SellingPrice'] = $rangePricingValue->SellingPrice;
                                    $temp['Type'] = $rangePricingValue->PricingType;
                                    $temp['OrderNumber'] = $index;
                                    
                                    $data[] = $temp;
                                    
                                    if($product->Type == 'None' || $product->Type == 'none'){
                                        $product->Type = $rangePricingValue->PricingType;
                                    }                                    
                                    if(($product->Type == $rangePricingValue->PricingType) && ($product->Term > $rangePricingValue->TermFrom) && ($product->Term <= $rangePricingValue->TermTo)){
                                        $product->SellingPrice = $rangePricingValue->SellingPrice;
                                        $product->OrderNumber = $index;
                                    }
                                }
                                $index ++;
                            } // end for each
                            
                            $productRates["product" . $product->id] = $data;
                            $productRatesFull["product" . $product->id] = $rates;
                        } // end if Range Pricing

        		} catch (Exception $e) {
        			array_push($arrayProductsFailure, array('ProductId'=> $product->ProductId, 'Message' => $this->GetReasonFailWebService( $product->ProductBaseId, $product->ProductName, $deal ) ));
                    echo $e;
                    echo "<br>";
                    $FailWebservice->flag = 1;
        		} 
        	} #end foreach

        	Session::put('productRates', $productRates);
            Session::put('productRatesFull', $productRatesFull);
            $FailWebservice->failMatchingRate = $arrayProductsMatchingRateFail; 

            if ($FailWebservice->flag == 1) {
				$FailWebservice->failureProductRates = $arrayProductsFailure;
            }
        	//print_r(json_encode($productRates));
        } # end call remote webservice
        
        ##---------------- Return response  --------------- ##

		// var used in layout
		$this->layout->with('ShowPrintButton', false);
		$this->layout->with('ShowMenuPrintButton', false);

		$this->layout->content = \View::make('plan.index')
								->with('Products', $products)
				                ->with('Settings', $settings)
				                ->with('FailWebservice', $FailWebservice)
				                ->with('taxRate', $taxRate)
				                ->with('deal', $deal);

	}

	private function getProductRates($product, $rates)
	{
		$data = array();
		$counter = 0;
		##--  US Warranty Products 
        if ($product->CompanyId == 1) {

        	$index = 'Rate';
        	$type = 'CoverageDesc';
        	$term = 'MonthTerm';
        	$deductible = 'Deductible';
            $mileage = 'MileageTerm';
            $interval = 'Interval';
            $tireRotation = 'TiresMileageInterval';
            $sellingPrice = "FiledAmount";
            $orderNumber = 'OrderNumber';
            $dissapearing = 'DisappearingDeductible';
        }
        ##-- Protective  Products 
        if ($product->CompanyId == 2) {
        	
        	$index = 'AutomobileRateQuote';
            $type = 'Coverage';
            $term = 'CoverageTermMonths';
            $deductible = 'Deductible';            
            $mileage = 'CoverageTermMiles';
            $interval = 'Interval';
            $tireRotation = 'TiresMileageInterval';
            $sellingPrice = "RetailPrice";
            $orderNumber = 'OrderNumber';
            $dissapearing = 'DisappearingDeductible';
        }
        ##-- Road Vantage Products 
        if ($product->CompanyId == 3) {
        	
        }

        foreach ($rates[$index] as $key => $rate) {
        	$temp = array();
        	if (array_key_exists($type, $rate)) {
        		 $temp['Type'] = $rate[$type];
        	}
        	if (array_key_exists($term, $rate)) {
        		 $temp['Term'] = $rate[$term];
        	}
        	if (array_key_exists($deductible, $rate)) {
        		 $temp['Deductible'] = $rate[$deductible];
        	}
        	if (array_key_exists($type, $rate)) {
        		 $temp['Type'] = $rate[$type];
        	}
        	if (array_key_exists($type, $rate)) {
        		 $temp['Type'] = $rate[$type];
        	}

        	if($product->ProductBaseId == 4){
	            if(array_key_exists($tireRotation, $rate)){
	                $temp['TireRotation'] = $rate[$tireRotation];
	            }	            
	            if(array_key_exists($interval, $rate)){
	                $temp['Interval'] = $rate[$interval];
	            }
            }

            if(array_key_exists($mileage, $rate)){
            	if ($product->CompanyId == 1) {
            		$temp['Mileage'] = str_replace(',', '', $rate[$mileage]);
                	$temp['Mileage'] = (int)$temp['Mileage'] / (int)1000;
            	}else{
            		$temp['Mileage'] = $rate[$mileage];
            	}
                
            }

            if(array_key_exists($dissapearing, $rate)){
                $temp['DisappearingDeductible'] = $rate[$dissapearing];
            }

            if(array_key_exists($sellingPrice, $rate)){
                $temp['SellingPrice'] = $rate[$sellingPrice];
            }     

            if (array_key_exists($orderNumber, $rate)) {
        		 $temp['OrderNumber'] = $rate[$orderNumber];
        	}else{        		
                 $temp['OrderNumber'] = $counter;
        	}

            $counter++;
        	$data[] = $temp;

        } # end for each

        return $data;

	}

	 private function getMatchingRate($product, $rates)
    {
        $index = 0;
        
        if($product->CompanyId == 1)
        { // US Warranty
            
            $eval = 0;
            foreach ($rates['Rate'] as $key => $rate)
            {
                $term = 'MonthTerm';
                $type = 'CoverageDesc';
                $mileage = 'MileageTerm';
                $deductible = 'Deductible';
                $interval = 'Interval';
                $tireRotation = 'TiresMileageInterval';
                
                // print_r($product);
                
                if ($product->Type== 'none' || $product->Type== 'None') {
                    $product->Type = $rate[$type];
                }
                
                if($product->ProductName == 'Total Lost Protection (GAP)')
                {
                    $term = 'EndMonthTerm';
                }

                # Case 1 : 
                # all option in use, except deductible
                # Deductible not exist in rate response
                # e.g -> US Maintenance
                if ($product->UseType == 1 && $product->UseTerm == 1 && $product->UseDeductible != 1 && $product->UseMileage == 1 && $product->UseInterval == 1  && $product->UseTireRotation == 1 ) {
                    
                    #  Prepare format data for match
                    $rate[$mileage] = str_replace(',', '', $rate[$mileage]);    
                    $Mileage = $product->Mileage * 1000; 
                    $rate[$interval] = rtrim($rate[$interval]);

                    if ($product->Type == $rate[$type] && $product->Term == $rate[$term]  && $Mileage == $rate[$mileage] && $product->Interval == $rate[$interval] && number_format($product->TireRotation, 0, '.', ',') == $rate[$tireRotation]) {
                       return array($rate,$index,1);
                    }
                }

                # Case 2: 
                # type enable, term enabled, deductible enabled, mileage enabled,
                # tire disable, interval disabled
                # e.g -> US Vsc
                if ($product->UseType == 1 && $product->UseTerm == 1 && $product->UseDeductible == 1 && $product->UseMileage == 1 && $product->UseInterval != 1  && $product->UseTireRotation != 1 ) {
                    #  Prepare format data for match
                    $rate[$mileage] = str_replace(',', '', $rate[$mileage]);    
                    $Mileage = $product->Mileage * 1000; 

                    if ($product->Type == $rate[$type] && $product->Term == $rate[$term] && $product->Deductible == $rate[$deductible] && $Mileage == $rate[$mileage]) {
                       return array($rate,$index,1);
                    }
                }

                # Case 3: 
                # type enable, term enabled, deductible enabled
                # mileage disabled, tire disable, interval disabled
                # e.g -> ?
                if ($product->UseType == 1 && $product->UseTerm == 1 && $product->UseDeductible == 1 && $product->UseMileage != 1 && $product->UseInterval != 1  && $product->UseTireRotation != 1 ) {
                    if ($product->Type == $rate[$type] && $product->Term == $rate[$term] && $product->Deductible == $rate[$deductible] ) {
                       return array($rate,$index,1);
                    }
                }

                # Case 4: 
                # type enable, term enabled, 
                # deductible disable, mileage disabled, tire disable, interval disabled
                # e.g -> US Road Hazard US Key
                if ($product->UseType == 1 && $product->UseTerm == 1 && $product->UseDeductible != 1 && $product->UseMileage != 1 && $product->UseInterval != 1  && $product->UseTireRotation != 1 ) {
                    if ($product->Type == $rate[$type] && $product->Term == $rate[$term]) {
                       return array($rate,$index,1);
                    }
                }

                # Case 5: 
                # type disable, type only can disable if all rates type are same and 
                # rates term unique (dont duplicate). e.g -> US DENT
                if ($product->UseType != 1 && $product->UseTerm == 1 && $product->UseDeductible != 1 && $product->UseMileage != 1 && $product->UseInterval != 1  && $product->UseTireRotation != 1 ) {
                    if ($product->Term == $rate[$term]) {
                       return array($rate,$index,1);
                    }
                   
                }

                $index ++;
            } // end for each
              
            
            // By default returns the first rate
            return array(
                $rates['Rate'][0],0,0);
        }
        
        if($product->CompanyId == 2) // Protective
        {
            $lastRateTerm = 0;
            foreach ($rates['AutomobileRateQuote'] as $key => $rate)
            {
                $term = 'CoverageTermMonths';
                $type = 'Coverage';
                $mileage = 'CoverageTermMiles';
                $deductible = 'Deductible';
                
                
                # CAse 1: USe Range term to match
                # Only applicable  for Protective GAP
                if($product->ProductBaseId == 11)
                {
                    if ( ($product->Type == $rate[$type]) && ( $rate[$term] >=1 || $rate[$term] <= 60 ) ){
                        return array($rate,$index,1);
                    } 
                    elseif ( ($product->Type == $rate[$type]) && ( $rate[$term] >=61 || $rate[$term] <= 72 ) ){
                        return array($rate,$index,1);
                    } 
                    elseif ( ($product->Type == $rate[$type]) && ( $rate[$term] >= 73 || $rate[$term] <= 84 ) ){
                        return array($rate,$index,1);  
                    }                    
                    if($product->Type == $rate[$type] && $product->Term > $lastRateTerm && $product->Term <= $rate[$term]){
                        return array($rate,$index,1);
                    }
                }
                
                # Case 2: 
                # type enabled, term enabled, mileage enabled, deductible enabled
                # e.g -> Protective VSC
                if ($product->UseType == 1 && $product->UseTerm == 1 && $product->UseMileage == 1 && $product->UseDeductible == 1 ) {
                     if ($product->Type == $rate[$type] && $product->Term == $rate[$term] && $product->Mileage == $rate[$mileage] && $product->Deductible == $rate[$deductible]) {
                         return array($rate,$index,1);
                     }
                }

                # Case 3: 
                # type enabled, term enabled, mileage enabled
                # deductible disabled. e.g -> Protective VSC
                if ($product->UseType == 1 && $product->UseTerm == 1 && $product->UseMileage == 1 && $product->UseDeductible != 1 ) {
                     if ($product->Type == $rate[$type] && $product->Term == $rate[$term] && $product->Mileage == $rate[$mileage]) {
                         return array($rate,$index,1);
                     }
                }
                
                $lastRateTerm = $rate[$term];
                $index ++;
            }
            // By Default returns the first rate
            return array(
                $rates['AutomobileRateQuote'][0],
                0,
                0
            );
        }
        
        if($product->CompanyId == 3) // Road Vantage
        {
            if(! (is_array($rates->Plan->RateClassMoneys->RateClassMoney))){
                $rate = $rates->Plan->RateClassMoneys->RateClassMoney;
                $index = $rate->TermMile->TermId;
                return array($rate,$index,1);
            }
            
            foreach ($rates->Plan->RateClassMoneys->RateClassMoney as $key => $rate){
                $term = $rate->TermMile->Term;
                $mileage = $rate->TermMile->Mileage;
                $deductible = $rate->Deductible->DeductAmt;
                $type = $rates->Plan->Plan->PlanDescription;
                $index = $rate->TermMile->TermId;
                
                if($product->Term == $term){
                    return array($rate,$index,1);
                }
                $index ++;
            }
            // By Default returns the first rate
            $rates = $rates->Plan->RateClassMoneys->RateClassMoney{0};
            return array($rates, $rates->TermMile->TermId,0);
        }
        return null;
    }

    /**
     * Get details from webservice
     *
     * @param string $product            
     * @param Deal $deal            
     * @param DealerCode $dealercode            
     * @param array $settings            
     * @return array
     */
    private function getProductDetail($proxy, $product, $deal, $dealercode, $productOptions, $productRates, $type) // "WDBNG70J93A337105"
    {
        /*
         * var type of request get price of product = 0 get contract = 1
         */
        $parameters = DB::table('SettingsTable')->select('WebServiceUsername', 'WebServicePassword', 'DealerCode')
            ->where('CompanyId', '=', $product->CompanyId)
            ->first();
        
        $deal->Username = $parameters->WebServiceUsername;
        $deal->Password = $parameters->WebServicePassword;
        
        $response = $proxy->execute(new Api\Services\Request(array(
            "product" => $product,
            "deal" => $deal,
            "dealercode" => $dealercode,
            "productOptions" => $productOptions,
            "productRates" => $productRates,
            "type" => $type
        )));
        
        return $response;
    }

    /**
     * Create a new instance of the webservice proxy for the company associated with the product
     *
     * @param
     *            object
     * @param
     *            Product
     * @return ServiceProxy
     */
    private function getProxy($dealer, $product)
    {
        // We need the company information to process the request
        // $company = DB::table ( 'Company' )->where('id', '=', $product->CompanyId)->first();
        try {
            if($product->CompanyId == 3 && ($dealer->IsPDF == 1))
            {
                $company = DB::table('Company')->select('id', 'CompanyName', 'URL2 as URL')
                    ->where('id', '=', $product->CompanyId)
                    ->first();
            }
            else
            {
                $company = DB::table('Company')->select('id', 'CompanyName', 'URL')
                    ->where('id', '=', $product->CompanyId)
                    ->first();
            }

            $parameters = DB::table('SettingsTable')->select('WebServiceUsername', 'WebServicePassword', 'DealerCode')
                          ->where('CompanyId', '=', $company->id)
                          ->first();

            $proxy = Api\Services\ServiceProxyFactory::create(new Settings($dealer, $company, $parameters, $product), $company);
            
            return $proxy;
        } catch (Exception $e) {
            echo $e;
        }
    }

     private function GetReasonFailWebService($productBaseId, $name, $deal)
    {
        $message =  $name.' is not available! try again';

        if ( $deal->BeginningOdometer > 113999 ) {
            $message = $name.' not allowed vehicles with more than 113999 miles.';
        } elseif ( $deal->BeginningOdometer == '' ) {
            $message = 'Beginning Odometer cannot be empty';
        //} elseif (  ) {
        } else {
            $message = 'Could not retrieve rates.';
        }

        return $message;
    }

	
	public function disclosure()
	{
		$WebService = Session::get('WebServiceInfo');
        $UserSessionInfo = Session::get('UserSessionInfo');
        try{
            if(empty($UserSessionInfo->Username)){
                return Redirect::to('home');
            }
        }catch (Exception $e){
            return Redirect::to('home');
        }

		// $Json = Input::get('HiddenfieldsJson');
		// if (!empty($Json)) {
		// 	Session::put('JsonValues', $Json);
		// }else{
		// 	$Json = Session::get('JsonValues');
		// }

		// if (empty($Json)) {
		// 	return "No data";
		// }


		// get var from request
		$settings = DB::table('Dealer')->where('DealerId', '=', $UserSessionInfo->DealerId)->first();
        $taxRate = $settings->TaxRate;
        $SessionVar = Session::get('Provider');
        $PlansId = Input::get('Plan');


        $Accepted = Input::get('Accepted');
        $Rejected = Input::get('Rejected');
        
        $AcceptedType = Input::get('AcceptedType');
        
        $RejectedType = Input::get('RejectedType');
        $AcceptedTerm = Input::get('AcceptedTerm');
        $RejectedTerm = Input::get('RejectedTerm');
        $AcceptedDeductible = Input::get('AcceptedDeductible');
        $RejectedDeductible = Input::get('RejectedDeductible');
        
        $AcceptedPrice = Input::get('AcceptedPrice');
        $RejectedPrice = Input::get('RejectedPrice');
        
        $OrderAccepted = Input::get('OrderAccepted');
        $OrderRejected = Input::get('OrderRejected');
        
        $AcceptedMileage = Input::get('AcceptedMileage');
        $RejectedMileage = Input::get('RejectedMileage');
        
        $acceptedTireRotation = Input::get('AcceptedTireRotation');
        $rejectedTireRotation = Input::get('RejectedTireRotation');
        
        $acceptedInterval = Input::get('AcceptedInterval');
        $rejectedInterval = Input::get('RejectedInterval');
        
        $acceptedDescription = Input::get('AcceptedDescription');
        $rejectedDescription = Input::get('RejectedDescription');

        
        $apr = Input::get('APR');
        $term = Input::get('Term');
        $downPayment = Input::get('DownPayment');
        
        $surcharges = Input::get('ProtectiveVsc');

        $FailureProductsRates = json_decode( Input::get('FailureProductsRates') );
        
        $Products = DB::table('Products')->join('PlansProducts', 'Products.id', '=', 'PlansProducts.ProductId')
            ->join('ProductBase', 'Products.ProductBaseId', '=', 'ProductBase.ProductBaseId')
            ->where('PlansProducts.DealerId', '=', $UserSessionInfo->DealerId)
            ->where('Products.DealerId', '=', $UserSessionInfo->DealerId)
            ->orderBy('PlansProducts.Order', 'asc')
            //->get();
            ->get(array(
                    "Products.id",
                    "Products.ProductBaseId",
                    "Products.DealerId",
                    "Products.DisplayName",
                    "Products.ProductDescription",
                    "Products.IsTaxable",
                    "Products.SellingPrice",
                    "Products.UsingWebService",
                    "Products.Bullets",
                    "Products.BrochureImage",
                    "Products.BrochureHeight",
                    "Products.BrochureWidth",
                    "Products.UseTerm",
                    "Products.UseType",
                    "Products.UseDeductible",
                    "Products.UseTireRotation",
                    "Products.UseInterval",
                    "Products.UseRangePricing",
                    "Products.VehiclePlan",
                    "Products.Type",
                    "Products.Term",
                    "Products.Deductible",
                    "Products.Mileage",
                    "Products.TireRotation",
                    "Products.Interval",
                    "ProductBase.CompanyId",
                    "ProductBase.ProductName",
                    "ProductBase.ProductType",
                    "PlansProducts.ProductId"
                ));
         


		$this->layout->with('ShowPrintButton', true);
		$this->layout->with('ShowMenuPrintButton', false);
		$this->layout->with('term', $term);
		$this->layout->with('apr', $apr);
		$this->layout->with('downPayment', $downPayment);

		$this->layout->content = \View::make('plan.disclosure')
								->with('Products', $Products)
					            ->with('Accepted', $Accepted)
					            ->with('Rejected', $Rejected)
					            ->with('AcceptedPrice', $AcceptedPrice)
					            ->with('RejectedPrice', $RejectedPrice)
					            ->with('OrderAccepted', $OrderAccepted)
					            ->with('OrderRejected', $OrderRejected)
					            ->with('AcceptedType', $AcceptedType)
					            ->with('RejectedType', $RejectedType)
					            ->with('AcceptedTerm', $AcceptedTerm)
					            ->with('RejectedTerm', $RejectedTerm)
					            ->with('AcceptedDeductible', $AcceptedDeductible)
					            ->with('RejectedDeductible', $RejectedDeductible)
					            ->with('AcceptedMileage', $AcceptedMileage)
					            ->with('RejectedMileage', $RejectedMileage)
					            ->with('acceptedTireRotation', $acceptedTireRotation)
					            ->with('rejectedTireRotation', $rejectedTireRotation)
					            ->with('acceptedInterval', $acceptedInterval)
					            ->with('rejectedInterval', $rejectedInterval)
					            ->with('acceptedDescription', $acceptedDescription)
					            ->with('rejectedDescription', $rejectedDescription)
					            ->with('downPayment', $downPayment)
					            ->with('term', $term)
					            ->with('apr', $apr)
					            ->with('surcharges', $surcharges)
					            ->with('taxRate', $taxRate)
					            ->with('FailureProductsRates', $FailureProductsRates);
	}

}