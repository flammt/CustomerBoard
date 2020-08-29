<?php
namespace App\Http\Controllers;


use App\Http\Service\response\JsonResponse;
use App\Model\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @return void
     */
    public function __construct ()
    {
//        $this->middleware('auth');
    }

    public function getAuthUser () {
//        $response = new JsonResponse(Auth::user());
        $response = new JsonResponse(null);
        $response->status->code = 200;
        $response->result = (object) Auth::user();
        return response()->json($response);
    }

    /**
     * @param string $searchText
     * @return \Illuminate\Http\JsonResponse
     */
    public function search (string $searchText) {
//        $response = new JsonResponse(Auth::user());
        $response = new JsonResponse(null);
        $users = User::withTrashed()->where(function($query) use ($searchText) {
            return $query->orWhere('firstname', 'ilike', '%'.$searchText.'%')
                ->orWhere('lastname', 'ilike', '%'.$searchText.'%')
                ->orWhere('email', 'ilike', '%'.$searchText.'%')
                ->orWhere('name_token', 'ilike', '%'.$searchText.'%')
                ;
        })->take(8)->get();
        $response->status->code = 200;
        $response->result = $users->map(function($user) {
            return ['id' => $user->id, 'firstname' => $user->firstname, 'lastname' => $user->lastname];
        });
        return response()->json($response);
    }

    /**
     * Search by searchstring
     * @param string $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchName (string $name) {
//        $response = new JsonResponse(Auth::user());
        $response = new JsonResponse(null);
        try {
            $users = User::where('lastname', 'ilike', '%' . $name . '%')
                ->orWhere('firstname', 'ilike', '%'.$name.'%')
                ->take(9)->get();
            $response->status->code = 200;
            $response->result = $users;
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = "Error finding '".$name."': ".$e->getMessage();
        }
        return response()->json($response);
    }

     /**
      * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
//        $response = new JsonResponse(Auth::user());
        $response = new JsonResponse(null);
        $users = User::withTrashed()->all();
        $response->status->code = 200;
        $response->result = $users;
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage
     * or update when id is sent
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
//        $response = new JsonResponse(Auth::user());
        $response = new JsonResponse(null);
        Log::debug('Store user');
        // TODO check permissions
        $validator = Validator::make(
                $request->all(),
                [
                'salutation' => 'required',
                'email' => 'required|unique:users,email|email',
                'firstname' => 'required',
                'lastname' => 'required',
                'name_token' => 'required',
                'active' => 'required|boolean',
                'password' => 'required'
                ]);
        if ($validator->fails()) {
            Log::debug('Validation failure', $validator->errors()->all());
            $response->status->code = 400;
            $response->status->message = $validator->errors()->all();
            return response()->json($response);
        }
        $user = new User();
        $user->salutation = $request->input('salutation');
        $user->email = $request->input('email');
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->name_token = $request->input('name_token');
        $user->password = Hash::make($request->input('password'));
        try {
            $user->save();
            $active = $request->input('active');
            if (!$active) {
                $user->delete();
            }
            $response->status->code = 200;
            $response->result = $user->id;
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = "User save unsuccessful: ".$e->getMessage();
        }
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
//        $response = new JsonResponse(Auth::user());
        $response = new JsonResponse(null);
        $user = User::withTrashed()->find($id);
        if (empty($user)) {
            $response->status->code = 400;
            $response->status->message = 'User not found with id: '.$id;
            return response()->json($response);
        }
        if ($user->trashed()) {
            $user->active = false;
        } else {
            $user->active = true;
        }
        $response->status->code = 200;
        $response->result = $user;
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function update(Request $request, $id)
    {
//        $response = new JsonResponse(Auth::user());
        $response = new JsonResponse(null);
        Log::debug('Update user');
        // TODO check permissions
        $validator = Validator::make(
                $request->all(),
                [
                'id' => 'required|integer|min:0'
                ]);
        if ($validator->fails()) {
            Log::debug('Validation failure', $validator->errors()->all());
            $response->status->code = 400;
            $response->status->message = $validator->errors()->all();
            return response()->json($response);
        }
        $user = User::withTrashed()->find($request->input('id'));
        if ($request->has('salutation')) {
            $user->salutation = $request->input('salutation');
        }
        if ($request->has('email')) {
            $user->email = $request->input('email');
        }
        if ($request->has('firstname')) {
            $user->firstname = $request->input('firstname');
        }
        if ($request->has('lastname')) {
            $user->lastname = $request->input('lastname');
        }
        if ($request->has('name_token')) {
            $user->name_token = $request->input('name_token');
        }
        if ($request->has('active')) {
            if ($request->input('active')) {
                if ($user->trashed()) {
                    $user->restore();
                }
            } else {
                $user->delete();
            }
        }
        $password = $request->input('password');
        if ($password) {
            $user->password = Hash::make($request->input('password'));
        }
        try {
            $user->save();
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = "User update unsuccessful: ".$e->getMessage();
            return response()->json($response);
        }
        $response->status->code = 200;
        return response()->json($response);
    }

    /**
     * Change password
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function chpwd (Request $request) {
//        $response = new JsonResponse(Auth::user());
        $response = new JsonResponse(null);
        $validator = Validator::make(
            $request->all(),
            [
                'oldPwd' => 'required',
                'newPwd' => 'required',
            ]);
        if ($validator->fails()) {
            Log::debug('Validation failure', $validator->errors()->all());
            $response->status->code = 400;
            $response->status->message = $validator->errors()->all();
            return response()->json($response);
        }
        // without trashed: if she can't log in she can't change password
        $user = User::find(Auth::user()->id);
        if (!Hash::check($request->input('oldPwd'), $user->password)) {
            $response->status->code = 400;
            $response->status->message = "Wrong Password";
            return response()->json($response);
        }
        $user->password = Hash::make($request->input('newPwd'));
        try {
            $user->save();
            $response->status->code = 200;
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = "Change Password unsuccessful: ".$e->getMessage();
        }
        return response()->json($response);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        //
    }

    public function test() {
        return view('test.user');
    }
}
