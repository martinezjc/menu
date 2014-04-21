<?php
class DealerController extends BaseController 
{
	public function index()
	{
		$dealers = DB::select( DB::raw( 'SELECT DealerId, DealerName FROM Dealer' ) );
		
		return View::make('dealer.index')
					->with ('dealers', $dealers )
					->with ('currentUser', Session::get ( 'UserSessionInfo' ) );
	}

    /**
	 * Display a form in input mode
	 */
	public function add()
	{
		return View::make('dealer.edit' )
					->with('dealer', new Dealer() )
					->with('currentUser', Session::get ( 'UserSessionInfo' ));
	}
	
	/**
	 * Display a form in input mode with the current values
	 * @param Number $id
	 */
	public function view($id)
	{
		$dealer = DB::table ( 'Dealer' )->where ( 'DealerId', '=', $id )->first ();
		
		return View::make('dealer.edit' )
					->with('dealer', $dealer)
					->with('currentUser', Session::get ( 'UserSessionInfo' ));
	}
	
	public function save()
	{
		$DealerId = Input::get('DealerId');
        $DealerCode = Input::get('DealerCode');
        $DealerName = Input::get('DealerName');
        $CompanyCode = Input::get('CompanyCode');
    	$Deal = Input::get('Deal');
        $URL = Input::get('URL');
        $Year = Input::get('Year');
        $Make = Input::get('Make');
        $Model = Input::get('Model');
        $FinancedAmount = Input::get('FinancedAmount');
        $BasePayment = Input::get('BasePayment');
        $APR = Input::get('APR');
        $Term = Input::get('Term');
        $DownPayment = Input::get('DownPayment');
        $Buyer = Input::get('Buyer');
        $CoBuyer = Input::get('CoBuyer');
        $Trim = Input::get('Trim');
        $TradeAllowance = Input::get('TradeAllowance');
        $TradePayOff = Input::get('TradePayOff');
        $BeginningOdometer = Input::get('BeginningOdometer');
        $Address1 = Input::get('Address1');
        $Address2 = Input::get('Address2');
        $City = Input::get('City');
        $State = Input::get('State');
        $StateCode = Input::get('StateCode');
        $ZipCode = Input::get('ZipCode');
        $Country = Input::get('Country');
        $CountryCode = Input::get('CountryCode');
        $Telephone = Input::get('Telephone');
        $Email = Input::get('Email');
        $Disclosure = Input::get('Disclosure');
        $Vin = Input::get('Vin');
        $DisplayPayOff = Input::get('DisplayPayOff');
        $DisplayTerm = Input::get('DisplayTerm');
        $DisplayAPR = Input::get('DisplayAPR');
        $DisplayFinancedAmount = Input::get('DisplayFinancedAmount');
        $DisplayDownPayment = Input::get('DisplayDownPayment');
        $DisplayCoBuyer = Input::get('DisplayCoBuyer');
        $DisplayBuyer = Input::get('DisplayBuyer');
        $DisplayTradeIn = Input::get('DisplayTradeIn');

        $settingExists = DB::table('Dealer')
                         ->where('DealerId', '=', $DealerId)
                         ->first();

        if ( empty($settingExists) ) {
        	$InsertedDealerId = DB::table('Dealer')
        	           ->insertGetId(array( 'DisplayPayOff' => $DisplayPayOff,
                                       'DisplayTerm' => $DisplayTerm,
                                       'DisplayAPR' => $DisplayAPR,
                                       'DisplayFinancedAmount' => $DisplayFinancedAmount,
                                       'DisplayDownPayment' => $DisplayDownPayment,
                                       'DisplayCoBuyer' => $DisplayCoBuyer,
                                       'DisplayBuyer' => $DisplayBuyer,
                                       'DisplayTradeIn' => $DisplayTradeIn,
                                       'CompanyCode' => $CompanyCode,
                                       'DealerName' => $DealerName,
        	           	                 'Deal' => $Deal,
        	           	                 'URL' => $URL,
        	           	                 'Year' => $Year,
        	           	                 'Make' => $Make,
        	           	                 'Model' => $Model,
        	           	                 'FinancedAmount' => $FinancedAmount,
        	           	                 'BasePayment' => $BasePayment,
        	           	                 'APR' => $APR,
        	           	                 'Term' => $Term,
        	           	                 'DownPayment' => $DownPayment,
        	           	                 'Buyer' => $Buyer,
        	           	                 'CoBuyer' => $CoBuyer,
                                       'Trim' => $Trim,
                                       'TradeAllowance' => $TradeAllowance,
                                       'TradePayOff' => $TradePayOff,
                                       'BeginningOdometer' => $BeginningOdometer,
                                       'Address1' => $Address1,
                                       'Address2' => $Address2,
                                       'City' => $City,
                                       'State' => $State,
                                       'StateCode' => $StateCode,
                                       'ZipCode' => $ZipCode,
                                       'Country' => $Country,
                                       'CountryCode' => $CountryCode,
                                       'Telephone' => $Telephone,
                                       'Email' => $Email,
        	           	                 'Disclosure' => $Disclosure,
                                       'Vin' => $Vin));
            return $InsertedDealerId;
        } else {
            $settings = DB::table('Dealer')
                       ->where('DealerId', '=', $DealerId)
        	           ->update(array( 'DisplayPayOff' => $DisplayPayOff,
                                       'DisplayTerm' => $DisplayTerm,
                                       'DisplayAPR' => $DisplayAPR,
                                       'DisplayFinancedAmount' => $DisplayFinancedAmount,
                                       'DisplayDownPayment' => $DisplayDownPayment,
                                       'DisplayCoBuyer' => $DisplayCoBuyer,
                                       'DisplayBuyer' => $DisplayBuyer,
                                       'DisplayTradeIn' => $DisplayTradeIn,
                                       'CompanyCode' => $CompanyCode,
                                       'DealerName' => $DealerName, 
                                       'Deal' => $Deal,
        	           	                 'URL' => $URL,
        	           	                 'Year' => $Year,
        	           	                 'Make' => $Make,
        	           	                 'Model' => $Model,
        	           	                 'FinancedAmount' => $FinancedAmount,
        	           	                 'BasePayment' => $BasePayment,
        	           	                 'APR' => $APR,
        	           	                 'Term' => $Term,
        	           	                 'DownPayment' => $DownPayment,
        	           	                 'Buyer' => $Buyer,
        	           	                 'CoBuyer' => $CoBuyer,
                                       'Trim' => $Trim,
                                       'TradeAllowance' => $TradeAllowance,
                                       'TradePayOff' => $TradePayOff,
                                       'BeginningOdometer' => $BeginningOdometer,
                                       'Address1' => $Address1,
                                       'Address2' => $Address2,
                                       'City' => $City,
                                       'State' => $State,
                                       'StateCode' => $StateCode,
                                       'ZipCode' => $ZipCode,
                                       'Country' => $Country,
                                       'CountryCode' => $CountryCode,
                                       'Telephone' => $Telephone,
                                       'Email' => $Email,
        	           	                 'Disclosure' => $Disclosure,
                                       'Vin' => $Vin));
            return $DealerId;
        }
	}
	
