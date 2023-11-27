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
     * Valido permisos 
     */
    public function __construct()
    {
        $this->middleware( 'permission:api.users.index' )->only([ 'index' ]);
        $this->middleware( 'permission:api.users.store')->only([ 'store' ]);
        $this->middleware( 'permission:api.users.show' )->only([ 'show' ]);
        $this->middleware( 'permission:api.users.update' )->only([ 'update' ]);
        $this->middleware( 'permission:api.users.destroy' )->only([ 'destroy' ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            return UsersResource::collection( User::latest()->paginate(4) );
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
                ])->assignRole( 'General User' );

                return response()->json([
                    'status'        => 'ok',
                    'data'          => new UsersResource( $user )
                ], Response::HTTP_OK);
            endif;

            return response()->json([
                'status'        => 'failed',
                'message'       => 'Failed to set the user because there are now exists.'
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
    public function show( $slug )
    {
        try{        
            
            /**
             * Valido el rol del usuario que realiza la peticion
             */
            if( request()->user()->hasRole('Super Admin') ) :
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
            else : 
                /**
                 * Valido que el slug del usuario existe, de lo contrario notifico a la peticion
                 */
                $user = User::where('slug', $slug)
                            ->where('id', request()->user()->id )
                            ->first();
                if(  is_object( $user ) && !is_null( $user ) ) :
                    return response()->json([
                        'status'        => 'ok',
                        'data'          => new UsersResource( $user )
                    ], Response::HTTP_OK);
                else :
                    return response()->json([
                        'status'            => 'failed',
                        'message'           => "You can not see information from other users."
                    ], Response::HTTP_CONFLICT);
                endif;
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
    public function update( Request $request, $slug )
    {
        try{   
            /**
             * Valido que el slug del usuario existe, de lo contrario notifico a la peticion
             */       
            $user = User::where('slug', $slug)->first();     
            if(  is_object( $user ) && !is_null( $user ) ) :
                if( $request->has('is_active') ) :
                    $user->is_active = ( strcmp( $request->is_active, '1') == 0 ) ? '1' : '0';
                endif;
                if( $request->has('password') ) :
                    $user->password = Hash::make( $request->password );
                endif;
                $user->save();
                return response()->json([
                    'status'        => 'ok',
                    'message'       => 'User updated with success.',
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
                'message'       => 'Failed to delete user data.'
            ], Response::HTTP_CONFLICT);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $slug )
    {
        try{           
            /**
             * Valido que el slug del usuario existe, de lo contrario notifico a la peticion
             */       
            $user = User::where('slug', $slug)->first();     
            if(  is_object( $user ) && !is_null( $user ) ) :

                $user->is_deleted = '1';
                $user->save();
                
                return response()->json([
                    'status'        => 'ok',
                    'message'       => 'User deleted with success'
                ], Response::HTTP_OK);
            endif;
            return response()->json([
                'status'            => 'failed',
                'message'           => "The requested user doesn't exist."
            ], Response::HTTP_CONFLICT);
        }catch( Exception $e ){
            return response()->json([
                'status'        => 'failed',
                'message'       => 'Failed to delete user data.'
            ], Response::HTTP_CONFLICT);
        }
    }
}
