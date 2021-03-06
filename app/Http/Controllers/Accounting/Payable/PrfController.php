<?php

namespace App\Http\Controllers\Accounting\Payable;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\Prf\Statusbayar;
use App\Model\Accounting\Bankaccount;
use App\Model\Accounting\Fop;
use App\Model\Accounting\Jenistransaksi;
use App\Model\Accounting\Payable\InvoicePayable;
use App\Model\Accounting\Prf\Prf;
use App\Model\Accounting\Prf\PrfDetail;
use App\Model\Inventory\Retur\Retur;
use App\Model\Inventory\Supplier;
use App\Model\Kepegawaian\Pegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prf = Prf::with([
            'Jenistransaksi','Supplier','FOP','Akunbank'
        ])->where('status_aktif', 'Aktif')->get();

        $id = Prf::getId();
        foreach($id as $value);
        $idlama = $value->id_prf;
        $idbaru = $idlama + 1;
        $blt = date('m');

        $kode_prf = 'PRF-'.$idbaru.'/'.$blt;

        $jenis_transaksi = Jenistransaksi::all();
        $supplier = Supplier::all();

        $today = Carbon::now()->isoFormat('dddd');
        $tanggal = Carbon::now()->format('j F Y');

        return view('pages.accounting.payable.prf.prf', compact('prf','jenis_transaksi','supplier','kode_prf','today','tanggal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jenis_transaksi = Jenistransaksi::all();
        $pegawai = Pegawai::all();
        $supplier = Supplier::all();
        $fop = Fop::all();
        $akun_bank = Bankaccount::all();

        $id = Prf::getId();
        foreach($id as $value);
        $idlama = $value->id_prf;
        $idbaru = $idlama + 1;
        $blt = date('m');

        $kode_prf = 'AKPRF-'.$idbaru.'/'.$blt;

        return view('pages.accounting.payable.prf.create', compact('jenis_transaksi','pegawai','supplier','fop','akun_bank','kode_prf')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $supplier = Supplier::where('nama_supplier',$request->nama_supplier)->first();
        $id_supplier = $supplier->id_supplier;

        $invoice = InvoicePayable::where('id_supplier', $id_supplier)->where('status_prf', 'Belum Dibuat')->where('status_aktif', 'Aktif')->first();

        if (empty($invoice)){
            throw new \Exception('Tidak Terdapat Invoice');
        }else{
            $prf = Prf::create([
                'id_jenis_transaksi'=>'4',
                'id_supplier'=>$id_supplier,
                'kode_prf'=> $request->kode_prf,
                'id_bengkel' => $request['id_bengkel'] = Auth::user()->id_bengkel,
                'status_aktif' => 'Tidak Aktif'
            ]);
            
            return $prf;
        }
      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_prf)
    {
        $prf = Prf::with('Detailprf.Detailinvoice','Jenistransaksi','FOP','Akunbank','Supplier','Supplier.InvoicePayable.Detailinvoice','Supplier.InvoicePayable')->findOrFail($id_prf);

        // return $prf;

        return view('pages.accounting.payable.prf.detail')->with([
            'prf' => $prf
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_prf)
    {

        $prf = Prf::with([
            'Jenistransaksi','Supplier.InvoicePayable','Supplier.InvoicePayable.Detailinvoice','FOP','Akunbank','Detailprf','Detailprf.Detailinvoice'
        ])->find($id_prf);
        
        // return $prf;

        $jenis_transaksi = Jenistransaksi::all();
        $pegawai = Pegawai::all();
        $supplier = Supplier::all();
        $fop = Fop::all();
        $akun_bank = Bankaccount::all();
        $invoice = InvoicePayable::get();

        $id = Prf::getId();
        foreach($id as $value);
        $idlama = $value->id_prf;
        $idbaru = $idlama + 1;
        $blt = date('y-m');

        $kode_prf = 'PRF-'.$blt.'/'.$idbaru;

        return view('pages.accounting.payable.prf.create', compact('invoice','jenis_transaksi','pegawai','supplier','fop','akun_bank','kode_prf','prf'));  
    }

    public function edit2($id_prf)
    {

        $prf = Prf::with([
            'Jenistransaksi','Supplier.InvoiceEdit','Supplier.InvoiceEdit.Detailinvoice','FOP','Akunbank','Detailprf','Detailprf.Detailinvoice'
        ])->find($id_prf);
        
        // return $prf;

        $jenis_transaksi = Jenistransaksi::all();
        $pegawai = Pegawai::all();
        $supplier = Supplier::all();
        $fop = Fop::all();
        $akun_bank = Bankaccount::all();
        $invoice = InvoicePayable::where('status_aktif', 'Aktif')->get();

       

        return view('pages.accounting.payable.prf.edit', compact('invoice','jenis_transaksi','pegawai','supplier','fop','akun_bank','prf'));  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_prf)
    {
        $bank = Bankaccount::where('kode_bank', $request->kode_bank)->first();
       
        $temp = 0;
        foreach($request->invoice as $key=>$item){
           
            $invoice = InvoicePayable::findOrFail($item['id_payable_invoice']);
            $invoice->status_prf = 'Telah Dibuat';
            $invoice->save();
            
            $temp = $temp + $item['harga_invoice'];
        }
        // $id_bank_account = $bank->id_bank_account;
        
        if (empty($bank)) {
            $prf = Prf::findOrFail($id_prf);
            $prf->tanggal_prf = $request->tanggal_prf;
            $prf->keperluan_prf = $request->keperluan_prf;
            $prf->grand_total = $request->grand_total;
            $prf->id_fop = $request->id_fop;
            $prf->status_prf = 'Pending';
            $prf->status_jurnal = 'Belum Diposting';
            $prf->status_bayar = 'Belum Dibayar';
            $prf->status_aktif = 'Aktif';
            $prf->grand_total = $temp;
        }else{
            $prf = Prf::findOrFail($id_prf);
            $prf->tanggal_prf = $request->tanggal_prf;
            $prf->keperluan_prf = $request->keperluan_prf;
            $prf->grand_total = $request->grand_total;
            $prf->id_fop = $request->id_fop;
            $prf->id_bank_account = $bank->id_bank_account;
            $prf->status_prf = 'Pending';
            $prf->status_jurnal = 'Belum Diposting';
            $prf->status_bayar = 'Belum Dibayar';
            $prf->status_aktif = 'Aktif';
            $prf->grand_total = $temp;
        }

       
        $prf->save();
        $prf->Detailprf()->sync($request->invoice);
        return $request;
        
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_prf)
    {
        $prf = Prf::findOrFail($id_prf);
        PrfDetail::where('id_prf', $id_prf)->delete();
        $prf->delete();

        return redirect()->route('prf.index')->with('messagehapus','Data Prf Berhasil dihapus');
    }

    public function statusBayar(Statusbayar $request, $id_prf)
    {

        $item = Prf::findOrFail($id_prf);
        $item->status_bayar = $request->status_bayar;
        $item->tanggal_bayar = $request->tanggal_bayar;
 
        $item->save();
        return redirect()->back()->with('messagekirim','Data PRF Berhasil dibayarkan');
    }

    public function Cetakprf($id_prf){
        $prf = Prf::with('Detailprf.Detailinvoice','Jenistransaksi','FOP','Akunbank','Supplier','Supplier.InvoicePayable.Detailinvoice','Supplier.InvoicePayable')->findOrFail($id_prf);

        

        $now = Carbon::now();
        return view('print.Accounting.cetak-prf')->with([
            'prf' => $prf,
            'now' => $now
        ]);
    }
}
