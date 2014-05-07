<?php
use Illuminate\View\View;

class AccountController extends BaseController 
{
    public function show($id)
    {
    	$currentUser = Session::get('UserSessionInfo');
        
        if ( is_null( $currentUser ) ) 
        {
            return Redirect::to('login');
        }
        
		$dealers = DB::table('Dealer')->get();
		$myAccount = 0;
	    
	    if ($currentUser->DealerId)
	    {
		    $users = DB::select( DB::raw( "SELECT UserId, Username, FirstName FROM UsersTable WHERE Username <> 'admin' " ) );
	    } else {
            $users = DB::select( DB::raw( 'SELECT UserId, Username, FirstName FROM UsersTable ' ) );
	    }
		
		return \View::make('account.index')->with('Dealers', $dealers)->with('users', $users)->with('MyAccount', $myAccount)->with('DealerIdHidden',$id)->with('currentUser', $currentUser)->with('title', 'Users');
    }

	public function retrieve()
	{
		$id = Input::get('id');
		$data = array();
		$userInfo = DB::table('UsersTable')
						->where('UserId', '=', $id)
						->first();
		
		if ( $userInfo )
		{
			$data[] = array('UserId' => $id,
							'FirstName' => $userInfo->FirstName,
							'Username' => $userInfo->Username,
							'Password' => $userInfo->Password,
							'DealerId' => is_null($userInfo->DealerId) ? '' : $userInfo->DealerId,
							'Administrator' => $userInfo->Administrator,
							'LastName' => $userInfo->LastName,
							'Email' => $userInfo->Email);
		}
		return json_encode($data);
	}
	
	public function create()
	{
		$UserSessionInfo = Session::get('UserSessionInfo');
		$FirstName = Input::get('FirstName');
		$Username = Input::get('Username');
		$Password = Input::get('Password');
		$LastName = Input::get('LastName');
		$Email = Input::get('Email');
	
		if ( is_null($UserSessionInfo->DealerId) ) {
			$DealerId = Input::get('DealerId');
			$Administrator = Input::get('Administrator');
		} else {
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
			return 'true';
		} else {
			return 'false';
		}
	}
	
	public function update()
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
	
		if ( is_null($UserSessionInfo->DealerId) ) {
			$DealerId = Input::get('DealerId');
			$Administrator = Input::get('Administrator');
		} else {
			$DealerId = $UserSessionInfo->DealerId;
			$Administrator = False;
		}
	
		if ( $PasswordChange == '1' ){
			$EditPassword = Sha1($Password);
		} else {
			$EditPassword = $Password;
		}
	
		$Result = DB::table('UsersTable')
		->where('UserId', '=', $UserId)
		->update( array( 'FirstName' => $FirstName,
				'LastName' => $LastName,
				'Email' => $Email,
				'Username' => $Username,
				'Password' => $EditPassword,
				'DealerId' => $DealerId,
				'Administrator' => $Administrator ));
	
		if ( $Result ){
			return 'true';
		} else {
			return 'false';
		}
	}
	
	public function delete()
	{
		$userId = Input::get('UserId');
	
		$Result = DB::table('UsersTable')
		->where('UserId', '=', $userId)
		->delete();

		if ( $Result ){
			return 'true';
		} else {
			return 'false';
		}
	}
}