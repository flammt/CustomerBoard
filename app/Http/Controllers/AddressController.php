<?php


namespace App\Http\Controllers;


use App\Http\Service\response\JsonResponse;
use App\Model\Account;
use App\Model\Address;
use App\Model\AddressType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{

    /**
     * @return void
     */
    public function __construct ()
    {
//        $this->middleware('auth');
    }

    /**
     * Change an Address by its single set field
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update (Request $request) {
//        $response = new JsonResponse(Auth::user());
        $response = new JsonResponse(null);
        $validator = Validator::make (
            $request->all(), [
                'id' => 'required',
        ]);
        if ($validator->fails()) {
            $response->status->code = 400;
            $response->status->message = $validator->errors()->all();
            return response()->json($response);
        }
        $address = Address::find($request->input('id'));
        if (empty($address)) {
            $response->status->code = 400;
            $response->status->message = 'Unknown address with id: '.$request->input('id');
            return response()->json($response);
        }
        if($request->input('type')) {
            $type = AddressType::find($request->input('type.id'));
            if (empty($type)) {
                $response->status->code = 400;
                $response->status->message = 'Unknown address type: '.$request->input('type.id');
                return response()->json($response);
            }
        }
        $address->name1 = $request->input('name1') ?? $address->name1;
        $address->name2 = $request->input('name2') ?? $address->name2;
        $address->name3 = $request->input('name3') ?? $address->name3;
        $address->street = $request->input('street') ?? $address->street;
        $address->zip = $request->input('zip') ?? $address->zip;
        $address->town = $request->input('town') ?? $address->town;
        $address->country_code = $request->input('countryCode') ?? $address->country_code;
        $address->type_id = $request->input('type.id') ?? $address->type_id;
        try {
            $address->save();
            $response->status->code = 200;
            return response()->json($response);
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = "Error updating address: " . $request->input('id') . ". " . $e->getMessage();
            return response()->json($response);
        }
    }

    /**
     * Store new Address
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store (Request $request) {
//        $response = new JsonResponse(Auth::user());
        $response = new JsonResponse(null);
        $validator = Validator::make (
            $request->all(), [
                'accountId' => 'required',
            'type.id' => 'required',
            'name1' => 'required',
            'zip' => 'required',
            'town' => 'required',
            'countryCode' => 'required',
        ]);
        if ($validator->fails()) {
            $response->status->code = 400;
            $response->status->message = $validator->errors()->all();
            return response()->json($response);
        }
        $account = Account::find($request->input('accountId'));
        if (empty($account)) {
            $response->status->code = 400;
            $response->status->message = 'Unknown account with id: '.$request->input('accountId');
            return response()->json($response);
        }
        $type = AddressType::find($request->input('type.id'));
        if (empty($type)) {
            $response->status->code = 400;
            $response->status->message = 'Unknown address type: '.$request->input('type.id');
            return response()->json($response);
        }
        $address = new Address();
        $address->name1 = $request->input('name1');
        $address->name2 = $request->input('name2');
        $address->name3 = $request->input('name3');
        $address->street = $request->input('street');
        $address->zip = $request->input('zip');
        $address->town = $request->input('town');
        $address->country_code = $request->input('countryCode');
        $address->type_id = $type->id;
        try {
            $address->save();
            $account->addresses()->attach($address);
            $account->save();
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = "Address save unsuccessful: ".$e->getMessage();
            return response()->json($response);
        }
        $response->status->code = 200;
        return response()->json($response);
    }

    /**
     * Get types table
     * 'Hauptadresse' is not available for selection but only created
     * together with a new account.
     * @return \Illuminate\Http\JsonResponse
     */
    public function types () {
//        $response = new JsonResponse(Auth::user());
        $response = new JsonResponse(null);
        $types = AddressType::all();
        $types = $types->filter(function($type) {
            if ($type->name != 'Hauptadresse') {
                return $type;
            }
        });
        $response->status->code = 200;
        $response->result = $types->toArray();
        return response()->json($response);
    }

    public function typeAdd ($name) {
//        $response = new JsonResponse(Auth::user());
        $response = new JsonResponse(null);
        $type = AddressType::where('name', $name)->first();
        if (empty($type)) {
            $type = new AddressType();
            $type->name = $name;
            try {
                $type->save();
            } catch (\Exception $e) {
                $response->status->code = 500;
                $response->status->message = 'Could not save type "'.$name.'", '.$e->getMessage();
                return response()->json($response);
            }
            $response->status->code = 200;
            return response()->json($response);
        }
    }

    public function typeRemove ($id) {
//        $response = new JsonResponse(Auth::user());
        $response = new JsonResponse(null);
        $type = AddressType::find($id);
        if (!empty($type)) {
            try {
                $type->delete();
            } catch (\Exception $e) {
                $response->status->code = 500;
                $response->status->message = 'Could not delete type "'.$id.'", '.$e->getMessage();
                return response()->json($response);
            }
            $response->status->code = 200;
            return response()->json($response);
        }
    }


}