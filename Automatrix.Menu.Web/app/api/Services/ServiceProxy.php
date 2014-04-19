<?php namespace Api\Services;

/**
 * 
 * @author brittongr
 * @description: Service wrapper to connect to external companies webservices
 *  
 */
abstract class ServiceProxy
{
	/**
	 * Real instance of the webservice
	 * @var object
	 */
	protected $proxy = null;
	
	public function __construct($proxy, $settings)
	{
		$this->proxy = $proxy;
		$this->buildProxy($settings);
	}
	
	/**
	 * This method must be implemented in the extended classes to setup the proxy
	 * 
	 * @param Settings $settings
	 */
	protected abstract function buildProxy($settings);
	
	/**
	 * Execute call against the remote service of the external companies
	 * 
	 * @param Request $request
	 */
	public abstract function execute($request);
}