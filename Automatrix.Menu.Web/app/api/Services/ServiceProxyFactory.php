<?php namespace Api\Services;

/**
 * 
 * @author gbritton
 * @description Factory class for service proxies
 *
 */
class ServiceProxyFactory
{
	/**
	 * Create a new instance of the service class
	 * 
	 * @param {mixed}
	 * @return Api\Remote\ServiceProxy
	 */
	public static function create($settings, $company)
	{
		ini_set('soap.wsdl_cache_enabled', 1); 
		ini_set('soap.wsdl_cache_ttl', 1);

		
		$ServiceCall = 0;
		try {
			switch ($company->id) {

			case 1:
				//$ServiceCall = new USWarrantyServiceProxy(new \SoapClient($settings->webservice->url), $settings);
				if (is_soap_fault($ServiceCall = new USWarrantyServiceProxy(new \SoapClient($settings->webservice->url), $settings))) {
					return 0;//trigger_error("SOAP Fault: (faultcode: {$result->faultcode}, faultstring: {$result->faultstring})", E_USER_ERROR);
				}
				break;
			
			case 2: 
			    //$ServiceCall = new ProtectiveServiceProxy(new \SoapClient($settings->webservice->url), $settings);
				if (is_soap_fault($ServiceCall = new ProtectiveServiceProxy(new \SoapClient($settings->webservice->url), $settings))) {
					return 0;//trigger_error("SOAP Fault: (faultcode: {$result->faultcode}, faultstring: {$result->faultstring})", E_USER_ERROR);
				}
				break;
			case 3: 
				//$ServiceCall = new ProtectiveServiceProxy(new \SoapClient($settings->webservice->url), $settings);
				if (is_soap_fault($ServiceCall = new RoadVantageServiceProxy(new \SoapClient($settings->webservice->url), $settings))) {
					return 0;//trigger_error("SOAP Fault: (faultcode: {$result->faultcode}, faultstring: {$result->faultstring})", E_USER_ERROR);
				}
				break;
			}

			return $ServiceCall;
			
		} catch (SoapFault $e) {
			return 0;
		}
		// TODO: Create a custom service based on the company
		
		
		//return new USWarrantyServiceProxy(new SoapClientMock(), $settings);
	}

	
}

