<?php


namespace Api\Services;

/**
 * Actual implementation for Protective webservice
 *
 * @author brittongr
 *        
 */
class ProtectiveServiceProxy extends ServiceProxy
{

    function __construct($proxy, $settings)
    {
        parent::__construct($proxy, $settings);
    }

    protected function buildProxy($settings)
    {
        // TODO: Read the current hardcoded values from the settings
        $this->proxy->__setLocation($settings->webservice->url);
    }

    public function execute($request)
    {
        $method = $this->getMethod($request);
        
        set_time_limit(180);
        ini_set("default_socket_timeout", 180);
        
        try
        {
            $response = $this->proxy->$method($this->getParameters($request));
            
            if($request->type == 0)
            { // Get Rates
                $dat = (array) $response;
                $json = json_encode($dat);
                $data = json_decode($json, true);
                return $data;
            }
            else
            { // Get PDF Contract
                return $response->GetContractFormsResult->Automobiles->AutomobileContractFormsResponse;
            }
        }
        catch (SoapFault $e)
        {
            echo $e->faultcode;
        }
    }

    private function getMethod($request)
    {
        $method = "";
        $productBaseId = $request->product->ProductBaseId;
        
        if($request->type == 0)
        {
            if($productBaseId == 11 || $productBaseId == 12)
                $method = "GetRates";
        }
        else
        {
            if($productBaseId == 11 || $productBaseId == 12)
                $method = "GetContractForms";
        }
        
        return $method;
    }