	public function delete($id)
	{
		$result = DB::table ( 'Dealer' )->where ( 'DealerId', '=', $id )->delete ();
		
		return $result;
	}
	
	public function displayUsers($id)
	{
		$currentUser = Session::get('UserSessionInfo');
		$dealers = DB::table('Dealer')->get();
		$myAccount = 0;
	    
	  if ($currentUser->DealerId)
	  {
		    $users = DB::select( DB::raw( "SELECT UserId, Username, FirstName FROM UsersTable WHERE Username <> 'admin' " ) );
		} else {
        $users = DB::select( DB::raw( 'SELECT UserId, Username, FirstName FROM UsersTable' ) );
		}
		
		return View::make('account.index')->with('Dealers', $dealers)->with('users', $users)->with('MyAccount', $myAccount)->with('DealerIdHidden',$id)->with('currentUser', $currentUser);
	}

	public function getUserData()
    {
    	$UserId = Input::get('UserId');
    	$Data = array();

    	$UserInfo = DB::table('UsersTable')
    	            ->where('UserId', '=', $UserId)
    	            ->first();

    	if ( $UserInfo ){
    		if ( is_null($UserInfo->DealerId) ) {
    			$DealerId = '';
    		} else {
    			$DealerId = $UserInfo->DealerId;
    		}
            $Data[] = array('UserId' => $UserId,
            	            'FirstName' => $UserInfo->FirstName,
                            'Username' => $UserInfo->Username,
                            'Password' => $UserInfo->Password,
                            'DealerId' => $DealerId,
                            'Administrator' => $UserInfo->Administrator,
                            'LastName' => $UserInfo->LastName,
                            'Email' => $UserInfo->Email);

            return json_encode($Data);
    	}
    }

