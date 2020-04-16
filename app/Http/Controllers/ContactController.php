<?php
namespace App\Http\Controllers;


use App\Http\Service\response\JsonResponse;
use App\Model\Contact;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * @return void
     */
    public function __construct ()
    {
        $this->middleware('auth');
    }

    /**
     * Mark Contact deleted (deleted_at = date)
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete ($id) {
        $response = new JsonResponse(Auth::user());
        $contact = Contact::find($id);
        if (!$contact) {
            $response->status->code = 400;
            $response->status->message = 'Invalid contact id: '.$id;
        } else {
            try {
                $contact->delete();
                $response->status->code = 200;
            } catch (Exception $e) {
                $response->status->code = 500;
                $response->status->message = 'Could not delete contact with id: '.$id.' '.$e->getMessage();
            }
        }
        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store (Request $request) {
        $response = new JsonResponse(Auth::user());
        $validator = Validator::make(
            $request->all(), [
                'accountId' => 'required',
                'lastname' => 'required',
            ]);
        if ($validator->fails()) {
            Log::debug('Validation failure', $validator->errors()->all());
            $response->status->code = 400;
            $response->status->message = $validator->errors()->all();
            return response()->json($response);
        }
        $contact = new Contact();
        $contact->account_id = $request->input('accountId');
        $contact->title = $request->input('title');
        $contact->firstname = $request->input('firstname');
        $contact->lastname = $request->input('lastname');
        $contact->gender = $request->input('gender');
        $contact->department = $request->input('department');
        $contact->position = $request->input('position');
        $contact->is_adhoc = false;
        try {
            $contact->save();
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = 'Error saving contact '.$e->getMessage();
            return response()->json($response);
        }
        $response->status->code = 200;
        return response()->json($response);
    }


    /**
     * Get all contacts for an account
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function allInAccount (int $id) {
        $response = new JsonResponse(Auth::user());
        try {
            $contacts = Contact::with('account')
                ->whereHas('account', function(Builder $query) use ($id) {
                    $query->where('id', $id);
                })->take(9)->get();
            $response->status->code = 200;
            $response->result = $contacts;
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = "Error finding account with id: '".$id."': ".$e->getMessage();
        }
        return response()->json($response);
    }


    /**
     * Get all contacts for an account
     * @param int $id
     * @param string $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchInAccountWithoutAdhoc (int $id, $name = '') {
        $response = new JsonResponse(Auth::user());
        try {
            $contacts = Contact::with('account')
                ->whereHas('account', function(Builder $query) use ($id) {
                    $query->where('id', $id);
                })->where('is_adhoc', 'false')
                ->where('lastname', 'ilike', '%'.$name.'%')
                ->take(9)->get();
            $response->status->code = 200;
            $response->result = $contacts;
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = "Error finding account with id: '".$id."': ".$e->getMessage();
        }
        return response()->json($response);
    }

    /**
     * Search by name with temporary contacts and join the corresponding account
     * @param int $id
     * @param string $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchInAccount (int $id, string $name = '') {
        $response = new JsonResponse(Auth::user());
        try {
            $contacts = Contact::with('account')
                ->whereHas('account', function(Builder $query) use ($id) {
                    $query->where('id', $id);
                })
                ->where('lastname', 'ilike', '%' . $name . '%')
                ->take(9)->get();
            $response->status->code = 200;
            $response->result = $contacts;
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = "Error finding '".$name."': ".$e->getMessage();
        }
        return response()->json($response);
    }

    /**
     * Search all by name without temporary contacts
     * @param string $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchAll (string $name = null) {
        $response = new JsonResponse(Auth::user());
        if ($name) {
            try {
                $contacts = Contact::with('account')
                    ->where('lastname', 'ilike', '%' . $name . '%')
                    ->where('is_adhoc', 'false')
                    ->take(20)->get();
                $response->status->code = 200;
                $response->result = $contacts;
            } catch (Exception $e) {
                $response->status->code = 500;
                $response->status->message = "Error finding '".$name."': ".$e->getMessage();
            }
        } else {
            try {
                $contacts = Contact::with('account')
                    ->where('is_adhoc', 'false')
                    ->take(20)->get();
                $response->status->code = 200;
                $response->result = $contacts;
            } catch (Exception $e) {
                $response->status->code = 500;
                $response->status->message = "Error retrieving contacts: ".$e->getMessage();
            }
        }
        return response()->json($response);
    }

}
