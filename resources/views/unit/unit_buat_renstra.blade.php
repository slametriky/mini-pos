@extends('layouts.master')
@section('title', 'Buat Renstra')

@push('page-styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@1.1/dist/css/tom-select.css" rel="stylesheet">

<style>
    .gr {
        text-decoration: underline;
    }

    .custom-table {
        font-size: 12px;
        border: 1px solid black;
        color: black;
        border-collapse: collapse;
        width: 100%;
    } 

    .custom-table th {
        text-align: center;
    }

    .custom-table th , td{
        padding:3px 5px;
        border: 1px solid rgb(230, 230, 230);
    }

    .btn-custom {
        padding: .1rem .4rem;
        font-size: 10px;
    }

    .check {
        background-color:#3bb5575b;
    }

    .comment {
        background-color:#ff000075;
    }
</style>
    
@endpush

@section('content')
    @php
        [$periode_id, $periode_text] = explode('.',$periode);
    @endphp
    <section class="section">
        <div class="section-header">
            <h1>Buat Renstra</h1>            
        </div>
        <div class="section-body">                        
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <h4>Buat Renstra Periode {{ $periode_text }}</h4>
                        </div>
                        <div class="card-body">           
                            <form method="POST" id="formTampil">
                                <div class="form-group">
                                    <div class="col-sm-12 col-md-6">
                                        <select onchange="setTahun(this.value)" id="selectTahun" name="tahun" class="form-control" required>
                                            <option value="">Pilih Tahun</option>                                                                                        
                                            @foreach ($tahun as $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>        
                                <div class="form-group">
                                    <div class="col-sm-12 col-md-5">
                                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                                    </div>
                                </div>                               
                            </form>               
                            <hr>  
                            <div id="tmpStatus">                                
                                                               
                            </div>
                            <div class="table-responsive col-12 mt-2">
                                <button class="btn btn-primary mb-2" id="btnRekamProgram" onclick="rekamProgram()">Rekam Program</button>
                                <table class="custom-table" id="table">
                                    <thead>
                                        <tr>
                                            <th rowspan="2"></th>
                                            <th rowspan="2">Kode</th>
                                            <th rowspan="2">URAIAN</th>                                                                                                                     
                                            <th rowspan="2">VOL</th>
                                            <th rowspan="2">SAT</th>
                                            <th rowspan="2">HARGA</th>
                                            <th rowspan="2">JUMLAH</th>  
                                            <th rowspan="2">SD</th>    
                                            <th colspan="3">Dokumen</th>
                                            <th rowspan="2">Catatan</th>     
                                        </tr>
                                        <tr>
                                            <th>KAK</th>
                                            <th>RAB</th>
                                            <th>Pendukung</th>
                                        </tr>
                                    </thead>   
                                    <tbody id="tableData">
                                        
                                    </tbody>                         
                                </table>                                
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>            
        </div>       
    </section>
    <div class="modal fade" tabindex="-1" role="dialog" id="modalProgram">
        <div class="modal-dialog modal-lg role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Rekam Program</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formRekamProgram" method="post">                
                <div class="modal-body">     
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-2 col-lg-2">Program</label>
                        <div class="col-sm-12 col-md-9">
                            <select name="program" class="form-control" id="program" required>
                                <option value="">Pilih Program</option>
                                @foreach ($programs as $program)
                                    <option value="{{ $program->id }}">{{ $program->kode_program }}-{{ $program->desk_program }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>                                                                                      
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Pilih</button>
                </div>
            </form>
          </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="modalKegiatan">
        <div class="modal-dialog modal-lg role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Rekam Kegiatan</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formRekamKegiatan" method="post">                
                <div class="modal-body">     
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-2 col-lg-2">Kegiatan</label>
                        <div class="col-sm-12 col-md-9">
                            <input type="hidden" id="rka_program_id" name="rka_program_id">
                            <input type="hidden" id="program_id" name="program_id">
                            <select name="kegiatan" class="form-control" id="kegiatan" required>
                                <option value="">Pilih Kegiatan</option>
                              
                            </select>
                        </div>
                    </div>                                                                                      
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Pilih</button>
                </div>
            </form>
          </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="modalKro">
        <div class="modal-dialog modal-lg role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Rekam KRO</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formRekamKro" method="post">                
                <div class="modal-body">     
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-2 col-lg-2">KRO</label>
                        <div class="col-sm-12 col-md-9">
                            <input type="hidden" id="rka_kegiatan_id" name="rka_kegiatan_id">
                            <input type="hidden" id="kegiatan_id" name="kegiatan_id">
                            <select name="kro" class="form-control" id="kro" required>
                                <option value="">Pilih KRO</option>
                                
                            </select>
                        </div>
                    </div>                                                                                      
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Pilih</button>
                </div>
            </form>
          </div>
        </div>
    </div>
    {{-- Rekam RO --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modalRo">
        <div class="modal-dialog modal-lg role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Rekam RO</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formRekamRo" method="post">                
                <div class="modal-body">     
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-2 col-lg-2">RO</label>
                        <div class="col-sm-12 col-md-9">
                            <input type="hidden" id="rka_kro_id" name="rka_kro_id">
                            <input type="hidden" id="kro_id" name="kro_id">
                            <select name="ro" class="form-control" id="ro" required>
                                <option value="">Pilih RO</option>
                                
                            </select>
                        </div>
                    </div>                                                                                      
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Pilih</button>
                </div>
            </form>
          </div>
        </div>
    </div>
    {{-- Rekam Komponen --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modalKomponen">
        <div class="modal-dialog modal-lg role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Rekam Komponen</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formRekamKomponen" method="post">                
                <div class="modal-body">     
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-2 col-lg-2">Komponen</label>
                        <div class="col-sm-12 col-md-9">
                            <input type="hidden" id="rka_ro_id" name="rka_ro_id">
                            <input type="hidden" id="ro_id" name="ro_id">
                            <select name="komponen" class="form-control" id="komponen" required>
                                <option value="">Pilih Komponen</option>
                                
                            </select>
                        </div>
                    </div>                                                                                      
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Pilih</button>
                </div>
            </form>
          </div>
        </div>
    </div>
    {{-- Rekam Sub Komponen --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modalSubKomponen">
        <div class="modal-dialog modal-lg role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Rekam Sub Komponen</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formRekamSubKomponen" method="post">                
                <div class="modal-body">     
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-2 col-lg-2">Sub Komponen</label>
                        <div class="col-sm-12 col-md-3">
                            <input type="hidden" id="rka_komponen_id" name="rka_komponen_id">
                            <input type="hidden" id="komponen_id" name="komponen_id">
                            <input type="text" class="form-control" name="sub_komponen" id="sub_komponen">
                        </div>
                    </div>         
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-2 col-lg-2">Uraian</label>
                        <div class="col-sm-12 col-md-9">                            
                            <input type="text" class="form-control" name="uraian" id="uraian">
                        </div>
                    </div>                                                                                      
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Pilih</button>
                </div>
            </form>
          </div>
        </div>
    </div>
    {{-- Rekam Akun --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modalAkun">
        <div class="modal-dialog modal-lg role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Rekam Akun</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formRekamAkun" method="post">                
                <div class="modal-body">     
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-2 col-lg-2">Akun</label>
                        <div class="col-sm-12 col-md-9">
                            <input type="hidden" id="rka_sub_komponen_id" name="rka_sub_komponen_id">
                            <select name="akun" placeholder="Masukkan Kode Akun" class="" id="akun" required>
                                
                            </select>
                        </div>
                    </div>           
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-2 col-lg-2">Beban/Jns Bantuan/Cr Penarikan</label>
                        <div class="col-sm-12 col-md-9">
                            <select class="form-control" name="jenis_pendanaan" id="jenis_pendanaan" required>
                                <option value="">Pilih</option>
                                @foreach ($jenis_pendanaans as $item)
                                    <option value="{{ $item->id }}">{{ $item->kode_pendanaan }}-{{ $item->desk_pendanaan }}-{{ $item->cara_tarik }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>                                                                              
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Pilih</button>
                </div>
            </form>
          </div>
        </div>
    </div>
    {{-- Rekam Detail --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modalDetail">
        <div class="modal-dialog modal-lg role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Rekam Detail</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formRekamDetail" method="post">                
                <div class="modal-body">     
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-2 col-lg-2">Uraian</label>
                        <div class="col-sm-12 col-md-9">
                            <input type="hidden" id="rka_akun_id" name="rka_akun_id">
                            <input type="text" autocomplete="off" required class="form-control" name="uraian" id="uraian_detail">
                        </div>
                    </div>                                                                                             
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-2 col-lg-2">Volkeg</label>
                        <div class="col-sm-12 col-md-2">
                            <input type="number" autocomplete="off" required class="form-control" name="vol" id="vol">
                        </div>
                    </div>                                                                                           
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-2 col-lg-2">Satkeg</label>
                        <div class="col-sm-12 col-md-3">
                            <select name="satuan" class="form-control" id="satuan" required>
                                <option value="">Pilih Satuan</option>
                                @foreach ($satuans as $satuan)
                                    <option value="{{ $satuan->id }}">{{ $satuan->satuan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>                                                                                           
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-2 col-lg-2">Harga Satuan</label>
                        <div class="col-sm-12 col-md-9">
                            <input type="text" class="form-control" required name="harga" id="harga">
                        </div>
                    </div>                                                                                              
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-2 col-lg-2">Jumlah</label>
                        <div class="col-sm-12 col-md-9">
                            <input type="text" required class="form-control" readonly name="jumlah" id="jumlah">
                        </div>
                    </div>                                                                                                            
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Pilih</button>
                </div>
            </form>
          </div>
        </div>
    </div>
    {{-- Edit Detail --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modalEditDetail">
        <div class="modal-dialog modal-lg role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Detail</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formEditDetail" method="post">                
                <div class="modal-body">     
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-2 col-lg-2">Uraian</label>
                        <div class="col-sm-12 col-md-9">
                            <input type="hidden" id="detail_id" name="id">
                            <input type="text" autocomplete="off" required class="form-control" name="uraian" id="uraian_e">
                        </div>
                    </div>                                                                                             
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-2 col-lg-2">Volkeg</label>
                        <div class="col-sm-12 col-md-2">
                            <input type="number" autocomplete="off" required class="form-control" name="vol" id="vol_e">
                        </div>
                    </div>                                                                                           
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-2 col-lg-2">Satkeg</label>
                        <div class="col-sm-12 col-md-3">
                            <select name="satuan" class="form-control" id="satuan_e" required>
                                <option value="">Pilih Satuan</option>
                                @foreach ($satuans as $satuan)
                                    <option value="{{ $satuan->id }}">{{ $satuan->satuan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>                                                                                           
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-2 col-lg-2">Harga Satuan</label>
                        <div class="col-sm-12 col-md-9">
                            <input type="text" class="form-control" required name="harga" id="harga_e">
                        </div>
                    </div>                                                                                              
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-2 col-lg-2">Jumlah</label>
                        <div class="col-sm-12 col-md-9">
                            <input type="text" required class="form-control" readonly name="jumlah" id="jumlah_e">
                        </div>
                    </div>                                                                                                              
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
          </div>
        </div>
    </div>
    {{-- Detail Data Pendukung Detail --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modalUploadFileList">
        <div class="modal-dialog modal-lg role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Upload Dokumen <span id="txtDokumen"></span></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="formUpload" method="post">                
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-2 col-lg-2">Data Pendukung</label>                       
                        <div class="col-sm-12 col-md-4">
                            <input type="hidden" id="data_id" name="data_id">                           
                            <input type="file" class="form-control" name="file_pendukung" id="file_pendukung" required>
                            <small>Format file *.pdf ukuran maksimal 1MB</small>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <button type="submit" id="btnUploadFile" class="btn btn-primary">Upload</button>
                        </div>
                    </div>                                                                                                                        
                </form>                
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody id="dataFile">
                    
                    </tbody>
                </table>
            </div>
          </div>
        </div>
    </div>
        
    {{-- Komentar Sub Kegiatan --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modalListComment">
        <div class="modal-dialog modal-lg role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Komentar / Catatan</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Komentar</td>
                            <td>Tanggal Komentar</td>
                        </tr>
                    </thead>
                    <tbody id="dataComment">
                    
                    </tbody>
                </table>
            </div>
          </div>
        </div>
    </div>
@endsection
    
@push('page-script')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@1.1/dist/js/tom-select.complete.min.js"></script>
    <script>
        
    </script>
    <script>                
        
        let tmpData = '';
        let tmpTahun = '';   
        let tmpDetailId = '';
        let tmpLevel = '';
        let tmpLevelId = '';
        let tmpRkaSubKomId = '';
        let statusRenstra = '{{ $status_renstra }}';
        let tmpStatus = '';

        hapusProgram = (id) => {
            Swal.fire({
                title: "Yakin hapus data?",            
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal"
            }).then((result) => {
                
                if(result.value){

                    axios.post('/unit/hapus_program', {                                
                        id
                    })
                    .then((response) => {                            
                        if(response.data.responCode == 1){
                            Swal.fire({                                
                                icon: 'success',                   
                                title: 'Berhasil',                                
                                timer: 2000,                                
                                showConfirmButton: false
                            })

                        loadData(tmpTahun);
                            
                        } else {
                            Swal.fire({                                
                                icon: 'warning',                   
                                title: 'Gagal!',
                                text: response.data.respon,                            
                            })
                        }
                    }, (error) => {
                        console.log(error);
                    });
                }            

            });
        }

        hapusKegiatan = (id) => {
            Swal.fire({
                title: "Yakin hapus data?",            
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal"
            }).then((result) => {
                
                if(result.value){

                    axios.post('/unit/hapus_kegiatan', {                                
                        id
                    })
                    .then((response) => {                            
                        if(response.data.responCode == 1){
                            Swal.fire({                                
                                icon: 'success',                   
                                title: 'Berhasil',                                
                                timer: 2000,                                
                                showConfirmButton: false
                            })

                        loadData(tmpTahun);
                            
                        } else {
                            Swal.fire({                                
                                icon: 'warning',                   
                                title: 'Gagal!',
                                text: response.data.respon,                            
                            })
                        }
                    }, (error) => {
                        console.log(error);
                    });
                }            

            });
        }
        
        hapusKro = (id) => {
            Swal.fire({
                title: "Yakin hapus data?",            
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal"
            }).then((result) => {
                
                if(result.value){

                    axios.post('/unit/hapus_kro', {                                
                        id
                    })
                    .then((response) => {                            
                        if(response.data.responCode == 1){
                            Swal.fire({                                
                                icon: 'success',                   
                                title: 'Berhasil',                                
                                timer: 2000,                                
                                showConfirmButton: false
                            })

                        loadData(tmpTahun);
                            
                        } else {
                            Swal.fire({                                
                                icon: 'warning',                   
                                title: 'Gagal!',
                                text: response.data.respon,                            
                            })
                        }
                    }, (error) => {
                        console.log(error);
                    });
                }            

            });
        }

        hapusRo = (id) => {
            Swal.fire({
                title: "Yakin hapus data?",            
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal"
            }).then((result) => {
                
                if(result.value){

                    axios.post('/unit/hapus_ro', {                                
                        id
                    })
                    .then((response) => {                            
                        if(response.data.responCode == 1){
                            Swal.fire({                                
                                icon: 'success',                   
                                title: 'Berhasil',                                
                                timer: 2000,                                
                                showConfirmButton: false
                            })

                        loadData(tmpTahun);
                            
                        } else {
                            Swal.fire({                                
                                icon: 'warning',                   
                                title: 'Gagal!',
                                text: response.data.respon,                            
                            })
                        }
                    }, (error) => {
                        console.log(error);
                    });
                }            

            });
        }

        hapusKomponen = (id) => {
            Swal.fire({
                title: "Yakin hapus data?",            
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal"
            }).then((result) => {
                
                if(result.value){

                    axios.post('/unit/hapus_komponen', {                                
                        id
                    })
                    .then((response) => {                            
                        if(response.data.responCode == 1){
                            Swal.fire({                                
                                icon: 'success',                   
                                title: 'Berhasil',                                
                                timer: 2000,                                
                                showConfirmButton: false
                            })

                        loadData(tmpTahun);
                            
                        } else {
                            Swal.fire({                                
                                icon: 'warning',                   
                                title: 'Gagal!',
                                text: response.data.respon,                            
                            })
                        }
                    }, (error) => {
                        console.log(error);
                    });
                }            

            });
        }

        hapusSubKomponen = (id) => {
            Swal.fire({
                title: "Yakin hapus data?",            
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal"
            }).then((result) => {
                
                if(result.value){

                    axios.post('/unit/hapus_sub_komponen', {                                
                        id
                    })
                    .then((response) => {                            
                        if(response.data.responCode == 1){
                            Swal.fire({                                
                                icon: 'success',                   
                                title: 'Berhasil',                                
                                timer: 2000,                                
                                showConfirmButton: false
                            })

                        loadData(tmpTahun);
                            
                        } else {
                            Swal.fire({                                
                                icon: 'warning',                   
                                title: 'Gagal!',
                                text: response.data.respon,                            
                            })
                        }
                    }, (error) => {
                        console.log(error);
                    });
                }            

            });
        }

        hapusAkun = (id) => {
            Swal.fire({
                title: "Yakin hapus data?",            
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal"
            }).then((result) => {
                
                if(result.value){

                    axios.post('/unit/hapus_akun', {                                
                        id
                    })
                    .then((response) => {                            
                        if(response.data.responCode == 1){
                            Swal.fire({                                
                                icon: 'success',                   
                                title: 'Berhasil',                                
                                timer: 2000,                                
                                showConfirmButton: false
                            })

                        loadData(tmpTahun);
                            
                        } else {
                            Swal.fire({                                
                                icon: 'warning',                   
                                title: 'Gagal!',
                                text: response.data.respon,                            
                            })
                        }
                    }, (error) => {
                        console.log(error);
                    });
                }            

            });
        }

        hapusDetail = (id) => {
            Swal.fire({
                title: "Yakin hapus data?",            
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal"
            }).then((result) => {
                
                if(result.value){

                    axios.post('/unit/hapus_detail', {                                
                        id
                    })
                    .then((response) => {                            
                        if(response.data.responCode == 1){
                            Swal.fire({                                
                                icon: 'success',                   
                                title: 'Berhasil',                                
                                timer: 2000,                                
                                showConfirmButton: false
                            })

                        loadData(tmpTahun);
                            
                        } else {
                            Swal.fire({                                
                                icon: 'warning',                   
                                title: 'Gagal!',
                                text: response.data.respon,                            
                            })
                        }
                    }, (error) => {
                        console.log(error);
                    });
                }            

            });
        }

        hapusFileDetail = (id) => {
            Swal.fire({
                title: "Yakin hapus data?",            
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal"
            }).then((result) => {
                
                if(result.value){

                    axios.post('/unit/hapus_file_detail', {                                
                        id
                    })
                    .then((response) => {                            
                        if(response.data.responCode == 1){
                            Swal.fire({                                
                                icon: 'success',                   
                                title: 'Berhasil',                                
                                timer: 2000,                                
                                showConfirmButton: false
                            })

                        loadListFileDetail(tmpLevelId, tmpLevel, tmpJenis);
                            
                        } else {
                            Swal.fire({                                
                                icon: 'warning',                   
                                title: 'Gagal!',
                                text: response.data.respon,                            
                            })
                        }
                    }, (error) => {
                        console.log(error);
                    });
                }            

            });
        }

        hapusFileSubKom = (id) => {
            Swal.fire({
                title: "Yakin hapus data?",            
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal"
            }).then((result) => {
                
                if(result.value){

                    axios.post('/unit/hapus_file_subkom', {                                
                        id
                    })
                    .then((response) => {                            
                        if(response.data.responCode == 1){
                            Swal.fire({                                
                                icon: 'success',                   
                                title: 'Berhasil',                                
                                timer: 2000,                                
                                showConfirmButton: false
                            })

                            loadListFileSubKom(tmpLevelId, tmpJenis);
                            document.getElementById("formUpload").reset();

                            
                        } else {
                            Swal.fire({                                
                                icon: 'warning',                   
                                title: 'Gagal!',
                                text: response.data.respon,                            
                            })
                        }
                    }, (error) => {
                        console.log(error);
                    });
                }            

            });
        }

        loadData = (tahun) => {
                        
            axios.post('/unit/data_rka', {                                
                tahun
            })
            .then((res) => {                            
                
                let data_tr = '';
                if(res.data.length > 0){

                    tmpData = res.data;
                    res.data.forEach((data, index) => {
                        data_tr += `
                            <tr id="${data.kode}" 
                            ${(() => {
                            if(data.level == 'subKomponen' && data.checklist == 1) {
                                return `
                                class="check"
                                ` 
                            } else if(data.level == 'subKomponen' && data.checklist == 0 && data.comment == 1){
                                return `
                                class="comment"
                                ` 
                            }
                            else {
                                return '';
                            }


                            })()}>
                                <td class="text-center">
                                    ${(() => {
                                        if(data.level == 'program') {
                                            return `Prog`;
                                        } else if(data.level == 'kegiatan') {
                                            return `Keg`   
                                        } else if(data.level == 'kro') {
                                            return `KRO`
                                        } else if(data.level == 'ro') {
                                            return `RO`
                                        } else if(data.level == 'komponen') {
                                            return `Kmp`
                                        } else if(data.level == 'subKomponen') {
                                            return `sKmp`
                                        } else if(data.level == 'akun') {
                                            return `Akun`
                                        } else {
                                            return ''
                                        }
                                    })()}
                                </td>
                                <td class="text-right 
                                    ${(() => {
                                        if(data.level == 'kegiatan' || data.level == "akun") return ` gr`
                                        if(data.level == 'komponen') return ` font-weight-bold`
                                        if(data.level == 'subKomponen') return ` font-italic`
                                    })()}">
                                    ${data.kode}
                                </td>
                                <td
                                    ${(() => {
                                        if(data.level == 'kegiatan' || data.level == "akun") return `class='gr'`
                                        if(data.level == 'komponen') return `class='font-weight-bold'`
                                        if(data.level == 'subKomponen') return `class='font-italic'`
                                    })()}
                                >
                                    ${data.desk}
                                </td>
                                <td class="text-center">${data.volume != null ? data.volume : ''}</td>
                                <td class="text-center">${data.satuan != null ? data.satuan : ''}</td>
                                <td class="text-right">${data.harga != null ? formatRupiah(data.harga) : ''}</td>
                                <td class="text-right
                                    ${(() => {
                                        if(data.level == 'kegiatan' || data.level == "akun") return ` gr`
                                        if(data.level == 'komponen') return ` font-weight-bold`
                                        if(data.level == 'subKomponen') return ` font-italic`
                                    })()}">
                                    ${data.jml != null ? formatRupiah(data.jml) : ''}
                                </td>
                                <td class="
                                    ${(() => {
                                        if(data.level == "akun") return ` gr`                                        
                                    })()}">
                                    ${(() => {
                                        if(data.level == "akun") return `${data.sd}`; else return ``                                        
                                    })()}                                   
                                </td>
                                    ${(() => {
                                    
                                    if(data.level == 'subKomponen') {

                                        let kakLabel = data.kak == 1 ? 'btn-primary' : 'btn-danger';
                                        let rabLabel = data.rab == 1 ? 'btn-primary' : 'btn-danger';
                                        let pendukungLabel = data.pendukung == 1 ? 'btn-primary' : 'btn-danger';

                                        return `
                                        <td class="text-center">
                                            <button class="btn ${kakLabel} btn-custom" title="KAK"  onclick="uploadFile(${data.id}, 'subKom', 'kak')"><i class="fa fa-file-pdf"></i></button>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn ${rabLabel} btn-custom" title="RAB"  onclick="uploadFile(${data.id}, 'subKom', 'rab')"><i class="fa fa-file-pdf"></i></button>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn ${pendukungLabel} btn-custom" title="Data Pendukung"  onclick="uploadFile(${data.id}, 'subKom', 'pendukung')"><i class="fa fa-file-pdf"></i></button>
                                        </td>
                                        ` 
                                    } else if(data.level == 'detail') {

                                        let kakLabel = data.kak == 1 ? 'btn-primary' : 'btn-danger';
                                        let rabLabel = data.rab == 1 ? 'btn-primary' : 'btn-danger';
                                        let pendukungLabel = data.pendukung == 1 ? 'btn-primary' : 'btn-danger';

                                        return `
                                        <td class="text-center">
                                            <button class="btn ${kakLabel} btn-custom" title="RKA"  onclick="uploadFile(${data.id}, 'detail', 'kak')"><i class="fa fa-file-pdf"></i></button>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn ${rabLabel} btn-custom" title="RAB"  onclick="uploadFile(${data.id}, 'detail', 'rab')"><i class="fa fa-file-pdf"></i></button>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn ${pendukungLabel} btn-custom" title="Data Pendukung"  onclick="uploadFile(${data.id}, 'detail', 'pendukung')"><i class="fa fa-file-pdf"></i></button>
                                        </td>
                                        ` 
                                    } 
                                    else {
                                        return '<td></td><td></td><td></td>';
                                    }
                                    })()}
                                <td>
                                    ${(() => {

                                        if(data.status == 0){
                                            if (data.level == 'program') {
                                                return `
                                                <button class="btn btn-primary btn-custom" onclick="rekamKegiatan(${data.id},${data.program_id})">Rekam Kegiatan</button>
                                                <button class="btn btn-danger btn-custom" onclick="hapusProgram(${data.id})"><i class="fa fa-trash"></i></button>
                                                `
                                            } else if(data.level == 'kegiatan') {
                                                return `
                                                <button class="btn btn-primary btn-custom" title="Rekam KRO" onclick="rekamKro(${data.id},${data.kegiatan_id})">Rekam KRO</button>
                                                <button class="btn btn-danger btn-custom" onclick="hapusKegiatan(${data.id})"><i class="fa fa-trash"></i></button>
                                                ` 
                                            } else if(data.level == 'kro') {
                                                return `
                                                <button class="btn btn-primary btn-custom" onclick="rekamRo(${data.id},${data.kro_id})">Rekam RO</button>
                                                <button class="btn btn-danger btn-custom" onclick="hapusKro(${data.id})"><i class="fa fa-trash"></i></button>
                                                ` 
                                            } else if(data.level == 'ro') {
                                                return `
                                                <button class="btn btn-primary btn-custom" onclick="rekamKomponen(${data.id},${data.ro_id})">Rekam Komponen</button>
                                                <button class="btn btn-danger btn-custom" onclick="hapusRo(${data.id})"><i class="fa fa-trash"></i></button>
                                                ` 
                                            } else if(data.level == 'komponen') {
                                                return `
                                                <button class="btn btn-primary btn-custom" onclick="rekamSubKomponen(${data.id},${data.komponen_id})">Rekam Sub Komponen</button>
                                                <button class="btn btn-danger btn-custom" onclick="hapusKomponen(${data.id})"><i class="fa fa-trash"></i></button>
                                                ` 
                                            } else if(data.level == 'subKomponen') {
                                                
                                                let commentLabel = data.comment == 1 ? 'btn-primary' : 'btn-danger';

                                                return `
                                                <button class="btn btn-primary btn-custom" onclick="rekamAkun(${data.id})">Rekam Akun</button>
                                                <button class="btn btn-danger btn-custom" onclick="hapusSubKomponen(${data.id})"><i class="fa fa-trash"></i></button>
                                                <button class="btn ${commentLabel} btn-custom" title="Komentar" ${data.comment == 1 ? '' : 'disabled' }  onclick="comment(${data.id})"><i class="fa fa-comment"></i></button>
                                                ` 
                                            } else if(data.level == 'akun') {
                                                return `
                                                <button class="btn btn-primary btn-custom" onclick="rekamDetail(${data.id})">Rekam Detail</button>
                                                <button class="btn btn-danger btn-custom" onclick="hapusAkun(${data.id})"><i class="fa fa-trash"></i></button>
                                                ` 
                                            } else if(data.level == 'detail') {
                                                return `
                                                <button class="btn btn-primary btn-custom" onclick="editDetail(${data.id})"><i class="fa fa-edit"></i></button>
                                                <button class="btn btn-danger btn-custom" onclick="hapusDetail(${data.id})"><i class="fa fa-trash"></i></button>
                                                ` 
                                            }
                                        } else {
                                            
                                            if(data.level == 'subKomponen') {

                                                let commentLabel = data.comment == 1 ? 'btn-primary' : 'btn-danger';
                                                
                                                return `
                                                <button class="btn ${commentLabel} btn-custom" title="Komentar" ${data.comment == 1 ? '' : 'disabled' } onclick="comment(${data.id})"><i class="fa fa-comment"></i></button>
                                                ` 
                                            } else {
                                                return '';
                                            }
                                        }

                                    })()}
                                </td>                                
                            </tr>                            
                        `;
                    })

                    cekAsset();
                    
                } else {
                    Swal.fire({                    
                        icon: 'warning',                   
                        title: 'Data Kosong',
                        timer: 1000,                                
                        showConfirmButton: false
                    })

                    document.getElementById("tmpStatus").innerHTML = '';
                    document.getElementById("btnRekamProgram").style.display = "block";

                }

                document.getElementById("tableData").innerHTML = data_tr;

            }, (error) => {
                console.log(error);
            });
        }

        loadKegiatan = (id) => {
            axios.post('/unit/data_kegiatan', {    
                id                            
            })
            .then((res) => {                            

                // console.log(res);
                let opt = '<option value="">Pilih Kegiatan</option>';
                if(res.data.length > 0){

                    res.data.forEach((data, index) => {
                        opt += `
                            <option value="${data.id}">${data.kode_kegiatan}-${data.desk_kegiatan}</option>                    
                        `;
                    })
                    

                }

                document.getElementById("kegiatan").innerHTML = opt;
            
            }, (error) => {
                console.log(error);
            });
        }

        loadKro = (id) => {
            axios.post('/unit/data_kro', {   
                id                             
            })
            .then((res) => {                            

               
                let opt = '<option value="">Pilih KRO</option>';
                if(res.data.length > 0){
                                        
                    res.data.forEach((data, index) => {
                        opt += `
                            <option value="${data.id}">${data.kode_kro}-${data.desk_kro}</option>                    
                        `;
                    })
                    

                }
                
                document.getElementById("kro").innerHTML = opt;

            
            }, (error) => {
                console.log(error);
            });
        }

        loadRo = (id) => {
            axios.post('/unit/data_ro', {   
                id                             
            })
            .then((res) => {                            

               
                let opt = '<option value="">Pilih RO</option>';
                if(res.data.length > 0){
                                        
                    res.data.forEach((data, index) => {
                        opt += `
                            <option value="${data.id}">${data.kode_ro}-${data.desk_ro}</option>                    
                        `;
                    })
                    
                }
                
                document.getElementById("ro").innerHTML = opt;
            
            }, (error) => {
                console.log(error);
            });
        }

        loadKomponen = (id) => {
            axios.post('/unit/data_komponen', {   
                id                             
            })
            .then((res) => {                            

               
                let opt = '<option value="">Pilih Komponen</option>';
                if(res.data.length > 0){
                                        
                    res.data.forEach((data, index) => {
                        opt += `
                            <option value="${data.id}">${data.kode_komponen}-${data.desk_komponen}</option>                    
                        `;
                    })
                    
                }
                
                document.getElementById("komponen").innerHTML = opt;
            
            }, (error) => {
                console.log(error);
            });
        }

        loadSubkomponen = (id) => {
            axios.post('/unit/data_komponen', {   
                id                             
            })
            .then((res) => {                            
               
                if(res.data.length > 0){
                                        
                    res.data.forEach((data, index) => {
                        opt += `
                            <option value="${data.id}">${data.kode_komponen}-${data.desk_komponen}</option>                    
                        `;
                    })
                    
                }
                
                document.getElementById("komponen").innerHTML = opt;
            
            }, (error) => {
                console.log(error);
            });
        }
        
        rekamProgram = () => {  

            //cek apakah tahun sudah dipilih
            if(tmpTahun != ''){ 
                $("#modalProgram").modal("show");
                document.getElementById("formRekamProgram").reset();            
            } else {
                Swal.fire({                    
                    icon: 'warning',                   
                    title: 'Ada kesalahan',
                    text: 'Silahkan pilih tahun terlebih dahulu!',                            
                })
            }

        }

        rekamKegiatan = (id, program_id) => {  
            
            loadKegiatan(program_id)
            $("#rka_program_id").val(id)
            $("#program_id").val(program_id)


            $("#modalKegiatan").modal("show");
            document.getElementById("formRekamKegiatan").reset();            

        }

        rekamKro = (rka_kegiatan_id, kegiatan_id) => {  
            
            loadKro(kegiatan_id)
            $("#rka_kegiatan_id").val(rka_kegiatan_id)
            $("#kegiatan_id").val(kegiatan_id)


            $("#modalKro").modal("show");
            document.getElementById("formRekamKro").reset();            

        }

        rekamRo = (rka_kro_id, kro_id) => {  
            
            loadRo(kro_id)
            $("#rka_kro_id").val(rka_kro_id)
            $("#kro_id").val(kro_id)

            $("#modalRo").modal("show");
            document.getElementById("formRekamRo").reset();            

        }

        rekamKomponen = (rka_ro_id, ro_id) => {  
            
            loadKomponen(ro_id)
            $("#rka_ro_id").val(rka_ro_id)
            $("#ro_id").val(ro_id)

            $("#modalKomponen").modal("show");
            document.getElementById("formRekamKomponen").reset();            

        }

        rekamSubKomponen = (rka_komponen_id, komponen_id) => {  
            
            // loadKomponen(ro_id)
            $("#rka_komponen_id").val(rka_komponen_id)
            $("#komponen_id").val(komponen_id)

            $("#modalSubKomponen").modal("show");
            document.getElementById("formRekamSubKomponen").reset();            

        }

        rekamAkun = (rka_sub_komponen_id) => {  
            
            // loadKomponen(ro_id)
            $("#rka_sub_komponen_id").val(rka_sub_komponen_id)

            $("#modalAkun").modal("show");
            document.getElementById("formRekamAkun").reset(); 
            tom.clear();           

        }

        rekamDetail = (rka_akun_id) => {  
            
            $("#rka_akun_id").val(rka_akun_id)

            $("#modalDetail").modal("show");
            document.getElementById("formRekamDetail").reset(); 

        }

        uploadFile = (level_id, level, jenis) => {

            tmpLevel = level;
            tmpLevelId = level_id;
            tmpJenis = jenis;
            
            $("#data_id").val(tmpLevelId);

            if(level == 'detail'){                
                loadListFileDetail(tmpLevelId, jenis);
            } else {
                loadListFileSubKom(tmpLevelId, jenis);
            }           

            document.getElementById("formUpload").reset();

            $("#modalUploadFileList").modal("show");

        }

        loadListFileDetail = (id, jenis) => {
            axios.post('/unit/load_list_file_detail', {   
                id, jenis                             
            })
            .then((res) => {                            

                let data_tr = '';
                if(res.data.length > 0){
                    
                    res.data.forEach((data, index) => {
                        data_tr += `
                            <tr>
                                <td>${++index}</td>                                
                                <td>
                                    <a class="btn btn-primary btn-sm" target="_blank" title="lihat" href="{{ asset('assets/file/${data.file}') }}" role="button"><i class="fa fa-eye"></i></a>
                                    <button class="btn btn-sm btn-danger" ${tmpStatus == 1 ? "disabled" : ""} onclick="hapusFileDetail(${data.id})"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        `;
                    })

                    if(tmpJenis == "pendukung"){
                        document.getElementById("btnUploadFile").disabled = false;
                    } else {
                        document.getElementById("btnUploadFile").disabled = true;
                    }

                } else {
                    document.getElementById("btnUploadFile").disabled = false;
                }
               
                document.getElementById("dataFile").innerHTML = data_tr;
                
            }, (error) => {
                console.log(error);
            });
        }

        loadListFileSubKom = (id, jenis) => {
            axios.post('/unit/load_list_file_subkom', {   
                id, jenis                             
            })
            .then((res) => {                            

                document.getElementById("btnUploadFile").disabled = false;

                let data_tr = '';
                if(res.data.length > 0){
                    res.data.forEach((data, index) => {
                        data_tr += `
                            <tr>
                                <td>${++index}</td>                               
                                <td>
                                    <a class="btn btn-primary btn-sm" target="_blank" title="lihat" href="{{ asset('assets/file/${data.file}') }}" role="button"><i class="fa fa-eye"></i></a>
                                    <button class="btn btn-sm btn-danger" ${tmpStatus == 1 ? "disabled" : ""} onclick="hapusFileSubKom(${data.id})"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        `;
                    })
                    
                    if(tmpJenis == "pendukung"){
                        document.getElementById("btnUploadFile").disabled = false;
                    } else {
                        document.getElementById("btnUploadFile").disabled = true;
                    }

                } 

                if(tmpStatus == 1){
                    document.getElementById("btnUploadFile").disabled = true;
                }
                

                document.getElementById("dataFile").innerHTML = data_tr;
                
            }, (error) => {
                console.log(error);
            });

            
        }

        editDetail = (detail_id) => {  
            
            let dataDetail = tmpData.filter((data) => {
                return data.level == "detail" && data.id == detail_id;
            })
            
            $("#detail_id").val(dataDetail[0].id);
            $("#uraian_e").val(dataDetail[0].uraian);
            $("#vol_e").val(dataDetail[0].volume);
            $("#satuan_e").val(dataDetail[0].satuan_id);
            $("#harga_e").val(formatRupiah(dataDetail[0].harga));
            $("#jumlah_e").val(formatRupiah(dataDetail[0].jml));

            
            $("#modalEditDetail").modal("show");

        }

        setTahun = (tahun) => {
            tmpTahun = tahun;
        }

        formatRupiah = (angka) => {
            let number_string = angka.toString().replace(/[^,\d]/g, ''),
            split = number_string.split(','),
            sisa  = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        
            if(ribuan){
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
        
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

            return rupiah;

        }

        gabung = (angka) => {
            
            let jml = angka.split('.').join('');

            return jml;
            
        }

        comment = (id) => {
            
            tmpRkaSubKomId = id;

            loadListComment(id);
            
            $("#modalListComment").modal("show");
        }

        loadListComment = (id) => {
            axios.post('/unit/load_list_comment', {   
                id                             
            })
            .then((res) => {                            

                let data_tr = '';
                if(res.data.length > 0){
                    res.data.forEach((data, index) => {
                        data_tr += `
                            <tr>
                                <td>${++index}</td>
                                <td>
                                    ${data.comment}
                                </td>
                                <td>
                                    ${data.tanggal}
                                </td>
                            </tr>
                        `;
                    })
                }
               
                document.getElementById("dataComment").innerHTML = data_tr;
                
            }, (error) => {
                console.log(error);
            });
        }

        $('#harga').keyup(delay(function (e) {

            let vol = $("#vol").val();

            $("#harga").val(formatRupiah($(this).val()));

            if(vol == ''){
                
                Swal.fire({                    
                    icon: 'warning',                   
                    title: 'Ada kesalahan',
                    text: 'Volume belum diisi!',                            
                })

                $("#jumlah").val(formatRupiah(pembulatan(gabung($("#harga").val()))));
                
            } else {

                let jumlah = pembulatan(gabung($("#harga").val()) * vol);

                $("#jumlah").val(formatRupiah(jumlah));                

            }


        }, 500));

        $('#vol').keyup(delay(function (e) {

            let vol = $("#vol").val();            
            let harga = gabung($("#harga").val());

            if(harga != ''){

                $("#jumlah").val(formatRupiah(pembulatan(vol * harga)));
                
                
            } 

        }, 500));

        $('#harga_e').keyup(delay(function (e) {

            let vol = $("#vol_e").val();

            $("#harga_e").val(formatRupiah($(this).val()));

            if(vol == ''){
                
                Swal.fire({                    
                    icon: 'warning',                   
                    title: 'Ada kesalahan',
                    text: 'Volume belum diisi!',                            
                })

                $("#jumlah_e").val(formatRupiah(pembulatan(gabung($("#harga_e").val()))));
                
            } else {

                let jumlah = pembulatan(gabung($("#harga_e").val()) * vol);

                $("#jumlah_e").val(formatRupiah(jumlah));                

            }


        }, 500));

        $('#vol_e').keyup(delay(function (e) {

            let vol = $("#vol_e").val();            
            let harga = gabung($("#harga_e").val());

            if(harga != ''){

                $("#jumlah_e").val(formatRupiah(pembulatan(vol * harga)));
                
            } 

        }, 500));

        cekAsset = () => {
            
            let dataProgram = tmpData.filter((data) => {
                return data.level == "program";
            })

            let dataTmpStatus = '';
            tmpStatus = dataProgram[0].status;

            if(dataProgram[0].status ==  0){                
                dataTmpStatus = `      
                    <div class="col-md-5">
                        <button class="btn btn-success" onclick="simpan()">Simpan</button>
                    </div>             
                `;                  

                document.getElementById("btnRekamProgram").style.display = "block";

            } else {

                document.getElementById("btnRekamProgram").style.display = "none";
                dataTmpStatus = `
                    <div class="col-md-4">
                        <h4 class="text-success">Sudah Tersimpan</h4>
                    </div>
                    <div class="col-md-4">
                        <button ${(statusRenstra != 4 && statusRenstra != 1) ? "disabled" : ""}  class="btn btn-danger" onclick="batalSimpan()">Batal Simpan</button>
                    </div>
                `;
                
            }
            
            document.getElementById("tmpStatus").innerHTML = dataTmpStatus;

        }

        simpan = () => {
            Swal.fire({
                title: "Yakin simpan?",            
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal"
            }).then((result) => {
                
                if(result.value){

                    axios.post('/unit/simpan_rka', {                                
                        'tahun':tmpTahun
                    })
                    .then((response) => {                            
                        if(response.data.responCode == 1){
                            Swal.fire({                                
                                icon: 'success',                   
                                title: 'Berhasil',                                
                                timer: 2000,                                
                                showConfirmButton: false
                            })

                        loadData(tmpTahun);
                            
                        } else {
                            Swal.fire({                                
                                icon: 'warning',                   
                                title: 'Gagal!',
                                text: response.data.respon,                            
                            })
                        }
                    }, (error) => {
                        console.log(error);
                    });
                }            

            });
        }

        batalSimpan = () => {
            Swal.fire({
                title: "Yakin batal simpan?",            
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal"
            }).then((result) => {
                
                if(result.value){

                    axios.post('/unit/batal_simpan_rka', {                                
                        'tahun':tmpTahun
                    })
                    .then((response) => {                            
                        if(response.data.responCode == 1){
                            Swal.fire({                                
                                icon: 'success',                   
                                title: 'Berhasil',                                
                                timer: 2000,                                
                                showConfirmButton: false
                            })

                        loadData(tmpTahun);
                            
                        } else {
                            Swal.fire({                                
                                icon: 'warning',                   
                                title: 'Gagal!',
                                text: response.data.respon,                            
                            })
                        }
                    }, (error) => {
                        console.log(error);
                    });
                }            

            });
        }

        function delay(callback, ms) {
            var timer = 0;
            return function() {
                var context = this, args = arguments;
                clearTimeout(timer);
                timer = setTimeout(function () {
                callback.apply(context, args);
                }, ms || 0);
            };
        }

        pembulatan = (angka) => {

            if(angka < 1000)
            {  angka = 1000; }

            let rest = angka % 1000; 
            return angka - rest 
        }

        function validateFile(){
            const allowedExtensions =  ['pdf'],
                    sizeLimit = 1000000; // 1 megabyte

            // destructuring file name and size from file object
            const { name:fileName, size:fileSize } = this.files[0];

            /*
            * if filename is apple.png, we split the string to get ["apple","png"]
            * then apply the pop() method to return the file extension
            *
            */
            const fileExtension = fileName.split(".").pop();

            /* 
                check if the extension of the uploaded file is included 
                in our array of allowed file extensions
            */
            if(!allowedExtensions.includes(fileExtension)){
                Swal.fire({
                    title: 'Ada kesalahan!',
                    text: "Format file harus *.pdf!",
                    icon: 'warning',            
                }); 

                this.value = null;
            }else if(fileSize > sizeLimit){
                Swal.fire({
                    title: 'Ada kesalahan!',
                    text: "Ukuran maksimal file adalah 1MB!",
                    icon: 'warning',            
                }); 

                this.value = null;
            }
        }

        document.getElementById("file_pendukung").addEventListener("change", validateFile)

        let tom = new TomSelect('#akun',{
            valueField: 'id',
            searchField: ['kode_akun', 'desk_akun'],
            // fetch remote data
            load: function(query, callback) {
                var self = this;
                if( self.loading > 1 ){
                    callback();
                    return;
                }

                axios.post('/unit/cari_akun', {   
                    query                        
                })
                .then((res) => {                                                    
                    callback(res.data);
                
                }, () => {
                    callback();
                });

            },
            // custom rendering function for options
            render: {
                option: function(item) {
                    return `<option value="${item.kode_akun}">${item.kode_akun}-${item.desk_akun}</option>`;
                },
                item: function(item, escape) {
				    return `<option value="${item.kode_akun}">${item.kode_akun}-${item.desk_akun}</option>`;
			    }
                
            },
            
        });

        document.addEventListener('DOMContentLoaded', function() {        

            console.log(statusRenstra);
            
            formRekamProgram.onsubmit = (e) => {
                
                e.preventDefault();                

                let formData = new FormData(formRekamProgram);   
                let periode_id = "{{ $periode_id }}";
                let renstra_id = "{{ $renstra_id }}";


                formData.append('tahun', tmpTahun);
                formData.append('periode_id', periode_id);
                formData.append('renstra_id', renstra_id);

                axios({
                    method: 'post',
                    url: '/unit/rekam_program',
                    data: formData,                    
                })
                .then(function (res) {

                    if(res.data.responCode == 1){                      

                        loadData(tmpTahun);

                        $("#modalProgram").modal("hide");                

                    } else {   

                        Swal.fire({                    
                            icon: 'warning',                   
                            title: 'Ada kesalahan',
                            text: res.data.respon,                            
                        })
                    }

                })
                .catch(function (res) {
                    //handle error
                    console.log(res);
                });
            

            }     

            formRekamKegiatan.onsubmit = (e) => {
                
                e.preventDefault();                

                let formData = new FormData(formRekamKegiatan);   

                formData.append('tahun', tmpTahun);

                axios({
                    method: 'post',
                    url: '/unit/rekam_kegiatan',
                    data: formData,                    
                })
                .then(function (res) {

                    if(res.data.responCode == 1){                      

                        loadData(tmpTahun);

                        $("#modalKegiatan").modal("hide");                

                    } else {   

                        Swal.fire({                    
                            icon: 'warning',                   
                            title: 'Ada kesalahan',
                            text: res.data.respon,                            
                        })
                    }

                })
                .catch(function (res) {
                    //handle error
                    console.log(res);
                });
            

            } 

            formRekamKro.onsubmit = (e) => {
                
                e.preventDefault();                

                let formData = new FormData(formRekamKro);   

                formData.append('tahun', tmpTahun);

                axios({
                    method: 'post',
                    url: '/unit/rekam_kro',
                    data: formData,                    
                })
                .then(function (res) {

                    if(res.data.responCode == 1){                      

                        loadData(tmpTahun);

                        $("#modalKro").modal("hide");                

                    } else {   

                        Swal.fire({                    
                            icon: 'warning',                   
                            title: 'Ada kesalahan',
                            text: res.data.respon,                            
                        })
                    }

                })
                .catch(function (res) {
                    //handle error
                    console.log(res);
                });
            

            } 

            formRekamRo.onsubmit = (e) => {
                
                e.preventDefault();                

                let formData = new FormData(formRekamRo);   

                formData.append('tahun', tmpTahun);

                axios({
                    method: 'post',
                    url: '/unit/rekam_ro',
                    data: formData,                    
                })
                .then(function (res) {

                    if(res.data.responCode == 1){                      

                        loadData(tmpTahun);

                        $("#modalRo").modal("hide");                

                    } else {   

                        Swal.fire({                    
                            icon: 'warning',                   
                            title: 'Ada kesalahan',
                            text: res.data.respon,                            
                        })
                    }

                })
                .catch(function (res) {
                    //handle error
                    console.log(res);
                });
            

            } 

            formRekamKomponen.onsubmit = (e) => {
                
                e.preventDefault();                

                let formData = new FormData(formRekamKomponen);   

                formData.append('tahun', tmpTahun);

                axios({
                    method: 'post',
                    url: '/unit/rekam_komponen',
                    data: formData,                    
                })
                .then(function (res) {

                    if(res.data.responCode == 1){                      

                        loadData(tmpTahun);

                        $("#modalKomponen").modal("hide");                

                    } else {   

                        Swal.fire({                    
                            icon: 'warning',                   
                            title: 'Ada kesalahan',
                            text: res.data.respon,                            
                        })
                    }

                })
                .catch(function (res) {
                    //handle error
                    console.log(res);
                });
            

            }

            formRekamSubKomponen.onsubmit = (e) => {
                
                e.preventDefault();                

                let formData = new FormData(formRekamSubKomponen);   

                formData.append('tahun', tmpTahun);

                axios({
                    method: 'post',
                    url: '/unit/rekam_sub_komponen',
                    data: formData,                    
                })
                .then(function (res) {

                    if(res.data.responCode == 1){                      

                        loadData(tmpTahun);

                        $("#modalSubKomponen").modal("hide");                

                    } else {   

                        Swal.fire({                    
                            icon: 'warning',                   
                            title: 'Ada kesalahan',
                            text: res.data.respon,                            
                        })
                    }

                })
                .catch(function (res) {
                    //handle error
                    console.log(res);
                });
            

            }

            formRekamAkun.onsubmit = (e) => {
                
                e.preventDefault();                

                let formData = new FormData(formRekamAkun);   

                formData.append('tahun', tmpTahun);

                axios({
                    method: 'post',
                    url: '/unit/rekam_akun',
                    data: formData,                    
                })
                .then(function (res) {

                    if(res.data.responCode == 1){                      

                        loadData(tmpTahun);

                        $("#modalAkun").modal("hide");                

                    } else {   

                        Swal.fire({                    
                            icon: 'warning',                   
                            title: 'Ada kesalahan',
                            text: res.data.respon,                            
                        })
                    }

                })
                .catch(function (res) {
                    //handle error
                    console.log(res);
                });
            

            }

            formRekamDetail.onsubmit = (e) => {
                
                e.preventDefault();                

                let formData = new FormData(formRekamDetail);   

                formData.append('tahun', tmpTahun);

                axios({
                    method: 'post',
                    url: '/unit/rekam_detail',
                    data: formData,                    
                })
                .then(function (res) {

                    if(res.data.responCode == 1){                      

                        loadData(tmpTahun);

                        $("#modalDetail").modal("hide");                

                    } else {   

                        Swal.fire({                    
                            icon: 'warning',                   
                            title: 'Ada kesalahan',
                            text: res.data.respon,                            
                        })
                    }

                })
                .catch(function (res) {
                    //handle error
                    console.log(res);
                });
            

            }

            formEditDetail.onsubmit = (e) => {
                e.preventDefault();                

                let formData = new FormData(formEditDetail);   

                axios({
                    method: 'post',
                    url: '/unit/update_detail',
                    data: formData,                    
                })
                .then(function (res) {

                    console.log(res);
                    if(res.data.responCode == 1){                      

                        loadData(tmpTahun);

                        $("#modalEditDetail").modal("hide");                

                    } else {   

                        Swal.fire({                    
                            icon: 'warning',                   
                            title: 'Ada kesalahan',
                            text: res.data.respon,                            
                        })
                    }

                })
                .catch(function (res) {
                    //handle error
                    console.log(res);
                });
            }

            formUpload.onsubmit = (e) => {
                
                e.preventDefault();                

                let formData = new FormData(formUpload);   

                formData.append('jenis', tmpJenis);

                let link = (tmpLevel == "detail") ? '/unit/upload_file_detail' : '/unit/upload_file_subkom';  

                axios({
                    method: 'post',
                    url: link,
                    data: formData,                    
                })
                .then(function (res) {

                    if(res.data.responCode == 1){                      
                        
                        Swal.fire({                    
                            icon: 'success',                   
                            title: 'Berhasil',
                        })

                        if(tmpLevel == "detail"){
                            loadListFileDetail(tmpLevelId, tmpJenis);
                        } else {
                            loadListFileSubKom(tmpLevelId, tmpJenis);
                        }

                        document.getElementById("formUpload").reset();

                        $("#modalUpload").modal("hide");


                    } else {   

                        Swal.fire({                    
                            icon: 'warning',                   
                            title: 'Ada kesalahan',
                            text: res.data.respon,                            
                        })
                    }

                })
                .catch(function (res) {
                    //handle error
                    console.log(res);
                });
            

            }         

            formTampil.onsubmit = (e) => {
                
                e.preventDefault();                                

                loadData(tmpTahun);

            }           
          
        }, false);     
         
    </script>
@endpush