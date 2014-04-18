<?php
session_start();
class LoginController extends BaseController {
    public function get_LoginPage()
    {
        $URLSession = Session::get('URLSession');
        if (!empty($URLSession)) {
            $LastURL = $URLSession->uri;
        } else {
            $LastURL = '';
        }
        return View::make('login')->with('LastURL', $LastURL);
    }
    
    public function post_authenticate()
    {
        $username = Input::get('Username');
        $password = Input::get('Password');
        $Rememberme = Input::get('Remeberme');

        $URLSession = Session::get('URLSession');
        
        $LastURL = !empty($URLSession) ? $URLSession->uri : $LastURL = ''; 

        $data = array();
        
        // Read user from menu app database
        $user = $this->getUser($username, $password);
        
        if($user)
        {
	        Session::put('UserSessionInfo', $user);
	         
	        if ($Rememberme == 1) {
	        	//Set Cookies for login. Duration = 7 days
	        	$week = time() + (86400 * 7);
	        	setcookie('User', Crypt::encrypt($username), $week);
	        	setcookie('Pass', Crypt::encrypt($username), $week);
	        }
	        else
	        if ($Rememberme == 0) {
	        	//Destroy cookie
	        	$time = time() - 3600;
	        	setcookie('User', '', $time);
	        	setcookie('Pass', '', $time);
	        }
	         
	        $data[] = array( 'FirstName' => $user->FirstName,
	        				 'LastURL' => $LastURL);
	        
	        return json_encode($data);
        }
        else
        	return '0';
    }   
 
    private function getUser($username, $password)
    {
    	// Read user from menu app database
    	$user = $this->getLocalUser($username, $password);
    	
    	// If user was not found try reading from DMS Data
    	if(!$user)
    		$user = $this->getDMSUser($username, $password);
    	
    	 return $user;
    }
    
    /**
     * Get users from menu app database
     */
    private function getLocalUser($username, $password)
    {
    	$user = DB::table('UsersTable')
		    	->leftJoin('Dealer', 'UsersTable.DealerId', '=', 'Dealer.DealerId')
		    	->where('Username', '=', $username)
		    	->where('Password', '=', Sha1($password) )
		    	->first(array("UserId", "Administrator", "Username", "FirstName", "LastName", "UsersTable.DealerId", "DealerLogo", "DealerName" ));
    	
    	if($user != null)
    		$user->Name = $user->FirstName.' '.$user->LastName;
    	
    	return $user;
    }
    
    private function getDMSUser($username, $password)
    {
    	// TODO: Verify the array don't contains any empty or null value
    	$companies = DB::table('Dealer')->where('CompanyCode', '!=', 0)->lists('CompanyCode');
    	 
    	$user = null;
    	
    	if(count($companies) > 0)
    	{
    		// TODO: Specify the fields that are needed
    		$record = DB::connection('sqlsrv2')
			    		->table('UsersTable')
			    		->whereIn('CompanyCode', $companies)
			    		->where('UserName', '=', $username)
			    		->where('Password', '=', $password)
			    		->first();
    		
    		if($record != null)
    		{
	    		$dealer = DB::table('Dealer')
					    		->where('CompanyCode', '=', $record->CompanyCode)
					    		->first();
	    		
	    		// TODO: Read the first and last name
	    		$user = new stdClass();
	    		$user->UserId = 0;
	    		$user->Username = $record->UserName;
	    		$user->FirstName = $record->FirstName;
	    		$user->LastName = $record->LastName;
	    		$user->Name = $record->FirstName.' '.$record->LastName;
				$user->Administrator = $record->IsSupervisor == True ? 1 : 0;
	    		$user->DealerId = $dealer->DealerId;
	    		$user->DealerName = $dealer->DealerName;
	    		$user->DealerLogo = $dealer->DealerLogo;
    		}
    	}    	
    	
    	return $user;
    }
    
    public function post_closeSession(){
        Session::forget('UserSessionInfo');
	    Session::forget('WebServiceInfo');
        Session::forget('WebServiceInfoFinance');
        return Redirect::to('login');
    }
}


