<?php


namespace App\Http\Controllers;


use App\Http\Service\response\JsonResponse;
use App\Model\Address;
use App\Model\Remark;
use App\Model\RemarkType;
use App\Model\Contact;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RemarkController
{

    public function update (Request $request) {
//        $response = new JsonResponse(Auth::user());
        $response = new JsonResponse(null);
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
        $remark = Remark::find($request->input('id'));
        if(empty($remark)) {
            $response->status->code = 400;
            $response->status->message = 'Invalid remark id: '.$request->input('id');
            return response()->json($response);
        }
        if ($request->input('typeId')) {
            $type = RemarkType::find($request->input('typeId'));
            if (empty($type)) {
                $response->status->code = 400;
                $response->status->message = 'Invalid remark type id: '.$request->input('typeId');
                return response()->json($response);
            }
            $remark->remark_type_id = $type->id;
        }
        if ($request->input('data')) {
            $remark->text = $request->input('data');
        }
        $remark->updated_user_id = Auth::user()->id;
        try {
            $remark->save();
            $response->status->code = 200;
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = "Remark update unsuccessful: ".$e->getMessage();
        }
        return response()->json($response);
    }

    public function delete ($id) {
//        $response = new JsonResponse(Auth::user());
        $response = new JsonResponse(null);
        $remark = Remark::find($id);
        if(empty($remark)) {
            $response->status->code = 400;
            $response->status->message = 'Invalid remark id: '.$id;
            return response()->json($response);
        }
        try {
            $remark->delete();
            $response->status->code = 200;
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = "Remark delete unsuccessful: ".$e->getMessage();
        }
        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeToContact (Request $request)
    {
//        $response = new JsonResponse(Auth::user());
        $response = new JsonResponse(null);
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
        $type = RemarkType::find($request->input('typeId'));
        if (empty($type)) {
            $response->status->code = 400;
            $response->status->message = 'Invalid remark type id: '.$request->input('typeId');
            return response()->json($response);
        }
        $remark = new Remark();
        $remark->remark_type_id = $request->input('typeId');
        $remark->text = $request->input(('data'));
        $remark->created_user_id = Auth::user()->id;
        try {
            $remark->save();
            $contact->remarks()->attach($remark);
            $response->status->code = 200;
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = "Remark save unsuccessful: ".$e->getMessage();
        }
        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeToAddress (Request $request)
    {
//        $response = new JsonResponse(Auth::user());
        $response = new JsonResponse(null);
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
        $type = RemarkType::find($request->input('typeId'));
        if (empty($type)) {
            $response->status->code = 400;
            $response->status->message = 'Invalid remark type id: '.$request->input('typeId');
            return response()->json($response);
        }
        $remark = new Remark();
        $remark->remark_type_id = $request->input('typeId');
        $remark->text = $request->input(('data'));
        $remark->created_user_id = Auth::user()->id;
        try {
            $remark->save();
            $address->remarks()->attach($remark);
            $response->status->code = 200;
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = "Remark save unsuccessful: ".$e->getMessage();
        }
        return response()->json($response);
    }

    /**
     * Get types table
     * @return \Illuminate\Http\JsonResponse
     */
    public function types () {
//        $response = new JsonResponse(Auth::user());
        $response = new JsonResponse(null);
        $types = RemarkType::all();
        $response->status->code = 200;
        $response->result = (object) $types;
        return response()->json($response);
    }
}