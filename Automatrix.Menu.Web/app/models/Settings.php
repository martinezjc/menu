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
	public function __construct($dealer, $company, $product)
	{
		// TODO: Map config properties to class properties
		
		$this->webservice = new stdClass();
		$this->webservice->credentials = new stdClass();
		
		$this->webservice->url = $company->URL;
		$this->webservice->credentials->username = $company->Username;
		$this->webservice->credentials->password = $company->Password;
		
		if($product->ProductName == "US Key")
			$this->webservice->method = "GetKeyRates";	
	}
}