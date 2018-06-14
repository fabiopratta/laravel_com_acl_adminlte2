<?php
/**
 * @file           RegisterController.php
 * @author         Fabio Pratta <fabiobrotas@hotmail.com>
 * @copyright      Copyright - sagp | 14/06/2018
 * @since 14/06/2018
 */

namespace App\Http\Controllers\API;


use App\Entities\User;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class RegisterController extends Controller {

	/**
	 * get token for access in API
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function getToken(Request $request) {
		$this->validate( $request, [
			'email'    => 'required|email',
			'password' => 'required'
		] );

		$http = new Client;
		$response = $http->post('http://sagp.local/oauth/token', [
			'form_params' => [
				'grant_type' => 'password',
				'client_id' => '2',
				'client_secret' => 'mCctQFMZZqTtvMnFIytueksFYgrCBP3af16CupNz',
				'username' => $request->input('email'),
				'password' => $request->input('password')
			],
		]);
		return json_decode((string) $response->getBody(), true);
	}

}