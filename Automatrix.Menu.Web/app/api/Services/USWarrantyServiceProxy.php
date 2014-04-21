<?php namespace Api\Services;

/**
 * Actual implementation for USWarranty webservice
 *
 * @author brittongr
 *
 */
class USWarrantyServiceProxy extends ServiceProxy
{	
	function __construct($proxy, $settings){
		parent::__construct($proxy, $settings);	
	}
	
	protected function buildProxy($settings)
	{
		// TODO: Read the current hardcoded values from the settings
		$this->proxy->__setLocation($settings->webservice->url);
		
		$header = new \SoapHeader ("http://UsWarranty.com/UswcWebServiceRates", "AuthenticationHeader", array (
				"Username" => $settings->webservice->credentials->username,
				"Password" => $settings->webservice->credentials->password
		), false );
		
		$this->proxy->__setSoapHeaders ( array ($header) );

	}
	
	public function execute($request)
	{		

		set_time_limit(60);

		try {

			if ($request->type == 0) { // Get rates
					$method = $this->getMethod($request);
					$response = $this->proxy->$method ($this->getParameters($request));
					$dat = ( array ) $response;
					$xml = simplexml_load_string ( $dat [$method.'Result'] );
					$json = json_encode ( $xml );
					$data = json_decode ( $json, true );
					// if ($request->product->ProductBaseId == 2) {
					// 	$arr= $this->getParameters($request);
					// 	print_r(strlen($arr['Vin'])); die();
					// }
					return $data;

			} else { // Get PDF Contract
				$parameters = $this->getParameters($request);
				$xml = $this->getXml($parameters, $request);
				$url = 'http://www.uswarranty.com/Testuswcwebservicepolicies/webservice.asmx?wsdl';

		        $soap_do = curl_init(); 
		        curl_setopt($soap_do, CURLOPT_URL,            $url );   
		        curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 20); 
		        curl_setopt($soap_do, CURLOPT_TIMEOUT,        20); 
		        curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
		        curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);  
		        curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false); 
		        curl_setopt($soap_do, CURLOPT_POST,           true ); 
		        curl_setopt($soap_do, CURLOPT_POSTFIELDS,    $xml); 
		        curl_setopt($soap_do, CURLOPT_HTTPHEADER,     array('Content-Type: text/xml; charset=utf-8', 'Content-Length: '.strlen($xml) )); 
		        

		        $result = curl_exec($soap_do);		        		
		        $err = curl_error($soap_do); 

