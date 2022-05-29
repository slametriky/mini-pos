@extends('layouts.master')
@section('title', 'RO')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Master RO</h1>            
        </div>
        <div class="section-body">                        
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <h4>Data RO</h4>
                        </div>
                        <div class="card-body">           
                            <form method="POST" id="formTampil">
                                <div class="form-group">
                                    <div class="col-sm-12 col-md-6">
                                        <select id="selectKro" name="kro" class="form-control" required>
                                            <option value="">Pilih KRO</option>                                                
                                            @foreach ($kros as $kro)
                                                <option value="{{ $kro->id }}">({{ $kro->kode_kegiatan }}) {{ $kro->kode_kro }}-{{ $kro->desk_kro }}</option>                                                
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
                            <div class="table-responsive col-12">
                                <button class="btn btn-primary mb-2" onclick="tambah()"><i class="fa fa-plus"></i> Tambah</button>
                                <table class="table table-bordered" id="table">
                                    <thead>
                                        <th width="10%">No</th>
                                        <th>Kode</th>                                                                                                                     
                                        <th>RO</th>    
                                        <th>Aksi</th>     
                                    </thead>   
                                    <tbody id="tableData"></tbody>                         
                                </table>
                                
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>            
        </div>       
    </section>
    <div class="modal fade" tabindex="-1" role="dialog" id="modalTambah">
        <div class="modal-dialog modal-lg role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Tambah Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formTambah" method="post">                
                <div class="modal-body">     
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-2 col-lg-2">KRO</label>
                        <div class="col-sm-12 col-md-9">
                            <select name="kro" class="form-control" id="kro" required>

                            </select>
                        </div>
                    </div>       
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-2 col-lg-2">Kode</label>
                        <div class="col-sm-12 col-md-2">
                            <input type="text" maxlength="3" minlength="3" class="form-control" id="kode" name="kode" placeholder="Kode" autocomplete="off" required>
                        </div>
                    </div>               
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-2 col-lg-2">RO</label>
                        <div class="col-sm-12 col-md-9">
                            <input type="text" class="form-control" id="ro" name="ro" placeholder="RO" autocomplete="off" required>
                        </div>
                    </div>                                                             
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
          </div>
        </div>
    </div>    
    
    <div class="modal fade" tabindex="-1" role="dialog" id="modalEdit">
        <div class="modal-dialog modal-lg role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formEdit" method="post">                
                <div class="modal-body">     
                    <input type="hidden" name="id" id="idEdit">  
                    <input type="hidden" name="kro" id="kroEdit">     
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-2 col-lg-2">Kode</label>
                        <div class="col-sm-12 col-md-2">
                            <input type="text" maxlength="3" minlength="3" class="form-control" id="kode_e" name="kode" placeholder="Kode" autocomplete="off" required>
                        </div>
                    </div>               
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-2 col-lg-2">RO</label>
                        <div class="col-sm-12 col-md-9">
                            <input type="text" class="form-control" id="ro_e" name="ro" placeholder="RO" autocomplete="off" required>
                        </div>
                    </div>                                                             
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
          </div>
        </div>
    </div> 
@endsection
    
@push('page-script')
    <script>

        let tmpData = '';
        let tmpId = '';

        tambah = () => {
            $("#modalTambah").modal("show");                
            document.getElementById("formTambah").reset();
        }

        editData = (id) => {

            let curData = tmpData.filter((data) => {
                return data.id == id;                
            })                              
            
            $("#idEdit").val(curData[0].id);      
            $("#kroEdit").val(tmpId);           
            $("#kode_e").val(curData[0].kode_ro);                
            $("#ro_e").val(curData[0].desk_ro);                
                
            $("#modalEdit").modal("show");                            
                   
        }

        hapusData = (id) => {
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

                    axios.post('/admin/hapus_ro', {                                
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

                            if(tmpId != ''){
                                loadData(tmpId);
                            }
                            
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

        loadData = (kro) => {
            
            tmpId = kro;
            
            axios.post('/admin/tampil_ro', {                                
                kro
            })
            .then((res) => {                            
                
                $('#table').DataTable().destroy();

                let data_tr = '';
                if(res.data.length > 0){

                    tmpData = res.data;
                    res.data.forEach((data, index) => {
                        data_tr += `
                            <tr>
                                <td>${++index}</td>
                                <td>${data.kode_ro}</td>
                                <td>${data.desk_ro}</td>
                                <td>
                                    <button class="btn btn-primary" onclick="editData(${data.id})">Edit</button>
                                    <button class="btn btn-danger" onclick="hapusData(${data.id})">Hapus</button>
                                </td>                                
                            </tr>                            
                        `;
                    })
                }

                document.getElementById("tableData").innerHTML = data_tr;
                $('#table').DataTable();

            }, (error) => {
                console.log(error);
            });
        }

        loadKro = () => {
            axios.post('/admin/data_kro', {                                
            })
            .then((res) => {                            

                let opt = '<option value="">Pilih KRO</option>';
                if(res.data.length > 0){

                    tmpOpd = res.data;
                    
                    res.data.forEach((data, index) => {
                        opt += `
                            <option value="${data.id}">(${data.kode_kegiatan}) ${data.kode_kro}-${data.desk_kro}</option>                    
                        `;
                    })
                    
                    document.getElementById("kro").innerHTML = opt;

                }

            
            }, (error) => {
                console.log(error);
            });
        }

        document.addEventListener('DOMContentLoaded', function() {            

            loadKro();
            
            formTambah.onsubmit = (e) => {
            
                e.preventDefault();     

                let formData = new FormData(formTambah);   

                axios({
                    method: 'post',
                    url: '/admin/tambah_ro',
                    data: formData,                    
                })
                .then(function (response) {
                    //handle success                    
                    if(response.data.responCode == 1){
                        Swal.fire({            
                            icon: 'success',                   
                            title: 'Berhasil',                            
                            timer: 2000,                                
                            showConfirmButton: false
                        })

                        if(tmpId != ''){
                            loadData(tmpId);
                        }

                        $("#modalTambah").modal("hide");                

                    } else {   

                        Swal.fire({                    
                            icon: 'warning',                   
                            title: 'Ada kesalahan',
                            text: response.data.respon,                            
                        })
                    }
                })
                .catch(function (response) {
                    //handle error
                    console.log(response);
                });

            }

            formEdit.onsubmit = (e) => {
            
                e.preventDefault();     

                let formData = new FormData(formEdit);   

                axios({
                    method: 'post',
                    url: '/admin/update_ro',
                    data: formData,                    
                })
                .then(function (response) {
                    //handle success 
                                                         
                    if(response.data.responCode == 1){
                        Swal.fire({            
                            icon: 'success',                   
                            title: 'Berhasil',                            
                            timer: 2000,                                
                            showConfirmButton: false
                        })

                        if(tmpId != ''){
                            loadData(tmpId);
                        }
                        $("#modalEdit").modal("hide");                
                        
                    } else {
                       
                        Swal.fire({                    
                            icon: 'warning',                   
                            title: 'Ada kesalahan',
                            text: response.data.respon
                        })
                    }
                })
                .catch(function (response) {
                    //handle error
                    console.log(response);
                });

            }       

            formTampil.onsubmit = (e) => {
                
                e.preventDefault();                

                let kro = $("#selectKro").val();  

                loadData(kro);

            }     

                     
        }, false);     
         
    </script>
@endpush