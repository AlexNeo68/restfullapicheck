<?php

namespace App\Http\Controllers\User;

use App\User;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCreated;
use App\Transformers\UserTransformer;

class UserController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['store', 'verify','resend']);

        $this->middleware('client.credentials')->only(['store', 'resend']);

        $this->middleware('transform.input:' . UserTransformer::class)->only(['store', 'update']);

        $this->middleware('scope:manage-account')->only(['show', 'update']);

        $this->middleware('can:view,user')->only(['show']);
        $this->middleware('can:update,user')->only(['delete']);
        $this->middleware('can:delete,user')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->isAllowedAdmin();

        $users = User::all();
        return $this->showAll($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ];

        $this->validate($request, $rules);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = User::REGULAR_USER;

        $user = User::create($data);

        return $this->showOne($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'email' => 'email|unique:users,email,'.$user->id,
            'password' => 'min:6|confirmed',
            'admin' => 'in:' . User::REGULAR_USER . ','. User::ADMIN_USER
        ];

        $this->validate($request, $rules);

        if($request->has('name')){
            $user->name = $request->name;
        }

        if($request->has('email') && $user->email !== $request->email){
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerificationCode();
            $user->email = $request->email;
        }

        if($request->has('password')){
            $user->password = bcrypt($request->password);
        }

        if($request->has('admin')){

            $this->isAllowedAdmin();

            if(!$user->isVerified()){
                return $this->errorResponse('Only verified user may change admin field', 409);
            }
            $user->admin = $request->admin;
        }

        if(!$user->isDirty()){
            return $this->errorResponse('Your need to specify values to update', 422);
        }

        $user->save();
        return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->showOne($user);
    }

    public function verify($token)
    {
        $user = User::where('verification_token', $token)->firstOrFail();
        $user->verified = User::VERIFIED_USER;
        $user->verification_token = null;
        $user->save();
        return $this->showMessage('User verified success!');
    }

    public function resend(User $user)
    {
        if($user->isVerified()){
            return $this->errorResponse('User already verified!', 409);
        }
        retry(5, function() use ($user){
            Mail::to($user->email)->send(new UserCreated($user));
        }, 100);
        return $this->showMessage('User resend verify send success!');
    }
}