    private function getParameters($data)
    {
        $parameters = null;
        $productBaseId = $data->product->ProductBaseId;
        
        // Get Rates
        if($data->type == 0)
        {
            
            if($productBaseId == 12)
            {
                $request = new \stdClass();
                $request->Validation = new \stdClass();
                $request->Validation->Username = $data->deal->Username;
                $request->Validation->Password = $data->deal->Password;
                $request->DealerNumber = $data->dealercode;
                $request->Automobiles = array();
                $request->Automobiles[0] = new \stdClass();
                $request->Automobiles[0]->VIN = $data->deal->VIN;
                $request->Automobiles[0]->Lender = 'Other';
                $request->Automobiles[0]->ProductClassCode = 0;
                
                $request->Automobiles[0]->MarkUp = new \stdClass();
                $request->Automobiles[0]->MarkUp->MarkupType = 'ByPercent';
                $request->Automobiles[0]->MarkUp->Type = 'ByPercent';
                $request->Automobiles[0]->MarkUp->Value = 0;
                
                $request->Automobiles[0]->VSCRateOptions = new \stdClass();
                $request->Automobiles[0]->VSCRateOptions->InServiceDate = date('c');
                $request->Automobiles[0]->VSCRateOptions->BeginningOdometer = $data->deal->BeginningOdometer; // 5000;
                $request->Automobiles[0]->VSCRateOptions->VehiclePlan = $data->product->VehiclePlan;
                
                $request->Automobiles[0]->VSCRateOptions->Surcharges = new \stdClass();
                $request->Automobiles[0]->VSCRateOptions->Surcharges->BusinessUse = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->ConversionPackage = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->ConversionVAN = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->ElectronicsPackage = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->GPS = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->TenCylinder = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->TwelveCylinder = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->Hybrid = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->FourWDTurbo = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->ACSystem = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->LiftKitTireWheel = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->SnowPlow = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->MobilityEquipment = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->SealsGaskets = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->VideoPackage = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->DualWheel = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->KiaElligibility = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->Kia100000 = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->LimitedLiability75k = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->EngineSize = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->LiftKit = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->LiftKit100 = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->LiftKit200 = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->LiftKit4Inch = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->LiftKit6Inch = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->EntertainmentPackage = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->PaintlessDentRemoval = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->WindShield = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->CommercialUse = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->PowerSteps = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->OneTon = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->TireWheel = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->Turbo = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->Diesel = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->FourByFour = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->FourWheelSteering = false;
                $request->Automobiles[0]->VSCRateOptions->Surcharges->LEWUpsell = false;
                
                $parameters = array(
                    "RateRequest" => $request
                );
            }
            else 
                if($productBaseId == 11)
                {
                    $request = new \stdClass();
                    $request->Validation = new \stdClass();
                    $request->Validation->Username = $data->deal->Username;
                    $request->Validation->Password = $data->deal->Password;
                    $request->DealerNumber = $data->dealercode;
                    $request->Automobiles = array();
                    $request->Automobiles[0] = new \stdClass();
                    $request->Automobiles[0]->VIN = $data->deal->VIN;
                    $request->Automobiles[0]->ID = "";
                    $request->Automobiles[0]->ProductClassCode = 0;
                    $request->Automobiles[0]->Lender = 'Other';
                    
                    $request->Automobiles[0]->MarkUp = new \stdClass();
                    $request->Automobiles[0]->MarkUp->MarkupType = 'ByPercent';
                    $request->Automobiles[0]->MarkUp->Type = 'ByPercent';
                    $request->Automobiles[0]->MarkUp->Value = 0;
                    
                    $request->Automobiles[0]->GAPRateOptions = new \stdClass();
                    $request->Automobiles[0]->GAPRateOptions->AmountMSRP = 0;
                    $request->Automobiles[0]->GAPRateOptions->AmountFinanced = $data->deal->FinancedAmount; // 15000;
                    $request->Automobiles[0]->GAPRateOptions->BeginningOdometer = $data->deal->BeginningOdometer; // 5000;
                    $request->Automobiles[0]->GAPRateOptions->FinancingType = 'Purchase';
                    $request->Automobiles[0]->GAPRateOptions->ContractPrefix = "401";
                    $request->Automobiles[0]->GAPRateOptions->VehiclePurchasePrice = $data->deal->SalesPrice;
                    
                    $parameters = array(
                        "RateRequest" => $request
                    );
                }
        }
        else
        { // Get PDF Contract
                 
            // Do validations of data
            $data = $this->ValidateRequest($data);
            
            if($productBaseId == 11 || $productBaseId == 12)
            {
                // get Contract Numbers
                $contractNumber = $this->GetContractNumbers($data);
                
                $request = new \stdClass();
                $request->Validation = new \stdClass();
                $request->Validation->Username = $data->deal->Username;
                $request->Validation->Password = $data->deal->Password;
                $request->DealerNumber = $data->dealercode;
                $request->Automobiles = array();
                $request->Automobiles[0] = new \stdClass();
                $request->Automobiles[0]->VIN = $data->deal->VIN;
                $request->Automobiles[0]->VehiclePurchaseDate = date('c');
                
                $request->Automobiles[0]->Lienholder = new \stdClass();
                $request->Automobiles[0]->Lienholder->Name = $data->deal->LienHolderName;
                $request->Automobiles[0]->Lienholder->PhoneNumber = $data->deal->LienHolderPhone;
                $request->Automobiles[0]->Lienholder->Address = new \stdClass();
                $request->Automobiles[0]->Lienholder->Address->Address1 = $data->deal->LienHolderAddress;
                //$request->Automobiles[0]->Lienholder->Address->Address2 = ""; //$data->deal->LienHolderAddress2;
                $request->Automobiles[0]->Lienholder->Address->City = $data->deal->LienHolderCity;
                $request->Automobiles[0]->Lienholder->Address->State = $data->deal->LienHolderState;
                $request->Automobiles[0]->Lienholder->Address->StateCode='FL'; // TODO: Read this from the deal information
                $request->Automobiles[0]->Lienholder->Address->Country = $data->deal->LienHolderCountry;
                $request->Automobiles[0]->Lienholder->Address->CountryCode = 'UnitedStatesOfAmerica';
                $request->Automobiles[0]->Lienholder->Address->ZipCode = $data->deal->LienHolderZip;

                $request->Automobiles[0]->Purchaser = new \stdClass();
                $request->Automobiles[0]->Purchaser->FirstPurchaser = new \stdClass();
                $request->Automobiles[0]->Purchaser->FirstPurchaser->FirstName = $data->FirstName;
                $request->Automobiles[0]->Purchaser->FirstPurchaser->MiddleInitial = "";
                $request->Automobiles[0]->Purchaser->FirstPurchaser->LastName = $data->LastName;
                $request->Automobiles[0]->Purchaser->CustomerPhoneNumber = $data->deal->Telephone;
                $request->Automobiles[0]->Purchaser->CustomerEmail = $data->deal->Email;
                
                $request->Automobiles[0]->Purchaser->Address = new \stdClass();
                $request->Automobiles[0]->Purchaser->Address->Address1 = $data->deal->Address1;
                // $request->Automobiles[0]->Purchaser->Address->Address2 = $data->deal->Address2;
                $request->Automobiles[0]->Purchaser->Address->City = $data->deal->City;
                $request->Automobiles[0]->Purchaser->Address->State = $data->deal->State;
                $request->Automobiles[0]->Purchaser->Address->StateCode = strtoupper($data->deal->State);
                $request->Automobiles[0]->Purchaser->Address->ZipCode = round($data->deal->ZipCode);
                $request->Automobiles[0]->Purchaser->Address->Country = $data->deal->Country;
                $request->Automobiles[0]->Purchaser->Address->CountryCode = 'UnitedStatesOfAmerica'; // $data->deal->Country;
                                                                                                     
                // Vehicle Service Contract
                if($productBaseId == 12)
                {
                    
                    $request->Automobiles[0]->VSCContract = new \stdClass();
                    $request->Automobiles[0]->VSCContract->VSCContractDetails = new \stdClass();
                    $request->Automobiles[0]->VSCContract->VSCContractDetails->ContractNumber = $contractNumber; // 50000;
                    $request->Automobiles[0]->VSCContract->VSCContractDetails->ContractPrefix = $data->productRates->ContractPrefix; // "CG50";
                    $request->Automobiles[0]->VSCContract->VSCContractDetails->EffectiveDate = date('c');
                    $request->Automobiles[0]->VSCContract->VSCContractDetails->PurchaseDate = date('c');
                    $request->Automobiles[0]->VSCContract->VSCContractDetails->VehiclePurchaseDate = date('c');
                    
                    $request->Automobiles[0]->VSCContract->VSCContractDetails->RateQuote = new \stdClass();
                    $request->Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->CoverageTermMonths = $data->productOptions->term;
                    $request->Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->RetailPrice = $data->productOptions->price;
                    $request->Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->ProductType = $data->productRates->ProductType; // 'VSC';
                    $request->Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->RateNumber = $data->productRates->RateNumber; // 191462;
                    $request->Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->ProductClass = $data->productRates->ProductClass; // "VSC";
                    $request->Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->ProductClassCode = $data->productRates->ProductClassCode; // 1;
                    $request->Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->Coverage = $data->productOptions->type;
                    $request->Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->CoverageCode = $data->productRates->CoverageCode; // "BAS08";
                    $request->Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->OrderNumber = $data->productRates->OrderNumber; // 0;
                    $request->Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->CoverageTermMinMonths = $data->productOptions->term;
                    $request->Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->CoverageTermMiles = $data->productOptions->mileage;
                    $request->Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->CoverageSortOrder = $data->productRates->CoverageSortOrder; // ;
                    $request->Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->Deductible = $data->productOptions->deductible;
                    $request->Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->DealerCost = 368;
                    $request->Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->ContractFormID = 0;
                    $request->Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->DisappearingDeductible = $data->DisappearingDeductible;
                    
                    $request->Automobiles[0]->VSCContract->MileageAtInServiceDate = ""; // date('c');
                    $request->Automobiles[0]->VSCContract->VehiclePlan = $data->product->VehiclePlan;
                    $request->Automobiles[0]->VSCContract->BeginningOdometer = $data->deal->BeginningOdometer;
                    $request->Automobiles[0]->VSCContract->InServiceDate = date('c');
                    $request->Automobiles[0]->VSCContract->VehiclePurchasePrice = $data->deal->SalesPrice; // 20000;
                    $request->Automobiles[0]->VSCContract->FinancingType = 'Purchase';
                    $request->Automobiles[0]->VSCContract->ContractSalesTax = 0;
                    
                    $request->Automobiles[0]->VSCContract->Surcharges = new \stdClass();
                    $request->Automobiles[0]->VSCContract->Surcharges->BusinessUse = $data->productOptions->surcharges[0];
                    $request->Automobiles[0]->VSCContract->Surcharges->ConversionPackage = $data->productOptions->surcharges[1];
                    $request->Automobiles[0]->VSCContract->Surcharges->ElectronicsPackage = $data->productOptions->surcharges[2];
                    $request->Automobiles[0]->VSCContract->Surcharges->GPS = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->MobilityEquipment = $data->productOptions->surcharges[3];
                    $request->Automobiles[0]->VSCContract->Surcharges->SealsGaskets = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->VideoPackage = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->ConversionVAN = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->DualWheel = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->KiaElligibility = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->Kia100000 = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->LimitedLiability75k = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->EngineSize = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->LiftKit = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->LiftKit100 = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->LiftKit200 = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->LiftKit4Inch = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->LiftKit6Inch = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->EntertainmentPackage = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->PaintlessDentRemoval = false;
                    
                    $request->Automobiles[0]->VSCContract->Surcharges->WindShield = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->CommercialUse = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->PowerSteps = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->OneTon = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->TireWheel = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->Turbo = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->Diesel = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->FourByFour = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->FourWheelSteering = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->LEWUpsell = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->TenCylinder = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->TwelveCylinder = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->Hybrid = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->FourWDTurbo = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->ACSystem = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->LiftKitTireWheel = false;
                    $request->Automobiles[0]->VSCContract->Surcharges->SnowPlow = false;
                }
                
                // GAP
                if($productBaseId == 11)
                {
                    $request->Automobiles[0]->GAPContract = new \stdClass();
                    $request->Automobiles[0]->GAPContract->AmountFinanced = $data->deal->NewFinancedAmount;
                    $request->Automobiles[0]->GAPContract->AmountMSRP = $data->deal->NewFinancedAmount;
                    $request->Automobiles[0]->GAPContract->APR = $data->deal->APR;
                    $request->Automobiles[0]->GAPContract->BeginningOdometer = $data->deal->BeginningOdometer;
                    $request->Automobiles[0]->GAPContract->DownPayment = $data->deal->DownPayment;
                    $request->Automobiles[0]->GAPContract->FinancingType = 'Purchase';
                    $request->Automobiles[0]->GAPContract->InsuranceDeductible = 0;
                    $request->Automobiles[0]->GAPContract->MileageAtInServiceDate = ""; // date('c');
                    
                    $request->Automobiles[0]->GAPContract->GAPContractDetails = new \stdClass();
                    $request->Automobiles[0]->GAPContract->GAPContractDetails->ContractPrefix = $data->productRates->ContractPrefix;
                    $request->Automobiles[0]->GAPContract->GAPContractDetails->ContractNumber = $contractNumber; // 50000;
                    $request->Automobiles[0]->GAPContract->GAPContractDetails->EffectiveDate = date('c');
                    $request->Automobiles[0]->GAPContract->GAPContractDetails->PurchaseDate = date('c');
                    $request->Automobiles[0]->GAPContract->GAPContractDetails->VehiclePurchaseDate = date('c');
                    
                    $request->Automobiles[0]->GAPContract->GAPContractDetails->RateQuote = new \stdClass();
                    $request->Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->ProductClass = $data->productRates->ProductClass; // "GAP";
                    $request->Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->ProductClassCode = $data->productRates->ProductClassCode; // 50;
                    $request->Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->CoverageCode = $data->productRates->CoverageCode; // "G13L1P";
                    $request->Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->CoverageTermMonths = $data->productOptions->term;
                    $request->Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->RetailPrice = $data->productOptions->price;
                    $request->Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->ProductType = $data->productRates->ProductType; // 'GAP';
                    $request->Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->RateNumber = $data->productRates->RateNumber; // 188608;
                    $request->Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->OrderNumber = $data->productRates->OrderNumber; // ;
                    $request->Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->CoverageTermMinMonths = $data->productRates->CoverageTermMinMonths;
                    $request->Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->CoverageTermMiles = $data->productRates->CoverageTermMiles;
                    $request->Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->CoverageSortOrder = $data->productRates->CoverageSortOrder; // 3;
                    $request->Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->Deductible = $data->productOptions->deductible;
                    $request->Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->ContractFormID = 0;
                    
                    $request->Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->DisappearingDeductible = false;
                    $request->Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->DealerCost = false;
                }
                
                $parameters = array(
                    "contractFormsRequest" => $request
                );
            }
        }
        
        // print_r(json_encode($parameters));
        // die();
        return $parameters;
    }

