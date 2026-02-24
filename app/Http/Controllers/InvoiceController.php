<?php

namespace App\Http\Controllers;

use App\Models\Carmake;
use App\Models\Carmodel;
use App\Models\Category;
use App\Models\City;
use App\Models\Invoice;
use App\Models\Listing;
use App\Models\Package;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arr['invoices'] = Invoice::all();
        $arr['listings'] = Listing::where('user_id', Auth::id());
        return view ('user.invoice_list')->with ($arr);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        $arr['categories'] = Category::all();
        $arr['cities'] = City::all();
        $arr['makes'] = Carmake::all();
        $arr['models'] = Carmodel::all();
        $arr['listing'] = Listing::all();
        $arr['vehicle'] = Vehicle::all();
        $arr['packages'] = Package::all();
        $arr['invoice'] = $invoice;

        return view('user.show_invoice')->with($arr);
    }

    public function generated_invoice(Invoice $invoice) 
    {
        $invoiced = Invoice::findorFail($invoice);
        $data = ['invoice' => $invoiced];
        $pdf = Pdf::loadView('user.invoice_pdf', $data);
        return $pdf->download('invoice.pdf');
    }
    
    public function generatePDF(Invoice $invoice)
    {
        $arr['categories'] = Category::all();
        $arr['cities'] = City::all();
        $arr['makes'] = Carmake::all();
        $arr['models'] = Carmodel::all();
        $arr['listing'] = Listing::all();
        $arr['vehicle'] = Vehicle::all();
        $arr['packages'] = Package::all();
        $arr['invoice'] = $invoice;
  
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y'),
            'invoice' => $invoice
        ]; 
            
        $pdf = PDF::loadView('user.invoice_pdf', $data);
     
        return $pdf->download('itsolutionstuff.pdf');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
    
}
