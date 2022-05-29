@extends('layouts.master')
@section('title', 'Produk')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Master Produk</h1>            
        </div>
        <div class="section-body">                        
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <h4>Data Produk</h4>
                        </div>
                        <div class="card-body">                            
                            <button class="btn btn-primary" onclick="tambah()"><i class="fa fa-plus"></i> Tambah</button>
                            <div class="table-responsive mt-3">
                                <table class="table table-bordered" id="table">
                                    <thead>
                                        <th width="10%">No</th>
                                        <th>Produk</th>                                                                                                                     
                                        <th>Deskripsi</th>                                                                                                                     
                                        <th>Harga</th>                                                                                                                     
                                        <th>Kategori</th>                                                                                                                     
                                        <th>Gambar</th>                                                                                                                     
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

    <div class="modal fade" role="dialog" id="modalTambah">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Tambah Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formTambah" method="post" enctype="multipart/form-data">                
                <div class="modal-body">      
                    <div class="alert alert-danger print-error-msg" style="display:none">

                        <ul></ul>
                
                    </div>                        
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-3 col-lg-3">Nama Produk</label>
                        <div class="col-sm-12 col-md-9">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Produk" autocomplete="off" >
                        </div>
                    </div>         
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-3 col-lg-3">Deskripsi</label>
                        <div class="col-sm-12 col-md-9">
                            <textarea name="description" id="" cols="30" rows="10" class="form-control" ></textarea>
                        </div>
                    </div>         
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-3 col-lg-3">Harga</label>
                        <div class="col-sm-12 col-md-9">
                            <input type="text" class="form-control" id="price" name="price" placeholder="Harga" autocomplete="off" >
                        </div>
                    </div>                        
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-3 col-lg-3">Kategori</label>
                        <div class="col-sm-12 col-md-9">
                            <select name="category_id" id="category_id" class="form-control select2" >
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>       
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-3 col-lg-3">Gambar</label>
                        <div class="col-sm-12 col-md-9">
                            <input type="file" name="image" class="form-control" id="image" >
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
                <form id="formEdit" enctype="multipart/form-data">                
                    <div class="modal-body">      
                        <div class="alert alert-danger print-error-msg" style="display:none">

                            <ul></ul>
                    
                        </div>                                                                      
                        <div class="form-group row">
                            <label class="col-form-label col-12 col-md-3 col-lg-3">Produk</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="hidden" id="idEdit" name="id" required>
                                <input type="text" class="form-control" id="name_e" name="name" placeholder="Produk" autocomplete="off" >
                            </div>
                        </div>         
                        <div class="form-group row">
                            <label class="col-form-label col-12 col-md-3 col-lg-3">Deskripsi</label>
                            <div class="col-sm-12 col-md-9">
                                <textarea name="description" id="description_e" cols="30" rows="10" class="form-control" ></textarea>
                            </div>
                        </div>         
                        <div class="form-group row">
                            <label class="col-form-label col-12 col-md-3 col-lg-3">Harga</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="text" class="form-control" id="price_e" name="price" placeholder="Harga" autocomplete="off" >
                            </div>
                        </div>                        
                        <div class="form-group row">
                            <label class="col-form-label col-12 col-md-3 col-lg-3">Kategori</label>
                            <div class="col-sm-12 col-md-9">
                                <select name="category_id" id="category_e" class="form-control select2" >
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>       
                        <div class="form-group row">
                            <label class="col-form-label col-12 col-md-3 col-lg-3">Gambar</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="file" name="image" class="form-control" id="image_e">
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
        let curData = '';

        tambah = () => {
            $("#modalTambah").modal("show");                
            $(".print-error-msg").css('display','none');
            $("#category_id").val('').trigger('change');
            document.getElementById("formTambah").reset();
        }

        editData = (id) => {
            
            $(".print-error-msg").css('display','none');
            
            let url = "{{ route('products.edit', ':product') }}";
            url = url.replace(':product',id);

            axios.get(url)
            .then((res) => {                            
                
                let data = res.data;

                document.getElementById("formEdit").reset();

                $("#idEdit").val(data.id);           
                $("#name_e").val(data.name);                
                $("#description_e").val(data.description);                
                $("#price_e").val(data.price);                                   
                
                $("#category_e").val(data.category_id).trigger('change');

                $("#modalEdit").modal("show");       

            }, (error) => {
                console.log(error);
            });                                  
                   
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

                    axios.delete(`/products/${id}`)
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

            $('#table').DataTable().destroy();

            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('products.data') }}",
                columns: [
                    { data: 'no', name:'id', render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }},
                    { "data": "name" },
                    { "data": "description" },
                    { "data": "price_formatted" },
                    { "data": "category.name" },
                    { 'data': null, wrap: true, "render": function (item) { 
                            return `<img src="${item.image_url}" width="100" heigh="100"></img>` 
                        } 
                    },     
                    { 'data': null, wrap: true, "render": function (item) { 
                            return `<button type="button" title="edit" onclick="editData(${item.id})" class="btn btn-primary"><i class="fas fa-edit"></i></button> 
                            <button type="button" title="hapus" onclick="hapusData(${item.id})" class="btn btn-danger"><i class="fas fa-trash"></i></button>` 
                        } 
                    },     
                ],
            });            
        }        

        document.addEventListener('DOMContentLoaded', function() {            

            loadData();

            formTambah.onsubmit = (e) => {
            
                e.preventDefault();     

                let formData = new FormData(formTambah);   

                axios({
                    method: 'post',
                    url: '{{ route("products.store") }}',
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

                    // console.log(error.response.data.errors);

                    $(".print-error-msg").find("ul").html('');
                    $(".print-error-msg").css('display','block');

                    $.each( error.response.data.errors, function( key, value ) {
                        $(".print-error-msg").find("ul").append('<li>'+value+'</li>');

                    });
                    
                    
                });

            }

            formEdit.onsubmit = (e) => {
            
                e.preventDefault();     

                let formData = new FormData(formEdit); 
                let id = $("#idEdit").val();

                formData.append('_method', 'PUT');

                axios({
                    method: 'POST',
                    url: `/products/${id}`,
                    data: formData,                    
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