<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class AdminInvoiceController extends Controller
{
    public function index()
    {
        $arr['invoices'] = Invoice::all();

        return view('admin.invoice.index')->with($arr);
    }
    public function invoice_edit( Invoice $invoice)
    {
        $arr['invoice'] = $invoice;
        
        return view('admin.invoice.edit')->with($arr);
    }
    public function invoice_update(Request $request, Invoice $invoice)
    {
        $invoice->status = $request->invoice_status;
        $invoice->update();
        return redirect() -> route('admin.invoice.invoice_edit',$invoice->id)->with('success','Succesfully Update');

    }

}
