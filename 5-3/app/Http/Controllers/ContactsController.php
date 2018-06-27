<?php

namespace App\Http\Controllers;

use App\Contact;
use DB;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    protected $view = 'notebook';

    /**
     * Handling POST
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        if ($request->has('add')) {
            return $this->update($request);
        }
        return $this->index(
            $request,
            Contact::all()
        );
    }

    /**
     * Contact add & edit
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Request $request, $id = null)
    {
        $resultHintAction = $request->has('save') ? 'updated' : 'added';
        $request->validate([
            'first_name' => 'required|max:127',
            'last_name' => 'required|max:127',
            'phone_number' => 'required|integer|max:99999999999'
        ]);
        $contact = $request->has('save') ? Contact::find($id) : new Contact();
        $contact->fill($request->all('first_name', 'last_name'));
        $contact->phone_number = (int)substr($request->phone_number, 0, 11);
        $result = $contact->save();
        $params = array(
            'operationResult' => $result === true
                ? ('Contact ' . $resultHintAction) : ('Contact has not been ' . $resultHintAction)
        );
        return $this->index(
            $request,
            Contact::all(),
            $params
        );
    }

    /**
     * Change form: add to edit
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        return $this->index(
            $request,
            Contact::all(),
            array('editContactID' => $id)
        );
    }

    /**
     * View search result
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function find($request)
    {
        $f_first_name = !$request->has('f_first_name') ? '%' : $request->f_first_name;
        $f_last_name = !$request->has('f_last_name') ? '%' : $request->f_last_name;
        $f_phone_number = !$request->has('f_phone_number')
            ? '%' : substr($request->f_phone_number, 0, 11);
        $searchResult = Contact::where('first_name', 'like', "%$f_first_name%")
            ->where('last_name', 'like', "%$f_last_name%")
            ->where('phone_number', 'like', "%$f_phone_number%")
            ->get();
        $params = array(
            'f_first_name' => $request->f_first_name,
            'f_last_name' => $request->f_last_name,
            'f_phone_number' => $request->f_phone_number
        );
        return $this->index(
            $request,
            $searchResult,
            $params
        );
    }

    /**
     * Output by id
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        return $this->index(
            $request,
            array('contacts' => Contact::findOrFail(substr($id, 0, 8)))
        );
    }

    /**
     * Output
     * @param Request $request
     * @param null|\Illuminate\Database\Eloquent\Collection|static[] $contacts
     * @param array $params
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $contacts = null, $params = [])
    {
        if ($request->has('find') && count($params) === 0) {
            return $this->find($request);
        }
        if ($contacts === null) {
            $contacts = Contact::all();
        }
        $params['contacts'] = $contacts;
        return view($this->view, $params);
    }

    /**
     * Delete
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy(Request $request, $id)
    {
        $result = Contact::destroy([$id]);
        return $this->index(
            $request,
            Contact::all(),
            array('operationResult' => $result > 0 ? 'Contact deleted' : 'Contact has not been deleted')
        );
    }
}