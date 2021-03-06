<?php

namespace App\Http\Controllers\Accounting\Payable;

use App\Http\Controllers\Controller;
use App\Model\Accounting\Jenistransaksi;
use App\Model\Accounting\Payable\InvoicePayable;
use App\Model\Accounting\Payable\InvoicePayabledetail;
use App\Model\Inventory\Rcv\Rcv;
use App\Model\Kepegawaian\Pegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class InvoicePayableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoice = InvoicePayable::with([
            'Rcv.Detail','Rcv'
        ])->where('status_aktif', 'Aktif')->get();

        $rcv = Rcv::with([
            'PO'
        ])->where([['status_invoice', '=', 'Belum diBuat']])->where('status_aktif', 'Aktif')->get();

        $jenis_transaksi = Jenistransaksi::all();
        $today = Carbon::now()->isoFormat('dddd');
        $tanggal = Carbon::now()->format('j F Y');

        return view('pages.accounting.payable.invoice.invoice',['hutang' => InvoicePayable::where('status_prf','Belum Dibuat')->where('status_aktif', 'Aktif')->sum('total_pembayaran')], 
        compact('invoice','today','tanggal','jenis_transaksi','rcv'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rcv = Rcv::where('kode_rcv',$request->kode_rcv)->first();
        $id_rcv = $rcv->id_rcv;
        $id_supplier = $rcv->id_supplier;
        $id_po = $rcv->id_po;

        $id = InvoicePayable::getId();
        foreach($id as $value);
        $idlama = $value->id_payable_invoice;
        $idbaru = $idlama + 1;
        $blt = date('y-m');

        $kode_invoice = 'INVC-'.$blt.'/'.$idbaru;

        $invoice = InvoicePayable::create([
            'id_rcv'=>$id_rcv,
            'id_supplier'=>$id_supplier,
            'id_jenis_transaksi'=> '5',
            'id_po' => $id_po,
            'kode_invoice' => $kode_invoice,
            'status_aktif' => 'Tidak Aktif',
            'id_bengkel' => $request['id_bengkel'] = Auth::user()->id_bengkel

           
        ]);
        
        return $invoice;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_payable_invoice)
    {
        $invoice = InvoicePayable::with('Detailinvoice')->findOrFail($id_payable_invoice);

        return view('pages.accounting.payable.invoice.detail')->with([
            'invoice' => $invoice
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = InvoicePayable::with([
            'Rcv.Detailrcv','Rcv','Jenistransaksi','Detailinvoice'
        ])->find($id);

        $jenis_transaksi = Jenistransaksi::all();
        $pegawai = Pegawai::all();
        $rcv = Rcv::all();

        return view('pages.accounting.payable.invoice.create', compact('invoice','jenis_transaksi','pegawai','rcv'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_payable_invoice)
    {
        $invoice = InvoicePayable::findOrFail($id_payable_invoice);
        $invoice->kode_invoice = $request->kode_invoice;
        $invoice->id_pegawai = $request['id_pegawai'] = Auth::user()->pegawai->id_pegawai;
        $invoice->tanggal_invoice = $request->tanggal_invoice;
        $invoice->tenggat_invoice = $request->tenggat_invoice;
        $invoice->deskripsi_invoice = $request->deskripsi_invoice;
        $invoice->total_pembayaran = $request->total_pembayaran;

        $temp = 0;
            foreach($request->sparepart as $key=>$item){
                $temp = $temp + $item['total_harga'];
            }
        
        $invoice->total_pembayaran = $temp;
        $invoice->status_aktif = 'Aktif';
        $invoice->status_prf ='Belum diBuat';
        $invoice->status_jurnal ='Belum diPosting';    
        $invoice->save();

        $rcv = Rcv::where('id_rcv',$invoice->id_rcv)->first();
        $rcv->status_invoice = 'Sudah dibuat';
        $rcv->save();
        
        $invoice->Detailinvoice()->sync($request->sparepart);
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_payable_invoice)
    {
        $invoice = InvoicePayable::findOrFail($id_payable_invoice);
        InvoicePayabledetail::where('id_payable_invoice', $id_payable_invoice)->delete();
        $invoice->delete();

        return redirect()->back()->with('messagehapus','Data Invoice Berhasil dihapus');
    }

    public function CetakInvoice($id_payable_invoice)
    {
        $invoice = InvoicePayable::with('Detailinvoice','Rcv','PO','Supplier','Pegawai')->findOrFail($id_payable_invoice);
        // return $invoice;
        $now = Carbon::now();
        return view('print.Accounting.cetak-invoice', compact('invoice','now'));
    }
}