    private function GetContractNumbers($data)
    {
        // if ($data->product->ProductBaseId == 11) {
        // $data->productRates->ContractPrefix = "401";
        // }
        
        // if (empty($data->productRates->ContractPrefix)) {
        // $data->productRates->ContractPrefix = "SELUP";
        // }
        
        // print_r($data->productRates->CoverageCode);
        // die();
        $request = new \stdClass();
        $request->Validation = new \stdClass();
        $request->Validation->Username = $data->deal->Username;
        $request->Validation->Password = $data->deal->Password;
        $request->DealerNumber = $data->dealercode;
        $request->ContractNumberRequests = new \stdClass();
        $request->ContractNumberRequests->ContractNumberRequest = new \stdClass();
        $request->ContractNumberRequests->ContractNumberRequest->ContractPrefix = $data->productRates->ContractPrefix;
        
        $parameters = array(
            "NumbersRequest" => $request
        );
        
        $response = $this->proxy->GetContractNumbers($parameters);
        
        if(! (empty($response->GetContractNumbersResult->ContractNumberResponses->ContractNumberResponse->ContractNumber)))
        {
            return $response->GetContractNumbersResult->ContractNumberResponses->ContractNumberResponse->ContractNumber;
        }
        else
        {
            return 0;
        }
    }

