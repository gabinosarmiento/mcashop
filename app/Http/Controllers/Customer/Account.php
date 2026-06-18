<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\AddressRequest;
use App\Http\Requests\Customer\BillingRequest;
use App\Http\Requests\Customer\EditRequest;
use App\Models\ColonyModel;
use App\Models\CustomerAddressModel;
use App\Models\CustomerBillingModel;
use App\Models\CustomerModel;
use App\Models\QuoteModel;
use App\Models\ShippingModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Account extends Controller
{
    # account
    public function account()
    {
        $data = CustomerModel::find(auth('customer')->id())->makeVisible('password')->toArray();

        return view('customer.account.index', compact('data'));
    }

    # account_record
    public function account_record()
    {
        $data = CustomerModel::find(Auth::guard('customer')->id())->toArray();

        $view = view('customer.account.record', compact('data'));

        return response(['render' => ['record-html' => $view->render()]]);
    }

    # account_edit
    public function account_edit()
    {
        $data = CustomerModel::find(auth('customer')->id())->toArray();

        $view = view('customer.account.edit', compact('data'));

        return response(['render' => ['overlap-one' => $view->render()]]);
    }

    # account_update
    public function account_update(EditRequest $request)
    {
        $data = $request->only('firstname', 'lastname', 'phone');

        CustomerModel::find(Auth::guard('customer')->id())->update($data);

        return $this->account_record();
    }

    # address
    public function address()
    {
        $data = CustomerAddressModel::where('customer_id', auth('customer')->id())->firstOrEmpty()->toArray();

        return view('customer.address.index', compact('data'));
    }

    # address_record
    public function address_record()
    {
        $data = CustomerAddressModel::where('customer_id', auth('customer')->id())->firstOrEmpty()->toArray();

        $view = view('customer.address.record', compact('data'));

        return response(['render' => ['record-html' => $view->render()]]);
    }

    # address_add
    public function address_add()
    {
        $view = view('customer.address.add');

        return response(['render' => ['overlap-one' => $view->render()]]);
    }

    # address_add
    public function address_save(AddressRequest $request)
    {
        $data = $request->only('customer_id', 'name', 'phone', 'email', 'street', 'streets', 'reference', 'colony', 'city', 'state', 'country', 'zc');

        $user = CustomerAddressModel::create($data);

        return $this->address_record();
    }

    # address_edit
    public function address_edit($id)
    {
        $data = CustomerAddressModel::find($id)->toArray();

        $view = view('customer.address.edit', compact('data'));

        return response(['render' => ['overlap-one' => $view->render()]]);
    }

    # address_update
    public function address_update(AddressRequest $request)
    {
        $data = $request->only('customer_id', 'name', 'phone', 'email', 'street', 'streets', 'reference', 'colony', 'city', 'state', 'country', 'zc');

        CustomerAddressModel::find($request->id)->update($data);

        return $this->address_record();
    }

    public function address_location(Request $request)
    {
        $request->validate(['zc' => 'required|digits:5|exists:colony,zc'], [], ['zc' => 'código postal']);

        $colonies = ColonyModel::where('zc', $request->zc)->get();

        $colony = $colonies->first();

        $data['zc']    = $colony->zc;
        $data['city']  = $colony->city->name;
        $data['state'] = $colony->city->state->name;

        $data['colonies'] = $colonies->pluck('name', 'id')->toArray();

        $view = view('partials.location', compact('data'));

        return response(['render' => ['location-html' => $view->render()]]);
    }

    # billing
    public function billing()
    {
        $data = CustomerBillingModel::where('customer_id', Auth::guard('customer')->id())->firstOrEmpty()->toArray();

        return view('customer.billing.index', compact('data'));
    }

    # billing_record
    public function billing_record()
    {
        $data = CustomerBillingModel::where('customer_id', Auth::guard('customer')->id())->firstOrEmpty()->toArray();

        $view = view('customer.billing.record', compact('data'));

        return response(['render' => ['record-html' => $view->render()]]);
    }

    # billing_add
    public function billing_add()
    {
        $view = view('customer.billing.add');

        return response(['render' => ['overlap-one' => $view->render()]]);
    }

    # billing_add
    public function billing_save(BillingRequest $request)
    {
        $data = $request->only('customer_id', 'name', 'rfc', 'regime', 'phone', 'email', 'zc');

        $user = CustomerBillingModel::create($data);

        return $this->billing_record();
    }

    # billing_edit
    public function billing_edit($id)
    {
        $data = CustomerBillingModel::find($id)->toArray();

        $view = view('customer.billing.edit', compact('data'));

        return response(['render' => ['overlap-one' => $view->render()]]);
    }

    # billing_update
    public function billing_update(BillingRequest $request)
    {
        $data = $request->only('customer_id', 'name', 'rfc', 'regime', 'phone', 'email', 'zc');

        CustomerBillingModel::find($request->id)->update($data);

        return $this->billing_record();
    }

    public function quote()
    {
        $data = QuoteModel::where('customer_id', Auth::guard('customer')->id())->orderByDesc('id')->get()->toArray();

        return view('customer.quote.index', compact('data'));
    }

    # account_edit
    public function quote_see($id)
    {
        $data = QuoteModel::with('products')->find($id)->toArray();

        $view = view('customer.quote.see', compact('data'));

        return response(['render' => ['overlap-one' => $view->render()]]);
    }

    public function shipping()
    {
        $data = ShippingModel::where('customer_id', Auth::guard('customer')->id())->orderByDesc('id')->get()->toArray();

        return view('customer.shipping.index', compact('data'));
    }

    public function shipping_see($id)
    {
        $data = ShippingModel::with('products')->find($id)->toArray();

        $view = view('customer.shipping.see', compact('data'));

        return response(['render' => ['overlap-one' => $view->render()]]);
    }

    public function shipping_ticket($id)
    {
        $data = ShippingModel::where('customer_id', Auth::guard('customer')->id())->where('id', $id)->firstOrFail()->toArray();

        $data['expires'] = date('Y-m-d 23:59:00', strtotime('+1 day', strtotime($data['created_at'])));
        $data['expired'] = time() > strtotime($data['expires']);
        $data['printed'] = date('Y-m-d H:i:s');

        $html = view('customer.shipping.ticket', compact('data'))->render();

        $options = new Options();

        $pdf = new Dompdf($options);

        $pdf->loadHtml($html);
        $pdf->setPaper([0, 0, 250, 380]);

        $pdf->render();

        return response($pdf->output(), 200, ['Content-Type' => 'application/pdf']);
    }
}