		        if (!(empty($result))) {
		        	// Void Contract
		        	$contractNumber = $this->getContractNumber($result,$request);
		        	$this->VoidContract($contractNumber,$request);
		           	return $result;
		        } else {
		        	return $err;
		        }
					
			}
			

			
		} catch (SoapFault $e) { 
		    return 0;//$e->faultcode; 
		
		} 
	}

	private function getMethod($request)
	{
		$method = "";
		$product = $request->product->ProductBaseId;
		
		if($product == 1 )//US Key
			$method = "GetKeyRates";
		else
			if($product == 4)//Maintenance Plan
				$method = "GetMaintRates";
			else
				if($product == 2)//Vehicle Service Contract
					$method = "GetVscRates";
				else
					if($product == 3)//Total Lost Protection (GAP)
						$method = "GetGapRates";
					 else
                        if($product == 9)//Road Hazard
                        	$method = "GetRoadHazardRates";
                        else
	                        if($product == 5)// US Dent
	                        	$method = "GetDentRates";
	                        else
		                        if($product == 7)// US Chemical
		                        	$method = "GetChemicalRates";
		                        else
		                        if($product == 8)// US Etch
		                        	$method = "GetEtchRates";

						
		return $method;				
	}
	
	private function getParameters($request)
	{
		$parameters = null;
		$vin = $request->deal->VIN;
	    $dealercode = $request->dealercode;
		$ProductBaseId = $request->product->ProductBaseId;
		

		// Get Rates
		if ($request->type == 0) {
			
						//US Key ----------------------------------------------------------------
						if($ProductBaseId == 1)
						{
							$parameters = array 
							(
								"Company" => "USW",
								"DealerCode" => $dealercode,//"11401",
								"Vin" => trim($vin),
								"SaleDate" => date('c')//"2014-02-19T13:59:06.5902435-06:00"
							);
						}
						else
							//Maintenance Plan
							if($ProductBaseId == 4)
							{
								$parameters = array
								(
									"Company" => "USW",
									"DealerCode" => $dealercode,//"11401",
									"Vin" => trim($vin),
									"SaleDate" => date('c'),//"2014-02-19T13:59:06.5902435-06:00",
									"Mileage" => trim(round($request->deal->BeginningOdometer)),//"100000",
									"AloneOption" => "Alone"
								);
							}
							else
								//Vehicle Service Contract
								if($ProductBaseId == 2)
								{
									$parameters = array
									(
										"Company" => "USW",
										"DealerCode" => $dealercode,//"11401",
										"Vin" => trim($vin),
										"SaleDate" => date('c'),//"2014-02-19T13:59:06.5902435-06:00",
										"Mileage" => trim(round($request->deal->BeginningOdometer)),//"100000",
										"NewUsed" => "Used",
										"InSrvDate" => date('c')//"2014-02-19T13:59:06.5902435-06:00"
									);
							}
								else
									//Total Lost Protection (GAP)
									if($ProductBaseId == 3)
									{
										$parameters = array
										(
											"Company" => "USW",
											"DealerCode" => $dealercode,//"11401",
											"SaleDate" => date('c'),//"2014-02-19T13:59:06.5902435-06:00",
											"Mileage" => trim(round($request->deal->BeginningOdometer)),//"100000",
											"Vin" => trim($vin)
										);
									} 
									else
										//Road Hazard
										if($ProductBaseId == 9)
										{
											$parameters = array
											(
												"Company" => "USW",
												"DealerCode" => $dealercode,//"11401",
												"SaleDate" => date('c'),//"2014-02-19T13:59:06.5902435-06:00",
												"Mileage" => trim(round($request->deal->BeginningOdometer)),//"100000",
												"Vin" => trim($vin)
											);
										}
										else
										// US Dent
											if($ProductBaseId == 5)
											{
												$parameters = array
												(
													"Company" => "USW",
													"DealerCode" => $dealercode,//"11401",
													"SaleDate" => date('c'),//"2014-02-19T13:59:06.5902435-06:00",
													"Mileage" => trim(round($request->deal->BeginningOdometer)),//"100000",
													"Vin" => trim($vin)
												);
											}
											else
											// CHemical
												if($ProductBaseId == 7)
												{
													$parameters = array
													(
														"Company" => "USW",
														"DealerCode" => $dealercode,//"11401",
														"SaleDate" => date('c'),//"2014-02-19T13:59:06.5902435-06:00",
														"Vin" => trim($vin)
													);
												}
												else
												// Etch
													if($ProductBaseId == 8)
													{
														$parameters = array
														(
															"Company" => "USW",
															"DealerCode" => $dealercode,//"11401",
															"SaleDate" => date('c'),//"2014-02-19T13:59:06.5902435-06:00",
															"Vin" => trim($vin)
														);
													}
										//-----------------------------------------------------------------------

		} else {  // Get PDF Contract
				//-----------Start ---------------------

				if (empty($request->productRates->CvCvty)) {
					$request->productRates->CvCvty = '';
				}
				if (empty($request->productRates->MileageTerm)) {
					$request->productRates->MileageTerm = '';
				}
				if (empty($request->productRates->Interval)) {
					$request->productRates->Interval = '';
				}

				$pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';

				if (preg_match($pattern, $request->deal->Email) === 1) {
				    //valid
				}else{
					$request->deal->Email = 'test@mail.com';
				}

				if (strlen(round($request->deal->ZipCode)) < 5) {
					$request->deal->ZipCode = 12345;
				}
				
				$fullName = explode(" ", $request->deal->Buyer);
						
				$data = new \stdClass();

		        $data->AuthenticationHeader = new \stdClass();
		        $data->AuthenticationHeader->Username = $request->deal->Username;
		        $data->AuthenticationHeader->Password = $request->deal->Password;

		        $data->Products = new \stdClass();

		        $data->Products->Customer = new \stdClass();
		        $data->Products->Customer->CompanyInitials = 'USW' ;
		        $data->Products->Customer->DealerCode = $dealercode;
		        $data->Products->Customer->LastName = $fullName[1];
		        $data->Products->Customer->FirstName = $fullName[0];
		        $data->Products->Customer->MiddleInitial = '';
		        $data->Products->Customer->LastName2 = '';
		        $data->Products->Customer->FirstName2 = '';
		        $data->Products->Customer->MiddleInitial2 = '';
		        $data->Products->Customer->Address = $request->deal->Address1;
		        $data->Products->Customer->City = $request->deal->City;
		        $data->Products->Customer->State = $request->deal->State;
		        $data->Products->Customer->Zip = round($request->deal->ZipCode);
		        $data->Products->Customer->Phone = $request->deal->Telephone;
		        $data->Products->Customer->PhoneNight = $request->deal->Telephone;
		        $data->Products->Customer->EmailAddress = $request->deal->Email;
		        $data->Products->Customer->Vin = $vin;
		        $data->Products->Customer->Odometer = $request->deal->BeginningOdometer;
		        $data->Products->Customer->SaleDate = date("m/d/Y");//'03/28/2014';
		        $data->Products->Customer->UswcFinanced = $request->deal->FinancedAmount;//20000;
		        $data->Products->Customer->StockNumber = 123;
		        $data->Products->Customer->DealNumber = 521;
		        $data->Products->Customer->CustomerNumber = 154;

		        $data->Products->Lienholder = new \stdClass();
		        $data->Products->Lienholder->Name  = $request->deal->LienHolderName;
		        $data->Products->Lienholder->Address  = $request->deal->LienHolderAddress;
		        $data->Products->Lienholder->City  = $request->deal->LienHolderCity;
		        $data->Products->Lienholder->State  = $request->deal->LienHolderState;
		        $data->Products->Lienholder->Zip = $request->deal->LienHolderZip;
		        
		        $data->Products->Vsc = new \stdClass();
		        $data->Products->Vsc->ContractNumber= '';
		        $data->Products->Vsc->CvCvty = $request->productRates->CvCvty;//"US46E";
		        $data->Products->Vsc->Cost = $request->productRates->AmtDueWtyCo;// '';
		        $data->Products->Vsc->RetailAmount = '';
		        $data->Products->Vsc->FiledAmount= $request->productRates->FiledAmount;// '';
		        $data->Products->Vsc->TermMonths= $request->productOptions->term;
		        $data->Products->Vsc->TermMiles= $request->productRates->MileageTerm;//"6,000";
		        $data->Products->Vsc->InServiceDate= date('c');
		        $data->Products->Vsc->Deductible= $request->productOptions->deductible;
		        $data->Products->Vsc->Cert = "N";
		        $data->Products->Vsc->Wrap = "N";
		        $data->Products->Vsc->FormNumber= $request->productRates->FormNumber;//"USWC US FC 02-12";
		        $data->Products->Vsc->Options = new \stdClass();
		        $data->Products->Vsc->Options->Option = "";

		        $data->Products->Maintenance = new \stdClass();
		        $data->Products->Maintenance->ContractNumber = "";
		        $data->Products->Maintenance->CvCvty = $request->productRates->CvCvty;
		        $data->Products->Maintenance->Cost = $request->productRates->AmtDueWtyCo;
		        $data->Products->Maintenance->RetailAmount = "";
		        $data->Products->Maintenance->FiledAmount = $request->productRates->FiledAmount;
		        $data->Products->Maintenance->TermMonths = $request->productOptions->term;
		        $data->Products->Maintenance->TermMiles = $request->productRates->MileageTerm;
		        $data->Products->Maintenance->Interval = $request->productRates->Interval;
		        $data->Products->Maintenance->FormNumber = $request->productRates->FormNumber;
		        $data->Products->Maintenance->Options = new \stdClass();
		        $data->Products->Maintenance->Options->Option = "";

		        $data->Products->RoadHazard =  new \stdClass();
		        $data->Products->RoadHazard->ContractNumber = "";
		        $data->Products->RoadHazard->CvCvty = $request->productRates->CvCvty;
		        $data->Products->RoadHazard->Cost = $request->productRates->AmtDueWtyCo;
		        $data->Products->RoadHazard->RetailAmount = "";
		        $data->Products->RoadHazard->FiledAmount = $request->productRates->FiledAmount;
		        $data->Products->RoadHazard->TermMonths = $request->productOptions->term;
		        $data->Products->RoadHazard->TermMiles = $request->productRates->MileageTerm;
		        $data->Products->RoadHazard->FormNumber = $request->productRates->FormNumber;
		        $data->Products->RoadHazard->Options = new \stdClass();
		        $data->Products->RoadHazard->Options->Option = "";

		        $data->Products->Key =  new \stdClass();
		        $data->Products->Key->ContractNumber = '';
		        $data->Products->Key->CvCvty = $request->productRates->CvCvty;//'GKN';
		        $data->Products->Key->Cost = $request->productRates->AmtDueWtyCo;
		        $data->Products->Key->RetailAmount = "";
		        $data->Products->Key->FiledAmount = $request->productRates->FiledAmount;
		        $data->Products->Key->TermYears = ($request->productOptions->term)/12;
		        $data->Products->Key->VehicleType = 'U';
		        $data->Products->Key->FormNumber = $request->productRates->FormNumber;
		        $data->Products->Key->Options = new \stdClass();
		        $data->Products->Key->Options->Option = "";  

		        $data->Products->Dent =  new \stdClass();
		        $data->Products->Dent->ContractNumber = "";
		        $data->Products->Dent->CvCvty = $request->productRates->CvCvty;
		        $data->Products->Dent->Cost = $request->productRates->AmtDueWtyCo;
		        $data->Products->Dent->RetailAmount = "";
		        $data->Products->Dent->FiledAmount = $request->productRates->FiledAmount;
		        $data->Products->Dent->TermYears = ($request->productOptions->term)/12;
		        $data->Products->Dent->FormNumber = $request->productRates->FormNumber;
		        $data->Products->Dent->Options = new \stdClass();
		        $data->Products->Dent->Options->Option = "";


		        $data->Products->Gap = new \stdClass();
		        $data->Products->Gap->ContractNumber = "";
		        $data->Products->Gap->RetailAmount = ""; 
		        $data->Products->Gap->FiledAmount = $request->productRates->FiledAmount;
		        $data->Products->Gap->TermMonths = $request->productOptions->term;
		        $data->Products->Gap->PurchasePrice = $request->deal->SalesPrice;
		        $data->Products->Gap->FinancedAmount = $request->deal->FinancedAmount;
		        $data->Products->Gap->MSRP = '500';
		        $data->Products->Gap->InterestRate = '10';
		        $data->Products->Gap->FormNumber = $request->productRates->FormNumber; 
		        $data->Products->Gap->FinanceType = "Purchase"; 



		        $data->Products->Etch = new \stdClass(); 
		        $data->Products->Etch->ContractNumber = ""; 
		        $data->Products->Etch->CvCvty = ""; 
		        $data->Products->Etch->Cost = ""; 
		        $data->Products->Etch->RetailAmount = ""; 
		        $data->Products->Etch->FiledAmount = ""; 
		        $data->Products->Etch->TermYears = ""; 
		        $data->Products->Etch->FormNumber = ""; 
		        $data->Products->Etch->EtchNumber = ""; 
		        $data->Products->Etch->PipNumber = ""; 



		        $data->Products->ShadowMark = new \stdClass(); 
		        $data->Products->ShadowMark->ContractNumber = ""; 
		        $data->Products->ShadowMark->CvCvty = ""; 
		        $data->Products->ShadowMark->Cost = ""; 
		        $data->Products->ShadowMark->RetailAmount = ""; 
		        $data->Products->ShadowMark->FiledAmount = ""; 
		        $data->Products->ShadowMark->TermYears = ""; 
		        $data->Products->ShadowMark->FormNumber = ""; 
		        $data->Products->ShadowMark->EtchNumber = ""; 
		        $data->Products->ShadowMark->PipNumber = "";  

		        $data->Products->SafeLease = new \stdClass();
		        $data->Products->SafeLease->ContractNumber = ""; 
		        $data->Products->SafeLease->Cost = ""; 
		        $data->Products->SafeLease->RetailAmount = ""; 
		        $data->Products->SafeLease->FiledAmount = ""; 
		        $data->Products->SafeLease->TermMonths = ""; 
		        $data->Products->SafeLease->TermMiles = ""; 
		        $data->Products->SafeLease->EffectiveDate = ""; 
		        $data->Products->SafeLease->Plan = ""; 
		        $data->Products->SafeLease->Deductible = ""; 
		        $data->Products->SafeLease->Limit = ""; 
		        $data->Products->SafeLease->Certified = ""; 
		        $data->Products->SafeLease->FormNumber = ""; 


		        $data->Products->Chemical =  new \stdClass(); 
		        $data->Products->Chemical->ContractNumber = ""; 
		        $data->Products->Chemical->CvCvty = ""; 
		        $data->Products->Chemical->Cost = ""; 
		        $data->Products->Chemical->RetailAmount = ""; 
		        $data->Products->Chemical->FiledAmount = ""; 
		        $data->Products->Chemical->TermYears = ""; 
		        $data->Products->Chemical->FormNumber = ""; 
		        $data->Products->Chemical->PipNumber = "";

		        $parameters = $data;
				//------------END----------------------
		}
		return $parameters;
	}

	private function getXml($data, $request)
	{

		$Products = $data->Products;

		$body = $this->getXmlBody($Products, $request);

 		$xml = '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
  <s:Header>
    <h:AuthenticationHeader xmlns:h="http://UsWarranty.com/UswcWebServicePolicies" xmlns="http://UsWarranty.com/UswcWebServicePolicies" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
      <Username>'.$data->AuthenticationHeader->Username.'</Username>
      <Password>'.$data->AuthenticationHeader->Password.'</Password>
    </h:AuthenticationHeader>
  </s:Header>
  <s:Body xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
    <SubmitProducts xmlns="http://UsWarranty.com/UswcWebServicePolicies">
    <xmlDoc>
        <Products xmlns="">
          <Customer>
            <CompanyInitials>'.$Products->Customer->CompanyInitials.'</CompanyInitials>
            <DealerCode>'.$Products->Customer->DealerCode.'</DealerCode>
            <LastName>'.$Products->Customer->LastName.'</LastName>
            <FirstName>'.$Products->Customer->FirstName.'</FirstName>
            <MiddleInitial>'.$Products->Customer->MiddleInitial.'</MiddleInitial>
            <LastName2>'.$Products->Customer->LastName2.'</LastName2>
            <FirstName2>'.$Products->Customer->FirstName2.'</FirstName2>
            <MiddleInitial2>'.$Products->Customer->MiddleInitial2.'</MiddleInitial2>
            <Address>'.$Products->Customer->Address.'</Address>
            <City>'.$Products->Customer->City.'</City>
            <State>'.$Products->Customer->State.'</State>
            <Zip>'.$Products->Customer->Zip.'</Zip>
            <Phone>'.$Products->Customer->Phone.'</Phone>
            <PhoneNight>'.$Products->Customer->PhoneNight.'</PhoneNight>
            <EmailAddress>'.$Products->Customer->EmailAddress.'</EmailAddress>
            <Vin>'.$Products->Customer->Vin.'</Vin>
            <Odometer>'.$Products->Customer->Odometer.'</Odometer>
            <SaleDate>'.$Products->Customer->SaleDate.'</SaleDate>
            <UswcFinanced>'.$Products->Customer->UswcFinanced.'</UswcFinanced>
            <StockNumber>'.$Products->Customer->StockNumber.'</StockNumber>
            <DealNumber>'.$Products->Customer->DealNumber.'</DealNumber>
            <CustomerNumber>'.$Products->Customer->CustomerNumber.'</CustomerNumber>
          </Customer>
          <Lienholder>
            <Name>'.$Products->Lienholder->Name.'</Name>
            <Address>'.$Products->Lienholder->Address.'</Address>
            <City>'.$Products->Lienholder->City.'</City>
            <State>'.$Products->Lienholder->State.'</State>
            <Zip>'.$Products->Lienholder->Zip.'</Zip>
          </Lienholder>'.
          $body
          .'</Products>
      </xmlDoc>
    </SubmitProducts>
  </s:Body>
</s:Envelope>';

		return $xml;
	}

	private function getXmlBody ($data,  $request)
	{
		$ProductBaseId = $request->product->ProductBaseId;

		if ($ProductBaseId == 1 ) {
			$xml = '<Key>
            <ContractNumber>'.$data->Key->ContractNumber.'</ContractNumber>
            <CvCvty>'.$data->Key->CvCvty.'</CvCvty>
            <Cost>'.$data->Key->Cost.'</Cost>
            <RetailAmount>'.$data->Key->RetailAmount.'</RetailAmount>
            <FiledAmount>'.$data->Key->FiledAmount.'</FiledAmount>
            <TermYears>'.$data->Key->TermYears.'</TermYears>
            <VehicleType>'.$data->Key->VehicleType.'</VehicleType>
            <FormNumber>'.$data->Key->FormNumber.'</FormNumber>
            <Options>
              <Option>'.'</Option>
            </Options>
          </Key>';
		}

		if ($ProductBaseId == 2) {
			$xml = '<Vsc>
            <ContractNumber>'.$data->Vsc->ContractNumber.'</ContractNumber>
            <CvCvty>'.$data->Vsc->CvCvty.'</CvCvty>
            <Cost>'.$data->Vsc->Cost.'</Cost>
            <RetailAmount>'.$data->Vsc->RetailAmount.'</RetailAmount>
            <FiledAmount>'.$data->Vsc->FiledAmount.'</FiledAmount>
            <TermMonths>'.$data->Vsc->TermMonths.'</TermMonths>
            <TermMiles>'.$data->Vsc->TermMiles.'</TermMiles>
            <InServiceDate>'.$data->Vsc->InServiceDate.'</InServiceDate>
            <Deductible>'.$data->Vsc->Deductible.'</Deductible>
            <Cert>'.$data->Vsc->Cert.'</Cert>
            <Wrap>'.$data->Vsc->Wrap.'</Wrap>
            <FormNumber>'.$data->Vsc->FormNumber.'</FormNumber>
            <Options>
              <Option>'.$data->Vsc->Options->Option.'</Option>
            </Options>
          </Vsc>';
		}

		if ($ProductBaseId == 3) {

			$xml = '<Gap>
            <ContractNumber>'.$data->Gap->ContractNumber.'</ContractNumber>
            <RetailAmount>'.$data->Gap->RetailAmount.'</RetailAmount>
            <FiledAmount>'.$data->Gap->FiledAmount.'</FiledAmount>
            <TermMonths>'.$data->Gap->TermMonths.'</TermMonths>
            <PurchasePrice>'.$data->Gap->PurchasePrice.'</PurchasePrice>
            <FinancedAmount>'.$data->Gap->FinancedAmount.'</FinancedAmount>
            <MSRP>'.$data->Gap->MSRP.'</MSRP>
            <InterestRate>'.$data->Gap->InterestRate.'</InterestRate>
            <FormNumber>'.$data->Gap->FormNumber.'</FormNumber>
            <FinanceType>'.$data->Gap->FinanceType.'</FinanceType>
          </Gap>';
		}
		if ($ProductBaseId == 4) {
			$xml = '<Maintenance>
            <ContractNumber>'.$data->Maintenance->ContractNumber.'</ContractNumber>
             <CvCvty>'.$data->Maintenance->CvCvty.'</CvCvty>
            <Cost>'.$data->Maintenance->Cost.'</Cost>
            <RetailAmount>'.$data->Maintenance->RetailAmount.'</RetailAmount>
            <FiledAmount>'.$data->Maintenance->FiledAmount.'</FiledAmount>
            <TermMonths>'.$data->Maintenance->TermMonths.'</TermMonths>
            <TermMiles>'.$data->Maintenance->TermMiles.'</TermMiles>
            <Interval>'.$data->Maintenance->Interval.'</Interval>
            <FormNumber>'.$data->Maintenance->FormNumber.'</FormNumber>
            <Options>
              <Option>'.'</Option>
            </Options>
          </Maintenance>';
		}

		if ($ProductBaseId == 9) {
			$xml = '<RoadHazard>
            <ContractNumber>'.$data->RoadHazard->ContractNumber.'</ContractNumber>
            <CvCvty>'.$data->RoadHazard->CvCvty.'</CvCvty>
            <Cost>'.$data->RoadHazard->Cost.'</Cost>
            <RetailAmount>'.$data->RoadHazard->RetailAmount.'</RetailAmount>
            <FiledAmount>'.$data->RoadHazard->FiledAmount.'</FiledAmount>
            <TermMonths>'.$data->RoadHazard->TermMonths.'</TermMonths>
            <TermMiles>'.$data->RoadHazard->TermMiles.'</TermMiles>
            <FormNumber>'.$data->RoadHazard->FormNumber.'</FormNumber>
            <Options>
              <Option>'.'</Option>
            </Options>
          </RoadHazard>';
		}
		if ($ProductBaseId == 5) {
			$xml = '<Dent>
            <ContractNumber>'.$data->Dent->ContractNumber.'</ContractNumber>
            <CvCvty>'.$data->Dent->CvCvty.'</CvCvty>
            <Cost>'.$data->Dent->Cost.'</Cost>
            <RetailAmount>'.$data->Dent->RetailAmount.'</RetailAmount>
            <FiledAmount>'.$data->Dent->FiledAmount.'</FiledAmount>
            <TermYears>'.$data->Dent->TermYears.'</TermYears>
            <FormNumber>'.$data->Dent->FormNumber.'</FormNumber>
            <Options>
              <Option>'.'</Option>
            </Options>
          </Dent>';
		}


		return $xml;
	}


	private function getContractNumber($response,$request)
	{
	//	print_r($response);die();
		$contract = explode('&lt;ContractNumber&gt;', $response);
		if(!(empty($contract[1]))){
			$contract = explode('&lt;/ContractNumber&gt;', $contract[1]);
		}else{
			echo "Contract number not found";die();
		}
		$contractNumber = $contract[0];
		if (empty($contractNumber)){
			echo "Contract number not found";
			echo "<br>";
			$error = explode('&lt;ErrorCode&gt;', $response);
		    $error = explode('&lt;/ErrorCode&gt;', $error[1]);
			echo "Error code = ".$error[0];
			die();
		}
		return $contractNumber;		
	}

	private function VoidContract($contractNumber, $request)
	{
		$ProductBaseId = $request->product->ProductBaseId;

		$body = $this->getXmlBodyVoidContract($ProductBaseId, $contractNumber);

		$xml = '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
		<s:Header>
			<h:AuthenticationHeader xmlns:h="http://UsWarranty.com/UswcWebServicePolicies" xmlns="http://UsWarranty.com/UswcWebServicePolicies" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
				<Username>'.$request->deal->Username.'</Username>
				<Password>'.$request->deal->Password.'</Password>
			</h:AuthenticationHeader>
		</s:Header>
		<s:Body xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
		<VoidProducts xmlns="http://UsWarranty.com/UswcWebServicePolicies">
			<xmlDoc>
				<Products xmlns="">
					<Customer>
						<CompanyInitials>USW</CompanyInitials>
						<DealerCode>'.$request->dealercode.'</DealerCode>
					</Customer>'.
					$body	
				.'</Products>
			</xmlDoc>
		</VoidProducts>
		</s:Body>
		</s:Envelope>';

		$url = 'http://www.uswarranty.com/Testuswcwebservicepolicies/webservice.asmx?wsdl';

		$soap_do = curl_init(); 
		curl_setopt($soap_do, CURLOPT_URL,            $url );   
		curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 20); 
		curl_setopt($soap_do, CURLOPT_TIMEOUT,        20); 
		curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);  
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false); 
		curl_setopt($soap_do, CURLOPT_POST,           true ); 
		curl_setopt($soap_do, CURLOPT_POSTFIELDS,    $xml); 
		curl_setopt($soap_do, CURLOPT_HTTPHEADER,     array('Content-Type: text/xml; charset=utf-8', 'Content-Length: '.strlen($xml) )); 


		$result = curl_exec($soap_do);		        		
		$err = curl_error($soap_do); 
	}

	private function getXmlBodyVoidContract($ProductBaseId, $contractNumber)
	{
		if ($ProductBaseId == 1) { // Us  key
			$xml = '<Key><ContractNumber>'.$contractNumber.'</ContractNumber></Key>';
		}
		if ($ProductBaseId == 2) { // Vsc
			$xml = '<Vsc><ContractNumber>'.$contractNumber.'</ContractNumber></Vsc>';
		}
		if ($ProductBaseId == 3) { // Gap
			$xml = '<Gap><ContractNumber>'.$contractNumber.'</ContractNumber></Gap>';
		}
		if ($ProductBaseId == 4) { // Maintenance
			$xml = '<Maintenance><ContractNumber>'.$contractNumber.'</ContractNumber></Maintenance>';
		}
		if ($ProductBaseId == 5) { // Dent
			$xml = '<Dent><ContractNumber>'.$contractNumber.'</ContractNumber></Dent>';
		}
		if ($ProductBaseId == 9) { // Road Hazard
			$xml = '<RoadHazard><ContractNumber>'.$contractNumber.'</ContractNumber></RoadHazard>';
		}

		return $xml;
	}

}





