@extends('layouts.Admin.adminaccounting')

@section('content')
{{-- HEADER --}}
<main>
    <div class="container mt-5">
        <!-- Custom page header alternative example-->
        <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
            <div class="mr-4 mb-3 mb-sm-0">
                <h1 class="mb-0">Invoice Supplier</h1>
                <div class="small">
                    <span class="font-weight-500 text-primary">{{ $today }}</span>
                    · Tanggal {{ $tanggal }} · <span id="clock">12:16 PM</span> 
                </div>
            </div>
            <div class="small">
                <i class="fa fa-cogs" aria-hidden="true"></i>
                Bengkel
                <span class="font-weight-500 text-primary">{{ Auth::user()->bengkel->nama_bengkel}}
                @if (Auth::user()->pegawai->cabang != null)
                    {{ Auth::user()->pegawai->cabang->nama_cabang }}
                @else

                @endif
                
                </span>
                <hr>
                </hr>
            </div>
        </div>
    </div>

{{--  --}}
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card card-header-actions">
                <div class="card-header ">Data Invoice Supplier Inventory
                    <a href="" class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#Modaltambah">
                        Tambah Invoice
                    </a>
                </div>
            </div>
            <div class="card-body ">
                <div class="datatable">
                    @if(session('messageberhasil'))
                    <div class="alert alert-success" role="alert"> <i class="fas fa-check"></i>
                        {{ session('messageberhasil') }}
                        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    @endif
                    @if(session('messagejurnal'))
                    <div class="alert alert-success" role="alert"> <i class="fas fa-check"></i>
                        {{ session('messagejurnal') }}
                        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    @endif
                    @if(session('messagehapus'))
                    <div class="alert alert-danger" role="alert"> <i class="fas fa-check"></i>
                        {{ session('messagehapus') }}
                        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    @endif

                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-hover dataTable" id="dataTableUtama" width="100%"
                                    cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending"
                                                style="width: 10px;">
                                                No</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 40px;">Kode Inv.</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 30px;">Tanggal Inv.</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 50px;">Kode Rcv</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Start date: activate to sort column ascending"
                                                style="width: 80px;">Supplier</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 30px;">Tenggat Waktu</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 110px;">Total Inv.</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 40px;">Status Prf</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 40px;">Status Jurnal</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Actions: activate to sort column ascending"
                                                style="width: 140px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($invoice as $item)
                                        <tr role="row" class="odd">
                                            <th scope="row" class="small" class="sorting_1">{{ $loop->iteration}}.</th>
                                            <td>{{ $item->kode_invoice }}</td>
                                            <td>{{ $item->tanggal_invoice }}</td>
                                            <td>{{ $item->Rcv->kode_rcv }}</td>
                                            <td>{{ $item->Rcv->Supplier->nama_supplier }}</td>
                                            <td>{{ $item->tenggat_invoice }}</td>
                                            <td>Rp. {{ number_format($item->total_pembayaran,2,',','.') }}</td>
                                            <td>@if($item->status_prf == 'Belum Dibuat')
                                                <span class="badge badge-danger">
                                                    @elseif($item->status_prf == 'Telah Dibuat')
                                                    <span class="badge badge-success">
                                                        @else
                                                        <span>
                                                            @endif
                                                            {{ $item->status_prf }}
                                                        </span>
                                            </td>
                                            <td>@if($item->status_jurnal == 'Belum Diposting' && $item->status_prf == 'Belum Dibuat')
                                                <a href="" class="btn btn-danger btn-xs" type="button"
                                                    data-toggle="modal"
                                                    data-target="#Modaljurnal-{{ $item->id_payable_invoice }}">
                                                    Posting?
                                                </a>
                                                @elseif ($item->status_jurnal == 'Belum Diposting' && $item->status_prf == 'Telah Dibuat')
                                                    <span class="small"> - </span>

                                                @elseif ($item->status_jurnal == 'Sudah Diposting')
                                                <span class="badge badge-secondary">{{ $item->status_jurnal }}</span>
                                                @else
                                                <span class="badge badge-secondary">{{ $item->status_jurnal }}</span>
                                                <span>
                                                    @endif
                                                </span>
                                            </td>
                                            <td> @if($item->status_prf == 'Belum Dibuat')
                                                <a href="{{ route('invoice-payable.show',$item->id_payable_invoice) }}" class="btn btn-secondary btn-datatable" data-toggle="tooltip"
                                                    data-placement="top" title="" data-original-title="Detail Invoice">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('invoice-payable.edit', $item->id_payable_invoice) }}" class="btn btn-primary btn-datatable" data-toggle="tooltip"
                                                    data-placement="top" title="" data-original-title="Edit Invoice">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="" class="btn btn-danger btn-datatable" type="button"
                                                    data-toggle="modal"
                                                    data-target="#Modalhapus-{{ $item->id_payable_invoice }}">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                <a href="{{ route('cetak-invoice', $item->id_payable_invoice) }}" class="btn btn-warning btn-datatable" data-toggle="tooltip"
                                                    data-placement="top" title="" data-original-title="Cetak Invoice">
                                                    <i class="fas fa-print"></i></i>
                                                </a>
                                                @elseif ($item->status_prf == 'Telah Dibuat')
                                                <a href="{{ route('invoice-payable.show',$item->id_payable_invoice) }}" class="btn btn-secondary btn-datatable" data-toggle="tooltip"
                                                    data-placement="top" title="" data-original-title="Detail Invoice">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('cetak-invoice', $item->id_payable_invoice) }}" class="btn btn-warning btn-datatable" data-toggle="tooltip"
                                                    data-placement="top" title="" data-original-title="Cetak Invoice">
                                                    <i class="fas fa-print"></i></i>
                                                </a>
                                                @else
                                                @endif
                                            </td>
                                            @empty

                                            @endforelse
                                            
                                    </tbody>
                                    <tr id="grandtotal">
                                        <td colspan="6" class="text-center font-weight-500">
                                            Total Hutang Belum dibayar
                                        </td>
                                        <td colspan="5" class="grand_total text-center font-weight-500">
                                            Rp. {{ number_format($hutang,2,',','.') }}
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
</main>



