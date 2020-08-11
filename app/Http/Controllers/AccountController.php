<?php
namespace App\Http\Controllers;


use App\Model\Account;
use App\Http\Service\response\JsonResponse;
use App\Model\AccountLevel;
use App\Model\Address;
use App\Model\AddressType;
use App\Model\Contact;
use App\Model\Sector;
use App\Model\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Prof; //Profiler for account search

class AccountController extends Controller
{
    /**
     * @return void
     */
    public function __construct ()
    {
//        $this->middleware('auth');
    }

    /**
     * Get accounts with past next_contact date
     * @param $date string date until
     * @param $openContacts get open or done contacts
     * @param $userId User account manager
     * @return \Illuminate\Http\JsonResponse
     */
    public function byNextContactDateAndUser ($date, $openContacts, $userId = null) {
        $response = new JsonResponse(Auth::user());
        $accounts = null;
        $openContacts = $openContacts === 'true';
        $query = "select * from ( ";
        if($openContacts) {
            $query .= "select Distinct On (a.id) ";
        } else {
            $query .= "select ";
            // communications from today:
            $date = Carbon::parse($date)->addDay();
        }
$query .= "a.id,
a.next_contact,
u.firstname,
u.lastname,
c.id as communication_id,
c.created_at,
c.date as communication_date,
c.memo,
ct.name as type_name,
con.firstname as contact_firstname,
con.lastname as contact_lastname,
ad.country_code,
ad.name1,
ad.street,
ad.town,
ad.zip
from accounts a
left join communications c on a.id = c.account_id
left join communication_types ct on ct.id = c.communication_type_id
left join contacts con on c.contact_id = con.id
left join users u on u.id = a.account_manager_id
left join account_addresses aa on aa.account_id = a.id
left join addresses ad on ad.id = aa.address_id
left join address_types at on at.\"name\" = 'Hauptadresse' ";
        if($openContacts) {
            $query .= "where a.next_contact < ? ";
        } else {
            $query .= "where c.created_at < ? ";
        }
        if (!empty($userId)) {
            $query .= "and u.id = ? ";
            $query .= "
order by a.id, c.created_at desc, c.id desc
) as offene_nc ";
            if($openContacts) {
                $query .= "order by offene_nc.next_contact desc";
            } else {
                $query .= "order by offene_nc.created_at desc";
            }
            $accounts = collect(DB::select($query, [$date, $userId]))->chunk(10);
        } else {
            $query .= "
order by a.id, c.created_at desc, c.id desc
) as offene_nc ";
            if($openContacts) {
                $query .= "order by offene_nc.next_contact desc";
            } else {
                $query .= "order by offene_nc.created_at desc";
            }
            $accounts = collect(DB::select($query, [$date]))->chunk(10);
        }
        Log::info($query);
        // performance
//        $accounts = Account::with([
//            'accountManager',
//            'addresses' => function(Relation $query) {
//                $query->whereHas('type', function($q) {
//                    $q->where('name', 'Hauptadresse');
//                });
//        }])->addSelect(['communication' => Communication::select('id')->whereColumn('account_id', 'accounts.id' )->orderBy('date', 'desc')->limit(1)])
//            ->where('next_contact', '<', $date);
//        if ($userId) {
//            $accounts->whereHas('accountManager', function($query) use ($userId) {
//                $query->where('id', $userId);
//            });
//        }
//        $comIds = $accounts->pluck('communication');
//        $coms = Communication::whereIn('id', $comIds)->get();
//        $coms = $coms->keyBy('id');
//        $accounts = $accounts->get();
//        $accounts->each(function($acc) use ($coms) {
//            $acc->communication = $coms->get($acc->communication);
//        });
//        $accounts = $accounts->sortBy(function($a) {
//            return $a->next_contact;
//        })->values();
        $response->status->code = 200;
        $response->result = (object) $accounts;
        return response()->json($response);
    }

    // performance?
