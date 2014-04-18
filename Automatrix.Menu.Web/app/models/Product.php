<?php

class Product extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'ProductName' => 'required',
		'DisplayName' => 'required',
		'Cost' => 'required',
		'SellingPrice' => 'required'
	);
}