{{-- MODAL TAMBAH --}}
<div class="modal fade" id="Modaltambah" tabindex="-1" role="dialog" data-backdrop="static"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Data Penerimaan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <form action="" method="POST" id="form1" class="d-inline">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-danger" id="alertdatakosong" role="alert" style="display:none"> <i
                        class="fas fa-times"></i>
                    Error! Terdapat Data yang Masih Kosong!
                    <button class="close" type="button" onclick="$(this).parent().hide()" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    </div>
                    <label class="small mb-1">Isikan Form Dibawah Ini</label>
                    <hr>
                    </hr>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="small mb-1" for="id_jenis_transaksi">Jenis Transaksi</label>
                            <input class="form-control" id="id_jenis_transaksi" type="text" name="id_jenis_transaksi"
                                placeholder="" value="Penerimaan Sparepart" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="small mb-1 mr-1" for="kode_rcv">Pilih Receiving</label><span class="mr-4 mb-3"
                                style="color: red">*</span>
                            <div class="input-group input-group-joined">
                                <input class="form-control" type="text" placeholder="Masukan Kode Receiving"
                                    aria-label="Search" id="detailkodercv">
                                <div class="input-group-append">
                                    <a href="" class="input-group-text" type="button" data-toggle="modal"
                                        data-target="#Modalrcv">
                                        <i class="fas fa-folder-open"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="small" id="alertrcv" style="display:none">
                                <span class="font-weight-500 text-danger">Error! Anda Belum Memilih Receiving</span>
                                <button class="close" type="button" onclick="$(this).parent().hide()" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label class="small mb-1" for="kode_po">Kode PO</label>
                            <input class="form-control" id="detailkodepo" type="text" name="kode_po"
                                placeholder="Otomatis Terisi" value="{{ old('kode_po') }}" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="small mb-1" for="tanggal_rcv">Tanggal Receiving</label>
                            <input class="form-control" id="detailtanggalrcv" type="text" name="tanggal_rcv"
                                placeholder="Otomatis Terisi" value="{{ old('tanggal_rcv') }}" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="small mb-1" for="id_supplier">Supplier</label>
                            <input class="form-control" id="detailsupplier" type="text" name="id_supplier"
                                placeholder="Otomatis Terisi" value="{{ old('id_supplier') }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-success" onclick="submit1()" type="button">Selanjutnya!</button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- MODAL RCV --}}
<div class="modal fade" id="Modalrcv" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light ">
                <h5 class="modal-title">Pilih Kode Receiving</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="datatable">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-hover dataTable" id="dataTableRcv"
                                    width="100%" cellspacing="0" role="grid"
                                    aria-describedby="dataTable_info" style="width: 100%;">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending"
                                                style="width: 20px;">No</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                rowspan="1" colspan="1"
                                                aria-label="Position: activate to sort column ascending"
                                                style="width: 90px;">Kode Rcv</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                rowspan="1" colspan="1"
                                                aria-label="Position: activate to sort column ascending"
                                                style="width: 60px;">Kode PO</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                rowspan="1" colspan="1"
                                                aria-label="Office: activate to sort column ascending"
                                                style="width: 50px;">Tanggal Rcv</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                rowspan="1" colspan="1"
                                                aria-label="Office: activate to sort column ascending"
                                                style="width: 50px;">Supplier</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                rowspan="1" colspan="1"
                                                aria-label="Office: activate to sort column ascending"
                                                style="width: 50px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($rcv as $item)
                                            <tr id="item-{{ $item->id_rcv }}" class="border-bottom">
                                                <th scope="row" class="small" class="sorting_1">
                                                    {{ $loop->iteration}}</th>
                                                <td class="kode_rcv">{{ $item->kode_rcv }}</td>
                                                <td class="kode_po">{{ $item->PO->kode_po }}</td>
                                                <td class="tanggal_rcv">{{ $item->tanggal_rcv }}</td>
                                                <td class="nama_supplier">{{ $item->Supplier->nama_supplier }}</td>
                                                <td>
                                                    <button class="btn btn-success btn-xs"
                                                        onclick="tambahrcv(event, {{ $item->id_rcv }})" type="button"
                                                        data-dismiss="modal">Tambah
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                Data Receiving Kosong
                                            </td>
                                        </tr>
                                        @endforelse

                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- MODAL HAPUS --}}