    /*-----------------------------------------------------------------------------------------------------------*/
	
	public function displayProducts($id)
	{
		$currentUser = Session::get ( 'UserSessionInfo' );
		
		$products = DB::table('Products')
							 ->join('ProductBase', 'Products.ProductBaseId', '=', 'ProductBase.ProductBaseId')
							 ->join('Company', 'ProductBase.CompanyId', '=', 'Company.id')
							 ->leftjoin('PlansProducts', 'Products.id', '=', 'PlansProducts.ProductId')
							 ->where('Products.DealerId', '=', $id)
							 ->get(array('Products.id as ProductId',
							 			 'Products.DealerId', 
							 			 'Company.CompanyName',
							 			 'ProductBase.ProductName', 
							 			 'Products.DisplayName',
							 			 'Products.Cost',
							 		     'Products.SellingPrice',
							 			 DB::raw('CAST(ISNULL(PlansProducts.ProductId, 0) AS BIT) AS Added')));
		
		$bullets = DB::table('ProductDetail')->whereIn('ProductDetail.ProductId', $this->getKeys($products))->get();

		$this->merge($products, $bullets);
		
		return \View::make ( 'product.index' )
                        ->with('dealerId', $id)
                        ->with ( 'products', $products );
	}
	
	public function displayProduct($id, $productId)
	{
		return Redirect::action("ProductController@view", array('id' => $productId));
	}
	
	/**
	 * Returns an array with the ProductId
	 * @param array $products
	 */
	private function getKeys($products)
	{
		$keys = array();
		
		foreach ($products as $product)
		{
			$product->BulletPoints = array();
			
			$keys[] = $product->ProductId;
			
		}
		
		return $keys;
	}
	
	private function merge($products, $bullets)
	{
		foreach($products as $product)
		{
			foreach($bullets as $bullet)
			{
				if($product->ProductId == $bullet->ProductId)
					$product->BulletPoints[] = $bullet;
			}
		}	
	}
    
    public function show_newUserForm()
    {
    	$UserSessionInfo = Session::get('UserSessionInfo');
        $DealerId = Input::get('DealerId');
        $Dealers = DB::table('Dealer')->get();
        $MyAccount = 0;


        /*if ( is_null($UserSessionInfo->DealerId) ) {
            $Users = DB::table('UsersTable')->get();
        } else {*/
        	
        //}
        if (empty($UserSessionInfo->DealerId)) {
            if (empty($DealerId)) {
                $Users = DB::table('UsersTable')
                         ->whereRAW('DealerId IS NULL')
                         ->first();
                $MyAccount = 1;
            } else {
                $Users = DB::table('UsersTable')
                         ->where('DealerId', '=', $DealerId)
                         ->get();
            }            
            
        } else {
            $Users = DB::table('UsersTable')
                         ->where('DealerId', '=', $UserSessionInfo->DealerId)
                         ->get();
        }

        return View::make('addUser')->with('Dealers', $Dealers)->with('Users', $Users)->with('MyAccount', $MyAccount)->with('DealerIdHidden',$DealerId);
    }

