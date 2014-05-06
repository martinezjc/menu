<?php namespace Api\Services;

/**
 * Actual implementation for RoadVantage webservice
 *
 * @author brittongr
 *
 */
class RoadVantageServiceProxy extends ServiceProxy
{	
	function __construct($proxy, $settings){
		parent::__construct($proxy, $settings);	
	}
	
	protected function buildProxy($settings)
	{
		// TODO: Read the current hardcoded values from the settings
		$this->proxy->__setLocation($settings->webservice->url);
		
	}
	
	##---------------- Execute request and return response --------------- ##
	public function execute($request)
	{		

		set_time_limit(60);

		try {
			    $method = $this->getMethod($request);
			    $response = $this->proxy->$method($this->getParameters($request));				
			    return $this->getResponse($request, $response);

		} catch (SoapFault $e) { 
		    return 0;//$e->faultcode; 
		
		} 
	}

	##----------------  --------------- ##
    private function getResponse($request, $response)
    {
        if ($request->type == 0) { 
        	 # Rates Response
			$obj  = new \stdClass();
			$obj->QuoteId = $response->GetRatesResult->QuoteID;
			$obj->ManufactureWarranty = $response->GetRatesResult->ManufactureWarraties->ManufactureWarranty;
			$PlanRates = $response->GetRatesResult->PlanRates->PlanRate;

			# If PlanRates is not array
			if (! is_array($PlanRates)) {
				if ($request->product->ProductBaseId == 13) {	// Product Tire and Wheel
					if ($PlanRates->Plan->ProductTypeCode == 'RHT') {
						$obj->Plan = $PlanRates;
					}
				}
				if ($request->product->ProductBaseId == 14) { // Product Dent 
					if ($PlanRates->Plan->ProductTypeCode == 'PDR') {
						$obj->Plan = $PlanRates;
					}
				}
					
			}else{
				# PlanRates is array
				foreach ($PlanRates as $key => $PlanRate) {
					if ($request->product->ProductBaseId == 13) {	// Product Tire and Wheel
						if ($PlanRate->Plan->ProductTypeCode == 'RHT') {
							$obj->Plan = $PlanRate;
						}
					}
					if ($request->product->ProductBaseId == 14) { // Product Dent 
						if ($PlanRate->Plan->ProductTypeCode == 'PDR') {
							$obj->Plan = $PlanRate;
						}
					}
														
				}
			}
			
			return $obj;
		} else {  			
			# Void Contract 
			if (!(empty($response->GenerateContractResult->ContractNumber))) {
				$this->VoidContractPdf($response->GenerateContractResult->ContractNumber, $request);					
			}
			# Contract Response
			return  $response;
		}
    }
	##---------------- Get method for  Request --------------- ##
	private function getMethod($request)
	{
		if ($request->type == 0) {
			$method = "GetRates";
		}else{
			$method = "GenerateContract";
		}
		return $method;	
	}
	
	##---------------- Get parameters for  Request --------------- ##
	private function getParameters($request)
	{
		$parameters = null;
		$request = $this->ValidateRequest($request);

		
		if ($request->type == 0) {
			# Get Rates 
			$data = $this->getRatesParameters($request);
	        $parameters = array 
	        (
	            "objGetRatesRequest" => $data
	        );

		} else { 
			# Get PDF Contract 
			$data = $this->getContractParameters($request);
			$parameters = array 
	        (
	            "contract" => $data
	        );
		}

		return $parameters;
	}
	
	##---------------- Get parameter for  Rates  Request --------------- ##
	private function getRatesParameters($request)
	{
		$data = new \stdClass();
        $data->UserId = $request->deal->Username;
        $data->Password = $request->deal->Password;
        $data->TpaCode = "DEMO";
        $data->DealerNo = $request->dealercode;
        $data->VIN = $request->deal->VIN;//"3FA6P0H72DR262329";
        $data->VehiclePurchasePrice = $request->deal->SalesPrice;
        $data->VehicleOdometer = round($request->deal->BeginningOdometer);
        $data->NewUsed = "N";
        $data->SaleDate = date('c');
        $data->FinancedAmount = $request->deal->FinancedAmount;//20000;
        $data->FinanceTerm = $request->deal->Term;
        $data->InserviceDate = date('c');
        $data->VehiclePurchaseDate = date('c');   
        $data->GIPIteration = false;
        $data->MonthlyPayment = 0;
        $data->DOBBuyer = date('c');
        $data->DOBCoBuyer = date('c');
        $data->Trim = $request->deal->Trim;//"S";
        $data->ChromeStyle = 0;
        $data->VINPattern = 0;
        $data->VehicleYear = 0;
        $data->FullManufWarrMonths = 0;
        $data->FullManufWarrMiles = 0;
        $data->PowerTrainManufWarrMonths = 0;
        $data->PowerTrainManufWarrMiles = 0;   
        $data->FinanceApr = $request->deal->APR;  
        $data->MSRP = 0;  

        return $data;
	}

