@extends('layouts.master')
@section('title', 'Unit')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Master Unit</h1>            
        </div>
        <div class="section-body">                        
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <h4>Data Unit</h4>
                        </div>
                        <div class="card-body">
                            <button class="btn btn-primary" onclick="tambah()"><i class="fa fa-plus"></i> Tambah</button>
                            <div class="table-responsive mt-3">
                                <table class="table table-bordered" id="table">
                                    <thead>
                                        <th width="10%">No</th>
                                        <th>Unit</th>                                                                                                                     
                                        <th>Aksi</th>     
                                    </thead>                            
                                </table>
                                
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>            
        </div>       
    </section>
    <div class="modal fade" tabindex="-1" role="dialog" id="modalTambah">
        <div class="modal-dialog" role="document">
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
                        <label class="col-form-label col-12 col-md-3 col-lg-3">Unit</label>
                        <div class="col-sm-12 col-md-9">
                            <input type="text" class="form-control" id="unit" name="unit" placeholder="Nama Unit" autocomplete="off" required>
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEdit" method="post">                
                    <div class="modal-body">                    
                        <div class="form-group row">
                            <label class="col-form-label col-12 col-md-3 col-lg-3">Unit</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="hidden" name="id" id="idEdit">
                                <input type="text" class="form-control" id="unitEdit" name="unit" placeholder="Unit" autocomplete="off" required>
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
        let tmpOpd = '';

        tambah = () => {
            $("#modalTambah").modal("show");                
            document.getElementById("formTambah").reset();
        }

        editData = (id) => {

            $("#modalEdit").modal("show");                            
            
            axios.post('/admin/get_unit_byId', {                                
                id
            })
            .then((response) => {                     

                let curData = response.data;
                $("#idEdit").val(curData.id);                           
                $("#unitEdit").val(curData.unit);                
                
            }, (error) => {
                console.log(error);
            });
            
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

                    axios.post('/admin/hapus_unit', {                                
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

                            loadData();
                            
                        } else {
                            Swal.fire({                                
                                icon: 'warning',                   
                                title: 'Gagal...',
                                text: response.data.respon,                            
                            })
                        }
                    }, (error) => {
                        console.log(error);
                    });
                }            

            });
        }

        loadData = () => {
            
            $('#table').DataTable().destroy();

            $('#table').DataTable({
                processing: false,
                serverSide: false,
                ajax: '/admin/data_unit',
                columns: [
                    { data: 'no', name:'id', render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }},
                    { data: 'unit', name: 'unit' },
                    { 'data': null, wrap: true, "render": function (item) { 
                            return `<button type="button" title="edit" onclick="editData(${item.id})" class="btn btn-primary"><i class="fas fa-edit"></i></button> 
                            <button type="button" title="hapus" onclick="hapusData(${item.id})" class="btn btn-danger"><i class="fas fa-trash"></i></button>` 
                        } 
                    },                      
                ]
            });           
        }

        document.addEventListener('DOMContentLoaded', function() {            

            loadData();

            formTambah.onsubmit = (e) => {
            
                e.preventDefault();     

                let formData = new FormData(formTambah);   

                axios({
                    method: 'post',
                    url: '/admin/tambah_unit',
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

                        loadData();
                        $("#modalTambah").modal("hide");                

                        
                    } else {
                      
                        Swal.fire({                    
                            icon: 'warning',                   
                            title: 'Ada kesalahan',
                            text: `${response.data.respon}`,                            
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
                    url: '/admin/update_unit',
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

                        loadData();
                        $("#modalEdit").modal("hide");                

                        
                    } else {
                       
                        Swal.fire({                    
                            icon: 'warning',                   
                            title: 'Ada kesalahan',
                        })
                    }
                })
                .catch(function (response) {
                    //handle error
                    console.log(response);
                });

            }            

                     
        }, false);     
         
        // console.log('tes');
    </script>
@endpush