    private function ValidateRequest($data)
    {
        if($data->product->ProductBaseId == 12)
        {
            if(count($data->productOptions->surcharges) != 4)
            {
                for ($i = 0; $i < 4; $i ++)
                {
                    $data->productOptions->surcharges[i] = 0;
                }
            }
            
            if($data->productOptions->deductible == '100D')
            {
                $data->productOptions->deductible = 100;
                $data->DisappearingDeductible = true;
            }
            else
            {
                $data->DisappearingDeductible = false;
            }
        }
        
        if(strlen(round($data->deal->ZipCode)) < 5)
        {
            $data->deal->ZipCode = 12345;
        }
        
        $fullName = explode(" ", trim($data->deal->Buyer), 2);
        $data->FirstName = $fullName[0];
        
        // if surename is too longer , only show the initial of last string
        if(strlen(trim($fullName[1])) > 15)
        {
            $arr = explode(" ", trim($fullName[1]), 2);
            $data->LastName = $arr[0] . ' ' . substr($arr[1], 0, 1);
        }
        else
        {
            $data->LastName = trim($fullName[1]);
        }
        
        if(empty($data->productOptions->mileage))
        {
            $data->productOptions->mileage = $data->productRates->CoverageTermMiles;
        }
        
        if($data->productOptions->mileage == 0)
        {
            $data->productOptions->mileage = $data->productRates->CoverageTermMiles;
        }
        
        if(empty($data->productRates->ContractPrefix))
        {
            $data->productRates->ContractPrefix = $this->GetContractPrefix($data->productRates->CoverageCode);
        }
        
        // return request validated
        return $data;
    }
    
    //
    private function GetContractPrefix($CoverageCode)
    {
        // Product Automobile: Lifetime
        if($CoverageCode == "00ENG")
        {
            $ContractPrefix = "LEW00";
        }
        // Product Automobile: Mileage Plus
        if($CoverageCode == "0MPX1" || $CoverageCode == "0MPX2" || $CoverageCode == "0MPXE")
        {
            $ContractPrefix = "MPP00";
        }
        // Product Automobile: Select New Premium
        if($CoverageCode == "00NEW" || $CoverageCode == "00PRM")
        {
            $ContractPrefix = "SELNP";
        }
        // Product Automobile: Select Powertrain
        if($CoverageCode == "00PWR")
        {
            $ContractPrefix = "SELUP";
        }
        
        // Product Automobile: GAP
        if($CoverageCode == "GAPP10" || $CoverageCode == "GAPL10" || $CoverageCode == "GAPB10")
        {
            $ContractPrefix = "401";
        }
        
        return $ContractPrefix;
    }
}