//==========================   xml full  ================================================

/*  xml = '<Etch><ContractNumber/></Etch>
			<ShadowMark><ContractNumber/></ShadowMark>
			<SafeLease><ContractNumber/></SafeLease>
			<Chemical><ContractNumber/></Chemical>';
*/



/*   



 		$xml = '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
  <s:Header>
    <h:AuthenticationHeader xmlns:h="http://UsWarranty.com/UswcWebServicePolicies" xmlns="http://UsWarranty.com/UswcWebServicePolicies" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
      <Username>'.$data->AuthenticationHeader->Username.'</Username>
      <Password>'.$data->AuthenticationHeader->Password.'</Password>
    </h:AuthenticationHeader>
  </s:Header>
  <s:Body xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
    <SubmitProducts xmlns="http://UsWarranty.com/UswcWebServicePolicies">
    <xmlDoc>
        <Products xmlns="">
          <Customer>
            <CompanyInitials>'.$Products->Customer->CompanyInitials.'</CompanyInitials>
            <DealerCode>'.$Products->Customer->DealerCode.'</DealerCode>
            <LastName>'.$Products->Customer->LastName.'</LastName>
            <FirstName>'.$Products->Customer->FirstName.'</FirstName>
            <MiddleInitial>'.$Products->Customer->MiddleInitial.'</MiddleInitial>
            <LastName2>'.$Products->Customer->LastName2.'</LastName2>
            <FirstName2>'.$Products->Customer->FirstName2.'</FirstName2>
            <MiddleInitial2>'.$Products->Customer->MiddleInitial2.'</MiddleInitial2>
            <Address>'.$Products->Customer->Address.'</Address>
            <City>'.$Products->Customer->City.'</City>
            <State>'.$Products->Customer->State.'</State>
            <Zip>'.$Products->Customer->Zip.'</Zip>
            <Phone>'.$Products->Customer->Phone.'</Phone>
            <PhoneNight>'.$Products->Customer->PhoneNight.'</PhoneNight>
            <EmailAddress>'.$Products->Customer->EmailAddress.'</EmailAddress>
            <Vin>'.$Products->Customer->Vin.'</Vin>
            <Odometer>'.$Products->Customer->Odometer.'</Odometer>
            <SaleDate>'.$Products->Customer->SaleDate.'</SaleDate>
            <UswcFinanced>'.$Products->Customer->UswcFinanced.'</UswcFinanced>
            <StockNumber>'.$Products->Customer->StockNumber.'</StockNumber>
            <DealNumber>'.$Products->Customer->DealNumber.'</DealNumber>
            <CustomerNumber>'.$Products->Customer->CustomerNumber.'</CustomerNumber>
          </Customer>
          <Lienholder>
            <Name>'.$Products->Lienholder->Name.'</Name>
            <Address>'.$Products->Lienholder->Address.'</Address>
            <City>'.$Products->Lienholder->City.'</City>
            <State>'.$Products->Lienholder->State.'</State>
            <Zip>'.$Products->Lienholder->Zip.'</Zip>
          </Lienholder>
          <Vsc>
            <ContractNumber>'.$Products->Vsc->ContractNumber.'</ContractNumber>
            <CvCvty>'.$Products->Vsc->CvCvty.'</CvCvty>
            <Cost>'.$Products->Vsc->Cost.'</Cost>
            <RetailAmount>'.$Products->Vsc->RetailAmount.'</RetailAmount>
            <FiledAmount>'.$Products->Vsc->FiledAmount.'</FiledAmount>
            <TermMonths>'.$Products->Vsc->TermMonths.'</TermMonths>
            <TermMiles>'.$Products->Vsc->TermMiles.'</TermMiles>
            <InServiceDate>'.$Products->Vsc->InServiceDate.'</InServiceDate>
            <Deductible>'.$Products->Vsc->Deductible.'</Deductible>
            <Cert>'.$Products->Vsc->Cert.'</Cert>
            <Wrap>'.$Products->Vsc->Wrap.'</Wrap>
            <FormNumber>'.$Products->Vsc->FormNumber.'</FormNumber>
            <Options>
              <Option>'.$Products->Vsc->Options->Option.'</Option>
            </Options>
          </Vsc>
          <Maintenance>
            <ContractNumber>'.'</ContractNumber>
            <CvCvty>'.'</CvCvty>
            <Cost>'.'</Cost>
            <RetailAmount>'.'</RetailAmount>
            <FiledAmount>'.'</FiledAmount>
            <TermMonths>'.'</TermMonths>
            <TermMiles>'.'</TermMiles>
            <Interval>'.'</Interval>
            <FormNumber>'.'</FormNumber>
            <Options>
              <Option>'.'</Option>
            </Options>
          </Maintenance>
          <RoadHazard>
            <ContractNumber>'.'</ContractNumber>
            <CvCvty>'.'</CvCvty>
            <Cost>'.'</Cost>
            <RetailAmount>'.'</RetailAmount>
            <FiledAmount>'.'</FiledAmount>
            <TermMonths>'.'</TermMonths>
            <TermMiles>'.'</TermMiles>
            <FormNumber>'.'</FormNumber>
            <Options>
              <Option>'.'</Option>
            </Options>
          </RoadHazard>
          <Key>
            <ContractNumber>'.'</ContractNumber>
            <CvCvty>'.'</CvCvty>
            <Cost>'.'</Cost>
            <RetailAmount>'.'</RetailAmount>
            <FiledAmount>'.'</FiledAmount>
            <TermYears>'.'</TermYears>
            <VehicleType>'.'</VehicleType>
            <FormNumber>'.'</FormNumber>
            <Options>
              <Option>'.'</Option>
            </Options>
          </Key>
          <Dent>
            <ContractNumber>'.'</ContractNumber>
            <CvCvty>'.'</CvCvty>
            <Cost>'.'</Cost>
            <RetailAmount>'.'</RetailAmount>
            <FiledAmount>'.'</FiledAmount>
            <TermYears>'.'</TermYears>
            <FormNumber>'.'</FormNumber>
            <Options>
              <Option>'.'</Option>
            </Options>
          </Dent>
          <Gap>
            <ContractNumber>'.$Products->Gap->ContractNumber.'</ContractNumber>
            <RetailAmount>'.$Products->Gap->RetailAmount.'</RetailAmount>
            <FiledAmount>'.$Products->Gap->FiledAmount.'</FiledAmount>
            <TermMonths>'.$Products->Gap->TermMonths.'</TermMonths>
            <PurchasePrice>'.$Products->Gap->PurchasePrice.'</PurchasePrice>
            <FinancedAmount>'.$Products->Gap->FinancedAmount.'</FinancedAmount>
            <MSRP>'.$Products->Gap->MSRP.'</MSRP>
            <InterestRate>'.$Products->Gap->InterestRate.'</InterestRate>
            <FormNumber>'.$Products->Gap->FormNumber.'</FormNumber>
            <FinanceType>'.$Products->Gap->FinanceType.'</FinanceType>
          </Gap>
          <Etch>
            <ContractNumber>'.'</ContractNumber>
            <CvCvty>'.'</CvCvty>
            <Cost>'.'</Cost>
            <RetailAmount>'.'</RetailAmount>
            <FiledAmount>'.'</FiledAmount>
            <TermYears>'.'</TermYears>
            <FormNumber>'.'</FormNumber>
            <EtchNumber>'.'</EtchNumber>
            <PipNumber>'.'</PipNumber>
          </Etch>
          <ShadowMark>
            <ContractNumber>'.'</ContractNumber>
            <CvCvty>'.'</CvCvty>
            <Cost>'.'</Cost>
            <RetailAmount>'.'</RetailAmount>
            <FiledAmount>'.'</FiledAmount>
            <TermYears>'.'</TermYears>
            <FormNumber>'.'</FormNumber>
            <EtchNumber>'.'</EtchNumber>
            <PipNumber>'.'</PipNumber>
          </ShadowMark>
          <SafeLease>
            <ContractNumber>'.'</ContractNumber>
            <Cost>'.'</Cost>
            <RetailAmount>'.'</RetailAmount>
            <FiledAmount>'.'</FiledAmount>
            <TermMonths>'.'</TermMonths>
            <TermMiles>'.'</TermMiles>
            <EffectiveDate>'.'</EffectiveDate>
            <Plan>'.'</Plan>
            <Deductible>'.'</Deductible>
            <Limit>'.'</Limit>
            <Certified>'.'</Certified>
            <FormNumber>'.'</FormNumber>
          </SafeLease>
          <Chemical>
            <ContractNumber>'.'</ContractNumber>
            <CvCvty>'.'</CvCvty>
            <Cost>'.'</Cost>
            <RetailAmount>'.'</RetailAmount>
            <FiledAmount>'.'</FiledAmount>
            <TermYears>'.'</TermYears>
            <FormNumber>'.'</FormNumber>
            <PipNumber>'.'</PipNumber>
          </Chemical>
        </Products>
      </xmlDoc>
    </SubmitProducts>
  </s:Body>
</s:Envelope>';


*/
