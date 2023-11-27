<?php

namespace App\Http\Controllers\API\v1;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\api\v1\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Exception;

class LoginController extends Controller
{
    /**
     * Metodo para validar credenciales de usuario e iniciar session
     */
    public function store( LoginRequest $request )
    {

        try{
            /**
             * Valido que existe el usuario con las credenciales
             */
            if( Auth::attempt( $request->only(['email', 'password']) ) ) :
                return response()->json([
                    'status'        => 'ok',
                    'message'       => 'Welcome ' . $request->user()->fullName,
                    'token'         => $request->user()->createToken('auth_token')->plainTextToken,
                    'token_type'    => 'Bearer'
                ], Response::HTTP_OK);
            else :
                return response()->json([
                    'status'        => 'failed',
                    'message'       => 'Credentials are invalid.'
                ], Response::HTTP_UNAUTHORIZED);
            endif;
        }catch(Exception $e){
            return response()->json([
                'status'        => 'failed',
                'message'       => 'Failed to set user data.'
            ], Response::HTTP_CONFLICT);
        }        
    }
}
