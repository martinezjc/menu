<?php namespace Api\Services;

/**
 * 
 * @author brittongr
 * @description Request to wrap all the parameters in one object
 * 
 */
class Request
{
	/**
	 * Name of the product that will be requested.
	 * 
	 * @var string
	 */
	public $product;
	
	/**
	 * deal that should be requested.
	 * 
	 * @var string
	 */
	public $deal;

	/**
	 * Identication code of current Dealer.
	 * 
	 * @var string
	 */
	public $dealercode;
	
	/**
	 * 
	 * @param array $parameters
	 */

	/**
	 * Type of request for price or contract.
	 * Price = 0
	 * Contract = 1
	 *
	 * @var string
	 */
	public $type;

	/**
	 * Option choosed for deal
	 * 
	 * available only in forms 
	 *
	 * @var string
	 */
	public $productOptions;

	/**
	 * product rates
	 * 
	 * available only in forms 
	 *
	 * @var string
	 */
	public $productRates;

	public function __construct($parameters)
	{
		$this->product = $parameters["product"];
		$this->deal = $parameters["deal"];
		$this->dealercode = $parameters["dealercode"];
		$this->type = $parameters["type"];
		$this->productOptions = $parameters["productOptions"];
		$this->productRates = $parameters["productRates"];

	}
}