//    private function compressNextContacts (Collection $accounts) {
//        $zip = $accounts->map(function ($account) {
//            $acc = [
//                'id' => $account->id,
//                'accountManager' => $account->account_manager,
//                'address' => $account->addresses[0],
//            ];
//        });
//    }

    /**
     * Save one field of an account object or subobject
     * An empty account object is sent with only the attribute that should change
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update (Request $request, int $id) {
        $response = new JsonResponse(Auth::user());
        $account = Account::find($id);
        if (empty($account)) {
            $response->status->code = 400;
            $response->status->message = 'Invalid account: '.$id;
            return response()->json($response);
        }
        if ($request->input('address')) {
            $address = Address::find($request->input('address.id'));
            if (empty($address)) {
                $response->status->code = 400;
                $response->status->message = 'Unknown address: '.$request->input('address.id');
                return response()->json($response);
            }
            $address->name1 = $request->input('address.name1') ?? $address->name1;
            $address->name2 = $request->input('address.name2') ?? $address->name2;
            $address->name3 = $request->input('address.name3') ?? $address->name3;
            $address->street = $request->input('address.street') ?? $address->street;
            $address->zip = $request->input('address.zip') ?? $address->zip;
            $address->town = $request->input('address.town') ?? $address->town;
            $address->country_code = $request->input('address.countryCode') ?? $address->country_code;
            try {
                $address->save();
                $response->status->code = 200;
                $response->result = 'Address ' . $request->input('address.id') . ' updated';
                return response()->json($response);
            } catch (Exception $e) {
                $response->status->code = 500;
                $response->status->message = "Error updating address: " . $request->input('address.id') . ". " . $e->getMessage();
                return response()->json($response);
            }
        }
        else if ($request->input('contact')) {
            $contact = Contact::find($request->input('contact.id'));
            if (empty($contact)) {
                $response->status->code = 400;
                $response->status->message = 'Update Account: Unknown contact: '.$request->input('contact.id');
                return response()->json($response);
            }
            $contact->title = $request->input('contact.title') ?? $contact->title;
            $contact->firstname = $request->input('contact.firstname') ?? $contact->firstname;
            $contact->lastname = $request->input('contact.lastname') ?? $contact->lastname;
            $contact->gender = $request->input('contact.gender') ?? $contact->gender;
            $contact->department = $request->input('contact.department') ?? $contact->department;
            $contact->position = $request->input('contact.position') ?? $contact->position;
            $contact->is_adhoc = $request->input('contact.is_adhoc') ?? $contact->is_adhoc;
            try {
                $contact->save();
                $response->status->code = 200;
                $response->result = 'Contact ' . $request->input('contact.id') . ' updated';
                return response()->json($response);
            } catch (Exception $e) {
                $response->status->code = 500;
                $response->status->message = "Error updating Contact: " . $request->input('contact.id') . ". " . $e->getMessage();
                return response()->json($response);
            }
        }
        // communication update never needed??
        else if ($request->input('communication')) {
            $com = Contact::find($request->input('communication.id'));
            if (empty($com)) {
                $response->result = new \stdClass();
                $response->result->success = false;
                $response->result->data = 'Update Account: Unknown Communication: '.$request->input('communication.id');
                return response()->json($response);
            }
            $com->date = $request->input('communication.date') ?? $com->date;
            $com->memo = $request->input('communication.memo') ?? $com->memo;
            if ($request->input('communication.contact')) {
                $contact = Contact::find($request->input('communication.contact.id'));
                if (empty($contact)) {
                    $response->result = new \stdClass();
                    $response->result->success = false;
                    $response->result->data = 'Update Account: Unknown Contact: '.$request->input('communication.contact.id');
                    return response()->json($response);
                }
                $com->contact_id = $request->input('communication.contact.id');
            }
            if ($request->input('communication.')) {
                $contact = Contact::find($request->input('communication.contact.id'));
                if (empty($contact)) {
                    $response->result = new \stdClass();
                    $response->result->success = false;
                    $response->result->data = 'Update Account: Unknown Contact: '.$request->input('communication.contact.id');
                    return response()->json($response);
                }
                $com->contact_id = $request->input('communication.contact.id');
            }

        }
        else {
            $account->name = $request->input('name') ?? $account->name;
            $account->mnemonic = $request->input('mnemonic') ?? $account->mnemonic;
            if ($request->input('accountManager')) {
                $am = User::find($request->input('accountManager.id'));
                if (empty($am)) {
                    $response->status->code = 400;
                    $response->status->message = 'Update Account: Unknown user: '.$request->input('accountManager.id');
                    return response()->json($response);
                }
                $account->account_manager_id = $request->input('accountManager.id');
            }
            if ($request->input('level')) {
                $al = AccountLevel::find($request->input('level.id'));
                if (empty($al)) {
                    $response->status->code = 400;
                    $response->status->message = 'AccountLevel not found with id: '.$request->input('level.id');
                    return response()->json($response);
                }
                $account->account_level_id = $request->input('level.id');
            }
            if ($request->input('sector')) {
                $sector = Sector::find($request->input('sector.id'));
                if (empty($sector)) {
                    $response->status->code = 400;
                    $response->status->message = 'Sector not found with id: '.$request->input('sector.id');
                    return response()->json($response);
                }
                $account->sector_id = $request->input('sector.id');
            }
            $account->verbotskunde = $request->input('verbotskunde') ?? $account->verbotskunde;
            $account->next_contact = $request->input('nextContact') ?? $account->next_contact;
            try {
                $account->save();
                $response->status->code = 200;
                return response()->json($response);
            } catch (Exception $e) {
                $response->status->code = 500;
                $response->status->message = "Error updating account: " . $id . ". " . $e->getMessage();
                return response()->json($response);
            }
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store (Request $request) {
        $response = new JsonResponse(Auth::user());
        $validator = Validator::make (
            $request->all(), [
                'name' => 'required',
                'mnemonic' => 'required',
                'accountManager' => 'required',
                'level' => 'required',
                'verbotskunde' => 'required',
                'sector' => 'required',
                'address.name1' => 'required',
                'address.countryCode' => 'required',
                'address.zip' => 'required',
                'address.town' => 'required',
            ]);
        if ($validator->fails()) {
            Log::debug('Validation failure', $validator->errors()->all());
            $response->status->code = 400;
            $response->status->message = $validator->errors()->all();
            return response()->json($response);
        }
        $userDb = User::find($request->input('accountManager.id'));
        if (empty($userDb)) {
            $response->status->code = 400;
            $response->status->message = 'Unknown user: '.$request->input('accountManager.id');
            return response()->json($response);
        }
        $levelDb = AccountLevel::find($request->input('level.id'));
        if (empty($levelDb)) {
            $response->status->code = 400;
            $response->status->message = 'Unknown account level: '.$request->input('level.id');
            return response()->json($response);
        }
        $sectorDb = Sector::find($request->input('sector.id'));
        if (empty($sectorDb)) {
            $response->status->code = 400;
            $response->status->message = 'Unknown sector: '.$request->input('sector.id');
            return response()->json($response);
        }
        $address = new Address();
        $address->name1 = $request->input('address.name1');
        $address->name2 = $request->input('address.name2');
        $address->name3 = $request->input('address.name3');
        $address->street = $request->input('address.street');
        $address->zip = $request->input('address.zip');
        $address->town = $request->input('address.town');
        $address->country_code = $request->input('address.countryCode');
        $type = AddressType::where('name', 'Hauptadresse')->first();
        $address->type_id = $type->id;
        try {
            $address->save();
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = "Address save unsuccessful: ".$e->getMessage();
            return response()->json($response);
        }
        $account = new Account();
        $account->name = $request->input('name');
        $account->mnemonic = $request->input('mnemonic');
        $account->account_manager_id = $request->input('accountManager.id');
        $account->account_level_id = $request->input('level.id');
        $account->verbotskunde = $request->input('verbotskunde');
        $account->sector_id = $request->input('sector.id');
        $account->next_contact = $request->input('nextContact');
        try {
            $account->save();
            $account->addresses()->attach($address);
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = "Account save unsuccessful: ".$e->getMessage();
            return response()->json($response);
        }
        $response->status->code = 200;
        return response()->json($response);
    }


    /**
     * Get sectors table
     * @return \Illuminate\Http\JsonResponse
     */
    public function sectors () {
        $response = new JsonResponse(Auth::user());
        $sectors = Sector::all();
        $response->status->code = 200;
        $response->result = (object) $sectors;
        return response()->json($response);
    }


    /**
     * Get accountLevels table
     * @return \Illuminate\Http\JsonResponse
     */
    public function levels () {
        $response = new JsonResponse(Auth::user());
        $levels = AccountLevel::all();
        $response->status->code = 200;
        $response->result = (object) $levels;
        return response()->json($response);
    }

    /**
     * Show list depending on search input.
     * 1. Search for specific field:
     * k:mnemonic, n:name, l:countryCode, o:town, s:street, z:zip.
     * 2. Without prefix search in all above attributes.
     * When a field is specified it's not searched in all attributes any more.
     *
     * @param string $searchText
     * @return \Illuminate\Http\JsonResponse
     */
    public function search (string $searchText) {
        $response = new JsonResponse(Auth::user());
//    Prof::prof_flag('parse text');
        $parser = new SearchTextParser($searchText);
        $accounts = null;
//    Prof::prof_flag('make query');
        $q = DB::table('accounts')
            ->join('account_addresses', 'accounts.id', 'account_addresses.account_id')
            ->join('addresses', 'addresses.id', 'account_addresses.address_id')
            ->select('accounts.id');
        if ($parser->name) {
            $q->where('accounts.name', 'ilike', '%' . $parser->name . '%');
        }
        if ($parser->mnemonic) {
            $q->where('accounts.mnemonic', 'ilike', '%' . $parser->mnemonic . '%');
        }
        if ($parser->countryCode) {
            $q->where('addresses.country_code', 'ilike', '%' . $parser->countryCode . '%');
        }
        if ($parser->zip) {
            $q->where('addresses.zip', 'ilike', '%' . $parser->zip . '%');
        }
        if ($parser->street) {
            $q->where('addresses.street', 'ilike', '%' . $parser->street . '%');
        }
        if ($parser->town) {
            $q->where('addresses.town', 'ilike', '%' . $parser->town . '%');
        }
        foreach ($parser->words as $word) {
            $q->where(function(Builder $q) use ($word, $parser) {
                $where = false; // first where() placed?
                if (!$parser->street) {
                    $q->where('addresses.street', 'ilike', '%' . $word . '%');
                    $where = true;
                }
                if (!$parser->town) {
                    if ($where) {
                        $q->orWhere('addresses.town', 'ilike', '%' . $word . '%');
                    } else {
                        $q->where('addresses.town', 'ilike', '%' . $word . '%');
                        $where = true;
                    }
                }
                if (!$parser->name) {
                    if ($where) {
                        $q->orWhere('accounts.name', 'ilike', '%' . $word . '%');
                    } else {
                        $q->where('accounts.name', 'ilike', '%' . $word . '%');
                        $where = true;
                    }
                }
                if (!$parser->mnemonic) {
                    if ($where) {
                        $q->orWhere('accounts.mnemonic', 'ilike', '%' . $word . '%');
                    } else {
                        $q->where('accounts.mnemonic', 'ilike', '%' . $word . '%');
                        $where = true;
                    }
                }
                if (!$parser->zip) {
                    if ($where) {
                        $q->orWhere('addresses.zip', 'ilike', '%' . $word . '%');
                    } else {
                        $q->where('addresses.zip', 'ilike', '%' . $word . '%');
                    }
                }
            });
        }
//    Prof::prof_flag('->get()');
        $accounts = $q->take(8)->get();
        // get the whole object as tree:
        $ids = [];
        foreach ($accounts as $account) {
            $ids[] = $account->id;
        }
        $accounts = Account::with('addresses')->whereIn('accounts.id', $ids)->take(8)->get();
//    Prof::prof_flag('return');
        $response->status->code = 200;
        $response->result = $accounts;
//        Log::info('Profiling search text: '.$searchText);
//        Log::info(Prof::prof_print());
        return response()->json($response);
    }


    /**
     * Search by searchstring
     * @param string $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchName (string $name) {
        $response = new JsonResponse(Auth::user());
        try {
            $accounts = Account::where('name', 'ilike', '%' . $name . '%')
                ->take(9)->get();
            $response->status->code = 200;
            $response->result = $accounts;
        } catch (Exception $e) {
            $response->status->code = 500;
            $response->status->message = "Error searching: '".$name."': ".$e->getMessage();
        }
        return response()->json($response);
    }

    /**
     * Get Account by id
     *
     * @param  int $id
     * @return
     */
    public function show(int $id)
    {
        $response = new JsonResponse(Auth::user());
        try {
            $account = Account::with(['addresses', 'addresses.connections', 'level', 'sector', 'accountManager' => function(Relation $r) {
                $r->withTrashed();
            }, 'closer', 'contacts', 'contacts.connections', 'contacts.remarks', 'communications' => function(Relation $r) {
                $r->with(['contact' => function(Relation $r) {
                    $r->withTrashed();
                }, 'user' => function(Relation $r) {
                    $r->withTrashed();
                }, 'type'])->orderBy('date', 'desc');
            }])->find($id);
            $response->status->code = 200;
            $response->result = $this->export($account);
        } catch (Exception $e) {
            Log::error('Could not load Account: '.$id.', '.$e->getMessage());
            $response->status->code = 500;
            $response->status->message = "Could not load account: ".$e->getMessage();
        }
        return response()->json($response);
    }

    /**
     * Build view model
     * @param Account $acc
     * @return
     */
    private function export (Account $acc) {
        return new class ($acc) {
            public function __construct($acc)
            {
                $this->id = $acc->id;
                $this->mnemonic = $acc->mnemonic;
                $this->name = $acc->name;
                $this->nextContact = $acc->next_contact;
                $this->verbotskunde = $acc->verbotskunde;
                $this->level = $acc->level;
                $this->sector = $acc->sector;
                $this->accountManager = $acc->accountManager ? (object)$acc->accountManager : null;
                $this->address = (object)$acc->address;
                $this->addresses = [];
                foreach ($acc->addresses as $ad) {
                    $a = new \stdClass();
                    $a->id = $ad->id;
                    $a->name1 = $ad->name1;
                    $a->name2 = $ad->name2;
                    $a->name3 = $ad->name3;
                    $a->street = $ad->street;
                    $a->zip = $ad->zip;
                    $a->town = $ad->town;
                    $a->countryCode = $ad->country_code;
                    $a->type = (object)$ad->type;
                    $a->connections = (object) $ad->connections;
                    $a->remarks = (object) $ad->remarks;
                    $this->addresses[] = $a;
                }
                $contacts = collect();
                $this->contacts = [];
                if (!empty($acc->contacts) && sizeof($acc->contacts) > 0) {
                    foreach ($acc->contacts as $contact) {
                        $contact->menu = false; // needed in order toggle context menu in frontend (AccountContacts.vue)
                        $contacts->push((object)$contact);
                    }
                    // sort adhoc -> name
                    $contacts = $contacts->groupBy('is_adhoc');
                    // boolean groups to array['0', '1']
                    $contacts = $contacts->sortBy('is_adhoc');
                    if($contacts->get(0)) { // regular first
                        $this->contacts = array_merge($this->contacts, $contacts->get(0)->sortBy('lastname')->toArray());
                    }
                    if($contacts->get(1)) { // adhoc second
                        $this->contacts = array_merge($this->contacts, $contacts->get(1)->sortBy('lastname')->toArray());
                    }
                }
                $this->communications = [];
                foreach ($acc->communications as $com) {
                    $c = new \stdClass();
                    $c->id = $com->id;
                    $c->date = $com->date;
                    $c->account = (object)$com->account;
                    $c->contact = (object)$com->contact;
                    $c->user = (object)$com->user;
                    $c->type = (object)$com->type;
                    $c->memo = $com->memo;
                    $this->communications[] = $c;
                }
            }
        };
    }

}
