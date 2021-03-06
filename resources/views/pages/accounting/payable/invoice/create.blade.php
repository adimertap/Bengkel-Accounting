@extends('layouts.Admin.adminaccounting')

@section('content')
{{-- HEADER --}}
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon" style="color: white"><i
                                    class="fas fa-file-invoice-dollar"></i>
                            </div>
                            <div class="page-header-subtitle mr-2" style="color: white">Edit Data Invoice Supplier
                            </div>
                        </h1>
                        <div class="small">
                            <span class="font-weight-500">Invoice</span>
                            · Tambah · Data
                            <span class="font-weight-500 text-primary" id="id_bengkel"
                                style="display:none">{{ Auth::user()->bengkel->id_bengkel}}</span>
                        </div>
                    </div>
                    <div class="col-12 col-xl-auto">
                        <a href="{{ route('invoice-payable.index') }}"
                            class="btn btn-sm btn-light text-primary">Kembali</a>
                    </div>
                </div>
            </div>
            <div class="alert alert-danger" id="alertsparepartkosong" role="alert" style="display:none"><i
                    class="far fa-times-circle"></i>
                <span class="small">Error! Terdapat Data yang Masih Kosong!</span>
                <button class="close" type="button" onclick="$(this).parent().hide()" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        </div>
    </header>


    <div class="container mt-n10">
        <div class="row">
            <div class="col-lg-7">
                <div class="card mb-4">
                    <div class="card card-header-actions">
                        <div class="card-header ">Form Invoice
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('invoice-payable.store') }}" id="form1" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="kode_invoice">Kode Invoice</label>
                                    <input class="form-control" id="kode_invoice" type="text" name="kode_invoice"
                                        placeholder="Input Kode Invoice" value="{{ $invoice->kode_invoice }}" readonly />
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="id_jenis_transaksi">Jenis Transaksi</label>
                                    <input class="form-control" id="id_jenis_transaksi" type="text"
                                        name="id_jenis_transaksi" placeholder="Input Kode Invoice"
                                        value="{{ $invoice->Jenistransaksi->nama_transaksi }}" readonly />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="small mb-1 mr-1" for="tanggal_invoice">Tanggal Invoice</label><span
                                        class="mr-4 mb-3" style="color: red">*</span>
                                    <input class="form-control" id="tanggal_invoice" type="date" name="tanggal_invoice"
                                        placeholder="Input Tanggal Invoice" value="<?php echo date('Y-m-d'); ?>"
                                        class="form-control @error('tanggal_invoice') is-invalid @enderror" />
                                    @error('tanggal_invoice')<div class="text-danger small mb-1">{{ $message }}
                                    </div> @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="small mb-1 mr-1" for="tenggat_invoice">Tanggal Bayar
                                        Terakhir</label><span class="mr-4 mb-3" style="color: red">*</span>
                                    <input class="form-control" id="tenggat_invoice" type="date" name="tenggat_invoice"
                                        placeholder="Input Tanggal Bayar Terakhir"
                                        value="{{ $invoice->tenggat_invoice }}"
                                        class="form-control @error('tenggat_invoice') is-invalid @enderror" />
                                    @error('tenggat_invoice')<div class="text-danger small mb-1">{{ $message }}
                                    </div> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="small mb-1" for="deskripsi_invoice">Deskripsi Keperluan</label>
                                <textarea class="form-control" id="deskripsi_invoice" type="text"
                                    name="deskripsi_invoice" placeholder="" value="{{ $invoice->deskripsi_invoice }}"
                                    class="form-control @error('deskripsi_invoice') is-invalid @enderror">{{ $invoice->deskripsi_invoice }} </textarea>
                            </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card mb-4">
                    <div class="card-header">Detail Invoice
                    </div>
                    <div class="card-body">
                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label class="small mb-1" for="id_rcv">Kode Receiving</label>
                                <input class="form-control" id="id_rcv" type="text" name="id_rcv"
                                    placeholder="Input Kode Invoice" value="{{ $invoice->Rcv->kode_rcv }}" readonly />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="small mb-1" for="id_supplier">Supplier</label>
                                <input class="form-control" id="id_supplier" type="text" name="id_supplier"
                                    placeholder="Input Kode Invoice"
                                    value="{{ $invoice->Rcv->Supplier->nama_supplier }}" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="small mb-1" for="kode_po">Kode PO</label>
                                <input class="form-control" id="kode_po" type="text" name="kode_po"
                                    placeholder="Input Kode Invoice" value="{{ $invoice->Rcv->PO->kode_po }}"
                                    readonly />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="small mb-1" for="alamat_supplier">Alamat Supplier</label>
                                <input class="form-control" id="alamat_supplier" type="text" name="alamat_supplier"
                                    placeholder="Input Kode Invoice"
                                    value="{{ $invoice->Rcv->Supplier->alamat_supplier }}" readonly />
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <hr>
                            <a href="{{ route('invoice-payable.index') }}" class="btn btn-sm btn-light">Kembali</a>
                            <button class="btn btn-primary btn-sm" type="button" data-toggle="modal"
                                data-target="#Modalsumbit">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="card card-header-actions">
                <div class="card-header ">Detail Penerimaan
                </div>
            </div>
            <div class="card-body">

                <div class="datatable">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-hover dataTable" id="dataTableDetail"
                                    width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info"
                                    style="width: 100%;">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending"
                                                style="width: 20px;">No</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 60px;">Kode Sparepart</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 150px;">Nama Sparepart</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 50px;">Merk</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 30px;">Qty</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 50px;">Harga Sparepart</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 50px;">Total Harga</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 50px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($invoice->Rcv->Detailrcv as $item)
                                        <tr id="sparepart-{{ $item->id_sparepart }}" role="row" class="odd">
                                            <th scope="row" class="small" class="sorting_1">
                                                {{ $loop->iteration}}</th>
                                            <td class="kode_sparepart">{{ $item->kode_sparepart }}</td>
                                            <td class="nama_sparepart">{{ $item->nama_sparepart }}</td>
                                            <td class="merk_sparepart">{{ $item->Merksparepart->merk_sparepart }}</td>
                                            <td class="qty_rcv">{{ $item->pivot->qty_rcv }}</td>
                                            <td class="harga_diterima">
                                                Rp.{{ number_format($item->pivot->harga_diterima,2,',','.') }}</td>
                                            <td class="total_harga">
                                                Rp.{{ number_format($item->pivot->total_harga,2,',','.') }}</td>
                                            <td class="text-center">
                                                <div id="buttonclosetable-{{ $item->id_sparepart }}">
                                                    <button id="{{ $item->kode_sparepart }}-button"
                                                        class="btn btn-success btn-datatable" type="button"
                                                        data-toggle="modal"
                                                        data-target="#Modaltambah-{{ $item->id_sparepart }}">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </td>

                                        </tr>
                                        @empty

                                        @endforelse
                                    </tbody>
                                    <tr id="grandtotal">
                                        <td colspan="6" class="text-center font-weight-500">
                                            Total Harga
                                        </td>
                                        <td colspan="2" class="grand_total">
                                            Rp.{{ number_format($invoice->Rcv->grand_total,2,',','.') }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-3">
        <div class="card">
            <div class="card card-header-actions">
                <div class="card-header ">Detail Invoice Setelah Pengecekan
                </div>
            </div>
            <div class="card-body">

                <div class="datatable">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-hover dataTable" id="dataTableInvoice"
                                    width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info"
                                    style="width: 100%;">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending"
                                                style="width: 20px;">No</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 60px;">Kode Sparepart</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 150px;">Nama Sparepart</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 30px;">Qty</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 50px;">Harga Sparepart</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 50px;">Total Harga</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 50px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="konfirmasi">
                                        @forelse ($invoice->Detailinvoice as $detail)
                                        <tr id="gas-{{ $detail->id_sparepart }}" role="row" class="odd">
                                            {{-- <th scope="row" class="small" class="sorting_1">{{ $loop->iteration}}
                                            </th> --}}
                                            <td></td>
                                            <td class="kode_sparepartedit"><span id="{{ $detail->kode_sparepart }}">{{ $detail->kode_sparepart }}</span></td>
                                            <td class="nama_sparepartedit"><span id="{{ $detail->id_sparepart }}">{{ $detail->nama_sparepart }}</span>
                                            <td class="qtyedit">{{ $detail->pivot->qty_rcv }}</td>
                                            <td class="total_hargaedit">Rp {{ number_format($detail->pivot->harga_item,2,',','.')}}</td>
                                            <td class="total_hargaedit">Rp {{ number_format($detail->pivot->total_harga,2,',','.')}}</td>
                                            <td>

                                            </td>
                                        </tr>
                                        @empty

                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</main>


@forelse ($invoice->Rcv->Detailrcv as $item)
<div class="modal fade" id="Modaltambah-{{ $item->id_sparepart }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary-soft">
                <h5 class="modal-title" id="exampleModalCenterTitle">Pengecekan Invoice Penerimaan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"
                    id="buttonclose-{{ $item->id_sparepart }}"><span aria-hidden="true">×</span></button>
            </div>
            <form action="" method="POST" id="form-{{ $item->id_sparepart }}" class="d-inline">
                <div class="modal-body">
                    <div class="small mb-2">
                        <span class="font-weight-500 text-primary">{{ $item->nama_sparepart }}</span>
                    </div>
                    <div class="small mb-2">
                        <span class="text-muted">Pengecekan Quantitiy dan Harga Penerimaan</span>
                    </div>
                    <div class="form-group">
                        <label class="small mb-1 mr-1" for="qty_rcv">Qty Penerimaan</label>
                        <input class="form-control" name="qty_rcv" type="number" id="qty_rcv" min="1"
                            placeholder="Input Jumlah Pesanan" value="{{ $item->pivot->qty_rcv }}"></input>
                    </div>
                    <div class="form-group">
                        <label class="small mb-1 mr-1" for="harga_diterima">Harga Diterima</label>
                        <input class="form-control harga_diterima" name="harga_diterima" type="number"
                            id="harga_diterima" min="1000" placeholder="Input Harga"
                            value="{{ $item->pivot->harga_diterima }}">
                        </input>
                        <div class="small text-primary">Detail Harga (IDR):
                            <span id="detailhargaditerima" class="detailhargaditerima">Rp.
                                {{ number_format($item->pivot->harga_diterima,2,',','.')}}</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-success" onclick="tambahinvoice(event, {{ $item->id_sparepart }})"
                        type="button">Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@empty
@endforelse


{{-- MODAL KONFIRMASI --}}
<div class="modal fade" id="Modalsumbit" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success-soft">
                <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi Invoice</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">Apakah Form Invoice yang Anda inputkan sudah benar?</div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="button" data-dismiss="modal"
                    onclick="submit(event,{{ $invoice->Rcv->Detailrcv }},{{ $invoice->id_payable_invoice }})">Ya!Sudah</button>
            </div>
        </div>
    </div>
</div>


<template id="template_delete_button">
    <button class="btn btn-danger btn-datatable" onclick="hapussparepart(this)" type="button">
        <i class="fas fa-trash"></i>
    </button>
</template>

<template id="template_add_button">
    <button class="btn btn-success btn-datatable" type="button" data-toggle="modal" data-target="#Modaltambah">
        <i class="fas fa-plus"></i>
    </button>
</template>


<script>
    function submit(event, sparepart, id_payable_invoice) {
        console.log(id_payable_invoice)
        event.preventDefault()
        var form1 = $('#form1')
        var kode_invoice = form1.find('input[name="kode_invoice"]').val()
        var id_jenis_transaksi = $('#id_jenis_transaksi').val()
        var tanggal_invoice = form1.find('input[name="tanggal_invoice"]').val()
        var tenggat_invoice = form1.find('input[name="tenggat_invoice"]').val()
        var deskripsi_invoice = form1.find('textarea[name="deskripsi_invoice"]').val()
        var dataform2 = []
        var _token = form1.find('input[name="_token"]').val()
        // var grand_total = $(formgrandtotal.find('.grand_total')[0]).html()
        // var total_pembayaran = grand_total.split('Rp.')[1].replace('.', '').replace('.', '').replace(',00', '')

        var datasparepart = $('#konfirmasi').children()
        for (let index = 0; index < datasparepart.length; index++) {
            var children = $(datasparepart[index]).children()
            var td = children[1]
            var span = $(td).children()[0]
            var id = $(span).attr('id')

            var tds = children[2]
            var spans = $(tds).children()[0]
            var id_sparepart = $(spans).attr('id')

            if (id_sparepart == undefined | id_sparepart == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Anda Belum Memilih Penerimaan',
                })
            } else {
                var tdqty = children[3]
                var qty = $(tdqty).html()

                var tdharga = children[4]
                var getharga = $(tdharga).html()
                var hargafix = getharga.split('Rp')[1].replace('&nbsp;', '').replace('.', '').replace('.', '').replace(
                    ',00', '').trim()

                var tdhtotalarga = children[5]
                var gethargatotal = $(tdhtotalarga).html()
                var hargatotalfix = gethargatotal.split('Rp')[1].replace('&nbsp;', '').replace('.', '').replace('.', '')
                    .replace(',00', '').trim()

                var obj = {
                    id_sparepart: id_sparepart,
                    id_payable_invoice: id_payable_invoice,
                    qty_rcv: qty,
                    harga_item: hargafix,
                    total_harga: hargatotalfix
                }
                dataform2.push(obj)
            }
        }

        if (dataform2.length == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Anda Belum Memilih Data Penerimaan',
                timer: 2000,
                timerProgressBar: true,
            })
        } else if (tanggal_invoice == '' | tenggat_invoice == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Anda Belum Mengisi Tenggat Bayar',
                timer: 2000,
                timerProgressBar: true,
            })
        } else {
            var sweet_loader =
                '<div class="sweet_loader"><svg viewBox="0 0 140 140" width="140" height="140"><g class="outline"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="rgba(0,0,0,0.1)" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round"></path></g><g class="circle"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="#71BBFF" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-dashoffset="200" stroke-dasharray="300"></path></g></svg></div>';

            var data = {
                _token: _token,
                kode_invoice: kode_invoice,
                id_jenis_transaksi: id_jenis_transaksi,
                tanggal_invoice: tanggal_invoice,
                tenggat_invoice: tenggat_invoice,
                deskripsi_invoice: deskripsi_invoice,
                sparepart: dataform2
            }

            $.ajax({
                method: 'put',
                url: '/Accounting/invoice-payable/' + id_payable_invoice,
                data: data,
                beforeSend: function () {
                    swal.fire({
                        title: 'Mohon Tunggu!',
                        html: 'Data Invoice Sedang Diproses...',
                        showConfirmButton: false,
                        onRender: function () {
                            // there will only ever be one sweet alert open.
                            $('.swal2-content').prepend(sweet_loader);
                        }
                    });
                },
                success: function (response) {
                    swal.fire({
                        icon: 'success',
                        showConfirmButton: false,
                        html: '<h5>Success!</h5>'
                    });
                    window.location.href = '/Accounting/invoice-payable'

                },
                error: function (response) {
                    console.log(response)
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: '<h5>Error!</h5>'
                    });
                }
            });
        }
    }

    function tambahinvoice(event, id_sparepart) {
        var form = $('#form-' + id_sparepart)
        var qty_rcv_tes = form.find('input[name="qty_rcv"]').val()
        var harga_item_tes = form.find('input[name="harga_diterima"]').val()
        var total_harga = qty_rcv_tes * harga_item_tes
        var total_harga_fix = new Intl.NumberFormat('id', {
            style: 'currency',
            currency: 'IDR'
        }).format(total_harga)
        var harga_item = new Intl.NumberFormat('id', {
            style: 'currency',
            currency: 'IDR'
        }).format(harga_item_tes)

        if (qty_rcv_tes == 0 | qty_rcv_tes == '' | harga_item_tes == '' | harga_item_tes == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Terdapat Field Data Kosong!',
            })
        } else {
            var data = $('#sparepart-' + id_sparepart)
            var kode_sparepart = $(data.find('.kode_sparepart')[0]).text()
            var nama_sparepart = $(data.find('.nama_sparepart')[0]).text()
            var qty_rcv = $(data.find('.qty_rcv')[0]).text()
            var harga_diterima = $(data.find('.harga_diterima')[0]).text()
            // var total_harga = $(data.find('.total_harga')[0]).text()
            var template = $($('#template_delete_button').html())

            var table = $('#dataTableInvoice').DataTable()
            var row = $(`#${$.escapeSelector(kode_sparepart.trim())}`).parent().parent()
            table.row(row).remove().draw();

            $('#dataTableInvoice').DataTable().row.add([
                kode_sparepart, `<span id=${kode_sparepart}>${kode_sparepart}</span>`,
                `<span id=${id_sparepart}>${nama_sparepart}</span>`, qty_rcv_tes,
                harga_item, total_harga_fix,
                kode_sparepart
            ]).draw();

            $(`#buttonclose-${id_sparepart}`).click()

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: 'Berhasil Menambahkan Data Penerimaan'
            })
        }
    }

    function hapussparepart(element) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var table = $('#dataTableInvoice').DataTable()
                var row = $(element).parent().parent()
                table.row(row).remove().draw();
                var table = $('#dataTable').DataTable()
                var row2 = $(element).parent().parent()
            }
        })


    }

    $(document).ready(function () {
        $('.harga_diterima').each(function () {
            $(this).on('input', function () {
                var harga = $(this).val()
                var harga_fix = new Intl.NumberFormat('id', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(harga)

                var harga_paling_fix = $(this).parent().find('.detailhargaditerima')
                $(harga_paling_fix).html(harga_fix);
            })
        })

        var tablercv = $('#dataTableRcv').DataTable()
        var tabledetail = $('#dataTableDetail').DataTable()

        var template = $('#template_delete_button').html()
        $('#dataTableInvoice').DataTable({
            "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": template
                },
                {
                    "targets": 0,
                    "data": null,
                    'render': function (data, type, row, meta) {
                        return meta.row + 1
                    }
                }
            ]
        });

    });

</script>


@endsection
