<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceAttach;
use App\Models\Invoices;
use App\Models\InvoicesAttachments;
use Illuminate\Http\Request;

class InvoicesAttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(InvoiceAttach $invoiceAttach)
    {
        $invoice = Invoices::find($invoiceAttach->id);
        if ($invoiceAttach->hasFile('pic')) {
            $image = $invoiceAttach->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $invoiceAttach->invoice_number;
            $attachments = new InvoicesAttachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_id = $invoice->id;
            $attachments->save();

            // move pic
            $imageName = $invoiceAttach->pic->getClientOriginalName();
            $invoiceAttach->pic->move(public_path('Attachments/' . $invoice->invoice_number), $imageName);
        }
        return redirect()->route('invoices.show', $invoice->id)->with([
            'success' => 'تمت اضافة المرفق بنجاح'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvoicesAttachments  $invoicesAttachments
     * @return \Illuminate\Http\Response
     */
    public function show(InvoicesAttachments $invoicesAttachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoicesAttachments  $invoicesAttachments
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoicesAttachments $invoicesAttachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvoicesAttachments  $invoicesAttachments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoicesAttachments $invoicesAttachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoicesAttachments  $invoicesAttachments
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $invoiceAtt = InvoicesAttachments::find($id);
        unlink(public_path('Attachments/' . $invoiceAtt->invoice->invoice_number . '/') .  $invoiceAtt->file_name);
        InvoicesAttachments::destroy($id);
        return redirect()->route('invoices.show', $invoiceAtt->invoice->id)->with([
            'delete' => 'تم حدف المرفق بنجاح'
        ]);
    }
}
