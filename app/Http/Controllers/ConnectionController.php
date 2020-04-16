<?php


namespace App\Http\Controllers;


use App\Http\Service\response\JsonResponse;
use App\Model\Address;
use App\Model\CommunicationType;
use App\Model\Connection;
use App\Model\Connectiontype;
use App\Model\Contact;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ConnectionController
{

    public function update (Request $request) {
        $response = new JsonResponse(Auth::user());
        $validator = Validator::make (
            $request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            Log::debug('Validation failure', $validator->errors()->all());
            $response->status->code = 400;
            $response->status->message = $validator->errors()->all();
            return response()->json($response);
        }
        $connection = Connection::find($request->input('id'));
        if(empty($connection)) {
            $response->status->code = 400;
            $response->status->message = 'Invalid connection id: '.$request->input('id');
            return response()->json($response);
        }
        if ($request->input('typeId')) {
            $type = Connectiontype::find($request->input('typeId'));
            if (empty($type)) {
                $response->status->code = 400;
                $response->status->message = 'Invalid connection type id: '.$request->input('typeId');
                return response()->json($response);
            }
            $connection->connectiontype_id = $type->id;
        }
        if ($request->input('data')) {
            $connection->data = $request->input('data');
        }
        try {
            $connection->save();
            $response->status->code = 200;
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = "Connection update unsuccessful: ".$e->getMessage();
        }
        return response()->json($response);
    }

    public function delete ($id) {
        $response = new JsonResponse(Auth::user());
        $connection = Connection::find($id);
        if(empty($connection)) {
            $response->status->code = 400;
            $response->status->message = 'Invalid connection id: '.$id;
            return response()->json($response);
        }
        try {
            $connection->delete();
            $response->status->code = 200;
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = "Connection delete unsuccessful: ".$e->getMessage();
        }
        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeToContact (Request $request)
    {
        $response = new JsonResponse(Auth::user());
        $validator = Validator::make (
            $request->all(), [
            'parentId' => 'required',
            'typeId' => 'required',
            'data' => 'required',
        ]);
        if ($validator->fails()) {
            Log::debug('Validation failure', $validator->errors()->all());
            $response->status->code = 400;
            $response->status->message = $validator->errors()->all();
            return response()->json($response);
        }
        $contact = Contact::find($request->input('parentId'));
        if (empty($contact)) {
            $response->status->code = 400;
            $response->status->message = 'Invalid contact id: '.$request->input('parentId');
            return response()->json($response);
        }
        $type = Connectiontype::find($request->input('typeId'));
        if (empty($type)) {
            $response->status->code = 400;
            $response->status->message = 'Invalid connectionType id: '.$request->input('typeId');
            return response()->json($response);
        }
        $connection = new Connection();
        $connection->connectiontype_id = $request->input('typeId');
        $connection->data = $request->input(('data'));
        try {
            $connection->save();
            $contact->connections()->attach($connection);
            $response->status->code = 200;
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = "Connection save unsuccessful: ".$e->getMessage();
        }
        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeToAddress (Request $request)
    {
        $response = new JsonResponse(Auth::user());
        $validator = Validator::make (
            $request->all(), [
            'parentId' => 'required',
            'typeId' => 'required',
            'data' => 'required',
        ]);
        if ($validator->fails()) {
            Log::debug('Validation failure', $validator->errors()->all());
            $response->status->code = 400;
            $response->status->message = $validator->errors()->all();
            return response()->json($response);
        }
        $address = Address::find($request->input('parentId'));
        if (empty($address)) {
            $response->status->code = 400;
            $response->status->message = 'Invalid address id: '.$request->input('parentId');
            return response()->json($response);
        }
        $type = Connectiontype::find($request->input('typeId'));
        if (empty($type)) {
            $response->status->code = 400;
            $response->status->message = 'Invalid connectionType id: '.$request->input('typeId');
            return response()->json($response);
        }
        $connection = new Connection();
        $connection->connectiontype_id = $request->input('typeId');
        $connection->data = $request->input(('data'));
        try {
            $connection->save();
            $address->connections()->attach($connection);
            $response->status->code = 200;
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = "Connection save unsuccessful: ".$e->getMessage();
        }
        return response()->json($response);
    }

    /**
     * Get types table
     * @return \Illuminate\Http\JsonResponse
     */
    public function types () {
        $response = new JsonResponse(Auth::user());
        $types = Connectiontype::all();
        $response->status->code = 200;
        $response->result = (object) $types;
        return response()->json($response);
    }
}