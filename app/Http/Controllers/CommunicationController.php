<?php
namespace App\Http\Controllers;


use App\Http\Service\response\JsonResponse;
use App\Model\Account;
use App\Model\Communication;
use App\Model\CommunicationType;
use App\Model\Contact;
use App\Model\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CommunicationController extends Controller
{
    /**
     * @return void
     */
    public function __construct ()
    {
        $this->middleware('auth');
    }

    public function store (Request $request) {
        $response = new JsonResponse(Auth::user());
        Log::debug('Store Communication');
        $validator = Validator::make(
            $request->all(),
            [
                'date' => 'required',
                'account' => 'required',
                'contact' => 'required',
                'type' => 'required',
                'memo' => 'required',
            ]);
        if ($validator->fails()) {
            Log::debug('Validation failure', $validator->errors()->all());
            $response->status->code = 400;
            $response->status->message = $validator->errors()->all();
            return response()->json($response);
        }
        $account = Account::find($request->input('account.id'));
        if (empty($account)) {
            $response->status->code = 400;
            $response->status->message = 'Account not found: '.$request->input('account.id');
            return response()->json($response);
        }
        $account->next_contact = $request->input('nextContact');
        try {
            $account->save();
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = 'Could not save account with next_contact: '.$e->getMessage();
            return response()->json($response);
        }
        $type = CommunicationType::find($request->input('type.id'));
        if (empty($type)) {
            $response->status->code = 400;
            $response->status->message = 'Communication not found: '.$request->input('type.id');
            return response()->json($response);
        }
        $contact = null;
        if ($request->input('contact.id')) {
            $contact = Contact::find($request->input('contact.id'));
        } else {
            $contact = new Contact();
            $contact->lastname = $request->input('contact');
            $contact->is_adhoc = true;
            $contact->account_id = $account->id;
            try {
                $contact->save();
            } catch (Exception $e) {
                $response->status->code = 500;
                $response->status->message = 'Could not save adhoc Contact: '.$e->getMessage();
                return response()->json($response);
            }
        }
        $com = new Communication();
        $com->date = $request->input('date');
        $com->user_id = Auth::user()->id;
        $com->account_id = $account->id;
        $com->contact_id = $contact->id;
        $com->communication_type_id = $type->id;
        $com->memo = $request->input('memo');
        try {
            $com->save();
            $response->status->code = 200;
            return response()->json($response);
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = "Could not save Communication ".$e->getMessage();
            return response()->json($response);
        }
    }

    public function update (Request $request) {
        $response = new JsonResponse(Auth::user());
        $communication = Communication::find($request->input('id'));
        if (empty($communication)) {
            $response->status->code = 400;
            $response->status->message = 'Communication not found: '.$request->input('id');
            return response()->json($response);
        }
        if ($request->input('contact')) {
            $contact = Contact::find($request->input('contact.id'));
            if (empty($contact)) {
                $response->status->code = 400;
                $response->status->message = 'Contact not found: '.$request->input('contact.id');
                return response()->json($response);
            }
            $communication->contact_id = $contact->id;
        } else if ($request->input('user')) {
            $user = User::find($request->input('user.id'));
            if (empty($user)) {
                $response->status->code = 400;
                $response->status->message = 'User not found: '.$request->input('user.id');
                return response()->json($response);
            }
            $communication->user_id = $user->id;
        } else if ($request->input('type')) {
            $type = CommunicationType::find($request->input('type.id'));
            if (empty($type)) {
                $response->status->code = 400;
                $response->status->message = 'CommunicationType not found: '.$request->input('type.id');
                return response()->json($response);
            }
            $communication->communication_type_id = $type->id;
        } else if ($request->input('date')) {
            $communication->date = $request->input('date');
        } else if ($request->input('memo')) {
            $communication->memo = $request->input('memo');
        }
        try {
            $communication->save();
            $response->status->code = 200;
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = "Could not update Communication ".$e->getMessage();
        }
        return response()->json($response);
    }

    /**
     * Get types table
     * @return \Illuminate\Http\JsonResponse
     */
    public function types () {
        $response = new JsonResponse(Auth::user());
        $types = CommunicationType::all();
        $response->status->code = 200;
        $response->result = (object) $types;
        return response()->json($response);
    }

}