	##---------------- Get parameter for  Contract  Request --------------- ##
	private function getContractParameters($request)
	{
		$data = new \stdClass();
		$data->UserId = $request->deal->Username;
		$data->Password = $request->deal->Password;
		$data->TpaCode = "DEMO";
		$data->DealerNumber = $request->dealercode;
		$data->ContractFormNumber = $request->productRates->Rate->PDFFormNo;
		$data->SaleDate = date('c');
		$data->InserviceDate = date("c", strtotime( '-1 days' ));
		$data->VehiclePurchasePrice = $request->deal->SalesPrice;
		$data->VehiclePurchaseDate= date('c');
		$data->SaleOdometer = round($request->deal->BeginningOdometer);
		$data->QuoteId = $request->productRates->QuoteId;
		$data->PlanCode = $request->productRates->Plan->PlanCode;
		$data->RateBook = $request->productRates->Plan->RateBook;
		$data->FinalCopy = true;
		$data->NetCost = $request->productRates->Rate->NetRate;
		$data->GenerateContractDocument= true;
		$data->RetailCost = $request->productRates->Rate->RetailRate;
		$data->ManufWarrTerm = $request->productRates->ManufactureWarranty{0}->Term;
		$data->ManufWarrMiles = $request->productRates->ManufactureWarranty{0}->Mile;
		$data->FirstPaymentDate = date('c');
		$data->DigitallySigned = false;
		$data->IsTaxExempt = false;
		$data->TermMile = new \stdClass();
		$data->TermMile->TermId = $request->productRates->TermMile->TermId;
		$data->TermMile->Term = $request->productRates->TermMile->Term;
		$data->TermMile->Mileage = $request->productRates->TermMile->Mileage;
		$data->Deductible = new \stdClass();
		$data->Deductible->DeductId = $request->productRates->Deductible->DeductId;
		$data->Deductible->DeductAmt = $request->productRates->Deductible->DeductAmt;
		$data->Deductible->DeductType = $request->productRates->Deductible->DeductType;
		$data->Deductible->ReducedAmount = $request->productRates->Deductible->ReducedAmount;
		$data->Vehicle = new \stdClass();
		$data->Vehicle->VinNumber = $request->deal->VIN;
		$data->Vehicle->VehicleType = "N";
		$data->Vehicle->Year= 0;
		$data->Customer = new \stdClass();
		$data->Customer->FirstName = $request->deal->FirstName;
		$data->Customer->LastName = $request->deal->LastName;
		$data->Customer->MiddleInitial= substr($request->deal->MiddleName, 0, 1); // Only send the intials middlename
		$data->Customer->Email = $request->deal->Email;
		$data->Customer->Address = new \stdClass();
		$data->Customer->Address->Address1 = $request->deal->Address1;
		$data->Customer->Address->City = $request->deal->City;
		$data->Customer->Address->State = strtoupper($request->deal->State);
		$data->Customer->Address->ZipCode = round($request->deal->ZipCode);
		$data->Customer->Address->HomePhone = str_replace('-', '', $request->deal->Telephone);
		$data->LienHolder = new \stdClass();
		$data->LienHolder->Name= $request->deal->LienHolderName;
		$data->LienHolder->Phone= str_replace("-", "", $request->deal->LienHolderPhone);
		$data->LienHolder->Address1= $request->deal->LienHolderAddress;
		$data->LienHolder->Address2= ""; //$request->deal->LienHolderAddress2;
		$data->LienHolder->City= $request->deal->LienHolderCity;
		$data->LienHolder->State= $request->deal->LienHolderState;
		$data->LienHolder->ZipCode= $request->deal->LienHolderZip;

		return $data;
	}

	##---------------- Void Contract   --------------- ##
	private function VoidContractPdf($contractNumber, $request)
	{		
		$data = new \stdClass();
		$data->UserId = $request->deal->Username;
		$data->Password = $request->deal->Password;
		$data->RequestingUser = "Menuapp";
		$data->ContractNumber = $contractNumber;
		$data->TpaCode = "DEMO";
		$data->VIN = $request->deal->VIN;
		$data->DealerNumber = $request->dealercode;

		$proxy = new \SoapClient("https://uat.fiadmin.com/scs.webservice/ScsAutoService.asmx?wsdl");
    
        $parameters = array 
        (
            "request" => $data
        );

       $result = $proxy->VoidContract($parameters); 
          
	}

	##---------------- Validate data for Request --------------- ##
    private function ValidateRequest($request)
    {
        $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';

		if (preg_match($pattern, $request->deal->Email) === 0){
			$request->deal->Email = 'test@mail.com';
		}

		if (strlen(round($request->deal->ZipCode)) < 5) {
			$request->deal->ZipCode = 12345;
		}

		// if ($request->product->ProductBaseId == 13) {
		// 	$request->deal->BeginningOdometer = 23999;
		// }

		return $request;
    }
    
}