@forelse ($invoice as $item)
<div class="modal fade" id="Modalhapus-{{ $item->id_payable_invoice }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger-soft">
                <h5 class="modal-title" id="exampleModalCenterTitle">Konfirmasi Hapus Data</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <form action="{{ route('invoice-payable.destroy', $item->id_payable_invoice) }}" method="POST" class="d-inline">
                @csrf
                @method('delete')
                <div class="modal-body text-center">Apakah Anda Yakin Menghapus Data Invoice {{ $item->kode_invoice }} pada tanggal
                    {{ $item->tanggal_invoice }}?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-danger" type="submit">Ya! Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
@empty

@endforelse

@forelse ($invoice as $item)
<div class="modal fade" id="Modaljurnal-{{ $item->id_payable_invoice }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="exampleModalCenterTitle">Konfirmasi Posting Jurnal</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <form action="{{ route('jurnal-pengeluaran.update', $item->id_payable_invoice) }}" method="POST" class="d-inline">
                @method('PUT')
                @csrf
                <div class="modal-body text-center">Apakah Anda Yakin Memposting Data Invoice {{ $item->kode_invoice }} pada tanggal
                    {{ $item->tanggal_invoice }}?</div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-success" type="submit">Ya! Posting</button>
                </div>
            </form>
        </div>
    </div>
</div>
@empty

@endforelse

<script>
     function tambahrcv(event, id_rcv) {
        var data = $('#item-' + id_rcv)
        var _token = $('#form1').find('input[name="_token"]').val()
        var kode_rcv = $(data.find('.kode_rcv')[0]).text()
        var kode_po = $(data.find('.kode_po')[0]).text()
        var nama_supplier = $(data.find('.nama_supplier')[0]).text()
        var tanggal_rcv = $(data.find('.tanggal_rcv')[0]).text()

        $('#detailkodercv').val(kode_rcv)
        $('#detailkodepo').val(kode_po)
        $('#detailsupplier').val(nama_supplier)
        $('#detailtanggalrcv').val(tanggal_rcv)

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
                title: 'Berhasil Menambah Data Receiving'
            })

    }

    function submit1() {
        var _token = $('#form1').find('input[name="_token"]').val()
        var kode_rcv = $('#detailkodercv').val()
        var nama_supplier = $('#detailsupplier').val()
        var kode_po = $('#detailkodepo').val()
        var data = {
            _token: _token,
            kode_rcv: kode_rcv,
            kode_po: kode_po,
            nama_supplier: nama_supplier,
        }

         if (kode_rcv == 0 | kode_rcv == '' ){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Anda Belum Memilih Receiving',
                timer: 2000,
                timerProgressBar: true,
            })
        }else {
            var sweet_loader =
                '<div class="sweet_loader"><svg viewBox="0 0 140 140" width="140" height="140"><g class="outline"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="rgba(0,0,0,0.1)" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round"></path></g><g class="circle"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="#71BBFF" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-dashoffset="200" stroke-dasharray="300"></path></g></svg></div>';
                


            $.ajax({
                method: 'post',
                url: "/Accounting/invoice-payable",
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
                    window.location.href = '/Accounting/invoice-payable/' + response.id_payable_invoice + '/edit'
                },
                error: function (error) {
                    console.log(error)
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: '<h5>Error!</h5>'
                    });
                }

            });
        }

    }


    setInterval(displayclock, 500);

   function displayclock() {
       var time = new Date()
       var hrs = time.getHours()
       var min = time.getMinutes()
       var sec = time.getSeconds()
       var en = 'AM';

       if (hrs > 12) {
           en = 'PM'
       }

       if (hrs > 12) {
           hrs = hrs - 12;
       }

       if (hrs == 0) {
           hrs = 12;
       }

       if (hrs < 10) {
           hrs = '0' + hrs;
       }

       if (min < 10) {
           min = '0' + min;
       }

       if (sec < 10) {
           sec = '0' + sec;
       }

       document.getElementById('clock').innerHTML = hrs + ':' + min + ':' + sec + ' ' + en;
   }

   $(document).ready(function () {
        var tablercv = $('#dataTableRcv').DataTable()
        var tableutama = $('#dataTableUtama').DataTable()
    });

</script>

@endsection
