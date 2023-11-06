<?php

namespace App\Http\Controllers\API\v1;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\api\v1\UsersResource;
use App\Http\Requests\api\v1\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            return UsersResource::collection( User::latest()->paginate(1) );
        }catch(Exception $e){
            return response()->json([
                'status'        => 'failed',
                'message'       => 'Failed to get user data.'
            ], Response::HTTP_CONFLICT);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try{
            /**
             * Validamos que el usuario no se encuentre registrado
             */
            $slug = Str::of( $request->firstname .' ' . $request->lastname )->slug('-');
            $user = User::where('slug', $slug)->first();
            if( is_null( $user ) && !is_object( $user ) ) :

                $user = User::create([
                    'firstname'     => $request->firstname,
                    'lastname'      => $request->lastname,
                    'slug'          => $slug,
                    'password'      => Hash::make( $request->password ),
                    'email'         => $request->email
                ]);

                return response()->json([
                    'status'        => 'ok',
                    'data'          => new UsersResource( $user )
                ], Response::HTTP_OK);
            endif;

            return response()->json([
                'status'        => 'failed',
                'message'       => 'Failed to set user.'
            ], Response::HTTP_CONFLICT);
            
        }catch( Exception $e ){
            return response()->json([
                'status'        => 'failed',
                'message'       => 'Failed to set user.'
            ], Response::HTTP_CONFLICT);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        try{            
            /**
             * Valido que el slug del usuario existe, de lo contrario notifico a la peticion
             */
            $user = User::where('slug', $slug)->first();
            if(  is_object( $user ) && !is_null( $user ) ) :
                return response()->json([
                    'status'        => 'ok',
                    'data'          => new UsersResource( $user )
                ], Response::HTTP_OK);
            endif;
            return response()->json([
                'status'            => 'failed',
                'message'           => "The requested user doesn't exist."
            ], Response::HTTP_CONFLICT);
        }catch( Exception $e ){
            return response()->json([
                'status'        => 'failed',
                'message'       => 'Failed to get user data.'
            ], Response::HTTP_CONFLICT);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
