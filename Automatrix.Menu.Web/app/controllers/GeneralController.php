<?php
class GeneralController extends BaseController {
    
    public function show_generalPage()
    {
        /*
        Clear all sessions variables to prevent filter inapropiated Dealer Information
        */
        $UserSessionInfo = Session::get ( 'UserSessionInfo' );
        try
        {
            
            if (empty ( $UserSessionInfo->Username ))
            {
                return Redirect::to ( 'home' );
            }
        }
        catch ( Exception $e )
        {
            return Redirect::to ( 'home' );
        } 

        $DealerId = Input::get('DealerId');

        if (empty($DealerId)) {
            $DealerId = $UserSessionInfo->DealerId;
        }

            $settings = DB::table('Dealer')
                             ->where('DealerId', '=', $DealerId)
                             ->first();

            return View::make('general')->with('settings', $settings);

        
    }

    public function insert_settingInfo(){
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
        $FirstName = Input::get('FirstName');
        $MiddleName = Input::get('MiddleName');
        $LastName = Input::get('LastName');
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
        $LienHolderName = Input::get('LienHolderName');
        $LienHolderAddress = Input::get('LienHolderAddress');
        $LienHolderCountry = Input::get('LienHolderCountry');
        $LienHolderCity = Input::get('LienHolderCity');
        $LienHolderState = Input::get('LienHolderState');
        $LienHolderZip = Input::get('LienHolderZip');
        $LienHolderEmail = Input::get('LienHolderEmail');
        $LienHolderPhone = Input::get('LienHolderPhone');
        $LienHolderFax = Input::get('LienHolderFax');
        $LienHolderType = Input::get('LienHolderType');
        $LienHolderContact = Input::get('LienHolderContact');
        $TaxRate = Input::get('TaxRate');
        $VehiclePurchasePrice = Input::get('VehiclePurchasePrice');
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
                                       'FirstNameParameter' => $FirstName,
                                       'MiddleNameParameter' => $MiddleName,
                                       'LastNameParameter' => $LastName,
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
                                       'LienHolderName' => $LienHolderName,
                                       'LienHolderAddress' => $LienHolderAddress,
                                       'LienHolderCountry' => $LienHolderCountry,
                                       'LienHolderCity' => $LienHolderCity,
                                       'LienHolderState' => $LienHolderState,
                                       'LienHolderZip' => $LienHolderZip,
                                       'LienHolderEmail' => $LienHolderEmail,
                                       'LienHolderPhone' => $LienHolderPhone,
                                       'LienHolderFax' => $LienHolderFax,
                                       'LienHolderType' => $LienHolderType,
                                       'LienHolderContact' => $LienHolderContact,
                                       'TaxRate' => $TaxRate,
                                       'VehiclePurchasePrice' => $VehiclePurchasePrice,
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
                                       'FirstNameParameter' => $FirstName,
                                       'MiddleNameParameter' => $MiddleName,
                                       'LastNameParameter' => $LastName,
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
                                       'LienHolderName' => $LienHolderName,
                                       'LienHolderAddress' => $LienHolderAddress,
                                       'LienHolderCountry' => $LienHolderCountry,
                                       'LienHolderCity' => $LienHolderCity,
                                       'LienHolderState' => $LienHolderState,
                                       'LienHolderZip' => $LienHolderZip,
                                       'LienHolderEmail' => $LienHolderEmail,
                                       'LienHolderPhone' => $LienHolderPhone,
                                       'LienHolderFax' => $LienHolderFax,
                                       'LienHolderType' => $LienHolderType,
                                       'LienHolderContact' => $LienHolderContact,
                                       'TaxRate' => $TaxRate,
                                       'VehiclePurchasePrice' => $VehiclePurchasePrice,
        	           	                 'Disclosure' => $Disclosure,
                                       'Vin' => $Vin));
            return $DealerId;
        }

    }

    public function get_WebService()
    {
        $DealerId = Input::get('DealerId');
        $param = 100;

         $settings = DB::table('Dealer')
                         ->where('DealerId', '=', $DealerId)
                         ->first();

        $response = file_get_contents($settings->URL . $param); 
       
        $response = str_replace('"', '', $response);
        $response = str_replace('{', '', $response);
        $response = explode(',', $response);

        foreach ($response as $lineNum => $line)
        {
            list($key, $value) = explode(":", $line);
            $newArray[$key] = $value;
        }

        $deal = new Deal();

        $deal->Deal = $newArray[$settings->Deal];
        $deal->Year = $newArray[$settings->Year];
        $deal->Make = $newArray[$settings->Make];
        $deal->Model = $newArray[$settings->Model];
        $deal->Trim = $newArray[$settings->Trim];
        $deal->FinancedAmount = $newArray[$settings->FinancedAmount];
        $deal->APR = $newArray[$settings->APR];
        $deal->Term = $newArray[$settings->Term];
        $deal->DownPayment = $newArray[$settings->DownPayment];
        $deal->Buyer = $newArray[$settings->Buyer];
        $deal->CoBuyer = $newArray[$settings->CoBuyer];
        
        Session::put('WebServiceInfo', $deal);
    }

    public function update_DisplayedFields()
    {
    	$DealerId = Input::get('DealerId');
    	$Option = Input::get('CheckOption');
    	$Value = Input::get('CheckValue');

    	$updateFields = DB::table('Dealer')
    	                ->where('DealerId', '=', $DealerId)
    	                ->update(array($Option => $Value));
    }
    
    public function show_companyPage()
    {
        $UserSessionInfo = Session::get('UserSessionInfo');
        
        if ( $UserSessionInfo->DealerId != '' ) 
        {
            return Redirect::to('settings-page');
        }

        $Companies = DB::select( DB::raw("SELECT id, CompanyName, URL, Username, Password FROM Company"));

        return View::make('company')->with('Companies', $Companies);
    }

    public function removeCompanyInfo()
    {
        $CompanyId = Input::get('CompanyId');

        DB::table('Company')
             ->where('id', '=', $CompanyId)
             ->delete();
    }

    public function updateCompanyInfo()
    {
        $CompanyId = Input::get('CompanyId');
        $CompanyName = Input::get('CompanyName');
        $URL = Input::get('URL');
        $Username = Input::get('Username');
        $Password = Input::get('Password');

        DB::table('Company')
             ->where('id', '=', $CompanyId)
             ->update(array('CompanyName' => $CompanyName,
                            'URL' => $URL,
                            'Username' => $Username,
                            'Password' => $Password));
                      
    }

    public function get_CompanyInfo() 
    {
        $CompanyId = Input::get('CompanyId');
        $data = array();

        $CompanyInfo = DB::table('Company')
                       ->where('id', '=', $CompanyId)
                       ->first();
        
        $data[] = array('CompanyName' => $CompanyInfo->CompanyName,
                        'URL' => $CompanyInfo->URL,
                        'Username' => $CompanyInfo->Username,
                        'Password' => $CompanyInfo->Password);

        return json_encode($data);
    }

    public function get_companyProducts()
    {
        $UserSessionInfo = Session::get('UserSessionInfo');
        
        if ( $UserSessionInfo->DealerId != '' ) 
        {
            return Redirect::to('settings-page');
        }
        
        $Companies = DB::table('Company')->get();

        return View::make('companyProducts')->with('Companies', $Companies);
    }

    public function show_companyProducts()
    {
        $CompanyId = Input::get('CompanyId');

        $Products = DB::table('ProductBase')
                        ->where('CompanyId', '=', $CompanyId)
                        ->get();

        $table = '<table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Product</th>
                      <th>Webservice Method</th>
                      <th>Parameters</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>';
        foreach($Products as $Product => $ProductInfo){
            $table .= '<tr>';
            $table .= '<td></td>';
            $table .= '<td>' . $ProductInfo->ProductName . '</td>';
            $table .= '<td>' . $ProductInfo->WSMethod . '</td>';
            $table .= '<td>' . $ProductInfo->Parameters . '</td>';
            $table .= '<td style="width:10%"><a href="#productUpdateModal" data-dismiss="modal" data-toggle="modal" class="btn btn-warning" name="' . $ProductInfo->ProductBaseId . '"><i class="fa fa-pencil-square-o"></i> Modify</a></td>';
            $table .= '<td style="width:10%"><a href="#" class="btn btn-danger" id="deleteProductCompany" onClick="deleteProductCompany(' . $ProductInfo->ProductBaseId . '); return false;"><i class="fa fa-trash-o"></i> Delete</a></td>';
            $table .= '</tr>';
        }
        $table .= '</table>';

        return $table;
    }

    public function load_companyProduct()
    {
        $ProductBaseId = Input::get('ProductBaseId');
        $Data = array(); 

        $ProductInfo = DB::table('ProductBase')
                           ->where('ProductBaseId', '=', $ProductBaseId)
                           ->first();
         
        $Data[] = array('ProductName' => $ProductInfo->ProductName,
                         'WSMethod' => $ProductInfo->WSMethod,
                         'Parameters' => $ProductInfo->Parameters,
                         'CompanyId' => $ProductInfo->CompanyId);

        return json_encode($Data);
    }

    public function insert_companyProduct()
    {
        $CompanyId = Input::get('CompanyId');
        $ProductName = Input::get('ProductName');
        $WSMethod = Input::get('WSMethod');
        $Parameters = Input::get('Parameters');


        $ProductInfo = DB::table('ProductBase')
                           ->insert(array('ProductName' => $ProductName,
                                           'CompanyId' => $CompanyId,
                                           'WSMethod' => $WSMethod,
                                           'Parameters' => $Parameters));

    }

    public function update_companyProduct()
    {
        $ProductBaseId = Input::get('ProductBaseId');
        $CompanyId = Input::get('CompanyId');

        $ProductName = Input::get('ProductName');
        $WSMethod = Input::get('WSMethod');
        $Parameters = Input::get('Parameters');


        $ProductInfo = DB::table('ProductBase')
                           ->where('ProductBaseId', '=', $ProductBaseId)
                           ->update(array('ProductName' => $ProductName,
                                           'CompanyId' => $CompanyId,
                                           'WSMethod' => $WSMethod,
                                           'Parameters' => $Parameters));

    }

    public function delete_companyProduct()
    {
        $ProductBaseId = Input::get('ProductBaseId');

        DB::table('ProductBase')
                 ->where('ProductBaseId', '=', $ProductBaseId)
                 ->delete();
    }

    public function show_dealerPage()
    {
        $UserSessionInfo = Session::get('UserSessionInfo');

        if ( $UserSessionInfo->DealerId != '' ) 
        {
            return Redirect::to('settings-page');
        }

        $Dealers = DB::table('Dealer')->get();
          
        return View::make('dealers')->with('Dealers', $Dealers);
    }

    public function delete_deal()
    {
        $DealerId = Input::get('DealerId');

        $checkIntegrity = DB::table('UsersTable')
        ->where('DealerId', '=', $DealerId)
        ->get();

        if ( count( $checkIntegrity ) > 0 ) {
            return '0';
        } else {
            $Result = DB::table('Dealer')
                 ->where('DealerId', '=', $DealerId)
                 ->delete();

            return $Result;  
        }
    }

    public function send_mailResetPassword()
    {
        $Email = Input::get('Email');
        $data = array();
        $response=new \stdClass();
        $response->Found=false;
        $response->Message="Invalid Mail";

        $User = DB::table('UsersTable')
                    ->where('Email', '=', $Email)
                    ->first();

        if ($User) 
        {
            $data = array('UserId' => $User->UserId,
                          'FirstName' => $User->FirstName,
                          'LastName' => $User->LastName);
            try {
              $sendMail = Mail::send('mailbody', $data, function($message) 
              {
                  $message->from('admin@automatrixdms.com', 'Automatrixdms');
                  $message->to( Input::get('Email'), 'Financing Plans' )->subject('Financing Plans: Recover Password');
              });
              $response->Message=$Email;
              $response->Found=true;
            } catch(Exception $e) {
            }

        }

        return json_encode((array)$response);
    }

    public function load_resetPassword()
    {
        $UserId = Input::get('UserId');

        return View::make('passwordReset');
    }

    public function save_newPassword()
    {
        $UserId = Input::get('UserId');
        $newPassword = Input::get('newPassword');

        $updatePassword = DB::table('UsersTable')
                          ->where('UserId', '=', $UserId)
                          ->update(array('Password' => Sha1($newPassword)));

        if ($updatePassword) {
            return '1';
        } else {
            return '0';
        }
    }

}
?>
