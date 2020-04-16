<?php


namespace App\Http\Controllers;


use App\Http\Service\response\JsonResponse;
use App\Model\AddressType;
use App\Model\CommunicationType;
use App\Model\Connection;
use App\Model\Connectiontype;
use App\Model\Remark;
use App\Model\RemarkType;
use App\Model\Sector;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuxiliaryController extends Controller
{

    /**
     * @return void
     */
    public function __construct ()
    {
        $this->middleware('auth');
    }

    /**
     * Not used atm. Hard coded in Vue
     * @return \Illuminate\Http\JsonResponse
     */
    public function list () {
        $response = new JsonResponse(Auth::user());
        $response->status = 200;
        $response->result = ['Addresstyp', 'Gesprächsart', 'Branche'];
        return response()->json($response);
    }

    /**
     * Get AddressType by id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function addressType ($id) {
        $response = new JsonResponse(Auth::user());
        $at = AddressType::find($id);
        $response->status->code = 200;
        $response->result = (object)$at;
        return response()->json($response);
    }

    /**
     * Get all AddressType s
     * @return \Illuminate\Http\JsonResponse
     */
    public function addressTypes () {
        $response = new JsonResponse(Auth::user());
        $at = AddressType::all();
        $response->status->code = 200;
        $response->result = (object)$at;
        return response()->json($response);
    }

    /**
     * Store a new AddressType
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function newAddressType (Request $request) {
        $response = new JsonResponse(Auth::user());
        $validator = Validator::make (
            $request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $response->status->code = 400;
            $response->status->message = $validator->errors()->all();
            return response()->json($response);
        }
        $at = new AddressType();
        $at->name = $request->input('name');
        try {
            $at->save();
        } catch (Exception $e) {
            $response->status->code = 400;
            $response->status->message = 'AddressType not saved, '.$e->getMessage();
            return response()->json($response);
        }
        $response->status->code = 200;
        $response->result = (object)$at;
        return response()->json($response);
    }

    /**
     * Change AddressType field (name)
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAddressType (Request $request) {
        $response = new JsonResponse(Auth::user());
        $validator = Validator::make (
            $request->all(), [
            'id' => 'required',
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            Log::debug('Validation failure', $validator->errors()->all());
            $response->status->code = 400;
            $response->status->message = $validator->errors()->all();
            return response()->json($response);
        }
        $at = AddressType::find($request->input('id'));
        $at->name = $request->input('name');
        try {
            $at->save();
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = 'AddressType not saved, '.$e->getMessage();
            return response()->json($response);
        }
        $response->status->code = 200;
        $response->result = (object)$at;
        return response()->json($response);
    }

    // not used
    public function deleteAddressType ($id) {
        $response = new JsonResponse(Auth::user());
        $at = AddressType::find($id);
        if (empty($at)) {
            $response->status->code = 400;
            $response->status->message = 'AddressType not found: '.$id;
            return response()->json($response);
        }
        try {
            $at->delete();
            $response->status->code = 200;
            $response->status->message = 'AddressType deleted: '.$id;
            return response()->json($response);
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = 'AddressType not deleted, '.$e->getMessage();
            return response()->json($response);
        }
    }

    //--------------------------------------------------------------------------------------------

    /**
     * Get single CommunicationType
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function communicationType ($id) {
        $response = new JsonResponse(Auth::user());
        $type = CommunicationType::find($id);
        $response->status->code = 200;
        $response->result = (object)$type;
        return response()->json($response);
    }

    /**
     * Get all CommunicationTypes
     * @return \Illuminate\Http\JsonResponse
     */
    public function communicationTypes () {
        $response = new JsonResponse(Auth::user());
        $type = CommunicationType::all();
        $response->status->code = 200;
        $response->result = (object)$type;
        return response()->json($response);
    }

    /**
     * Store new CommunicationType
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function newCommunicationType (Request $request) {
        $response = new JsonResponse(Auth::user());
        $validator = Validator::make (
            $request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            Log::debug('Validation failure', $validator->errors()->all());
            $response->status->code = 400;
            $response->status->message = $validator->errors()->all();
            return response()->json($response);
        }
        $type = new CommunicationType();
        $type->name = $request->input('name');
        try {
            $type->save();
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = 'CommunicationType not saved, '.$e->getMessage();
            return response()->json($response);
        }
        $response->status->code = 200;
        $response->result = (object)$type;
        return response()->json($response);
    }

    /**
     * Change single CommunicationType field (name)
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCommunicationType (Request $request) {
        $response = new JsonResponse(Auth::user());
        $validator = Validator::make (
            $request->all(), [
            'id' => 'required',
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            Log::debug('Validation failure', $validator->errors()->all());
            $response->status->code = 400;
            $response->status->message = $validator->errors()->all();
            return response()->json($response);
        }
        $type = CommunicationType::find($request->input('id'));
        $type->name = $request->input('name');
        try {
            $type->save();
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = 'CommunicationType not saved, '.$e->getMessage();
            return response()->json($response);
        }
        $response->status->code = 200;
        $response->result = (object)$type;
        return response()->json($response);
    }

    // not used
    public function deleteCommunicationType ($id) {
        $response = new JsonResponse(Auth::user());
        $type = CommunicationType::find($id);
        if (empty($type)) {
            $response->status->code = 400;
            $response->status->message = 'CommunicationType not found: '.$id;
            return response()->json($response);
        }
        try {
            $type->delete();
            $response->status->code = 200;
            $response->status->message = 'CommunicationType deleted: '.$id;
            return response()->json($response);
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = 'CommunicationType not deleted, '.$e->getMessage();
            return response()->json($response);
        }
    }

    //--------------------------------------------------------------------------------------------

    /**
     * Get single Sector
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function sector ($id) {
        $response = new JsonResponse(Auth::user());
        $sector = Sector::find($id);
        $response->status->code = 200;
        $response->result = (object)$sector;
        return response()->json($response);
    }

    /**
     * Get all Sectors
     * @return \Illuminate\Http\JsonResponse
     */
    public function sectors () {
        $response = new JsonResponse(Auth::user());
        $sector = Sector::all();
        $response->status->code = 200;
        $response->result = (object)$sector;
        return response()->json($response);
    }

    /**
     * Store new Sector
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function newSector (Request $request) {
        $response = new JsonResponse(Auth::user());
        $validator = Validator::make (
            $request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            Log::debug('Validation failure', $validator->errors()->all());
            $response->status->code = 400;
            $response->status->message = $validator->errors()->all();
            return response()->json($response);
        }
        $sector = new Sector();
        $sector->name = $request->input('name');
        try {
            $sector->save();
            $response->status->code = 200;
            $response->result = (object)$sector;
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = 'Sector not saved, '.$e->getMessage();
        }
        return response()->json($response);
    }

    /**
     * Change single Sector field (name)
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSector (Request $request) {
        $response = new JsonResponse(Auth::user());
        $validator = Validator::make (
            $request->all(), [
            'id' => 'required',
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            Log::debug('Validation failure', $validator->errors()->all());
            $response->status->code = 400;
            $response->status->message = $validator->errors()->all();
            return response()->json($response);
        }
        $sector = Sector::find($request->input('id'));
        $sector->name = $request->input('name');
        try {
            $sector->save();
            $response->status->code = 200;
            $response->result = (object)$sector;
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = 'Sector not updated, '.$e->getMessage();
        }
        return response()->json($response);
    }


    //--------------------------------------------------------------------------------------------

    /**
     * Get single Connection
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function connectionType ($id) {
        $response = new JsonResponse(Auth::user());
        $connection = Connectiontype::find($id);
        $response->status->code = 200;
        $response->result = (object)$connection;
        return response()->json($response);
    }

    /**
     * Get all Connections
     * @return \Illuminate\Http\JsonResponse
     */
    public function connectionTypes () {
        $response = new JsonResponse(Auth::user());
        $connection = Connectiontype::all();
        $response->status->code = 200;
        $response->result = (object)$connection;
        return response()->json($response);
    }

    /**
     * Store new Connection
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function newConnectionType (Request $request) {
        $response = new JsonResponse(Auth::user());
        $validator = Validator::make (
            $request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            Log::debug('Validation failure', $validator->errors()->all());
            $response->status->code = 400;
            $response->status->message = $validator->errors()->all();
            return response()->json($response);
        }
        $connection = new Connectiontype();
        $connection->name = $request->input('name');
        try {
            $connection->save();
            $response->status->code = 200;
            $response->result = (object)$connection;
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = 'Connectiontype not saved, '.$e->getMessage();
        }
        return response()->json($response);
    }

    /**
     * Change single Connection field (name)
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateConnectionType (Request $request) {
        $response = new JsonResponse(Auth::user());
        $validator = Validator::make (
            $request->all(), [
            'id' => 'required',
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            Log::debug('Validation failure', $validator->errors()->all());
            $response->status->code = 400;
            $response->status->message = $validator->errors()->all();
            return response()->json($response);
        }
        $connection = Connectiontype::find($request->input('id'));
        $connection->name = $request->input('name');
        try {
            $connection->save();
            $response->status->code = 200;
            $response->result = (object)$connection;
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = 'Connectiontype not updated, '.$e->getMessage();
        }
        return response()->json($response);
    }


    //--------------------------------------------------------------------------------------------

    /**
     * Get single Remark
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function remarkType ($id) {
        $response = new JsonResponse(Auth::user());
        $remark = RemarkType::find($id);
        $response->status->code = 200;
        $response->result = (object)$remark;
        return response()->json($response);
    }

    /**
     * Get all Remarks
     * @return \Illuminate\Http\JsonResponse
     */
    public function remarkTypes () {
        $response = new JsonResponse(Auth::user());
        $remark = RemarkType::all();
        $response->status->code = 200;
        $response->result = (object)$remark;
        return response()->json($response);
    }

    /**
     * Store new Remark
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function newRemarkType (Request $request) {
        $response = new JsonResponse(Auth::user());
        $validator = Validator::make (
            $request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            Log::debug('Validation failure', $validator->errors()->all());
            $response->status->code = 400;
            $response->status->message = $validator->errors()->all();
            return response()->json($response);
        }
        $remark = new RemarkType();
        $remark->name = $request->input('name');
        try {
            $remark->save();
            $response->status->code = 200;
            $response->result = (object)$remark;
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = 'Remark not saved, '.$e->getMessage();
        }
        return response()->json($response);
    }

    /**
     * Change single Remark field (name)
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateRemarkType (Request $request) {
        $response = new JsonResponse(Auth::user());
        $validator = Validator::make (
            $request->all(), [
            'id' => 'required',
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            Log::debug('Validation failure', $validator->errors()->all());
            $response->status->code = 400;
            $response->status->message = $validator->errors()->all();
            return response()->json($response);
        }
        $remark = RemarkType::find($request->input('id'));
        $remark->name = $request->input('name');
        try {
            $remark->save();
            $response->status->code = 200;
            $response->result = (object)$remark;
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = 'Remark not updated, '.$e->getMessage();
        }
        return response()->json($response);
    }

}