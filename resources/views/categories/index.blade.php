@extends('layouts.master')
@section('title', 'Kategori')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Master Kategori</h1>            
        </div>
        <div class="section-body">                        
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <h4>Data Kategori</h4>
                        </div>
                        <div class="card-body">                            
                            <button class="btn btn-primary" onclick="tambah()"><i class="fa fa-plus"></i> Tambah</button>
                            <div class="table-responsive mt-3">
                                <table class="table table-bordered" id="table">
                                    <thead>
                                        <th width="10%">No</th>
                                        <th>Kategori</th>                                                                                                                     
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
                    <div class="alert alert-danger print-error-msg" style="display:none">

                        <ul></ul>
                
                    </div>                      
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-3 col-lg-3">Kategori</label>
                        <div class="col-sm-12 col-md-9">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Kategori" autocomplete="off" >
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
                        <div class="alert alert-danger print-error-msg" style="display:none">

                            <ul></ul>
                    
                        </div>                                                                          
                        <div class="form-group row">
                            <label class="col-form-label col-12 col-md-3 col-lg-3">Kategori</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="hidden" id="idEdit" name="id" required>
                                <input type="text" class="form-control" id="name_e" name="name" placeholder="Kategori" autocomplete="off" >
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

        tambah = () => {
            $("#modalTambah").modal("show");                
            $(".print-error-msg").css('display','none');
            document.getElementById("formTambah").reset();
        }

        editData = (id) => {

            $(".print-error-msg").css('display','none');

            let curData = tmpData.filter((data) => {
                return data.id == id;                
            })                              
            
            $("#idEdit").val(curData[0].id);           
            $("#name_e").val(curData[0].name);                
                
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

                    axios.delete(`/categories/${id}`)
                    .then(response => {     
                        
                        Swal.fire({                                
                            icon: 'success',                   
                            title: 'Berhasil',                                
                            timer: 2000,                                
                            showConfirmButton: false
                        })

                        loadData();
                                                    
                    })
                    .catch(error => {
                        console.log(error);
                        //     Swal.fire({                                
                        //         icon: 'warning',                   
                        //         title: 'Gagal...',
                        //         text: response.data.respon,                            
                        //     })
                        // }
                    })

                }            

            });
        }

        loadData = () => {

            axios.get('{{ route("categories.data") }}', {                                
            })
            .then((res) => {                            
                
                let data_tr = '';
                if(res.data.length > 0){

                    tmpData = res.data;
                    res.data.forEach((data, index) => {
                        data_tr += `
                            <tr>
                                <td>${++index}</td>
                                <td>${data.name}</td>
                                <td>
                                    <button class="btn btn-primary" onclick="editData(${data.id})"><i class="fas fa-edit"></i></button>
                                    <button 
                                    ${(() => {
                                        if(data.product != null) {
                                            return `disabled`;
                                        }
                                    })()}
                                    class="btn btn-danger" onclick="hapusData(${data.id})"><i class="fas fa-trash"></i></button>
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

        document.addEventListener('DOMContentLoaded', function() {            

            loadData();

            formTambah.onsubmit = (e) => {
            
                e.preventDefault();     

                let formData = new FormData(formTambah);   

                axios({
                    method: 'post',
                    url: '{{ route("categories.store") }}',
                    data: formData,                    
                })
                .then(function (response) {
                    //handle success                    
                    Swal.fire({            
                        icon: 'success',                   
                        title: 'Berhasil',                            
                        timer: 2000,                                
                        showConfirmButton: false
                    })

                    loadData();
                    $("#modalTambah").modal("hide");                
 
                })
                .catch(function (error) {
                    //handle error
                    $(".print-error-msg").find("ul").html('');
                    $(".print-error-msg").css('display','block');

                    $.each( error.response.data.errors, function( key, value ) {
                        $(".print-error-msg").find("ul").append('<li>'+value+'</li>');

                    });
                    
                });

            }

            formEdit.onsubmit = (e) => {
            
                e.preventDefault();     

                let id = $("#idEdit").val();

                const request = {
                    name: $("#name_e").val()
                }

                axios({
                    method: 'PUT',
                    url: `/categories/${id}`,
                    data: request,                    
                })
                .then(function (res) {
                    // handle success                                        
                    Swal.fire({            
                        icon: 'success',                   
                        title: 'Berhasil',                            
                        timer: 2000,                                
                        showConfirmButton: false
                    })

                    loadData();
                    $("#modalEdit").modal("hide");                
                       
                })
                .catch(function (error) {
                    //handle error
                    $(".print-error-msg").find("ul").html('');
                    $(".print-error-msg").css('display','block');

                    $.each( error.response.data.errors, function( key, value ) {
                        $(".print-error-msg").find("ul").append('<li>'+value+'</li>');

                    });
                });

            }            

                     
        }, false); 
        
    </script>
@endpush