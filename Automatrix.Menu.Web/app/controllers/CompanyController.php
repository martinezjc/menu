<?php
use Illuminate\View\View;

class CompanyController extends BaseController
{
	public function index()
	{
		$currentUser = Session::get ( 'UserSessionInfo' );
        
        if ( is_null( $currentUser ) ) 
        {
            return Redirect::to('login');
        }

		$companies = DB::select ( DB::raw ( "SELECT id, CompanyName, URL, Username, Password FROM Company" ) );
	
		return \View::make ( 'company.index' )->with ( 'companies', $companies )->with('title', 'Companies')->with('currentUser', $currentUser);
	}
	
	public function create()
	{
		$CompanyName = Input::get ( 'CompanyName' );
		$URL = Input::get ( 'URL' );
		$Username = Input::get ( 'Username' );
		$Password = Input::get ( 'Password' );
	
		$Company = DB::table ( 'Company' )->insert ( array (
				'CompanyName' => $CompanyName,
				'URL' => $URL,
				'Username' => $Username,
				'Password' => $Password
		) );
	
		return "Company " . $CompanyName . " has been added";
	}
	
	public function retrieve()
	{
		$id = Input::get ( 'id' );
		$data = array ();
	
		$companyInfo = DB::table ( 'Company' )->where ( 'id', '=', $id)->first ();
	
		$data [] = array (
				'CompanyName' => $companyInfo->CompanyName,
				'URL' => $companyInfo->URL
		);
	
		return json_encode ( $data );
	}
	
	public function update()
	{
		$CompanyId = Input::get ( 'CompanyId' );
		$CompanyName = Input::get ( 'CompanyName' );
		$URL = Input::get ( 'URL' );
		$Username = Input::get ( 'Username' );
		$Password = Input::get ( 'Password' );
	
		DB::table ( 'Company' )->where ( 'id', '=', $CompanyId )->update ( array (
		'CompanyName' => $CompanyName,
		'URL' => $URL,
		'Username' => $Username,
		'Password' => $Password
		) );
	}
	
	public function delete()
	{
		$id = Input::get ( 'id' );
	
		DB::table ( 'Company' )->where ( 'id', '=', $id )->delete ();
	}
}