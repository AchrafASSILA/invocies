<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoicesRequest;
use App\Models\Invoices;
use App\Models\InvoicesAttachments;
use App\Models\Sections;
use App\Models\User;
use App\Notifications\AddInvocieNotification;
use App\Notifications\addInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Notification;
use phpDocumentor\Reflection\Types\This;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoices::all();
        return view('invoices.invoices', compact('invoices'));
    }

    // get qll products filtered by section id and returns it  
    public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
        return json_encode($products);
    }
    // get qll invoices filtered by status and returns it  
    public function getInvoicesByStatus(string $status)
    {
        $invoices = Invoices::where('Status', $status)->get();
        return view('invoices.invoices_status', compact('invoices'));
    }
    // get all invoices archived by soft deletes 
    public function getInvoicesArchived()
    {
        $invoices = Invoices::onlyTrashed()->get();
        return view('invoices.invoices_archived', compact('invoices'));
    }
    // update invoice status 
    // 1 -> paid 
    // 2 -> unpaid 
    // 3 -> Partially driven 
    public function updateStatus(Request $request, int $id)
    {
        $invoice = Invoices::find($id) ? Invoices::find($id) : Invoices::withTrashed()->find($id);
        $value_status = 'مدفوعة جزئيا';
        if ($request->value_status == 1) :
            $value_status = 'مدفوعة';
        elseif ($request->value_status == 2) :
            $value_status = 'غير مدفوعة';
        endif;
        $invoice->update([
            'Status' => $value_status,
            'Value_Status' => $request->value_status
        ]);
        return redirect()->route('invoices.index')->with([
            'success' => 'تمت تحديث حالة الفاتورة بنجاح'
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Sections::all();
        return view('invoices.create_invoice', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoicesRequest $invoicesRequest)
    {
        $invoice =  Invoices::create([
            'invoice_number' => $invoicesRequest->invoice_number,
            'invoice_Date' => $invoicesRequest->invoice_Date,
            'Due_date' => $invoicesRequest->Due_date,
            'section_id' => $invoicesRequest->section_id,
            'product' => $invoicesRequest->product,
            'Amount_borrowed' => $invoicesRequest->Amount_borrowed,
            'Amount_collection' => $invoicesRequest->Amount_collection,

            'note' => $invoicesRequest->note,
        ]);


        if ($invoicesRequest->hasFile('pic')) {
            $image = $invoicesRequest->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $invoicesRequest->invoice_number;
            $attachments = new InvoicesAttachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_id = $invoice->id;
            $attachments->save();

            // move pic
            $imageName = $invoicesRequest->pic->getClientOriginalName();
            $invoicesRequest->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }
        // $user = auth()->user();

        $user = User::get();
        Notification::send($user, new addInvoice($invoice));
        Notification::send($user, new AddInvocieNotification($invoice));
        return redirect()->route('invoices.index')->with([
            'success' => 'تمت اضافة الفاتورة بنجاح'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {

        $invoice = Invoices::find($id);
        $attachments = InvoicesAttachments::where('invoice_id', $id)->get();

        return view('invoices.show_invoice', compact('invoice', 'attachments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $invoice = Invoices::find($id)->first();
        $sections = Sections::all();
        return view('invoices.edit_invoice', compact('invoice', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(InvoicesRequest $invoicesRequest, int $id)
    {
        $invoice = Invoices::find($id);

        $invoice->update([
            'Due_date' => $invoicesRequest->Due_date,
            'section_id' => $invoicesRequest->section_id,
            'product' => $invoicesRequest->product,
            'Amount_borrowed' => $invoicesRequest->Amount_borrowed,
            'Amount_collection' => $invoicesRequest->Amount_collection,
            'note' => $invoicesRequest->note
        ]);
        return redirect()->route('invoices.index')->with([
            'success' => 'تمت تعديل الفاتورة بنجاح'
        ]);
    }
    public function transformToArchived(int $id)
    {
        $invoice = Invoices::find($id);
        $invoice->delete();
        return redirect()->route('invoices.index')->with([
            'success' => 'تم نقل الفاتورة بنجاح'
        ]);
    }
    // print invoice function 
    public function printInvoice(int $id)
    {
        $invoice = Invoices::find($id) ? Invoices::find($id) : Invoices::withTrashed()->find($id);
        return view('invoices.print_invoice', compact('invoice'));
    }
    // transform invoicefrom archived to invoices 
    public function restoreInvoice(Request $request, int $id)
    {
        $invoice = Invoices::withTrashed()->find($id);
        $invoice->restore();
        return redirect()->route('invoices.index')->with([
            'success' => 'تم نقل الفاتورة بنجاح'
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $invoice = Invoices::find($id);
        FacadesFile::deleteDirectory(public_path('Attachments/' . $invoice->invoice_number));
        $invoice->forceDelete();
        return redirect()->route('invoices.index')->with([
            'delete' => 'تم حدف الفاتورة بنجاح'
        ]);
    }
    public function markAllNotificationsAsRead(Request $request)
    {
        $notifications = auth()->user()->unreadNotifications;
        if ($notifications) {
            $notifications->markAsRead();
            return back();
        }
    }
}