    public function insert_userInfo()
    {
    	  $UserSessionInfo = Session::get('UserSessionInfo');
        $FirstName = Input::get('FirstName');
        $Username = Input::get('Username');
        $Password = Input::get('Password');
        $LastName = Input::get('LastName');
        $Email = Input::get('Email');
        $Administrator = null;

        if ( is_null( $UserSessionInfo->DealerId ) ) 
        {
            $DealerId = Input::get('DealerId');
            $Administrator = Input::get('Administrator');
        } 
        else 
        {
            $DealerId = $UserSessionInfo->DealerId;
            $Administrator = False;
        }
        
        $Result = DB::table('UsersTable')
                  ->insertGetId( array( 'FirstName' => $FirstName,
                                   'Username' => $Username,
                                   'Password' => Sha1($Password),
                                   'DealerId' => $DealerId,
                                   'Administrator' => $Administrator,
                                   'LastName' => $LastName,
                                   'Email' => $Email ));
        
        if ( $Result ){
        	return '1';
        } else {
        	return '0';
        }
    }

    public function get_userInfo()
    {
    	$UserId = Input::get('UserId');
      $jsonFormat = Input::get('jsonFormat');
    	$Data = array();

    	$UserInfo = DB::table('UsersTable')
    	            ->where('UserId', '=', $UserId)
    	            ->first();

    	if ( $UserInfo ){
    		if ( is_null($UserInfo->DealerId) ) {
    			$DealerId = '';
    		} else {
    			$DealerId = $UserInfo->DealerId;
    		}
            $Data[] = array('UserId' => $UserId,
            	            'FirstName' => $UserInfo->FirstName,
                            'Username' => $UserInfo->Username,
                            'Password' => $UserInfo->Password,
                            'DealerId' => $DealerId,
                            'Administrator' => $UserInfo->Administrator,
                            'LastName' => $UserInfo->LastName,
                            'Email' => $UserInfo->Email);
      
          if ($jsonFormat == true) 
          {
              return json_encode($Data);
          } else { 
              return View::make('profile')->with('Users', $UserInfo);

    	    }
      }
    }

    public function update_userInfo()
    {
        $UserSessionInfo = Session::get('UserSessionInfo');
        $UserId = Input::get('UserId');
        $FirstName = Input::get('FirstName');
        $Username = Input::get('Username');
        $Password = Input::get('Password');
        $PasswordChange = Input::get('PasswordChange');
        $LastName = Input::get('LastName');
        $Email = Input::get('Email');
        $EditPassword = '';
      
        if ( is_null( $UserSessionInfo->DealerId ) ) 
        {
            $DealerId = Input::get('DealerId');
            $Administrator = Input::get('Administrator');
        } 
        else 
        {
            $DealerId = $UserSessionInfo->DealerId;
            $Administrator = False;
        }

        $PasswordChange == '1' ? $EditPassword = Sha1($Password) : $EditPassword = $Password ;
        
        $Result = DB::table('UsersTable')
                  ->where( 'UserId', '=', $UserId)
                  ->update( array( 'FirstName' => $FirstName,
                                   'LastName' => $LastName,
                                   'Email' => $Email,
                                   'Username' => $Username,
                                   'Password' => $EditPassword,
                                   'DealerId' => $DealerId,
                                   'Administrator' => $Administrator ));
        
        return !empty( $Result ) ? '1' : '0' ;
    }

    public function delete_userInfo()
    {
    	$UserId = Input::get('UserId');
        
        $Result = DB::table('UsersTable')
                  ->where('UserId', '=', $UserId)
                  ->delete();
    }

