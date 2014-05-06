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
        # TODO: Read the current hardcoded values from the settings
        $this->proxy->__setLocation($settings->webservice->url);
    }

    ##---------------- Execute request and return response --------------- ##
    public function execute($request)
    {        
        set_time_limit(60);
        try
        {
            $method = $this->getMethod($request->type);
            $response = $this->proxy->$method($this->getParameters($request));
            return $this->getResponse($request->type, $response);
        }
        catch (SoapFault $e)
        {
            echo $e->faultcode;
        }
    }

    ##----------------  --------------- ##
    private function getResponse($type, $response)
    {
        if ($type == 0) {
            # Rates Response
            $dat = (array) $response;
            $json = json_encode($dat);
            $data = json_decode($json, true);
            return $data;            
        }else{
            # Contract Response
            return $response->GetContractFormsResult->Automobiles->AutomobileContractFormsResponse;
        }
    }

    ##---------------- Get Method for  Request --------------- ##
    private function getMethod($type)
    {
        $method = "";

        if($type == 0){            
                $method = "GetRates";
        }
        else{           
                $method = "GetContractForms";
        }
        
        return $method;
    }

    ##---------------- Get parameters for  Request --------------- ##
    private function getParameters($data)
    {
        $parameters = null;
        $request = new \stdClass();
        $request->Validation = new \stdClass();
        $request->Validation->Username = $data->deal->Username;
        $request->Validation->Password = $data->deal->Password;
        $request->DealerNumber = $data->dealercode; 
        $request->Automobiles = array();       
        
        if($data->type == 0){
            # Get Rates parameters
            $request->Automobiles = $this->getRatesParameters($data);
            $parameters = array(
                "RateRequest" => $request
            );
        }else{        
            # Do validations of data
            $data = $this->ValidateRequest($data);

            # Get Contract parameters
            $request->Automobiles = $this->getContractParameters($data);
            $parameters = array(
                "contractFormsRequest" => $request
            );
        }
        return $parameters;
    }

    ##---------------- Get parameter for  Rates  Request --------------- ##
    private function getRatesParameters($data){

        $Automobiles = array();
        $Automobiles[0] = new \stdClass();
        $Automobiles[0]->VIN = $data->deal->VIN;
        $productBaseId = $data->product->ProductBaseId;

        # Vehicle Service Contract
        if($productBaseId == 12){        
            $Automobiles[0]->Lender = 'None';
            $Automobiles[0]->ProductClassCode = 0;            
            $Automobiles[0]->MarkUp = new \stdClass();
            $Automobiles[0]->MarkUp->MarkupType = 'ByPercent';
            $Automobiles[0]->MarkUp->Type = 'ByPercent';
            $Automobiles[0]->MarkUp->Value = 0;            
            $Automobiles[0]->VSCRateOptions = new \stdClass();
            $Automobiles[0]->VSCRateOptions->InServiceDate = date('c');
            $Automobiles[0]->VSCRateOptions->BeginningOdometer = $data->deal->BeginningOdometer; # 5000;
            $Automobiles[0]->VSCRateOptions->VehiclePlan = $data->product->VehiclePlan;            
            $Automobiles[0]->VSCRateOptions->Surcharges = new \stdClass();
            $Automobiles[0]->VSCRateOptions->Surcharges->BusinessUse = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->ConversionPackage = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->ConversionVAN = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->ElectronicsPackage = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->GPS = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->TenCylinder = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->TwelveCylinder = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->Hybrid = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->FourWDTurbo = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->ACSystem = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->LiftKitTireWheel = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->SnowPlow = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->MobilityEquipment = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->SealsGaskets = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->VideoPackage = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->DualWheel = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->KiaElligibility = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->Kia100000 = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->LimitedLiability75k = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->EngineSize = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->LiftKit = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->LiftKit100 = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->LiftKit200 = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->LiftKit4Inch = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->LiftKit6Inch = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->EntertainmentPackage = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->PaintlessDentRemoval = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->WindShield = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->CommercialUse = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->PowerSteps = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->OneTon = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->TireWheel = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->Turbo = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->Diesel = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->FourByFour = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->FourWheelSteering = false;
            $Automobiles[0]->VSCRateOptions->Surcharges->LEWUpsell = false;
        
        }
        # Protective Gap
        if($productBaseId == 11){
            
            $Automobiles[0]->ID = "";
            $Automobiles[0]->ProductClassCode = 0;
            $Automobiles[0]->Lender = 'Other';            
            $Automobiles[0]->MarkUp = new \stdClass();
            $Automobiles[0]->MarkUp->MarkupType = 'ByPercent';
            $Automobiles[0]->MarkUp->Type = 'ByPercent';
            $Automobiles[0]->MarkUp->Value = 0;            
            $Automobiles[0]->GAPRateOptions = new \stdClass();
            $Automobiles[0]->GAPRateOptions->AmountMSRP = 0;
            $Automobiles[0]->GAPRateOptions->AmountFinanced = $data->deal->FinancedAmount; # 15000;
            $Automobiles[0]->GAPRateOptions->BeginningOdometer = $data->deal->BeginningOdometer; # 5000;
            $Automobiles[0]->GAPRateOptions->FinancingType = 'Purchase';
            $Automobiles[0]->GAPRateOptions->ContractPrefix = "401";
            $Automobiles[0]->GAPRateOptions->VehiclePurchasePrice = $data->deal->SalesPrice;
            
            
        }
        return $Automobiles;
    }

    ##---------------- Get parameter for  Contract  Request --------------- ##
    private function getContractParameters($data){

        $Automobiles = array();
        $Automobiles[0] = new \stdClass();
        $Automobiles[0]->VIN = $data->deal->VIN;

        # get Contract Numbers
        $contractNumber = $this->getContractNumbers($data);
        $productBaseId = $data->product->ProductBaseId;

        $date=explode('T',$data->deal->VehiclePurchaseDate);
        $Automobiles[0]->VehiclePurchaseDate = date('c', strtotime($date[0]));
        
        $Automobiles[0]->Lienholder = new \stdClass();
        $Automobiles[0]->Lienholder->Name = $data->deal->LienHolderName;
        $Automobiles[0]->Lienholder->PhoneNumber = $data->deal->LienHolderPhone;
        $Automobiles[0]->Lienholder->Address = new \stdClass();
        $Automobiles[0]->Lienholder->Address->Address1 = $data->deal->LienHolderAddress;
        $Automobiles[0]->Lienholder->Address->City = $data->deal->LienHolderCity;
        $Automobiles[0]->Lienholder->Address->State = $data->deal->LienHolderState;
        $Automobiles[0]->Lienholder->Address->StateCode=$data->deal->LienHolderState;
        $Automobiles[0]->Lienholder->Address->Country = $data->deal->LienHolderCountry;
        $Automobiles[0]->Lienholder->Address->CountryCode = 'UnitedStatesOfAmerica';
        $Automobiles[0]->Lienholder->Address->ZipCode = $data->deal->LienHolderZip;

        $Automobiles[0]->Purchaser = new \stdClass();
        $Automobiles[0]->Purchaser->FirstPurchaser = new \stdClass();
        $Automobiles[0]->Purchaser->FirstPurchaser->FirstName = $data->deal->FirstName;
        $Automobiles[0]->Purchaser->FirstPurchaser->MiddleInitial = substr($data->deal->MiddleName, 0, 1); # Only send the intials middlename
        $Automobiles[0]->Purchaser->FirstPurchaser->LastName = $data->deal->LastName;
        $Automobiles[0]->Purchaser->CustomerPhoneNumber = $data->deal->Telephone;
        
        
        $Automobiles[0]->Purchaser->Address = new \stdClass();
        $Automobiles[0]->Purchaser->Address->Address1 = $data->deal->Address1;
        $Automobiles[0]->Purchaser->Address->City = $data->deal->City;
        $Automobiles[0]->Purchaser->Address->State = $data->deal->State;
        $Automobiles[0]->Purchaser->Address->StateCode = strtoupper($data->deal->State);
        $Automobiles[0]->Purchaser->Address->ZipCode = round($data->deal->ZipCode);
        $Automobiles[0]->Purchaser->Address->Country = $data->deal->Country;
        $Automobiles[0]->Purchaser->Address->CountryCode = 'UnitedStatesOfAmerica'; # $data->deal->Country;
                                                                                             
        # Vehicle Service Contract
        if($productBaseId == 12)
        {            
            $Automobiles[0]->VSCContract = new \stdClass();
            $Automobiles[0]->VSCContract->VSCContractDetails = new \stdClass();
            $Automobiles[0]->VSCContract->VSCContractDetails->ContractNumber = $contractNumber; # 50000;
            $Automobiles[0]->VSCContract->VSCContractDetails->ContractPrefix = $data->productRates->ContractPrefix; # "CG50";
            $Automobiles[0]->VSCContract->VSCContractDetails->EffectiveDate = date('c');
            $Automobiles[0]->VSCContract->VSCContractDetails->PurchaseDate = date('c');
            $Automobiles[0]->VSCContract->VSCContractDetails->VehiclePurchaseDate = date('c', strtotime($date[0]));                    
            $Automobiles[0]->VSCContract->VSCContractDetails->RateQuote = new \stdClass();
            $Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->CoverageTermMonths = $data->productOptions->term;
            $Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->RetailPrice = $data->productOptions->price;
            $Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->ProductType = $data->productRates->ProductType; # 'VSC';
            $Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->RateNumber = $data->productRates->RateNumber; # 191462;
            $Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->ProductClass = $data->productRates->ProductClass; # "VSC";
            $Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->ProductClassCode = $data->productRates->ProductClassCode; # 1;
            $Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->Coverage = $data->productOptions->type;
            $Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->CoverageCode = $data->productRates->CoverageCode; # "BAS08";
            $Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->OrderNumber = $data->productRates->OrderNumber; # 0;
            $Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->CoverageTermMinMonths = $data->productOptions->term;
            $Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->CoverageTermMiles = $data->productOptions->mileage;
            $Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->CoverageSortOrder = $data->productRates->CoverageSortOrder; # ;
            $Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->Deductible = $data->productOptions->deductible;
            $Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->DealerCost = 368;
            $Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->ContractFormID = 0;
            $Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->DisappearingDeductible = $data->DisappearingDeductible;
            $Automobiles[0]->VSCContract->VSCContractDetails->RateQuote->VehicleClassCode = $data->productRates->VehicleClassCode;                   
            $Automobiles[0]->VSCContract->MileageAtInServiceDate = ""; # date('c');
            $Automobiles[0]->VSCContract->VehiclePlan = $data->product->VehiclePlan;
            $Automobiles[0]->VSCContract->BeginningOdometer = $data->deal->BeginningOdometer;
            $Automobiles[0]->VSCContract->InServiceDate = date('c', strtotime($date[0]."12:00:00"));

            #Ramin indico que el SalesPrice seria el campo a enviar aca
            $Automobiles[0]->VSCContract->VehiclePurchasePrice = $data->deal->SalesPrice; # 20000;                    
            $Automobiles[0]->VSCContract->FinancingType = 'Purchase';
            $Automobiles[0]->VSCContract->ContractSalesTax =  $data->deal->TaxRate;                    
            $Automobiles[0]->VSCContract->Surcharges = new \stdClass();
            $Automobiles[0]->VSCContract->Surcharges->BusinessUse = $data->productOptions->surcharges[0];
            $Automobiles[0]->VSCContract->Surcharges->ConversionPackage = $data->productOptions->surcharges[1];
            $Automobiles[0]->VSCContract->Surcharges->ElectronicsPackage = $data->productOptions->surcharges[2];
            $Automobiles[0]->VSCContract->Surcharges->GPS = false;
            $Automobiles[0]->VSCContract->Surcharges->MobilityEquipment = $data->productOptions->surcharges[3];
            $Automobiles[0]->VSCContract->Surcharges->SealsGaskets = false;
            $Automobiles[0]->VSCContract->Surcharges->VideoPackage = false;
            $Automobiles[0]->VSCContract->Surcharges->ConversionVAN = false;
            $Automobiles[0]->VSCContract->Surcharges->DualWheel = false;
            $Automobiles[0]->VSCContract->Surcharges->KiaElligibility = false;
            $Automobiles[0]->VSCContract->Surcharges->Kia100000 = false;
            $Automobiles[0]->VSCContract->Surcharges->LimitedLiability75k = false;
            $Automobiles[0]->VSCContract->Surcharges->EngineSize = false;
            $Automobiles[0]->VSCContract->Surcharges->LiftKit = false;
            $Automobiles[0]->VSCContract->Surcharges->LiftKit100 = false;
            $Automobiles[0]->VSCContract->Surcharges->LiftKit200 = false;
            $Automobiles[0]->VSCContract->Surcharges->LiftKit4Inch = false;
            $Automobiles[0]->VSCContract->Surcharges->LiftKit6Inch = false;
            $Automobiles[0]->VSCContract->Surcharges->EntertainmentPackage = false;
            $Automobiles[0]->VSCContract->Surcharges->PaintlessDentRemoval = false;                    
            $Automobiles[0]->VSCContract->Surcharges->WindShield = false;
            $Automobiles[0]->VSCContract->Surcharges->CommercialUse = false;
            $Automobiles[0]->VSCContract->Surcharges->PowerSteps = false;
            $Automobiles[0]->VSCContract->Surcharges->OneTon = false;
            $Automobiles[0]->VSCContract->Surcharges->TireWheel = false;
            $Automobiles[0]->VSCContract->Surcharges->Turbo = true;
            $Automobiles[0]->VSCContract->Surcharges->Diesel = true;
            $Automobiles[0]->VSCContract->Surcharges->FourByFour = true;
            $Automobiles[0]->VSCContract->Surcharges->FourWheelSteering = false;
            $Automobiles[0]->VSCContract->Surcharges->LEWUpsell = false;
            $Automobiles[0]->VSCContract->Surcharges->TenCylinder = false;
            $Automobiles[0]->VSCContract->Surcharges->TwelveCylinder = false;
            $Automobiles[0]->VSCContract->Surcharges->Hybrid = false;
            $Automobiles[0]->VSCContract->Surcharges->FourWDTurbo = false;
            $Automobiles[0]->VSCContract->Surcharges->ACSystem = false;
            $Automobiles[0]->VSCContract->Surcharges->LiftKitTireWheel = false;
            $Automobiles[0]->VSCContract->Surcharges->SnowPlow = false;
        }
        
        # Protective GAP
        if($productBaseId == 11)
        {
            $Automobiles[0]->GAPContract = new \stdClass();
            $Automobiles[0]->GAPContract->AmountFinanced = $data->deal->NewFinancedAmount;
            $Automobiles[0]->GAPContract->AmountMSRP = $data->deal->SalesPrice;
            $Automobiles[0]->GAPContract->APR = $data->deal->NewAPR;
            $Automobiles[0]->GAPContract->BeginningOdometer = $data->deal->BeginningOdometer;
            $Automobiles[0]->GAPContract->DownPayment = $data->deal->NewDownPayment;
            $Automobiles[0]->GAPContract->FinancingType = 'Purchase';
            $Automobiles[0]->GAPContract->InsuranceDeductible = 0;
            $Automobiles[0]->GAPContract->MileageAtInServiceDate = ""; # date('c');                    
            $Automobiles[0]->GAPContract->GAPContractDetails = new \stdClass();
            $Automobiles[0]->GAPContract->GAPContractDetails->ContractPrefix = $data->productRates->ContractPrefix;
            $Automobiles[0]->GAPContract->GAPContractDetails->ContractNumber = $contractNumber; # 50000;
            $Automobiles[0]->GAPContract->GAPContractDetails->EffectiveDate = date('c');
            $Automobiles[0]->GAPContract->GAPContractDetails->PurchaseDate = date('c');
            $Automobiles[0]->GAPContract->GAPContractDetails->VehiclePurchaseDate = date('c', strtotime($date[0]));                    
            $Automobiles[0]->GAPContract->GAPContractDetails->RateQuote = new \stdClass();
            $Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->ProductClass = $data->productRates->ProductClass; # "GAP";
            $Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->ProductClassCode = $data->productRates->ProductClassCode; # 50;
            $Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->CoverageCode = $data->productRates->CoverageCode; # "G13L1P";
            $Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->CoverageTermMonths = $data->productOptions->term;
            $Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->RetailPrice = $data->productOptions->price;
            $Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->ProductType = $data->productRates->ProductType; # 'GAP';
            $Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->RateNumber = $data->productRates->RateNumber; # 188608;
            $Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->OrderNumber = $data->productRates->OrderNumber; # ;
            $Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->CoverageTermMinMonths = $data->productRates->CoverageTermMinMonths;
            $Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->CoverageTermMiles = $data->productRates->CoverageTermMiles;
            $Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->CoverageSortOrder = $data->productRates->CoverageSortOrder; # 3;
            $Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->Deductible = $data->productOptions->deductible;
            $Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->ContractFormID = 0;                    
            $Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->DisappearingDeductible = false;
            $Automobiles[0]->GAPContract->GAPContractDetails->RateQuote->DealerCost = false;
        }

        return $Automobiles;
    }

    ##---------------- Retrieve contract number for send  in contract request --------------- ##
    private function getContractNumbers($data)
    {
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

    ##---------------- Validate data for Request --------------- ##
    private function ValidateRequest($data)
    {
        if($data->product->ProductBaseId == 12){
            if(count($data->productOptions->surcharges) != 4){
                for ($i = 0; $i < 4; $i ++){
                    $data->productOptions->surcharges[i] = 0;
                }
            }
            
            if($data->productOptions->deductible == '100D'){
                $data->productOptions->deductible = 100;
                $data->DisappearingDeductible = true;
            }
            else{
                $data->DisappearingDeductible = false;
            }
        }
        
        if(strlen(round($data->deal->ZipCode)) < 5){
            $data->deal->ZipCode = 12345;
        }
        
        /*
        *  APPLY SALES TAX RATE ( WHERE APPLICABLE)
        *   
        */
        if ($data->product->IsTaxable == 1) {
            #$data->productOptions->price = ($data->productOptions->price) * (1 + ($data->deal->TaxRate / 100));  

        }else{ 
            # if product dont use tax rate in settings, delete.
             $data->deal->TaxRate = 0;
        }
        
        if(empty($data->productOptions->mileage)){
            $data->productOptions->mileage = $data->productRates->CoverageTermMiles;
        }
        
        if($data->productOptions->mileage == 0){
            $data->productOptions->mileage = $data->productRates->CoverageTermMiles;
        }
        
        if(empty($data->productRates->ContractPrefix)){
            $data->productRates->ContractPrefix = $this->GetContractPrefix($data->productRates->CoverageCode);
        }        

        if (strlen(trim($data->deal->LienHolderState)) == 2) {
            $data->deal->LienHolderState = strtoupper(trim($data->deal->LienHolderState));
        }
        else{
            $data->deal->LienHolderState = "FL";
        }
        # return request validated
        return $data;
    }
    
    ##---------------- Set contract prefix for send  in contract request --------------- ##
    private function GetContractPrefix($CoverageCode)
    {

         # Product Automobile: PREFERRED,PREFERRED WRAP,PREFERRED DOMESTIC CERTIFIED ,PREFERRED ASIAN CERTIFIED
        if($CoverageCode == "PR08" || $CoverageCode == "WRPR08" || $CoverageCode == "PRC08" || $CoverageCode == "PRCA08" ){
            $ContractPrefix = "AD40";
        }

        # Product Automobile: ADVANTAGE; POWERTRAIN PLUS; POWERTRAIN; ADVANTAGE WRAP; POWERTRAIN PLUS HIGH MILEAGE;POWERTRAIN HIGH MILEAGE; ADVANTAGE DOMESTIC CERTIFIED; ADVANTAGE ASIAN CERTIFIED
        if ($CoverageCode == "AD08" || $CoverageCode == "PP08" || $CoverageCode == "PT08" || $CoverageCode == "WRAD08" || $CoverageCode == "PPH08" || $CoverageCode == "PTH08"|| $CoverageCode == "ADC08" || $CoverageCode == "ADCA08" ) {
            $ContractPrefix = "AD40";
        }

        # Product Automobile: Lifetime
        if($CoverageCode == "00ENG"){
            $ContractPrefix = "LEW00";
        }
        # Product Automobile: Mileage Plus
        if($CoverageCode == "0MPX1" || $CoverageCode == "0MPX2" || $CoverageCode == "0MPXE"){
            $ContractPrefix = "MPP00";
        }
        # Product Automobile: Select New Premium
        if($CoverageCode == "00NEW" || $CoverageCode == "00PRM"){
            $ContractPrefix = "SELNP";
        }
        # Product Automobile: Select Powertrain
        if($CoverageCode == "00PWR"){
            $ContractPrefix = "SELUP";
        }
        
        # Product Automobile: GAP
        if($CoverageCode == "GAPP10" || $CoverageCode == "GAPL10" || $CoverageCode == "GAPB10"){
            $ContractPrefix = "401";
        }
        
        return $ContractPrefix;
    }
}
