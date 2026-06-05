<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\AddressRequest;
use App\Http\Requests\Customer\BillingRequest;
use App\Http\Requests\Customer\CreateRequest;
use App\Http\Requests\Customer\EditRequest;
use App\Models\ColonyModel;
use App\Models\CustomerAddressModel;
use App\Models\CustomerBillingModel;
use App\Models\CustomerModel;
use App\Models\QuoteModel;
use App\Models\ShippingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Account extends Controller
{
    # reload
    public function reload()
    {
        return view('customer.record');
    }

    public function create(CreateRequest $request)
    {
        $data = $request->only('firstname', 'lastname', 'phone', 'email', 'password', 'terms');

        $data['password'] = Hash::make($data['password']);

        $user = CustomerModel::create($data);

        Auth::guard('customer')->login($user);

        return response(['redirect' => route('cliente/cuenta')], 201);
    }

    public function account()
    {
        $data = CustomerModel::find(Auth::guard('customer')->id())->makeVisible('password')->toArray();

        return view('customer.account.index', compact('data'));
    }

    public function account_record()
    {
        $data = CustomerModel::find(Auth::guard('customer')->id())->toArray();

        return view('customer.account.record', compact('data'));
    }

    public function account_edit()
    {
        $data = CustomerModel::find(Auth::guard('customer')->id())->toArray();

        return view('customer.account.edit', compact('data'));
    }

    public function account_update(EditRequest $request)
    {
        $data = $request->only('firstname', 'lastname', 'phone');

        CustomerModel::find(Auth::guard('customer')->id())->update($data);

        return $this->account_record();
    }

    public function address()
    {
        $data = CustomerAddressModel::where('customer_id', Auth::guard('customer')->id())->firstOrEmpty()->toArray();

        return view('customer.address.index', compact('data'));
    }

    public function address_record()
    {
        $data = CustomerAddressModel::where('customer_id', Auth::guard('customer')->id())->firstOrEmpty()->toArray();

        return view('customer.address.record', compact('data'));
    }

    public function address_add()
    {
        return view('customer.address.add');
    }

    public function address_save(AddressRequest $request)
    {
        $data = $request->only('customer_id', 'name', 'phone', 'email', 'street', 'streets', 'reference', 'colony', 'city', 'state', 'country', 'zc');

        CustomerAddressModel::create($data);

        return $this->address_record();
    }

    public function address_edit($id)
    {
        $data = CustomerAddressModel::find($id)->toArray();

        return view('customer.address.edit', compact('data'));
    }

    public function address_update(AddressRequest $request)
    {
        $data = $request->only('customer_id', 'name', 'phone', 'email', 'street', 'streets', 'reference', 'colony', 'city', 'state', 'country', 'zc');

        CustomerAddressModel::find($request->id)->update($data);

        return $this->address_record();
    }

    public function address_location(Request $request)
    {
        $request->validate(['zc' => 'required|digits:5|exists:up_colony,zc'], [], ['zc' => 'código postal']);

        $colonies = ColonyModel::where('zc', $request->zc)->get();

        $colony = $colonies->first();

        $data['zc'] = $colony->zc;
        $data['city'] = $colony->city->name;
        $data['state'] = $colony->city->state->name;
        $data['colonies'] = $colonies->pluck('name', 'id')->toArray();

        return view('partials.location', compact('data'));
    }

    public function quote()
    {
        $data = QuoteModel::where('customer_id', Auth::guard('customer')->id())->orderByDesc('id')->get()->toArray();

        return view('customer.quote.index', compact('data'));
    }

    public function quote_see($id)
    {
        $data = QuoteModel::with('products')->find($id)->toArray();

        return view('customer.quote.see', compact('data'));
    }

    public function shipping()
    {
        $data = ShippingModel::where('customer_id', Auth::guard('customer')->id())->orderByDesc('id')->get()->toArray();

        return view('customer.shipping.index', compact('data'));
    }

    public function shipping_see($id)
    {
        $data = ShippingModel::with('products')->find($id)->toArray();

        return view('customer.shipping.see', compact('data'));
    }

    public function billing()
    {
        $data = CustomerBillingModel::where('customer_id', Auth::guard('customer')->id())->firstOrEmpty()->toArray();

        return view('customer.billing.index', compact('data'));
    }

    public function billing_record()
    {
        $data = CustomerBillingModel::where('customer_id', Auth::guard('customer')->id())->firstOrEmpty()->toArray();

        return view('customer.billing.record', compact('data'));
    }

    public function billing_add()
    {
        return view('customer.billing.add');
    }

    public function billing_save(BillingRequest $request)
    {
        $data = $request->only('customer_id', 'name', 'rfc', 'regime', 'phone', 'email', 'zc');

        CustomerBillingModel::create($data);

        return $this->billing_record();
    }

    public function billing_edit($id)
    {
        $data = CustomerBillingModel::find($id)->toArray();

        return view('customer.billing.edit', compact('data'));
    }

    public function billing_update(BillingRequest $request)
    {
        $data = $request->only('customer_id', 'name', 'rfc', 'regime', 'phone', 'email', 'zc');

        CustomerBillingModel::find($request->id)->update($data);

        return $this->billing_record();
    }
}