    public function get_TestDealerCode()
    {
        $code = Input::get('code');

        $Result = DB::table('Dealer')
                  ->where('DealerCode', '=', $code)
                  ->get();

        return $Result->DealerCode;
    }

    function get_settingsCode()
    {
        $UserSessionInfo = Session::get('UserSessionInfo');
        
        if ( $UserSessionInfo->DealerId != '' ) 
        {
            return Redirect::to('settings-page');
        }
        
        $DealerId = Input::get('DealerId');

        $Codes = DB::table('SettingsTable')
        ->leftJoin('Company', 'SettingsTable.CompanyId', '=', 'Company.id')
        ->leftJoin('Dealer', 'SettingsTable.DealerId', '=', 'Dealer.DealerId')
        ->where('SettingsTable.DealerId', '=', $DealerId)
        ->get();

        $Dealers = DB::table('Dealer')->get();
        $Companies = DB::table('Company')->get();

        return View::make('settingsCode')->with('Codes', $Codes)->with('Dealers', $Dealers)->with('Companies', $Companies);
    }

    public function save_settingCode()
    {
        $DealerId = Input::get('DealerId');
        $CompanyId = Input::get('CompanyId');
        $DealerNumber = Input::get('DealerCode');
        $WebServiceUsername = Input::get('WebServiceUsername');
        $WebServicePassword = Input::get('WebServicePassword');

        $checkSetting = DB::select( DB::raw( "SELECT AccountNumber FROM SettingsTable WHERE DealerId = " . $DealerId 
                                             . " AND CompanyId = " . $CompanyId ) );

        if ( $checkSetting )
        {
          return 'duplicate';
          exit();
        }

        $saveSetting = DB::table('SettingsTable')
        ->insertGetId( array('DealerCode' => $DealerNumber,
                             'DealerId' => $DealerId,
                             'CompanyId' => $CompanyId,
                             'WebServiceUsername' => $WebServiceUsername,
                             'WebServicePassword' => $WebServicePassword) );

        if ($saveSetting)
        {
            return '1';
        } else {
            return '0';
        }
    }

    public function load_settingCode()
    {
        $AccountNumber = Input::get('AccountNumber');
        $data = array();

        $infoSettingCode = DB::table('SettingsTable')
        ->where('AccountNumber', '=', $AccountNumber)
        ->first();
        
        $data[] = array('DealerId' => $infoSettingCode->DealerId,
                        'CompanyId' => $infoSettingCode->CompanyId,
                        'DealerCode' => $infoSettingCode->DealerCode,
                        'WebServiceUsername' => $infoSettingCode->WebServiceUsername,
                        'WebServicePassword' => $infoSettingCode->WebServicePassword);


        return json_encode($data);
    }

    public function update_settingCode()
    {
        $AccountNumber = Input::get('AccountNumber');
        $DealerId = Input::get('DealerId');
        $CompanyId = Input::get('CompanyId');
        $DealerCode = Input::get('DealerCode');
        $WebServiceUsername = Input::get('WebServiceUsername');
        $WebServicePassword = Input::get('WebServicePassword');
        
        $updateSetting = DB::table('SettingsTable')
        ->where('AccountNumber', '=', $AccountNumber)
        ->update( array('DealerId' => $DealerId,
                        'CompanyId' => $CompanyId,
                        'DealerCode' => $DealerCode,
                        'WebServiceUsername' => $WebServiceUsername,
                        'WebServicePassword' => $WebServicePassword));

        if ($updateSetting)
        {
            return '1';
        } else {
            return '0';
        }

    }

    public function delete_settingCode()
    {
        $AccountNumber = Input::get('AccountNumber');

        DB::table('SettingsTable')
        ->where('AccountNumber', '=', $AccountNumber)
        ->delete();
    }
    
}
?>
