<?php
use Illuminate\Support\Facades\Cache;

class ProductsController extends BaseController
{

    /**
     * Product Repository
     *
     * @var Product
     */
    protected $Product;

    protected $SessionWebService;

    public function __construct(Product $Product)
    {
        $this->Product = $Product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function get_ShowProductsViews()
    {
        $this->deleteVarSession();
        
        $URLSession = new stdClass();
        $DealerCode = '11401';
        $arrayProductsFailure = array();
        
        if(Input::get('Deal') != '')
        {
            $URLSession->uri = URL::current() . '/?Deal=' . Input::get('Deal');
        }
        else
        {
            $URLSession->uri = 'home';
        }
        
        Session::put('URLSession', $URLSession);
        
        $UserSessionInfo = Session::get('UserSessionInfo');
        if(empty($UserSessionInfo->Username))
        {
            $LastURL = 'home';
            return Redirect::to('login')->with('LastURL', $LastURL);
        }
        
        $param = Input::get('Deal');
        
        $DealerId = $UserSessionInfo->DealerId;
        
        $settings = DB::table('Dealer')->where('DealerId', '=', $DealerId)->first();

        if($settings)
        {
            $taxRate = $settings->TaxRate;
            $settings->IsPDF = 0; // use for choose webservice URL in getproxy function
            
            $EmptyDeal = 0;
            
            $deal = new Deal();
            $BeginningOdometer = 0;
            try
            {
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
                $deal->VIN = $newArray[$settings->Vin]; // TODO: Read VIN from database configuration
                $deal->Year = $newArray[$settings->Year];
                $deal->Make = $newArray[$settings->Make];
                $deal->Model = $newArray[$settings->Model];
                $deal->Trim = $newArray[$settings->Trim];
                $deal->FinancedAmount = $newArray[$settings->FinancedAmount];
                $deal->APR = $newArray[$settings->APR];
                $deal->Term = $newArray[$settings->Term];
                $deal->DownPayment = $newArray[$settings->DownPayment];
                $deal->BeginningOdometer = round($newArray[$settings->BeginningOdometer]);
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
                
                $EmptyDeal = 1;
                $BeginningOdometer = $deal->BeginningOdometer;
            }
            catch (Exception $e)
            {
                //echo $e;
                // Session::put ('WebServiceInfo', new Deal());
            }
            
            $data = array();
            
            $products = DB::table('Products')->join('PlansProducts', 'Products.id', '=', 'PlansProducts.ProductId')
                ->join('ProductBase', 'Products.ProductBaseId', '=', 'ProductBase.ProductBaseId')
                ->where('PlansProducts.DealerId', '=', $UserSessionInfo->DealerId)
                ->where('Products.DealerId', '=', $UserSessionInfo->DealerId)
                ->orderBy('PlansProducts.Order', 'asc')
                ->get();
            
            $rangePricing = DB::table('ProductPrice')->get();
            
            $products2 = $products;
            
            $products3 = $products;
            
            $products4 = $products;
            
            $productDetail = DB::table('ProductDetail')->get();
            
            $plansProducts = DB::table('PlansProducts')->get();
            
            // TODO: Call remote webservice to get product information
            // TODO: Read dynamically the name of the product that should be processed.
            
            $productRates = array();
            $productRatesFull = array();
            $proxies = array();
            $proxy = null;
            $key = null;
            
            $FailWebservice = new stdClass();
            $FailWebservice->flag = 0;
            $FailWebservice->message = '';
            $FailWebservice->failureProductRates = array();
            // echo "deal = ".$EmptyDeal;
            if($EmptyDeal == 1)
            {
                Session::put('settings', $settings);
                foreach ($products as $product)
                {
                    try
                    {

                        // Detect if the product must get pricing from the webservice
                        if($product->UsingWebService)
                        {
                            //read name of product in case fail
                            $FailWebservice->product = $product->DisplayName;

                            $key = "key" . $product->CompanyId;
                            
                            $proxy = $this->getProxy($settings, $product);
                            $proxies[$key] = $proxy;
                            
                            $CodeResult = DB::table('SettingsTable')->where('CompanyId', '=', $product->CompanyId)
                            ->where('DealerId', '=', $product->DealerId)
                            ->first();
                            
                            // Execute request to get pricing
                            $rates = $this->getProductDetail($proxy, $product, $deal, $CodeResult->DealerCode, 0, 0, 0);
                                                        
                            $data = array();
                            
                            if($product->CompanyId == 1)
                            {

                                $index = 0;
                                foreach ($rates['Rate'] as $key => $rate)
                                {
                                    $temp = array();
                                    
                                    if($product->ProductBaseId == 4)
                                    {
                                        if(array_key_exists('TiresMileageInterval', $rate))
                                        {
                                            $temp['TireRotation'] = $rate['TiresMileageInterval'];
                                        }
                                        
                                        if(array_key_exists('Interval', $rate))
                                        {
                                            $temp['Interval'] = $rate['Interval'];
                                        }
                                    }
                                    
                                    if(array_key_exists('MonthTerm', $rate))
                                    {
                                        $temp['Term'] = $rate['MonthTerm'];
                                    }
                                    else 
                                        if(array_key_exists('EndMonthTerm', $rate))
                                        {
                                            $temp['Term'] = $rate['EndMonthTerm'];
                                        }

                                        if(array_key_exists('CoverageDesc', $rate))
                                        {
                                            $temp['Type'] = $rate['CoverageDesc'];
                                        }

                                        if(array_key_exists('FiledAmount', $rate))
                                        {
                                            $temp['SellingPrice'] = $rate['FiledAmount'];
                                        }

                                        if(array_key_exists('MileageTerm', $rate))
                                        {
                                            $temp['Mileage'] = str_replace(',', '', $rate['MileageTerm']);
                                            $temp['Mileage'] = $temp['Mileage'] / 1000;
                                        }

                                        $temp['OrderNumber'] = $index;

                                        if(array_key_exists('Deductible', $rate))
                                        {
                                            $temp['Deductible'] = $rate['Deductible'];
                                        }

                                        $index = $index + 1;

                                        $data[] = $temp;
                                    }

                                    $productRates["product" . $product->id] = $data;
                                    $productRatesFull["product" . $product->id] = $rates;

                                // Check if is possible to get the matching rate from the webservice response
                                    $rateIndex = $this->getMatchingRate($product, $rates);

                                    $rate = $rateIndex[0];
                                    $product->OrderNumber = $rateIndex[1];

                                    if($product->ProductBaseId == 2 && $product->OrderNumber == 0)
                                    {
                                        $product->Type = $rate['CoverageDesc'];
                                        $product->Term = $rate['MonthTerm'];
                                        $product->Mileage = $rate['MileageTerm'];
                                        $product->Deductible = $rate['Deductible'];
                                    }

                                    $product->SellingPrice = (float) str_replace(',', '', $rate['FiledAmount']);
                                }

                                if($product->CompanyId == 2)
                                {

                                    $rates = $rates['GetRatesResult']['Automobiles']['AutomobileRateQuoteResponse']['AutomobileRateQuotes'];

                                    foreach ($rates['AutomobileRateQuote'] as $key => $rate)
                                    {

                                        $temp = array();

                                        if(array_key_exists('CoverageTermMonths', $rate))
                                        {
                                            $temp['Term'] = $rate['CoverageTermMonths'];
                                        }

                                        if(array_key_exists('Coverage', $rate))
                                        {
                                            $temp['Type'] = $rate['Coverage'];
                                        }

                                        $temp['SellingPrice'] = $rate['RetailPrice'];

                                        if(array_key_exists('CoverageTermMiles', $rate))
                                        {
                                            $temp['Mileage'] = $rate['CoverageTermMiles'];
                                        }
                                    // For Webservice Forms
                                        if(array_key_exists('OrderNumber', $rate))
                                        {
                                            $temp['OrderNumber'] = $rate['OrderNumber'];
                                        }

                                        if(array_key_exists('Deductible', $rate))
                                        {
                                            $temp['Deductible'] = $rate['Deductible'];
                                        }

                                        if(array_key_exists('DisappearingDeductible', $rate))
                                        {
                                            $temp['DisappearingDeductible'] = $rate['DisappearingDeductible'];
                                        }

                                        $data[] = $temp;
                                    }
                                    $productRates["product" . $product->id] = $data;
                                    $productRatesFull["product" . $product->id] = $rates;

                                // Check if is possible to get the matching rate from the webservice response
                                    if($product->ProductBaseId == 11)
                                    {
                                        $product->Term = $deal->Term;
                                    }
                                    $rateIndex = $this->getMatchingRate($product, $rates);

                                    $rate = $rateIndex[0];
                                    $product->OrderNumber = $rateIndex[1];

                                    $product->SellingPrice = (float) str_replace(',', '', $rate['RetailPrice']);

                                    if($product->ProductBaseId == 12)
                                    {
                                        $product->Term = $rate['CoverageTermMonths'];
                                        $product->Mileage = $rate['CoverageTermMiles'];
                                        $product->Deductible = $rate['Deductible'];
                                    }
                            } // end product company 2
                            
                            if($product->CompanyId == 3)
                            {

                                if(is_array($rates->Plan->RateClassMoneys->RateClassMoney))
                                {
                                    foreach ($rates->Plan->RateClassMoneys->RateClassMoney as $key => $rate)
                                    {
                                        $temp = array();
                                        $temp['Type'] = $rates->Plan->Plan->PlanDescription;
                                        $temp['Term'] = $rate->TermMile->Term;
                                        $temp['SellingPrice'] = $rate->Rate->RetailRate;
                                        $temp['Mileage'] = $rate->TermMile->Mileage;
                                        $temp['Deductible'] = $rate->Deductible->DeductAmt;
                                        $temp['OrderNumber'] = $rate->TermMile->TermId; // this will be the find key for matching in contract forms
                                        
                                        $data[] = $temp;
                                    }
                                }
                                else
                                {
                                    $rate = $rates->Plan->RateClassMoneys->RateClassMoney;
                                    $temp = array();
                                    $temp['Type'] = $rates->Plan->Plan->PlanDescription;
                                    $temp['Term'] = $rate->TermMile->Term;
                                    $temp['SellingPrice'] = $rate->Rate->RetailRate;
                                    $temp['Mileage'] = $rate->TermMile->Mileage;
                                    $temp['Deductible'] = $rate->Deductible->DeductAmt;
                                    $temp['OrderNumber'] = $rate->TermMile->TermId; // this will be the find key for matching in contract forms
                                    
                                    $data[] = $temp;
                                }
                                
                                $productRates["product" . $product->id] = $data;
                                $productRatesFull["product" . $product->id] = $rates;
                                
                                // Check if is possible to get the matching rate from the webservice response
                                $rateIndex = $this->getMatchingRate($product, $rates);
                                
                                $rate = $rateIndex[0];
                                $product->OrderNumber = $rateIndex[1];
                                
                                $product->SellingPrice = (float) str_replace(',', '', $rate->Rate->RetailRate);
                            } // end product company 3
                        }
                        
                        if($product->UseRangePricing == 1)
                        {

                            $key = "key" . $product->CompanyId;
                            $proxy = $this->getProxy($settings, $product);
                            $proxies[$key] = $proxy;
                            
                            $CodeResult = DB::table('SettingsTable')->where('CompanyId', '=', $product->CompanyId)
                            ->where('DealerId', '=', $product->DealerId)
                            ->first();
                            
                            // Execute request to get pricing
                            $rates = $this->getProductDetail($proxy, $product, $deal, $CodeResult->DealerCode, 0, 0, 0);
                            
                            $product->UsingWebService = 1;
                            $data = array();
                            
                            if(! (empty($deal->Term)))
                            {
                                $product->Term = $deal->Term;
                            }
                            
                            $index = 0;
                            foreach ($rangePricing as $key => $rangePricingValue)
                            {

                                $temp = array();
                                if($product->id == $rangePricingValue->ProductId)
                                {
                                    $temp['Term'] = $rangePricingValue->TermTo;
                                    $temp['SellingPrice'] = $rangePricingValue->SellingPrice;
                                    $temp['Type'] = $rangePricingValue->PricingType;
                                    $temp['OrderNumber'] = $index;
                                    
                                    $data[] = $temp;
                                    
                                    if($product->Type == 'None' || $product->Type == 'none')
                                    {
                                        $product->Type = $rangePricingValue->PricingType;
                                    }
                                    
                                    if(($product->Type == $rangePricingValue->PricingType) && ($product->Term > $rangePricingValue->TermFrom) && ($product->Term <= $rangePricingValue->TermTo))
                                    {
                                        $product->SellingPrice = $rangePricingValue->SellingPrice;
                                        $product->OrderNumber = $index;
                                    }
                                }
                                $index ++;
                            } // end for each
                            
                            $productRates["product" . $product->id] = $data;
                            $productRatesFull["product" . $product->id] = $rates;
                        } // end if Range Pricing

                    }// end try
                    catch (Exception $e)
                    {
                        //$message = $this->GetReasonFailWebService();
                        array_push($arrayProductsFailure, array('ProductId'=> $product->ProductId, 'Message' => 'Could not retrieve rates.'));
                        //echo $e;
                        $FailWebservice->flag = 1;
                    } // end catch
                    if($product->ProductBaseId==12||$product->ProductBaseId==11||$product->ProductBaseId==2||$product->ProductBaseId==3)
                        $product->Years=round($product->Term/12,1);
                }// end for each

                Session::put('productRates', $productRates);
                Session::put('productRatesFull', $productRatesFull);

            } // end if


            $deal->BeginningOdometer = $BeginningOdometer;
            Session::put('WebServiceInfo', $deal);

            if ($FailWebservice->flag == 1) {

                //$FailWebservice->failureProductRates = array('items' => $arrayProductsFailure);
                $FailWebservice->failureProductRates = $arrayProductsFailure;

                //Try to detect why reason webservice fail 
                //$FailWebservice->message = $this->GetReasonFailWebService();
            }
            return View::make('financemenu')->with('Products', $products)
                ->with('Products2', $products2)
                ->with('Products3', $products3)
                ->with('Products4', $products4)
                ->with('Datas', $productDetail)
                ->with('Settings', $settings)
                ->with('PlansProducts', $plansProducts)
                ->with('ShowPrintButton', false)
                ->with('FailWebservice', $FailWebservice)
                ->with('ShowMenuPrintButton', true)
                ->with('taxRate', $taxRate)
                ->with('deal', $deal);
        }
        else
        {
            
            if(! (empty($UserSessionInfo->DealerId)))
            {
                return Redirect::to('settings-page');
            }
            else
            {
                return Redirect::to('dealer-settings');
            }
        }
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
                
                if($product->ProductName == 'Total Lost Protection (GAP)')
                {
                    $term = 'EndMonthTerm';
                }
                
                // Options fields in product should match the fields in the response
                if($product->Type == $rate[$type] && $product->Term == $rate[$term])
                {
                    if($product->ProductBaseId == 2)
                    {
                        if($product->Deductible == $rate[$deductible])
                        {
                            $eval = array(
                                $rate,
                                $index
                            );
                            if(($product->Mileage * 1000) == str_replace(',', '', $rate[$mileage]))
                            {
                                return array(
                                    $rate,
                                    $index
                                );
                            }
                        }
                    }
                    elseif($product->ProductBaseId == 4)
                    {
                        if($product->Interval == rtrim($rate[$interval]) && ($product->Mileage * 1000) == str_replace(',', '', $rate[$mileage]) && number_format($product->TireRotation, 0, '.', ',') == $rate[$tireRotation])
                        {
                            return array(
                                $rate,
                                $index
                            );
                        }
                    }
                    else
                    {
                        return array(
                            $rate,
                            $index
                        );
                    }
                }
                $index ++;
            } // end for each
              
            // return rate matching
            if($eval != 0)
            {
                return $eval;
            }
            
            // By default returns the first rate
            return array(
                $rates['Rate'][0],
                0
            );
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
                
                // only for GAP
                if($product->ProductBaseId == 11)
                {
                    if($product->Type == $rate[$type] && $product->Term > $lastRateTerm && $product->Term <= $rate[$term])
                    {
                        return array(
                            $rate,
                            $index
                        );
                    }
                }
                
                // Options fields in product should match the fields in the response
                if($product->Type == $rate[$type] && $product->Term == $rate[$term] && $product->Mileage == $rate[$mileage])
                {
                    if($product->Deductible == 0)
                    {
                        return array(
                            $rate,
                            $index
                        );
                    }
                    else
                    {
                        if($product->Deductible == $rate[$deductible])
                        {
                            return array(
                                $rate,
                                $index
                            );
                        }
                    }
                }
                
                $lastRateTerm = $rate[$term];
                $index ++;
            }
            // By Default returns the first rate
            return array(
                $rates['AutomobileRateQuote'][0],
                0
            );
        }
        
        if($product->CompanyId == 3) // Road Vantage
        {
            if(! (is_array($rates->Plan->RateClassMoneys->RateClassMoney)))
            {
                $rate = $rates->Plan->RateClassMoneys->RateClassMoney;
                $index = $rate->TermMile->TermId;
                return array(
                    $rate,
                    $index
                );
            }
            
            foreach ($rates->Plan->RateClassMoneys->RateClassMoney as $key => $rate)
            {
                
                $term = $rate->TermMile->Term;
                $mileage = $rate->TermMile->Mileage;
                $deductible = $rate->Deductible->DeductAmt;
                $type = $rates->Plan->Plan->PlanDescription;
                $index = $rate->TermMile->TermId;
                
                if($product->Term == $term)
                {
                    return array(
                        $rate,
                        $index
                    );
                }
                $index ++;
            }
            // By Default returns the first rate
            $rates = $rates->Plan->RateClassMoneys->RateClassMoney{0};
            return array(
                $rates,
                $rates->TermMile->TermId
            );
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

    public function get_settings()
    {
        return 'settings';
    }

    public function get_index()
    {
        $Products = $this->Product->all();
        
        return View::make('Products.index', compact('Products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('Products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();
        $validation = Validator::make($input, Product::$rules);
        
        if($validation->passes())
        {
            $this->Product->create($input);
            
            return Redirect::route('Products.index');
        }
        
        return Redirect::route('Products.create')->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id            
     * @return Response
     */
    public function show($id)
    {
        $Product = $this->Product->findOrFail($id);
        
        return View::make('Products.show', compact('Product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id            
     * @return Response
     */
    public function edit($id)
    {
        $Product = $this->Product->find($id);
        
        if(is_null($Product))
        {
            return Redirect::route('Products.index');
        }
        
        return View::make('Products.edit', compact('Product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id            
     * @return Response
     */
    public function update($id)
    {
        $input = array_except(Input::all(), '_method');
        $validation = Validator::make($input, Product::$rules);
        
        if($validation->passes())
        {
            $Product = $this->Product->find($id);
            $Product->update($input);
            
            return Redirect::route('Products.show', $id);
        }
        
        return Redirect::route('Products.edit', $id)->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id            
     * @return Response
     */
    public function destroy($id)
    {
        $this->Product->find($id)->delete();
        
        return Redirect::route('Products.index');
    }

    public function show_settingsPage()
    {
        $UserSessionInfo = Session::get('UserSessionInfo');
        try
        {
            
            if(empty($UserSessionInfo->Username))
            {
                return Redirect::to('home');
            }
        }
        catch (Exception $e)
        {
            return Redirect::to('home');
        }
        
        if(empty($UserSessionInfo->DealerId))
        {
            return Redirect::to('dealer-settings');
        }
        
        $Products = DB::select(DB::raw("SELECT id, ProductName FROM Products"));
        $Companies = DB::select(DB::raw("SELECT id, CompanyName FROM Company"));
        
        return View::make('settings')->with('Products', $Products)->with('Companies', $Companies);
    }

    public function get_infoProduct()
    {
        $ProductId = Input::get('ProductId');
        $data = array();
        
        $Product = DB::table('Products')->join('ProductBase', 'Products.ProductBaseId', '=', 'ProductBase.ProductBaseId')
            ->where('id', '=', $ProductId)
            ->first();
        
        $data[] = array(
            'idModified' => $Product->id,
            'ProductBaseId' => $Product->ProductBaseId,
            'ProductName' => $Product->ProductName,
            'CompanyId' => $Product->CompanyId,
            'DisplayName' => $Product->DisplayName,
            'Bullets' => $Product->Bullets,
            'Cost' => number_format($Product->Cost, 2, '.', ','),
            'Description' => $Product->ProductDescription,
            'Term' => $Product->Term,
            'Deductible' => $Product->Deductible,
            'VehiclePlan' => $Product->VehiclePlan,
            'Type' => $Product->Type,
            'UsingWebService' => $Product->UsingWebService,
            'UseRangePricing' => $Product->UseRangePricing,
            'SellingPrice' => number_format($Product->SellingPrice, 2, '.', ','),
            'UseType' => $Product->UseType,
            'UseTerm' => $Product->UseTerm,
            'UseDeductible' => $Product->UseDeductible,
            'UseVehiclePlan' => $Product->UseVehiclePlan,
            'BrochureHeight' => $Product->BrochureHeight,
            'BrochureWidth' => $Product->BrochureWidth,
            'BrochureImage' => $Product->BrochureImage
        );
        
        // if ( $Product->UseRangePricing == 1) {
        $Ranges = DB::table('ProductPrice')->where('ProductId', '=', $Product->id)->get();
        
        if($Ranges)
        {
            foreach ($Ranges as $Range => $RangeInfo)
            {
                $data[]['PricingInfo'] = array(
                    'idPricing' => $RangeInfo->ProductPriceId,
                    'TermFrom' => $RangeInfo->TermFrom,
                    'TermTo' => $RangeInfo->TermTo,
                    'PricingType' => $RangeInfo->PricingType,
                    'PricingCost' => $RangeInfo->PricingCost,
                    'SellingPrice' => $RangeInfo->SellingPrice
                );
            }
        }
        // }
        /*
         * $ProductDetail = DB::table('ProductDetail') ->where('ProductId', '=', $Product->id) ->get(); foreach( $ProductDetail as $Detail => $DetailInfo ){ $data[]['Bullets'] = $DetailInfo->BulletPoint; }
         */
        
        return json_encode($data);
    }

    public function insert_productInfo()
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

    public function update_productInfo()
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

    public function deletProduct()
    {
    }

    public function get_TableData()
    {
        $UserSessionInfo = Session::get('UserSessionInfo');
        $Products = DB::table('Products')->join('ProductBase', 'Products.ProductBaseId', '=', 'ProductBase.ProductBaseId')
            ->join('PlansProducts', 'Products.id', '=', 'PlansProducts.ProductId')
            ->where('PlansProducts.DealerId', '=', $UserSessionInfo->DealerId)
            ->where('Products.DealerId', '=', $UserSessionInfo->DealerId)
            ->orderBy('PlansProducts.Order', 'asc')
            ->get();
        
        $Company = DB::table('Company')->get();
        
        $Products2 = DB::select(DB::raw("select *
					from Products
					left join PlansProducts
					on Products.id = PlansProducts.ProductId
					left join ProductBase
					on Products.ProductBaseId = ProductBase.ProductBaseId
					where Products.DealerId = :value 
					"), array(
            'value' => $UserSessionInfo->DealerId
        ));
        
        $table = '<table class="table table-striped">
	      <thead>
	        <tr>
	          <th>#</th>
	          <th>Company</th>
	          <th>Product Name</th>
	          <th>Bullets Points</th>
	          <th>Cost</th>
	          <th>Selling Price</th>
	          <th></th>
	        </tr>
	      </thead>
	      <tbody>';
        
        foreach ($Products as $PlansProduct => $Plans)
        {
            
            $ProductContainerPlan = $Plans->ProductId;
            foreach ($Products as $Product => $ProductInfo)
            {
                if($ProductInfo->id == $ProductContainerPlan)
                {
                    $ProductContainerCompany = $ProductInfo->CompanyId;
                    $ProductDisplayName = $ProductInfo->DisplayName;
                    
                    if($ProductInfo->ProductDescription == '')
                    {
                        $ProductDescription = 'No description';
                    }
                    else
                    {
                        $ProductDescription = $ProductInfo->ProductDescription;
                    }
                    
                    $ProductCost = $ProductInfo->Cost;
                    $ProductSelling = $ProductInfo->SellingPrice;
                    $ProductName = $ProductInfo->ProductName;
                    foreach ($Company as $CompanyKey => $CompanyInfo)
                    {
                        if($CompanyInfo->id == $ProductContainerCompany)
                        {
                            $productCompanyName = $CompanyInfo->CompanyName;
                        }
                    }
                    
                    // Start Print Table
                    $table .= '<tr>
						          <td ><input type="checkbox" checked  name="productRef' . $ProductInfo->id . '" id="' . $ProductInfo->id . '" value="' . $ProductInfo->id . '  class="m" ">  ' . ++ $PlansProduct . '</td>
						          <td>' . $productCompanyName . '</td>';
                    $table .= '<td><a href="edit-product?ProductId=' . $ProductInfo->id . '" name="' . $ProductInfo->id . '" class="modify"><span title="Edit Product">' . $ProductName . '  <i class="fa fa-pencil-square-o"></i></span></a><br/>';
                    
                    if($ProductInfo->DisplayName == '')
                    {
                        $table .= $ProductInfo->ProductName . '</td>';
                    }
                    else
                    {
                        $table .= $ProductInfo->DisplayName . '</td>';
                    }
                    
                    $table .= '<td>' . $ProductDescription . '<br/>';
                    if($ProductInfo->Bullets)
                    {
                        $BulletsArray = explode(',', $ProductInfo->Bullets);
                        $table .= '<ul>';
                        foreach ($BulletsArray as $BulletArray => $BulletArrayInfo)
                        {
                            if($BulletArrayInfo)
                            {
                                $table .= '<li>' . $BulletArrayInfo . '</li>';
                            }
                        }
                        $table .= '</ul>';
                    }
                    $table .= '</td>';
                    
                    if($ProductInfo->UsingWebService == 1)
                    {
                        $table .= '<td align="right">Auto</td>
						              <td align="right">Auto</td>';
                    }
                    else
                    {
                        $table .= '<td align="right">$' . number_format($ProductCost, 2) . '</td>
						              <td align="right">$' . number_format($ProductSelling, 2) . '</td>';
                    }
                    
                    $table .= '<td></td>
						          </tr>';
                    // End Print Table
                } // endif
            } // end foreach
        } // Endfor each
          // Append Product Not Included in Plan
        $dataSave = array();
        $i = 0;
        foreach ($Products2 as $Products2key => $Products2value)
        {
            $flag = 0;
            $ProdcutEvaluated = $Products2value->id;
            foreach ($Products as $Product => $ProductInfo)
            {
                if($ProductInfo->id == $ProdcutEvaluated)
                {
                    $flag = 1;
                } // end if
            } // for each
            foreach ($dataSave as $key => $value)
            {
                if($value == $Products2value->id)
                {
                    $flag = 1;
                }
            }
            if($flag == 0)
            {
                $dataSave[$i] = $Products2value->id;
                $i = $i + 1;
                $ProductContainerCompany = $Products2value->CompanyId;
                $ProductDisplayName = $Products2value->DisplayName;
                
                if($Products2value->ProductDescription == '')
                {
                    $ProductDescription = 'No description';
                }
                else
                {
                    $ProductDescription = $Products2value->ProductDescription;
                }
                
                $ProductCost = $Products2value->Cost;
                $ProductSelling = $Products2value->SellingPrice;
                $ProductName = $Products2value->ProductName;
                foreach ($Company as $CompanyKey => $CompanyInfo)
                {
                    if($CompanyInfo->id == $ProductContainerCompany)
                    {
                        $productCompanyName = $CompanyInfo->CompanyName;
                    }
                }
                // Start Print Table
                $table .= '<tr>
						          <td><input type="checkbox" name="productRef' . $Products2value->id . '" id="' . $Products2value->id . '" value="' . $Products2value->id . '"></td>
						          <td>' . $productCompanyName . '</td>';
                $table .= '<td><a href="edit-product?ProductId=' . $Products2value->id . '" name="' . $Products2value->id . '" class="modify"><span title="Edit Product">' . $ProductName . '  <i class="fa fa-pencil-square-o"></i></span></a><br/>';
                if($Products2value->DisplayName == '')
                {
                    $table .= $Products2value->ProductName . '</td>';
                }
                else
                {
                    $table .= $Products2value->DisplayName . '</td>';
                }
                $table .= '<td>' . $ProductDescription . '<br/>';
                $BulletsArray = explode(',', $Products2value->Bullets);
                $table .= '<ul>';
                foreach ($BulletsArray as $BulletArray => $BulletArrayInfo)
                {
                    if($BulletArrayInfo)
                    {
                        $table .= '<li>' . $BulletArrayInfo . '</li>';
                    }
                }
                $table .= '</ul>';
                $table .= '</td>';
                
                if($Products2value->UsingWebService == 1)
                {
                    $table .= '<td align="right">Auto</td>
						              <td align="right">Auto</td>';
                }
                else
                {
                    $table .= '<td align="right">$' . number_format($ProductCost, 2) . '</td>
						              <td align="right">$' . number_format($ProductSelling, 2) . '</td>';
                }
                
                $table .= '<td><button type="button" class="btn btn-danger" value="' . $Products2value->id . '" >Delete</button></td>
						          </tr>';
                // End Print Table
            } // end if
        } // End for each
        $table .= '</tbody>
						      </table>';
        
        return $table;
    }

    public function get_SortableTableData()
    {
        $UserSessionInfo = Session::get('UserSessionInfo');
        $Products = DB::table('Products')->join('PlansProducts', 'Products.id', '=', 'PlansProducts.ProductId')
            ->where('PlansProducts.DealerId', '=', $UserSessionInfo->DealerId)
            ->where('Products.DealerId', '=', $UserSessionInfo->DealerId)
            ->orderBy('PlansProducts.Order', 'asc')
            ->get();
        $Company = DB::table('Company')->get();
        
        $table = '<div class="tables2">
                    <div class="gantry-width-block">                    
                    <ul class="rt-pricing-table2">
                    <li class="rt-table-title-premium">Premium</li>    	    		
    				<div class="sortable bodyTable">';
        
        $productRates = $object = json_decode(json_encode(Session::get('productRates')), FALSE);
        foreach ($Products as $PlansProduct => $Plans)
        {
            $ProductContainerPlan = $Plans->ProductId;
            foreach ($Products as $Product => $ProductInfo)
            {
                if($ProductInfo->id == $ProductContainerPlan)
                {
                    $ProductDisplayName = $ProductInfo->DisplayName;
                    
                    if($ProductInfo->ProductDescription == '')
                    {
                        $ProductDescription = 'No description';
                    }
                    else
                    {
                        $ProductDescription = $ProductInfo->ProductDescription;
                    }
                    
                    $ProductCost = $ProductInfo->SellingPrice;
                    
                    if($ProductInfo->DisplayName == '')
                    {
                        $ProductName = $ProductInfo->ProductName;
                    }
                    else
                    {
                        $ProductName = $ProductInfo->DisplayName;
                    }
                    
                    // Start Print Table
                    $table .= '<li class="sortableList" id=' . $ProductInfo->id . '>	
                                            <div class="product-header-container-settings">
                                            <div class="title-product">' . $ProductName . '</div>';
                    
                    if($ProductInfo->UsingWebService == 1)
                    {
                        $table .= '<div class="price-product">Auto</div>';
                    }
                    else
                    {
                        $table .= '<div class="price-product">$' . number_format((float) $ProductCost, 2, '.', ',') . '</div>';
                    }
                    $table .= '<div class="displayname-product">' . $ProductDescription . '</div></div>';
                    $BulletsArray = explode(',', $ProductInfo->Bullets);
                    foreach ($BulletsArray as $BulletArray => $BulletArrayInfo)
                    {
                        if($BulletArrayInfo)
                        {
                            $table .= '<span class="square">&#x25a0; </span><span class="bulletDetail">' . $BulletArrayInfo . '<span><br>';
                        }
                    }
                    
                    $table .= '</li>';
                    // End Print Table
                } // endif
            } // enf foreach
        } // Endfor each
        
        $table .= '</div></ul></div></div>';
        
        return $table;
    }

    public function get_UpdateOrderProducts()
    {
        $Order = Input::get('Order');
        $ProductId = Input::get('ProductId');
        $PlansId = Input::get('PlansId');
        
        DB::table('PlansProducts')->where('ProductId', '=', $ProductId)->update(array(
            'Order' => $Order
        ));
        
        return '1';
    }

    public function get_deleteTable()
    {
        $ProductId = Input::get('id');
        $PlansId = 1;
        
        DB::table('PlansProducts')->where('ProductId', '=', $ProductId)->delete();
        
        return '1';
    }

    public function get_InsertTable()
    {
        $ProductId = Input::get('id');
        $maxId = 0;
        
        $Validate = DB::table('PlansProducts')->where('ProductId', '=', $ProductId)->get();
        
        if(! empty($Validate))
        {
            return '0';
        }
        
        $table = DB::table('PlansProducts')->orderBy('Order', 'desc')->get();
        
        foreach ($table as $tablekey => $tablevalue)
        {
            $maxId = $tablevalue->Order;
        }
        $maxId = $maxId + 1;
        $UserSessionInfo = Session::get('UserSessionInfo');
        DB::table('PlansProducts')->insert(array(
            'DealerId' => $UserSessionInfo->DealerId,
            'ProductId' => $ProductId,
            'Order' => $maxId
        ));
        return '1';
    }

    public function createCompany()
    {
        $CompanyName = Input::get('CompanyName');
        $URL = Input::get('URL');
        $Username = Input::get('Username');
        $Password = Input::get('Password');
        
        $Company = DB::table('Company')->insert(array(
            'CompanyName' => $CompanyName,
            'URL' => $URL,
            'Username' => $Username,
            'Password' => $Password
        ));
        
        return "Company " . $CompanyName . " has been added";
    }

    public function populateCompanyList()
    {
        $Companies = DB::select(DB::raw("SELECT id, CompanyName FROM Company"));
        
        $list = '<select name="CompanyId" id="CompanyId" class="form-control" style="width:40%">';
        foreach ($Companies as $Company => $CompanyInfo)
        {
            $list .= '<option value="' . $CompanyInfo->id . '">' . $CompanyInfo->CompanyName . '</option>';
        }
        
        $list .= '</select>';
        
        return $list;
    }

    public function deleteProduct()
    {
        $ProductId = Input::get('ProductId');
        
        $DeletePrices = DB::table('ProductPrice')->where('ProductId', '=', $ProductId)->delete();
        
        $DeletedBullet = DB::table('ProductDetail')->where('ProductId', '=', $ProductId)->delete();
        
        $DeletedProduct = DB::table('PlansProducts')->where('ProductId', '=', $ProductId)->delete();
        
        $DeletedProduct2 = DB::table('Products')->where('id', '=', $ProductId)->delete();
        
        return 'The product has been removed';
    }

    public function post_disclosureMenu()
    {
        $WebService = Session::get('WebServiceInfo');
        $UserSessionInfo = Session::get('UserSessionInfo');
        try
        {
            
            if(empty($UserSessionInfo->Username))
            {
                return Redirect::to('home');
            }
        }
        catch (Exception $e)
        {
            return Redirect::to('home');
        }
        
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
        
        $Products = DB::table('Products')->join('PlansProducts', 'Products.id', '=', 'PlansProducts.ProductId')
            ->join('ProductBase', 'Products.ProductBaseId', '=', 'ProductBase.ProductBaseId')
            ->where('PlansProducts.DealerId', '=', $UserSessionInfo->DealerId)
            ->where('Products.DealerId', '=', $UserSessionInfo->DealerId)
            ->orderBy('PlansProducts.Order', 'asc')
            ->get();
        
        // $ProductsInverted = DB::table ( 'Products' )->join ( 'PlansProducts', 'Products.id', '=', 'PlansProducts.ProductId' )->orderBy ( 'PlansProducts.Order', 'desc' )->get ();
        
        $ProductDetail = DB::table('ProductDetail')->get();
        
        $PlansProducts = DB::table('PlansProducts')->get();
        
        return View::make('disclosureMenu')->with('Products', $Products)
            ->with('Details', $ProductDetail)
            ->with('PlansProducts', $PlansProducts)
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
            ->with('apr', $apr)
            ->with('surcharges', $surcharges)
            ->with('ShowPrintButton', true)
            ->with('taxRate', $taxRate)
            ->with('ShowMenuPrintButton', false);
    }

    public function loadCompanyProducts()
    {
        $type = Input::get('type');
        $CompanyId = Input::get('CompanyId');
        $data = array();
        
        if($type == 'addLabel')
        {
            $name = 'ProductName';
        }
        else
        {
            $name = 'productNameModified';
        }
        
        $Products = DB::table('ProductBase')->where('CompanyId', '=', $CompanyId)->get();
        
        if(! empty($Products))
        {
            foreach ($Products as $Product => $ProductInfo)
            {
                $data[] = array(
                    'ProductBaseId' => $ProductInfo->ProductBaseId,
                    'ProductName' => $ProductInfo->ProductName
                );
            }
        }
        else
        {
            $data[] = array(
                'ProductBaseId' => '0',
                'ProductName' => 'None'
            );
        }
        
        return json_encode($data);
    }

    public function get_response()
    {
        $Accepted = Input::get('ProductsAccepted');
        $Rejected = Input::get('ProductsRejected');
        $Total = Input::get('Total');
        $UserSessionInfo = Session::get('UserSessionInfo');
        
        $products = DB::table('Products')->join('PlansProducts', 'Products.id', '=', 'PlansProducts.ProductId')
            ->join('WebServiceSettings', 'Products.id', '=', 'WebServiceSettings.ProductId')
            ->where('PlansProducts.DealerId', '=', $UserSessionInfo->DealerId)
            ->where('Products.DealerId', '=', $UserSessionInfo->DealerId)
            ->orderBy('PlansProducts.Order', 'asc')
            ->get();
        
        $productDetails = DB::table('ProductDetail')->get();
        
        return exportPDF($Accepted, $Rejected, $Total, $products, $productDetails);
    }

    public function exportPDF()
    {
    $UserSessionInfo = Session::get('UserSessionInfo');
    $data = Session::get('WebServiceInfo');
    $Accepted = Input::get('acceptedarray');
    $Rejected = Input::get('rejectedarray');
    $CostPerDay = Input::get('CostPerDay');
    $AdditionalPayment = Input::get('AdditionalPayment');
    $UpdatedPayment = Input::get('UpdatedPayment');
    $Total = Input::get('Total');
    $CostByDayArray = Input::get('costbydayarray');
    $NewAPR = input::get('newapr');
    $NewTerm= input::get('newterm');
    $NewDownPayment = input::get('newdownpayment');
    $AcceptedDescriptionArray = input::get('accepteddescription');
    $RejectedDescriptionArray = input::get('rejecteddescription');


    if (empty($UpdatedPayment)) {
            $UpdatedPayment = 0;
    }

    $Accepted = explode(",",$Accepted);
    $Rejected  = explode(",",$Rejected);
    $CostByDay = explode(",", $CostByDayArray);
    $NewAcceptedDescription = explode("!", $AcceptedDescriptionArray);
    $NewRejectedDescription = explode("!", $RejectedDescriptionArray);

    $AcceptedDescription = array();
    $x = 0;
    foreach ($NewAcceptedDescription as $key => $value) {
        if($x>0)
            $value = substr($value, 1);

        $AcceptedDescription[$x] = $value;
        $x = $x+1;
    }

    $RejectedDescription = array();
    $x = 0;
    foreach ($NewRejectedDescription as $key => $value) {
        if($x>0)
            $value = substr($value, 1);

        $RejectedDescription[$x] = $value;
        $x = $x+1;
    }

    
    $arraycost = array();

    $x = 0;
    foreach ($CostByDay as $key => $value) {
        $arraycost[$x] = explode("  ", $value);
        $x=$x+1;
    }

      $products = DB::table ( 'Products' )
                    ->join ( 'PlansProducts', 'Products.id', '=', 'PlansProducts.ProductId' )
                    ->join('ProductBase', 'Products.ProductBaseId', '=', 'ProductBase.ProductBaseId')
                    //->join ( 'WebServiceSettings', 'Products.id', '=', 'WebServiceSettings.ProductId' )
                    ->where('PlansProducts.DealerId', '=', $UserSessionInfo->DealerId)
                    ->where('Products.DealerId', '=', $UserSessionInfo->DealerId)
                    ->orderBy ( 'PlansProducts.Order', 'asc' )
                    ->get ();

    $productDetails = DB::table ( 'ProductDetail' )->get ();

    $Dealer = DB::table ('Dealer')
                 ->where('DealerId','=', $UserSessionInfo->DealerId)
                 ->first();
    
    $html = '
    <html>
    <head>
    <style>

        html{
            margin-top:5px;
            margin-left: 10px;
            margin-right: 10px;
        }

        body{
            font:10px Arial, Tahoma, Verdana, Helvetica, sans-serif;
            //background-color:#BECEDC;
            color:#000;
        }
    
        p.productname{
            color:blue;
        }
    
        h5{
            color:red
        }
    
        table {
            //border: solid 1px #000000; 
            width:100%
        }
    
        // table.tableCommon{
        //  font:10px Arial, Tahoma, Verdana, Helvetica, sans-serif;
        // }
        
        .tableheader{
            text-align:center; 
            color:#FFFFFF; 
            height:15px;
            //font-size: 1em;
            font:10px Arial, Tahoma, Verdana, Helvetica, sans-serif;
            font-weight:bold;
        }
        
        table td.footercommon{
            border: 1px solid #E1E1E1; 
            background-color: #f3f3f3;
        }
        
        table td.tabletdcommon{
            border-top: 1px solid #E1E1E1; 
            border-left: 1px solid #E1E1E1; 
            border-right: 1px solid #E1E1E1; 
        }

        table td.alignleft{
            text-align: left
        }

        table td.alignright{
            text-align:right
        }
        
        .accepted{
            background: #51A351;
            width:32.5%
        }
        
        .rejected{
            background: #BD362F;
            width:32.5%
        }
        
        .disclosure{
            background: #A1927D;
            width:35%
        }
        
        li{
            padding-left:25px;
            list-style: square;
            //border-bottom: 1px dotted #AEAEAE;
        }

        .disclosurefont{
            font: 12px Arial, Tahoma, Verdana, Helvetica, sans-serif !important;
        }
        
    </style>

    </head>
    <body>
        <table>
            <tr>';
            if (!(empty($UserSessionInfo->DealerLogo))) {
                $html .= '<td rowspan="3" style="width:1px;"><img src="uploads/dealer/' . $UserSessionInfo->DealerLogo . '" width="180" height="20"/></td>';
            }
            
            $html .= '<td class="alignright"><b>Buyer:</b></td> <td class="alignleft" style="width:150px;">'.$data->Buyer.'</td>  <td class="alignright"><b>Amount Financed:</b></td> <td class="alignleft">$'.number_format($data->FinancedAmount,2).'</td> <td class="alignright"><b>Down Payment:</b></td> <td class="alignleft"> $'; if($NewDownPayment ==null) {$html.=number_format($data->FinancedAmount,2); }else { $html.=number_format($NewDownPayment,2); } $html.='</td></tr>
            <tr><td class="alignright"><b>Co Buyer:</b></td> <td class="alignleft">'.$data->CoBuyer.'</td> <td class="alignright"><b>APR:</b></td> <td class="alignleft">'; if($NewAPR ==null) {$html.=number_format($data->APR,2); }else { $html.=number_format($NewAPR,2); } $html.='</td> <td class="alignright"><b></b></td> <td class="alignleft"></td></tr>
            <tr><td colspan="2" style="text-align:center;"><b>'.$data->Year.' '.$data->Make.' '.$data->Model.'</b></td>  <td class="alignright"><b>Term:</b></td> <td class="alignleft">'; if($NewTerm ==null) {$html.=number_format($data->Term,2); }else { $html.=number_format($NewTerm,2); } $html.='</td> <td class="alignright"><b></b></td> <td class="alignleft"></td></tr>
        </table>';
    

        //aque ya viene la tabla de los productos aceptados
        $html .= '<table> 
                  <tr > 
                    <td valign="top" width="32.5%" class="tabletdcommon"> 
                        <table class="tableCommon">
                        <tr><td class="accepted tableheader">Products Accepted</td></tr>
                        <tr><td><table>';
                        if(count($Accepted)>0)
                        {
                            $i = 0;
                            foreach ($Accepted as $key => $value) {
                                foreach($products as $valor) 
                                {
                                    if($valor->id==$value)
                                    {
                                        $html .='
                                        <tr>
                                            <td style="color:#41699A"><strong>'.$valor->DisplayName.'</strong></td>
                                            <td valign="top" style="text-align:right"><b></b></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">'.$AcceptedDescription[$i].'</td>
                                        </tr>
                                        <tr><td style="border-bottom: 1px dotted #AEAEAE;" colspan="2">';
                                        $Bullets = explode(',', $valor->Bullets);
                                        foreach($Bullets as $Bullet)
                                        {
                                            if (!(empty($Bullet)))
                                            {
                                                $html .= '<li>'.$Bullet.'</li>';
                                            }
                                        }   
                                        $html .= '
                                        </td></tr>
                                        ';
                                    }
                                }

                                $i = $i + 1;
                            }
                        }
                         $html .= '
                            </table></td></tr>
                         </table>
                    </td>
                    <td valign="top" width="32.5%" class="tabletdcommon"> 
                         <table class="tableCommon">
                         <tr><td class="rejected tableheader">Products Rejected</td></tr>
                            <tr><td><table>';
                            if(count($Rejected)>0)
                            {
                                $i = 0;
                                foreach ($Rejected as $key => $value) {
                                    foreach($products as $valor) 
                                    {
                                        if($valor->id==$value)
                                        {
                                            $html .='
                                            <tr>
                                                <td style="color:#41699A"><strong>'.$valor->DisplayName.'</strong></td>
                                                <td valign="top" style="text-align:right"><b><div>'.$arraycost[$i][0].'</div> <div>'.$arraycost[$i][1].'</div></b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">'.$RejectedDescription[$i].'</td>
                                            </tr>
                                            <tr><td style="border-bottom: 1px dotted #AEAEAE;" colspan="2">';
                                            $Bullets = explode(',', $valor->Bullets);
                                            foreach($Bullets as $Bullet)
                                            {
                                                if (!(empty($Bullet)))
                                                {
                                                    $html .= '<li>'.$Bullet.'</li>';
                                                }
                                            }       
                                            $html .= '
                                            </td></tr>
                                            ';
                                        }
                                    }

                                    $i = $i + 1;
                                }
                            }
                            $html .= '
                            </table></td></tr>
                        </table> 
                    </td> 
                    <td valign="top" width="35%" class="tabletdcommon"> 
                        <table class="tableCommon">
                        <tr><td class="disclosure tableheader">Disclosure</td></tr>
                            <tr><td style="text-align: justify;" class="disclosurefont" >'.$Dealer->Disclosure.'</td></tr>';
                        $html .= '</table> 
                        
                    </td>  
                  </tr> 
                  <tr >
                    <td class="footercommon">
                      <table cellspacing="2" cellpadding="2">
                          <tr>
                              <td valign="top" class="alignleft" style="height:30px">
                              <b>Updated Payment:</b>
                              </td>
                              <td valign="top" class="alignright" style="height:30px">
                              <b>$'.number_format($UpdatedPayment,2).'</b>
                              </td>
                          </tr>
                          <tr>
                              <td colspan="2">
                              <b>Initials: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;______________________________________________</b>
                              </td>
                          </tr>
                      </table>
                    </td>

                    <td class="footercommon">
                      <table cellspacing="2" cellpadding="2">
                          <tr>
                              <td class="alignright" style="font:20px Arial, Tahoma, Verdana, Helvetica, sans-serif;">
                              <b>Cost Per Day:</b>
                              </td>
                              <td class="alignright" style="font:20px Arial, Tahoma, Verdana, Helvetica, sans-serif;">
                              <b>$'.number_format($CostPerDay,2).'</b>
                              </td>
                          </tr>
                          <tr>
                              <td class="alignright" style="font:10px Arial, Tahoma, Verdana, Helvetica, sans-serif">
                              <b>Aditional Payment:</b>
                              </td>
                              <td class="alignright" style="font:10px Arial, Tahoma, Verdana, Helvetica, sans-serif">
                              <b>$'.number_format($AdditionalPayment,2).'</b>
                              </td>
                          </tr>
                      </table>
                    </td>

                    <td class="footercommon">
                      <table>
                          <tr>
                              <td valign="top" class="alignright" style="width:70px;height:30px;padding-top:0;">
                              <b>Buyer:</b>
                              </td>
                              <td valign="top" class="alignleft" style="padding-top:0;">
                              <b>_________________________ Date: ___________________</b>
                              </td>
                          </tr>
                          <tr>
                              <td class="alignright" style="width:70px;">
                              <b>Co Buyer:</b>
                              </td>
                              <td class="alignleft" >
                              <b>_________________________ Date: ___________________</b>
                              </td>
                          </tr>
                      </table>
                    </td>
                  </tr>
                  <tr valign="bottom">
                    <td colspan="3" style="text-align:center; color:#41699A;">Powered by Automatrix</td>
                  </tr>
                  </table>
    </body>
    </html>';


    PDF::load($html, 'letter','landscape');
    //PDF::AutoPrint(true);
    echo PDF::show('disclosure');
    } 

   public function printMenuPdf(){
    $UserSessionInfo = Session::get('UserSessionInfo');


    $data = Session::get('WebServiceInfo');

    if($data == null)
    {
        echo "You need a deal to print the menu in pdf";
        die();
    }
    else
    {
        if($data->Deal == 0 | $data->Deal =="")
        {
            echo "You need a deal to print the menu in pdf";
            die();      
        }
    }

    $PremiumArray = Input::get('premiumarray');
    $PreferredArray = Input::get('preferredarray');
    $EconomyArray = Input::get('economyarray');
    $BasicArray = Input::get('basicarray');
    $PremiumAcceptedArray = Input::get('premiumacceptedarray');
    $PreferredAcceptedArray = Input::get('preferredacceptedarray');
    $EconomyAcceptedArray = Input::get('economyacceptedarray');
    $BasicAcceptedArray = Input::get('basicacceptedarray');
    $CostPremiumArray = Input::get('costpremiumarray');
    $CostPreferredArray = Input::get('costpreferredarray');
    $CostEconomyArray = Input::get('costeconomyarray');
    $CostBasicArray = Input::get('costbasicarray');
    $CostFooterArray = Input::get('costfooterarray');
    $FaceFooter = Input::get('facefooter');
    $PremiumDescriptionArray = Input::get('premiumdescription');
    $PreferredDescriptionArray = Input::get('preferreddescription');
    $EconomyDescriptionArray = Input::get('economydescription');
    $BasicDescriptionArray = Input::get('basicdescription');

    $Premium = explode(",",$PremiumArray);
    $Preferred  = explode(",",$PreferredArray);
    $Economy = explode(",", $EconomyArray);
    $Basic = explode(",", $BasicArray);
    // $Cost = explode(",",$CostByProductArray);
    $PremiumAccepted = explode(",",$PremiumAcceptedArray);
    $PreferredAccepted = explode(",",$PreferredAcceptedArray);
    $EconomyAccepted = explode(",",$EconomyAcceptedArray);
    $BasicAccepted = explode(",",$BasicAcceptedArray);
    $CostFooter = explode(",",$CostFooterArray);
    
    $CostPremium = explode(",",$CostPremiumArray);
    $CostPreferred  = explode(",",$CostPreferredArray);
    $CostEconomy = explode(",", $CostEconomyArray);
    $CostBasic = explode(",", $CostBasicArray);
    $NewPremiumDescription = explode("!",$PremiumDescriptionArray);
    $NewPreferredDescription = explode("!",$PreferredDescriptionArray);
    $NewEconomyDescription = explode("!",$EconomyDescriptionArray);
    $NewBasicDescription = explode("!",$BasicDescriptionArray);


    $PremiumDescription = array();
    $x = 0;
    foreach ($NewPremiumDescription as $key => $value) {
        if($x>0)
            $value = substr($value, 1);

        $PremiumDescription[$x] = $value;
        $x = $x+1;
    }

    $PreferredDescription = array();
    $x = 0;
    foreach ($NewPreferredDescription as $key => $value) {
        if($x>0)
            $value = substr($value, 1);

        $PreferredDescription[$x] = $value;
        $x = $x+1;
    }


    $EconomyDescription = array();
    $x = 0;
    foreach ($NewEconomyDescription as $key => $value) {
        if($x>0)
            $value = substr($value, 1);

        $EconomyDescription[$x] = $value;
        $x = $x+1;
    }

    $BasicDescription = array();
    $x = 0;
    foreach ($NewBasicDescription as $key => $value) {
        if($x>0)
            $value = substr($value, 1);

        $BasicDescription[$x] = $value;
        $x = $x+1;
    }


    $products = DB::table ( 'Products' )
                    ->join ( 'PlansProducts', 'Products.id', '=', 'PlansProducts.ProductId' )
                    ->join('ProductBase', 'Products.ProductBaseId', '=', 'ProductBase.ProductBaseId')
                    //->join ( 'WebServiceSettings', 'Products.id', '=', 'WebServiceSettings.ProductId' )
                    ->where('PlansProducts.DealerId', '=', $UserSessionInfo->DealerId)
                    ->where('Products.DealerId', '=', $UserSessionInfo->DealerId)
                    ->orderBy ( 'PlansProducts.Order', 'asc' )
                    ->get ();

    $productDetails = DB::table ( 'ProductDetail' )->get ();

    $Dealer = DB::table ('Dealer')
                 ->where('DealerId','=', $UserSessionInfo->DealerId)
                 ->first();

    // if($UserSessionInfo->DealerId != 1)
    //  die();


    $html = '
    <html>
    <head>
    <style>

        html{
            margin-top:5px;
            margin-left: 10px;
            margin-right: 10px;
        }

        body{
            font:10px Arial, Tahoma, Verdana, Helvetica, sans-serif;
            //background-color:#BECEDC;
            color:#000;
        }
    
        p.productname{
            color:blue;
        }
    
        h5{
            color:red
        }
    
        table {
            //border: solid 1px #000000; 
            width:100%
        }
    
        // table.tableCommon{
        //  font:10px Arial, Tahoma, Verdana, Helvetica, sans-serif;
        // }
        
        .tableheader{
            text-align:center; 
            color:#FFFFFF; 
            height:15px;
            //font-size: 1em;
            font:10px Arial, Tahoma, Verdana, Helvetica, sans-serif;
            font-weight:bold;
        }
        
        table td.footercommon{
            border: 1px solid #E1E1E1; 
            background-color: #f3f3f3;
            text-align:center;
        }
        
        table td.tabletdcommon{
            border-top: 1px solid #E1E1E1; 
            border-left: 1px solid #E1E1E1; 
            border-right: 1px solid #E1E1E1; 
        }

        table td.alignleft{
            text-align: left
        }

        table td.alignright{
            text-align:right
        }
        
        li{
            padding-left:25px;
            list-style: square;
            //border-bottom: 1px dotted #AEAEAE;
        }

        text.CostPerDay{
            font:18px Arial, Tahoma, Verdana, Helvetica, sans-serif;
            align:center;
            text-align:center;
            font-weight:bold;
        }

        text.Other{
            font-weight:bold;
        }

        tr.spacingtr td text
        {
            line-height: 22px;
        }
        
    </style>

    </head>
    <body>
        <table >
            <tr>';
            if (!(empty($UserSessionInfo->DealerLogo))) {
                $html .= '<td rowspan="3" style="width:1px;"><img src="uploads/dealer/' . $UserSessionInfo->DealerLogo . '" width="180" height="20"/></td>';
            }
            
            $html .= '<td class="alignright"><b>Buyer:</b></td> <td class="alignleft" style="width:150px;">'.$data->Buyer.'</td>  <td class="alignright"><b>Amount Financed:</b></td> <td class="alignleft">$'.number_format($data->FinancedAmount,2).'</td> <td class="alignright"><b>Down Payment:</b></td> <td class="alignleft"> $'.number_format($data->DownPayment,2).'</td></tr>
            <tr><td class="alignright"><b>Co Buyer:</b></td> <td class="alignleft">'.$data->CoBuyer.'</td> <td class="alignright"><b>APR:</b></td> <td class="alignleft">'.number_format($data->APR,2).'</td> <td class="alignright"><b></b></td> <td class="alignleft"></td></tr>
            <tr><td colspan="2" style="text-align:center;"><b>'.$data->Year.' '.$data->Make.' '.$data->Model.'</b></td>  <td class="alignright"><b>Term:</b></td> <td class="alignleft">'.number_format($data->Term,2).'</td> <td class="alignright"><b></b></td> <td class="alignleft"></td></tr>
        </table>';


        //aque ya viene la tabla de los productos aceptados
        $html .= '<table > 
                  <tr> 
                    <td valign="top" width="25%" class="tabletdcommon"> 
                         <table class="tableCommon">
                            <tr><td class="tableheader" style="background-color:#5CB85C">Premium</td></tr>
                            <tr><td><table>';
                            if(count($Premium)>0)
                            {
                                $i = 0;
                                foreach($products as $valor) 
                                {
                                    if(in_array($valor->id,$Premium))
                                    {
                                    $html .='
                                    <tr>
                                        <td style="color:#41699A">';
                                        if(in_array($valor->id,$PremiumAccepted))
                                            $html .= '<img style="padding-top:2px" src="images/checked.gif" width="8" height="8"/>';
                                        else
                                            $html .= '<img style="padding-top:2px" src="images/unchecked.gif" width="8" height="8"/>';

                                        $html .= '<strong>&nbsp;'.$valor->DisplayName.'</strong></td>
                                        <td valign="top" style="text-align:right"><b><div>$ '.number_format($CostPremium[$i],2).'</div></b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">'.$PremiumDescription[$i].'</td>
                                    </tr>
                                    <tr><td style="border-bottom: 1px dotted #AEAEAE;" colspan="2">';
                                    $Bullets = explode(',', $valor->Bullets);
                                    foreach($Bullets as $Bullet)
                                    {
                                        if (!(empty($Bullet)))
                                        {
                                            $html .= '<li>'.$Bullet.'</li>';
                                        }
                                    }   
                                    $html .= '
                                    </td></tr>
                                    ';

                                    $i = $i + 1;
                                    }
                                }
                            }
                         $html .= '
                            </table></td></tr>
                         </table>
                    </td>
                    <td valign="top" width="25%" class="tabletdcommon"> 
                         <table class="tableCommon">
                        <tr><td class="tableheader" style="background-color:#3E9DD3">Preferred</td></tr>
                            <tr><td><table>';
                            if(count($Preferred)>0)
                            {
                                $i = 0;
                                foreach($products as $valor) 
                                {
                                    if(in_array($valor->id,$Preferred))
                                    {
                                    $html .='
                                    <tr>
                                        <td style="color:#41699A">';
                                        if(in_array($valor->id,$PreferredAccepted))
                                            $html .= '<img style="padding-top:2px" src="images/checked.gif" width="8" height="8"/>';
                                        else
                                            $html .= '<img style="padding-top:2px" src="images/unchecked.gif" width="8" height="8"/>';

                                        $html .= '<strong>&nbsp;'.$valor->DisplayName.'</strong></td>
                                        <td valign="top" style="text-align:right"><b><div>$ '.number_format($CostPreferred[$i],2).'</div></b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">'.$PreferredDescription[$i].'</td>
                                    </tr>
                                    <tr><td style="border-bottom: 1px dotted #AEAEAE;" colspan="2">';
                                    $Bullets = explode(',', $valor->Bullets);
                                    foreach($Bullets as $Bullet)
                                    {
                                        if (!(empty($Bullet)))
                                        {
                                            $html .= '<li>'.$Bullet.'</li>';
                                        }
                                    }       
                                    $html .= '
                                    </td></tr>
                                    ';

                                    $i = $i + 1;

                                    }
                                }
                            }
                            $html .= '
                            </table></td></tr>
                        </table> 
                    </td> 
                    <td valign="top" width="25%" class="tabletdcommon"> 
                         <table class="tableCommon">
                        <tr><td class="tableheader" style="background-color:#DBB333">Economy</td></tr>
                            <tr><td><table>';
                            if(count($Economy)>0)
                            {
                                $i = 0;
                                foreach($products as $valor) 
                                {
                                    if(in_array($valor->id,$Economy))
                                    {
                                    $html .='
                                    <tr>
                                        <td style="color:#41699A">';
                                        if(in_array($valor->id,$EconomyAccepted))
                                            $html .= '<img style="padding-top:2px" src="images/checked.gif" width="8" height="8"/>';
                                        else
                                            $html .= '<img style="padding-top:2px" src="images/unchecked.gif" width="8" height="8"/>';

                                        $html .= '<strong>&nbsp;'.$valor->DisplayName.'</strong></td>
                                        <td valign="top" style="text-align:right"><b><div>$ '.number_format($CostEconomy[$i],2).'</div></b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">'.$EconomyDescription[$i].'</td>
                                    </tr>
                                    <tr><td style="border-bottom: 1px dotted #AEAEAE;" colspan="2">';
                                    $Bullets = explode(',', $valor->Bullets);
                                    foreach($Bullets as $Bullet)
                                    {
                                        if (!(empty($Bullet)))
                                        {
                                            $html .= '<li>'.$Bullet.'</li>';
                                        }
                                    }       
                                    $html .= '
                                    </td></tr>
                                    ';

                                    $i = $i + 1;

                                    }
                                }
                            }
                            $html .= '
                            </table></td></tr>
                        </table> 
                    </td>  
                    <td valign="top" width="25%" class="tabletdcommon"> 
                         <table class="tableCommon">
                        <tr><td class="tableheader" style="background-color:#8F8772">Basic</td></tr>
                            <tr><td><table>';
                            if(count($Basic)>0)
                            {
                                $i = 0;
                                foreach($products as $valor) 
                                {
                                    if(in_array($valor->id,$Basic))
                                    {
                                    $html .='
                                    <tr>
                                        <td style="color:#41699A">';
                                        if(in_array($valor->id,$BasicAccepted))
                                            $html .= '<img style="padding-top:2px" src="images/checked.gif" width="8" height="8"/>';
                                        else
                                            $html .= '<img style="padding-top:2px" src="images/unchecked.gif" width="8" height="8"/>';

                                        $html .= '<strong>&nbsp;'.$valor->DisplayName.'</strong></td>
                                        <td valign="top" style="text-align:right"><b><div>$ '.number_format($CostBasic[$i],2).'</div></b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">'.$BasicDescription[$i].'</td>
                                    </tr>
                                    <tr><td style="border-bottom: 1px dotted #AEAEAE;" colspan="2">';
                                    $Bullets = explode(',', $valor->Bullets);
                                    foreach($Bullets as $Bullet)
                                    {
                                        if (!(empty($Bullet)))
                                        {
                                            $html .= '<li>'.$Bullet.'</li>';
                                        }
                                    }       
                                    $html .= '
                                    </td></tr>
                                    ';

                                    $i = $i + 1;

                                    }
                                }
                            }
                            $html .= '
                            </table></td></tr>
                        </table> 
                    </td> 
                  </tr>'; 
                  if($FaceFooter=='false')
                  {
                  $html .='     
                  <tr>
                    <td class="footercommon">
                      <text class="CostPerDay">Cost Per Day '.$CostFooter[0].'</text><br/>
                      <text>Additonal Payment '.$CostFooter[1].'</text><br/>
                      <text>Monthly Payment '.$CostFooter[2].'</text><br/>
                    </td>

                    <td class="footercommon">
                      <text class="CostPerDay">Cost Per Day '.$CostFooter[5].'</text><br/>
                      <text>Additonal Payment '.$CostFooter[6].'</text><br/>
                      <text>Monthly Payment '.$CostFooter[7].'</text><br/>
                    </td>

                    <td class="footercommon">
                      <text class="CostPerDay">Cost Per Day '.$CostFooter[10].'</text><br/>
                      <text>Additonal Payment '.$CostFooter[11].'</text><br/>
                      <text>Monthly Payment '.$CostFooter[12].'</text><br/>
                    </td>

                    <td class="footercommon">
                      <text class="CostPerDay">Cost Per Day '.$CostFooter[15].'</text><br/>
                      <text>Additonal Payment '.$CostFooter[16].'</text><br/>
                      <text>Monthly Payment '.$CostFooter[17].'</text><br/>
                    </td>
                  </tr>';
                  }
                  else
                  {
                  $html .='
                  <tr class="spacingtr">
                    <td class="footercommon">
                      <text>'.$CostFooter[3].'</text><br/>
                      <text>'.$CostFooter[4].'</text>
                    </td>

                    <td class="footercommon">
                      <text>'.$CostFooter[8].'</text><br/>
                      <text>'.$CostFooter[9].'</text>
                    </td>

                    <td class="footercommon">
                      <text>'.$CostFooter[13].'</text><br/>
                      <text>'.$CostFooter[14].'</text>
                    </td>

                    <td class="footercommon">
                      <text>'.$CostFooter[18].'</text><br/>
                      <text>'.$CostFooter[19].'</text>
                    </td>
                  </tr>';
                  }
                  $html .='
                  <tr valign="bottom">
                    <td colspan="4" style="text-align:center; color:#41699A;">Powered by Automatrix</td>
                  </tr>
                  </table>
    </body>
    </html>';

    PDF::load($html, 'letter','landscape');
    //PDF::AutoPrint(true);
    echo PDF::show('menu');
    }

    public function load_newProduct()
    {
        $Companies = DB::select(DB::raw("SELECT id, CompanyName FROM Company"));
        $Products = DB::select(DB::raw("SELECT ProductBaseId, ProductName FROM ProductBase WHERE CompanyId = " . $Companies[0]->id));
        return View::make('addProduct')->with('Companies', $Companies)->with('Products', $Products);
    }

    public function load_editProduct()
    {
        $Companies = DB::select(DB::raw("SELECT id, CompanyName FROM Company"));
        
        // TODO: Combine the second query and the fourth query seems like is the same filter.
        $CompanySelected = DB::select(DB::raw("  SELECT CompanyId 
                                                    FROM ProductBase 
        	                                        WHERE ProductBaseId = ( SELECT ProductBaseId 
                                                                            FROM Products 
        	                                      	                     WHERE id = " . Input::get('ProductId') . ")"));
        
        $Products = DB::select(DB::raw("SELECT ProductBaseId, ProductName FROM ProductBase WHERE CompanyId = " . $CompanySelected[0]->CompanyId));
        
        $ProductSelected = DB::select(DB::raw("SELECT ProductBaseId FROM Products WHERE id = " . Input::get('ProductId')));
        
        $product = DB::table('Products')->where('id', '=', Input::get('ProductId'))->first();
        
        $optionsXML = simplexml_load_file("js/SelectParams.xml");
        $Terms = $optionsXML->xpath("//ProductBase[@Id=" . $product->ProductBaseId . "]/terms");
        $Types = $optionsXML->xpath("//ProductBase[@Id=" . $product->ProductBaseId . "]/types");
        $Deductibles = $optionsXML->xpath("//ProductBase[@Id=" . $product->ProductBaseId . "]/deductibles");
        $Terms = json_encode($Terms);
        $Terms = json_decode($Terms, true);
        $Types = json_encode($Types);
        $Types = json_decode($Types, true);
        $Deductibles = json_encode($Deductibles);
        $Deductibles = json_decode($Deductibles, true);
        
        if($product->UseRangePricing)
        {
            $data = DB::table("ProductPrice")->where('ProductId', '=', Input::get('ProductId'))
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
        
        return View::make('editProduct')->with('Companies', $Companies)
            ->with('Products', $Products)
            ->with('CompanySelected', $CompanySelected[0]->CompanyId)
            ->with('ProductSelected', $ProductSelected[0]->ProductBaseId)
            ->with('ProductData', $product)
            ->with('product', $product)
            ->with('Terms', $Terms)
            ->with('Types', $Types)
            ->with('Deductibles', $Deductibles);
    }

    public function CreatePDFForms()
    {
        $UserSessionInfo = Session::get('UserSessionInfo');
        $settings = Session::get('settings');
        // $DealerCode = '11401';
        $productId = Input::get('ProductId');
        
        $productOption = new stdClass();
        $productOption->term = Input::get('term');
        $productOption->type = Input::get('type');
        $productOption->deductible = Input::get('deductible');
        $productOption->mileage = Input::get('mileage');
        $productOption->price = Input::get('price');
        $productOption->surcharges = explode(",", Input::get('surcharges'));
        $findKey = Input::get('key');
        
        $deal = Session::get('WebServiceInfo');
        // TODO: Review this code
        $deal->NewFinancedAmount = Input::get('financedAmount');
        $deal->NewDownPayment = Input::get('downpayment');
        $deal->NewAPR = Input::get('apr');
        
        
        $productRatesFull = Session::get('productRatesFull');
        
        $products = DB::table('Products')->join('PlansProducts', 'Products.id', '=', 'PlansProducts.ProductId')
            ->join('ProductBase', 'Products.ProductBaseId', '=', 'ProductBase.ProductBaseId')
            ->where('PlansProducts.DealerId', '=', $UserSessionInfo->DealerId)
            ->where('Products.DealerId', '=', $UserSessionInfo->DealerId)
            ->orderBy('PlansProducts.Order', 'asc')
            ->get();
        
        $settings->IsPDF = 1; // use for choose webservice URL in getproxy function
        
        foreach ($products as $product)
        {
            
            $key = "key" . $product->CompanyId;
            
            $CodeResult = DB::table('SettingsTable')->where('CompanyId', '=', $product->CompanyId)
                ->where('DealerId', '=', $product->DealerId)
                ->first();
            
            // if ($product->UsingWebService == 0 && $product->id == $productId) {
            // echo "Contract available soon";
            // die();
            // }
            // ($product->UsingWebService == 1 || $product->UseRangePricing == 1)
            if($product->id == $productId)
            {
                
                if($product->ProductBaseId == 7 || $product->ProductBaseId == 8 || $product->ProductBaseId == 6)
                {
                    echo "Pdf contract available soon";
                    die();
                }
                
                $productRates = 0;
                
                if($product->UsingWebService == 0 && $product->UseRangePricing != 1)
                {
                    $productRates = $this->getManualProductrate($product, $productOption);
                }
                if($product->UsingWebService == 1)
                {
                    $productRates = $this->getMatchingRateForms($productRatesFull["product" . $product->id], $product, $findKey);
                }
                if($product->UseRangePricing == 1)
                {
                    $productRates = $this->getMatchingRateForms($productRatesFull["product" . $product->id], $product, $productOption);
                }
                if(! is_object($productRates))
                {
                    $productRates = (object) $productRates;
                }
                // print_r($productRates); die();
                $proxy = $this->getProxy($settings, $product);
                $proxies[$key] = $proxy;
                // Execute request to get pricing
                
                $data = $this->getProductDetail($proxy, $product, $deal, $CodeResult->DealerCode, $productOption, $productRates, 1);
                
                if($product->CompanyId == 1)
                {
                    if(! (empty($data)))
                    {
                        try
                        {
                            $pdf = explode('&lt;Pdf&gt;', $data);
                            $pdf = explode('&lt;/Pdf&gt;', $pdf[1]);
                            $response = base64_decode($pdf[0]);
                            if(! (empty($response)))
                            {
                                header("Content-type: application/pdf");
                                print_r($response);
                            }
                            else
                            {
                                echo "An error has occurred";
                            }
                        }
                        catch (Exception $e)
                        {
                            echo "An error has occurred";
                        }
                    }
                    else
                    {
                        echo "An error has occurred";
                    }
                }
                
                if($product->CompanyId == 2)
                {
                    
                    if(! (empty($data)))
                    {
                        // Total Lost Protection (GAP)
                        if($product->ProductBaseId == 11)
                        {
                            if(! (empty($data->GAPAcknowledgement->FormPDF)))
                            {
                                $PDF = $data->GAPAcknowledgement->FormPDF;
                                header("Content-type: application/pdf");
                                print_r($PDF);
                                die();
                            }
                            else
                            {
                                echo "An error has occurred" . "<br>";
                                // print_r($data->GAPAcknowledgement->ContractErrors->ContractError->Message);
                                if(! empty($data->GAPAcknowledgement->ContractErrors->ContractError->Message))
                                {
                                    print_r($data->GAPAcknowledgement->ContractErrors->ContractError->Message);
                                }
                                if(! empty($data->AutomobileErrors->AutomobileError->Message))
                                {
                                    print_r($data->AutomobileErrors->AutomobileError->Message);
                                }
                                die();
                            }
                        }
                        // Vehicle Service Contract
                        if($product->ProductBaseId == 12)
                        {
                            if(! (empty($data->VSCAcknowledgement->FormPDF)))
                            {
                                $PDF = $data->VSCAcknowledgement->FormPDF;
                                header("Content-type: application/pdf");
                                print_r($PDF);
                                die();
                            }
                            else
                            {
                                echo "An error has occurred" . "<br>";
                                if(! empty($data->VSCAcknowledgement->ContractErrors->ContractError->Message))
                                {
                                    print_r($data->VSCAcknowledgement->ContractErrors->ContractError->Message);
                                }
                                if(! empty($data->AutomobileErrors->AutomobileError->Message))
                                {
                                    print_r($data->AutomobileErrors->AutomobileError->Message);
                                }
                                die();
                            }
                        }
                    }
                } // end company 2
                
                if($product->CompanyId == 3)
                {
                    if(empty($data->GenerateContractResult->ContractDocument))
                    {
                        echo "An error has occurred";
                        echo "<br>";
                        if(! (empty($data->GenerateContractResult->Messages->Message->Text)))
                        {
                            print_r($data->GenerateContractResult->Messages->Message->Text);
                        }
                        print_r(round($deal->ZipCode));
                        die();
                    }
                    $data = base64_decode($data->GenerateContractResult->ContractDocument);
                    header("Content-type: application/pdf");
                    print_r($data);
                }
            }
        }
    }

    private function getMatchingRateForms($rates, $product, $findKey)
    {
        if($product->UseRangePricing == 1)
        {
            $rates = $rates['GetRatesResult']['Automobiles']['AutomobileRateQuoteResponse']['AutomobileRateQuotes'];
            
            foreach ($rates['AutomobileRateQuote'] as $key => $rate)
            {
                if($rate['Coverage'] == $findKey->type)
                {
                    if(($findKey->term > $rate['CoverageTermMinMonths']) && ($findKey->term <= $rate['CoverageTermMonths']))
                    {
                        return $rate;
                    }
                }
            }
        } // end if
        
        if($product->CompanyId == 1)
        {
            $index = 0;
            foreach ($rates['Rate'] as $key => $rate)
            {
                if($index == $findKey)
                {
                    return $rate;
                }
                $index = $index + 1;
            }
        }
        
        if($product->CompanyId == 2)
        {
            foreach ($rates['AutomobileRateQuote'] as $key => $rate)
            {
                if($rate["OrderNumber"] == $findKey)
                {
                    return $rate;
                }
            }
        }
        
        if($product->CompanyId == 3)
        {
            
            if(! (is_array($rates->Plan->RateClassMoneys->RateClassMoney)))
            {
                $rate = $rates->Plan->RateClassMoneys->RateClassMoney;
                if($rate->TermMile->TermId == $findKey)
                {
                    $rate->QuoteId = $rates->QuoteId;
                    $rate->ManufactureWarranty = $rates->ManufactureWarranty;
                    $rate->Plan = $rates->Plan->Plan;
                    return $rate;
                }
            }
            
            foreach ($rates->Plan->RateClassMoneys->RateClassMoney as $key => $rate)
            {
                if($rate->TermMile->TermId == $findKey)
                {
                    $rate->QuoteId = $rates->QuoteId;
                    $rate->ManufactureWarranty = $rates->ManufactureWarranty;
                    $rate->Plan = $rates->Plan->Plan;
                    return $rate;
                }
            }
        }
    }

    private function getManualProductrate($product, $productOption)
    {
        $obj = new stdClass();
        if($product->CompanyId == 1)
        {
            switch ($product->ProductBaseId)
            {
                case 1: // US key
                    $obj->CvCvty = 'GKN';
                    $obj->FormNumber = 'USWC GKN 11-12';
                break;
                case 2: // US VSC
                    $obj->CvCvty = 'US46H';
                    $obj->FormNumber = 'USWC US FC 02-12';
                break;
                case 3: // US Gap
                    $obj->CvCvty = ' ';
                    $obj->FormNumber = '';
                break;
                case 4: // US Maintenance
                    $obj->CvCvty = 'OUM';
                    $obj->FormNumber = 'USWC UM FC 10-12';
                break;
                case 5: // US Dent
                    $obj->CvCvty = 'DUSD';
                    $obj->FormNumber = 'USWC PDR USD 06-13';
                break;
                case 9: // US Road Hazard
                    $obj->CvCvty = 'US46R';
                    $obj->FormNumber = 'USWC US FC 02-12';
                break;
                
                default:
                break;
            }
            
            $obj->AmtDueWtyCo = $product->Cost;
            $obj->FiledAmount = $productOption->price;
            $obj->TermMonths = $productOption->term;
            $obj->Deductible = $productOption->deductible;
            $obj->TermMiles = $productOption->mileage;
            $obj->Interval = 1;
        }
        if($product->CompanyId == 2)
        {
            switch ($product->ProductBaseId)
            {
                case 11: // Protective Gap
                    $obj->ProductClass = 'GAP';
                    $obj->ProductClassCode = 50;
                    $obj->Coverage = 'Gap Purchase';
                    $obj->CoverageCode = 'GAPP10';
                    $obj->ProductType = 'GAP';
                    $obj->VehicleClassCode = 'G';
                break;
                case 12: // Protective Vsc
                    $obj->ContractPrefix = 'AD40 ';
                    $obj->ProductClass = 'VSC';
                    $obj->ProductClassCode = 1;
                    $obj->Coverage = 'PREFERRED';
                    $obj->CoverageCode = 'PR08';
                    $obj->ProductType = 'VSC';
                    $obj->VehicleClassCode = 11;
                    $obj->DisappearingDeductible = 0;
                break;
                
                default:
                // code...
                break;
            }
            
            if(empty($productOption->mileage))
            {
                $productOption->mileage = $productOption->term;
            }
            
            $obj->DealerCost = $product->Cost;
            $obj->RetailPrice = $productOption->price;
            $obj->CoverageTermMonths = $productOption->term;
            $obj->CoverageTermMinMonths = $productOption->term;
            $obj->Deductible = $productOption->deductible;
            $obj->CoverageTermMiles = $productOption->mileage;
            $obj->CoverageSortOrder = 1;
            $obj->OrderNumber = 1;
            $obj->RateNumber = 1;
        }
        
        return $obj;
    }

    public function SavetoDMS()
    {
        $UserSessionInfo = Session::get('UserSessionInfo');
        $WebService = Session::get('WebServiceInfo');
        $productRatesFull = Session::get('productRatesFull');
        
        $productsDB = DB::table('Products')->join('PlansProducts', 'Products.id', '=', 'PlansProducts.ProductId')
            ->join('ProductBase', 'Products.ProductBaseId', '=', 'ProductBase.ProductBaseId')
            ->where('PlansProducts.DealerId', '=', $UserSessionInfo->DealerId)
            ->where('Products.DealerId', '=', $UserSessionInfo->DealerId)
            ->orderBy('PlansProducts.Order', 'asc')
            ->get();
        $companies = DB::table('Company')->get();
        
        $productDeal = new stdClass();
        $productDeal->DealNumber = $WebService->Deal;
        $productDeal->Products[] = new stdClass();
        
        $productsJson = json_decode(Input::get('products'));
        $arr = array();
        $index = 0;
        
        foreach ($productsJson as $key => $productJson)
        {
            foreach ($productsDB as $productsDBKey => $productDB)
            {
                if(! (in_array($productJson->ID, $arr)) && ($productDB->ProductBaseId == $productJson->ID))
                {
                    $obj = new stdClass();
                    
                    foreach ($companies as $key => $company)
                    {
                        if($company->id == $productDB->CompanyId)
                        {
                            $obj->Company = $company->CompanyName;
                        }
                    }
                    
                    $obj->ProductName = $productDB->ProductName;
                    
                    if($productDB->UsingWebService == 1)
                    {
                        $rate = $this->getMatchingRateForms($productRatesFull["product" . $productDB->id], $productDB, $productJson->OrderNumber);
                        // print_r($rate);
                        // echo "<br>";
                        
                        if(array_key_exists('DealerCost', $rate))
                        {
                            $obj->ProductCost = number_format((float) $rate['DealerCost'], 2, '.', '');
                        }
                        if(array_key_exists('AmtDueWtyCo', $rate))
                        {
                            $obj->ProductCost = number_format((float) $rate['AmtDueWtyCo'], 2, '.', '');
                        }
                    }
                    else
                    {
                        $obj->ProductCost = number_format((float) $productDB->Cost, 2, '.', '');
                    }
                    
                    if($productDB->CompanyId == 3)
                    {
                        $obj->ProductCost = number_format((float) $productJson->Amount, 2, '.', '');
                    }
                    
                    $obj->ProductAmount = number_format((float) $productJson->Amount, 2, '.', '');
                    $obj->ProductType = $productDB->ProductType;
                    
                    if($obj->ProductCost > $obj->ProductAmount)
                    {
                        return 'The product amount for ' . $obj->Company . ' ' . $obj->ProductName . ' is lower than the product cost';
                    }
                    
                    array_push($arr, $productJson->ID);
                    $productDeal->Products[$index] = $obj;
                    $index ++;
                    // array_push($productDeal->Products, );
                }
            }
        }
        
        // $url = "http://webservice.automatrix.co/api/deal/";
        // $productDeal = json_encode($productDeal);
        // $options = array(
        // 'http' => array(
        // 'method' => 'PUT',
        // 'content' => $productDeal,
        // 'header'=> "Content-Type: application/json\r\n" .
        // "Accept: application/json\r\n"
        // )
        // );
        
        // $context = stream_context_create($options);
        // $result = file_get_contents($url, false, $context);
        // $response = json_decode($result);
        // var_dump($response);
        
        // print_r($productsJson);
        // echo "<br>";
        // echo "<br>";
        
        return json_encode($productDeal);
    }

    private function deleteVarSession()
    {
        Session::forget('WebServiceInfo');
    }

    /*
    *   Add here all Known reason of product fail
    *
    */
    private function GetReasonFailWebService($name, $deal)
    {
        $message =  $name.'is not available! try again';
        if ($deal->BeginningOdometer > 113999) {
            $message = $name.' not allowed vehicles with more than 113999 miles';
        }

        return $message;
    }
}
