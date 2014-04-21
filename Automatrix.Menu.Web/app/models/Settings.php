<?php

class Settings
{
	public $initials;
	
	public $dealerCode;
	
	public $webservice;
	
	/**
	 * 
	 * @param mixed $config
	 */
	public function __construct($dealer, $company, $parameters, $product)
	{
		// TODO: Map config properties to class properties
		
		$this->webservice = new stdClass();
		$this->webservice->credentials = new stdClass();
		
		$this->webservice->url = $company->URL;
		$this->webservice->DealerCode = $parameters->DealerCode;
		$this->webservice->credentials->username = $parameters->WebServiceUsername;
		$this->webservice->credentials->password = $parameters->WebServicePassword;
		
		if($product->ProductName == "US Key")
			$this->webservice->method = "GetKeyRates";	
	}
}