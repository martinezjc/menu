<?php
use Illuminate\Support\Facades\Cache;

class ContractController extends BaseController
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

    
    public function index()
    {
        # Session var
        $UserSessionInfo = Session::get('UserSessionInfo');
        $productRatesFull = Session::get('productRatesFull');
        $settings = Session::get('settings');
        $deal = Session::get('WebServiceInfo');

        # request var
        $productId = Input::get('ProductId');        
        $productOption = new stdClass();
        $productOption->term = Input::get('term');
        $productOption->type = Input::get('type');
        $productOption->deductible = Input::get('deductible');
        $productOption->mileage = Input::get('mileage');
        $productOption->price = Input::get('price');
        $productOption->surcharges = explode(",", Input::get('surcharges'));
        $productOption->tireRotation = Input::get('tire');
        $productOption->interval = Input::get('interval');
        $findKey = Input::get('key');
        $deal->NewFinancedAmount = Input::get('financedAmount');
        $deal->NewDownPayment = Input::get('downpayment');
        $deal->NewAPR = Input::get('apr');

        #use for choose webservice URL in getproxy function
        $settings->IsPDF = 1;
        
        // TODO: Review this code 
        $product = DB::table('Products')
            ->join('PlansProducts', 'Products.id', '=', 'PlansProducts.ProductId')
            ->join('ProductBase', 'Products.ProductBaseId', '=', 'ProductBase.ProductBaseId')
            ->where('PlansProducts.DealerId', '=', $UserSessionInfo->DealerId)
            ->where('Products.DealerId', '=', $UserSessionInfo->DealerId)
            ->where('Products.id', '=', $productId)
            ->orderBy('PlansProducts.Order', 'asc')
            //->get();
            ->first(array(
                    "Products.id",
                    "Products.ProductBaseId",
                    "Products.ProductName",
                    "Products.IsTaxable",
                    "Products.UseRangePricing",
                    "Products.SellingPrice",
                    "Products.UsingWebService",
                    "Products.VehiclePlan",
                    "Products.Type",
                    "Products.Term",
                    "Products.Deductible",
                    "Products.Mileage",
                    "Products.TireRotation",
                    "Products.Interval",
                    "ProductBase.CompanyId",
                    "PlansProducts.DealerId",
                    "PlansProducts.ProductId"
                ));

        //print_r($product); die();

        $CodeResult = DB::table('SettingsTable')
                        ->where('CompanyId', '=', $product->CompanyId)
                        ->where('DealerId', '=', $product->DealerId)
                        ->first(array("DealerCode"));

        


        ##---------------- try to get contract form  --------------- ##
        
        if($product->ProductBaseId == 7 || $product->ProductBaseId == 8 || $product->ProductBaseId == 6){
            echo "Pdf contract available soon";
            die();
        }
        
        $productRates = 0;
        
        if($product->UsingWebService == 0 && $product->UseRangePricing != 1){
            $productRates = $this->getManualProductrate($product, $productOption);
        }
        if($product->UsingWebService == 1){
            $productRates = $this->getMatchingRateForms($productRatesFull["product" . $product->id], $product, $findKey);
        }
        if($product->UseRangePricing == 1){
            $productRates = $this->getMatchingRateForms($productRatesFull["product" . $product->id], $product, $productOption);
        }
        if(! is_object($productRates)){
            $productRates = (object) $productRates;
        }
        
        $key = "key" . $product->CompanyId;
        $proxy = $this->getProxy($settings, $product);


        // Execute request to get pricing
        $data = $this->getProductDetail($proxy, $product, $deal, $CodeResult->DealerCode, $productOption, $productRates, 1);

        ##---------------- try to show contract form  --------------- ##

         if($product->CompanyId == 1){
            if(! (empty($data))){
                try{
                    $pdf = explode('&lt;Pdf&gt;', $data);
                    $pdf = explode('&lt;/Pdf&gt;', $pdf[1]);
                    $response = base64_decode($pdf[0]);
                    if(! (empty($response))){
                        header("Content-type: application/pdf");
                        print_r($response);
                    }else{
                        echo "An error has occurred";
                    }
                }
                catch (Exception $e){
                    echo "An error has occurred <br>";
                    echo "Could not retrieve pdf contract";
                    //echo $data;
                }
            }
            else{
                echo "An error has occurred <br>";
                echo "Empty response from server";
            }
        }
        
        if($product->CompanyId == 2){
            
            if(! (empty($data))){
                // Total Lost Protection (GAP)
                if($product->ProductBaseId == 11){
                    if(! (empty($data->GAPAcknowledgement->FormPDF))){
                        $PDF = $data->GAPAcknowledgement->FormPDF;
                        header("Content-type: application/pdf");
                        print_r($PDF);
                        die();
                    }
                    else{
                        echo "An error has occurred" . "<br>";
                        // print_r($data->GAPAcknowledgement->ContractErrors->ContractError->Message);
                        if(! empty($data->GAPAcknowledgement->ContractErrors->ContractError->Message)){
                            print_r($data->GAPAcknowledgement->ContractErrors->ContractError->Message);
                        }
                        if(! empty($data->AutomobileErrors->AutomobileError->Message)){
                            print_r($data->AutomobileErrors->AutomobileError->Message);
                        }
                        die();
                    }
                }
                // Vehicle Service Contract
                if($product->ProductBaseId == 12){
                    if(! (empty($data->VSCAcknowledgement->FormPDF))){
                        $PDF = $data->VSCAcknowledgement->FormPDF;
                        header("Content-type: application/pdf");
                        print_r($PDF);
                        die();
                    }
                    else{
                        echo "An error has occurred" . "<br>";
                        if(! empty($data->VSCAcknowledgement->ContractErrors->ContractError->Message)){
                            print_r($data->VSCAcknowledgement->ContractErrors->ContractError->Message);
                        }
                        if(! empty($data->AutomobileErrors->AutomobileError->Message)){
                            print_r($data->AutomobileErrors->AutomobileError->Message);
                        }
                        die();
                    }
                }
            }
        } // end company 2
        
        if($product->CompanyId == 3){
            if(empty($data->GenerateContractResult->ContractDocument)){
                echo "An error has occurred";
                echo "<br>";
                if(! (empty($data->GenerateContractResult->Messages->Message->Text))){
                    print_r($data->GenerateContractResult->Messages->Message->Text);
                }
                die();
            }
            $data = base64_decode($data->GenerateContractResult->ContractDocument);
            header("Content-type: application/pdf");
            print_r($data);
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
            $obj->TermMonths = $product->Term;
            $obj->Deductible = $product->Deductible;
            $obj->TermMiles = $product->Mileage;
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
        
        //Road vantages
        if ($product->CompanyId == 3) { 
            echo "Pdf Contract with manual price not available yet";die();
        }
        return $obj;
    }


}