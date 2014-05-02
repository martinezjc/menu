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
	
	##---------------- Execute request and return response --------------- ##
	public function execute($request)
	{
		set_time_limit(60);
	try {
			# Request for Rates
			if ($request->type == 0) { 
				 return $this->executeRateRequest($request);				
			} else { 
				# Request for Contract
				return  $this->executeContractRequest($request);	
			}
			
		} catch (SoapFault $e) { 
		    return 0;//$e->faultcode; 
		} 
	}

	##---------------- Execute Rates Request --------------- ##
	private function executeRateRequest($request)
	{
		$method = $this->getMethod($request);
		$response = $this->proxy->$method ($this->getParameters($request)); 
		$dat = ( array ) $response;
		$xml = simplexml_load_string ( $dat [$method.'Result'] );
		$json = json_encode ( $xml );
		$data = json_decode ( $json, true );
		return $data;
	}

	##---------------- Execute Contract Request --------------- ##
	private function executeContractRequest($request)
	{
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
        	# Void contract
        	$contractNumber = $this->getContractNumber($result,$request);
        	$this->VoidContract($contractNumber,$request);
           	return $result;
        } else {
        	return $err;
        }
	}

	##---------------- Get Method for  Rates Request --------------- ##
	private function getMethod($request)
	{
		$method = "";
		$productBaseId = $request->product->ProductBaseId;
		
		switch ($productBaseId) {
			case 1: //US Key
				$method = "GetKeyRates";
				break;
			case 2: //US Vehicle Service Contract
				$method = "GetVscRates";
				break;
			case 3: //US Total Lost Protection (GAP)
				$method = "GetGapRates";
				break;
			case 4: //US Maintenance Plan
				$method = "GetMaintRates";
				break;
			case 5: //US Dent
				$method = "GetDentRates";
				break;
			case 7: //US Chemical
				$method = "GetChemicalRates";
				break;
			case 8: //US Etch
				$method = "GetEtchRates";
				break;
			case 9: //US Road Hazard
				$method = "GetRoadHazardRates";
				break;
			
			default:
				break;
		}
						
		return $method;				
	}
	
	##---------------- Get parameter for Request --------------- ##
	private function getParameters($request)
	{
		$parameters = null;

		# Parameter for Rates
		if ($request->type == 0) {
			$parameters = $this->getRatesParameters($request);

		} else { 			
			# Do validations of data
            $request = $this->ValidateRequest($request);

            # Parameter for Contract
            $parameters = $this->getContractParameters($request);			
		}
		return $parameters;
	}

	##---------------- Get parameter for  Rates Request --------------- ##
	private function getRatesParameters($request)
	{

		$parameters = new \stdClass();
		$ProductBaseId = $request->product->ProductBaseId;

		# All products
		$parameters->Company = "USW";
		$parameters->DealerCode = $request->dealercode;
		$parameters->Vin = trim($request->deal->VIN);
		$parameters->SaleDate = date('c');

		# US Vsc, Us Gap, Us Maintenance, Us Dent, US Road hazard
		if ($ProductBaseId == 2 || $ProductBaseId == 3 || $ProductBaseId == 4 || $ProductBaseId == 5 || $ProductBaseId == 9) {
			$parameters->Mileage = trim(round($request->deal->BeginningOdometer));
		}

		# US Vsc
		if ($ProductBaseId == 2) {
			$parameters->NewUsed = "Used";
			$parameters->InSrvDate = date('c');
		}

		# US Maintenance
		if ($ProductBaseId == 4) {
			$parameters->AloneOption = "Alone";
		}

		$parameters = (array)$parameters;

		return $parameters;
    }

	##---------------- Get parameter for  Contract  Request --------------- ##
	private function getContractParameters($request)
	{
		$parameters = new \stdClass();
		$vin = $request->deal->VIN;
	    $dealercode = $request->dealercode;
		$productBaseId = $request->product->ProductBaseId;

		$parameters->AuthenticationHeader = new \stdClass();
        $parameters->AuthenticationHeader->Username = $request->deal->Username;
        $parameters->AuthenticationHeader->Password = $request->deal->Password;

        $parameters->Products = new \stdClass();

        $parameters->Products->Customer = new \stdClass();
        $parameters->Products->Customer->CompanyInitials = 'USW' ;
        $parameters->Products->Customer->DealerCode = $dealercode;
        $parameters->Products->Customer->LastName = $request->deal->LastName;
        $parameters->Products->Customer->FirstName = $request->deal->FirstName;
        $parameters->Products->Customer->MiddleInitial = substr($request->deal->MiddleName, 0, 1); // Only send the intials middlename
        $parameters->Products->Customer->LastName2 = '';
        $parameters->Products->Customer->FirstName2 = '';
        $parameters->Products->Customer->MiddleInitial2 = '';
        $parameters->Products->Customer->Address = $request->deal->Address1;
        $parameters->Products->Customer->City = $request->deal->City;
        $parameters->Products->Customer->State = $request->deal->State;
        $parameters->Products->Customer->Zip = round($request->deal->ZipCode);
        $parameters->Products->Customer->Phone = $request->deal->Telephone;
        $parameters->Products->Customer->PhoneNight = $request->deal->Telephone;
        $parameters->Products->Customer->EmailAddress = $request->deal->Email;
        $parameters->Products->Customer->Vin = $vin;
        $parameters->Products->Customer->Odometer = $request->deal->BeginningOdometer;
        $parameters->Products->Customer->SaleDate = date("m/d/Y");//'03/28/2014';
        $parameters->Products->Customer->UswcFinanced = $request->deal->FinancedAmount;//20000;
        $parameters->Products->Customer->StockNumber = 0;
        $parameters->Products->Customer->DealNumber = 0;
        $parameters->Products->Customer->CustomerNumber = 0;

        $parameters->Products->Lienholder = new \stdClass();
        $parameters->Products->Lienholder->Name  = $request->deal->LienHolderName;
        $parameters->Products->Lienholder->Address  = $request->deal->LienHolderAddress;
        $parameters->Products->Lienholder->Country  = $request->deal->LienHolderCountry;
        $parameters->Products->Lienholder->City  = $request->deal->LienHolderCity;
        $parameters->Products->Lienholder->State  = $request->deal->LienHolderState;
        $parameters->Products->Lienholder->Zip = $request->deal->LienHolderZip;

        

        switch ($productBaseId) {
			case 1: //US Key
				$parameters->Products->Key =  new \stdClass();
		        $parameters->Products->Key->ContractNumber = '';
		        $parameters->Products->Key->CvCvty = $request->productRates->CvCvty;//'GKN';
		        $parameters->Products->Key->Cost = $request->productRates->AmtDueWtyCo;
		        $parameters->Products->Key->RetailAmount = $request->productOptions->price;
		        $parameters->Products->Key->FiledAmount = $request->productOptions->price;
		        $parameters->Products->Key->TermYears = ($request->productOptions->term)/12;
		        $parameters->Products->Key->VehicleType = 'U';
		        $parameters->Products->Key->FormNumber = $request->productRates->FormNumber;
		        $parameters->Products->Key->Options = new \stdClass();
		        $parameters->Products->Key->Options->Option = ""; 
				break;
			case 2: //US Vehicle Service Contract
				$parameters->Products->Vsc = new \stdClass();
		        $parameters->Products->Vsc->ContractNumber= '';
		        $parameters->Products->Vsc->CvCvty = $request->productRates->CvCvty;//"US46E";
		        $parameters->Products->Vsc->Cost = $request->productRates->AmtDueWtyCo;// '';
		        $parameters->Products->Vsc->RetailAmount = $request->productOptions->price;
		        $parameters->Products->Vsc->FiledAmount= $request->productOptions->price;// '';
		        $parameters->Products->Vsc->TermMonths= $request->productOptions->term;
		        $parameters->Products->Vsc->TermMiles= ($request->productOptions->mileage)*1000;//"6,000";
		        $parameters->Products->Vsc->InServiceDate= date('c');
		        $parameters->Products->Vsc->Deductible= $request->productOptions->deductible;
		        $parameters->Products->Vsc->Cert = "N";
		        $parameters->Products->Vsc->Wrap = "N";
		        $parameters->Products->Vsc->FormNumber= $request->productRates->FormNumber;//"USWC US FC 02-12";
		        $parameters->Products->Vsc->Options = new \stdClass();
		        $parameters->Products->Vsc->Options->Option = "";
				break;
			case 3: //US Total Lost Protection (GAP)
				$parameters->Products->Gap = new \stdClass();
		        $parameters->Products->Gap->ContractNumber = "";
		        $parameters->Products->Gap->RetailAmount = $request->productOptions->price;
		        $parameters->Products->Gap->FiledAmount = $request->productOptions->price;
		        $parameters->Products->Gap->TermMonths = $request->productOptions->term;
		        $parameters->Products->Gap->PurchasePrice = $request->deal->SalesPrice;
		        $parameters->Products->Gap->FinancedAmount = $request->deal->FinancedAmount;
		        $parameters->Products->Gap->MSRP = $request->deal->SalesPrice;
		        $parameters->Products->Gap->InterestRate = $request->deal->NewAPR;
		        $parameters->Products->Gap->FormNumber = $request->productRates->FormNumber; 
		        $parameters->Products->Gap->FinanceType = "Purchase"; 

				break;
			case 4: //US Maintenance Plan
				$parameters->Products->Maintenance = new \stdClass();
		        $parameters->Products->Maintenance->ContractNumber = "";
		        $parameters->Products->Maintenance->CvCvty = $request->productRates->CvCvty;
		        $parameters->Products->Maintenance->Cost = $request->productRates->AmtDueWtyCo;
		        $parameters->Products->Maintenance->RetailAmount = $request->productOptions->price;
		        $parameters->Products->Maintenance->FiledAmount = $request->productOptions->price;
		        $parameters->Products->Maintenance->TermMonths = $request->productOptions->term;
		        $parameters->Products->Maintenance->TermMiles = ($request->productOptions->mileage)*1000;
		        $parameters->Products->Maintenance->Interval = $request->productOptions->interval;
		        $parameters->Products->Maintenance->FormNumber = $request->productRates->FormNumber;
		        $parameters->Products->Maintenance->Options = new \stdClass();
		        $parameters->Products->Maintenance->Options->Option = "";
				break;
			case 5: //US Dent
				$parameters->Products->Dent =  new \stdClass();
		        $parameters->Products->Dent->ContractNumber = "";
		        $parameters->Products->Dent->CvCvty = $request->productRates->CvCvty;
		        $parameters->Products->Dent->Cost = $request->productRates->AmtDueWtyCo;
		        $parameters->Products->Dent->RetailAmount = $request->productOptions->price;
		        $parameters->Products->Dent->FiledAmount = $request->productOptions->price;
		        $parameters->Products->Dent->TermYears = ($request->productOptions->term)/12;
		        $parameters->Products->Dent->FormNumber = $request->productRates->FormNumber;
		        $parameters->Products->Dent->Options = new \stdClass();
		        $parameters->Products->Dent->Options->Option = "";
				break;
			case 7: //US Chemical
				$parameters->Products->Chemical =  new \stdClass(); 
		        $parameters->Products->Chemical->ContractNumber = ""; 
		        $parameters->Products->Chemical->CvCvty = ""; 
		        $parameters->Products->Chemical->Cost = ""; 
		        $parameters->Products->Chemical->RetailAmount = ""; 
		        $parameters->Products->Chemical->FiledAmount = ""; 
		        $parameters->Products->Chemical->TermYears = ""; 
		        $parameters->Products->Chemical->FormNumber = ""; 
		        $parameters->Products->Chemical->PipNumber = "";
				break;
			case 8: //US Etch
				$parameters->Products->Etch = new \stdClass(); 
		        $parameters->Products->Etch->ContractNumber = ""; 
		        $parameters->Products->Etch->CvCvty = ""; 
		        $parameters->Products->Etch->Cost = ""; 
		        $parameters->Products->Etch->RetailAmount = ""; 
		        $parameters->Products->Etch->FiledAmount = ""; 
		        $parameters->Products->Etch->TermYears = ""; 
		        $parameters->Products->Etch->FormNumber = ""; 
		        $parameters->Products->Etch->EtchNumber = ""; 
		        $parameters->Products->Etch->PipNumber = ""; 
				break;
			case 9: //US Road Hazard
				$parameters->Products->RoadHazard =  new \stdClass();
		        $parameters->Products->RoadHazard->ContractNumber = "";
		        $parameters->Products->RoadHazard->CvCvty = $request->productRates->CvCvty;
		        $parameters->Products->RoadHazard->Cost = $request->productRates->AmtDueWtyCo;
		        $parameters->Products->RoadHazard->RetailAmount = $request->productOptions->price;
		        $parameters->Products->RoadHazard->FiledAmount = $request->productOptions->price;
		        $parameters->Products->RoadHazard->TermMonths = $request->productOptions->term;
		        $parameters->Products->RoadHazard->TermMiles = ($request->productOptions->mileage)*1000;
		        $parameters->Products->RoadHazard->FormNumber = $request->productRates->FormNumber;
		        $parameters->Products->RoadHazard->Options = new \stdClass();
		        $parameters->Products->RoadHazard->Options->Option = "";
				break;
			
			default:
				break;
		}
        // $parameters->Products->ShadowMark = new \stdClass(); 
        // $parameters->Products->ShadowMark->ContractNumber = ""; 
        // $parameters->Products->ShadowMark->CvCvty = ""; 
        // $parameters->Products->ShadowMark->Cost = ""; 
        // $parameters->Products->ShadowMark->RetailAmount = ""; 
        // $parameters->Products->ShadowMark->FiledAmount = ""; 
        // $parameters->Products->ShadowMark->TermYears = ""; 
        // $parameters->Products->ShadowMark->FormNumber = ""; 
        // $parameters->Products->ShadowMark->EtchNumber = ""; 
        // $parameters->Products->ShadowMark->PipNumber = "";  

        // $parameters->Products->SafeLease = new \stdClass();
        // $parameters->Products->SafeLease->ContractNumber = ""; 
        // $parameters->Products->SafeLease->Cost = ""; 
        // $parameters->Products->SafeLease->RetailAmount = ""; 
        // $parameters->Products->SafeLease->FiledAmount = ""; 
        // $parameters->Products->SafeLease->TermMonths = ""; 
        // $parameters->Products->SafeLease->TermMiles = ""; 
        // $parameters->Products->SafeLease->EffectiveDate = ""; 
        // $parameters->Products->SafeLease->Plan = ""; 
        // $parameters->Products->SafeLease->Deductible = ""; 
        // $parameters->Products->SafeLease->Limit = ""; 
        // $parameters->Products->SafeLease->Certified = ""; 
        // $parameters->Products->SafeLease->FormNumber = ""; 

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

		return $xml;
	}


	private function getContractNumber($response,$request)
	{
	    //print_r($response);die();
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

	##---------------- Validate data for  Contract  Request --------------- ##
	private function ValidateRequest($request)
	{
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

		if (preg_match($pattern, $request->deal->Email) === 0) {
			$request->deal->Email = 'test@mail.com';
		}

		if (strlen(round($request->deal->ZipCode)) < 5) {
			$request->deal->ZipCode = 12345;
		}

		 /*
        *  APPLY SALES TAX RATE ( WHERE APPLICABLE)
        *   
        */
        //if ($request->product->IsTaxable == 1) {
            //$request->productOptions->price = ($request->productOptions->price) * (1 + ($request->deal->TaxRate / 100));  

        //}

		return $request;
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
