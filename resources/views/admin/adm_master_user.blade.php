@extends('layouts.master')
@section('title', 'User')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Master User</h1>            
        </div>
        <div class="section-body">                        
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <h4>Data User</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" id="formTampilUser">
                                <div class="form-group">
                                    <label class="col-form-label col-12 col-md-2">Pilih Role User</label>
                                    <div class="col-sm-12 col-md-5">
                                        <select id="selectRole" name="role" class="form-control" required>
                                            <option value="">Pilih Role</option>                                                
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ ucfirst($role->role) }}</option>                                                
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
                            <div class="col-12" id="divUser">
                                
                            </div>                          
                            <div class="table-responsive col-12 mt-3">
                                <div id="dataUser">                                    
                                    <table class="table table-bordered" id="tableUser">
                                        <thead>
    
                                        </thead>
                                        <tbody>
    
                                        </tbody>
                                    </table>             
                                </div>       
                                <div id="dataBagian">                                                                    
                                    <table class="table table-bordered" id="tableBagian">
                                        <thead>
    
                                        </thead>
                                        <tbody>
    
                                        </tbody>
                                    </table>                                    
                                </div>
                            </div>         
                        </div>
                    </div>
                </div>
            </div>            
        </div>       
    </section>
    <div class="modal fade" tabindex="-1" role="dialog" id="modalTambahUserUnit">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Tambah Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formTambahUserUnit" method="post">                
                <div class="modal-body">                    
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-3 col-lg-3">Nama</label>
                        <div class="col-sm-12 col-md-9">
                            <input type="hidden" class="form-control" id="role_unit" name="role_user">
                            <input type="text" class="form-control" name="nama" placeholder="Nama" autocomplete="off" required>
                        </div>
                    </div>                        
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-3 col-lg-3">Email</label>
                        <div class="col-sm-12 col-md-9">
                            <input type="text" class="form-control" name="email" placeholder="Email" autocomplete="off" required>
                        </div>
                    </div>           
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-3 col-lg-3">Password</label>
                        <div class="col-sm-12 col-md-9">
                            <input type="password" class="form-control"  name="password" placeholder="Password" required>
                        </div>
                    </div>           
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-3 col-lg-3">Password Konfirmasi</label>
                        <div class="col-sm-12 col-md-9">
                            <input type="password" class="form-control"  name="password_confirmation" placeholder="Password Konfirmasi" required>
                        </div>
                    </div>           
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-3 col-lg-3">Unit</label>
                        <div class="col-sm-12 col-md-9">
                            <select name="unit" id="unit" required class="form-control"></select>
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

    <div class="modal fade" tabindex="-1" role="dialog" id="modalTambahUserBagian">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Tambah Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formTambahUserBagian" method="post">                
                <div class="modal-body">                    
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-3 col-lg-3">Nama</label>
                        <div class="col-sm-12 col-md-9">
                            <input type="hidden" class="form-control" id="role_bagian" name="role_user">
                            <input type="text" class="form-control" name="nama" placeholder="Nama" autocomplete="off" required>
                        </div>
                    </div>                        
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-3 col-lg-3">Email</label>
                        <div class="col-sm-12 col-md-9">
                            <input type="text" class="form-control" name="email" placeholder="Email" autocomplete="off" required>
                        </div>
                    </div>           
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-3 col-lg-3">Password</label>
                        <div class="col-sm-12 col-md-9">
                            <input type="password" class="form-control"  name="password" placeholder="Password" required>
                        </div>
                    </div>           
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-3 col-lg-3">Password Konfirmasi</label>
                        <div class="col-sm-12 col-md-9">
                            <input type="password" class="form-control"  name="password_confirmation" placeholder="Password Konfirmasi" required>
                        </div>
                    </div>           
                    <div class="form-group row">
                        <label class="col-form-label col-12 col-md-3 col-lg-3">Bagian</label>
                        <div class="col-sm-12 col-md-9">
                            <select name="bagian" id="bagian" required class="form-control"></select>
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
    
    <div class="modal fade" tabindex="-1" role="dialog" id="modalEditUserUnit">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEditUserUnit" method="post">                
                    <div class="modal-body">                    
                        <div class="form-group row">
                            <label class="col-form-label col-12 col-md-3 col-lg-3">Nama</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="hidden" class="form-control" id="role_unit_e" name="role_user">
                                <input type="hidden" class="form-control" id="id_u_e" name="user_id">
                                <input type="text" class="form-control" name="nama" id="nama_u_e" placeholder="Nama" autocomplete="off" required>
                            </div>
                        </div>                        
                        <div class="form-group row">
                            <label class="col-form-label col-12 col-md-3 col-lg-3">Email</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="text" class="form-control" name="email" id="email_u_e" placeholder="Email" autocomplete="off" required>
                            </div>
                        </div>                                  
                        <div class="form-group row">
                            <label class="col-form-label col-12 col-md-3 col-lg-3">Unit</label>
                            <div class="col-sm-12 col-md-9">
                                <select name="unit" id="unit_e" required class="form-control"></select>
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

    <div class="modal fade" tabindex="-1" role="dialog" id="modalEditUserBagian">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEditUserBagian" method="post">                
                    <div class="modal-body">                    
                        <div class="form-group row">
                            <label class="col-form-label col-12 col-md-3 col-lg-3">Nama</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="hidden" class="form-control" id="role_bagian_e" name="role_user">
                                <input type="hidden" class="form-control" id="id_b_e" name="user_id">
                                <input type="text" class="form-control" name="nama" id="nama_b_e" placeholder="Nama" autocomplete="off" required>
                            </div>
                        </div>                        
                        <div class="form-group row">
                            <label class="col-form-label col-12 col-md-3 col-lg-3">Email</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="text" class="form-control" name="email" id="email_b_e" placeholder="Email" autocomplete="off" required>
                            </div>
                        </div>                                  
                        <div class="form-group row">
                            <label class="col-form-label col-12 col-md-3 col-lg-3">Bagian</label>
                            <div class="col-sm-12 col-md-9">
                                <select name="bagian" id="bagian_e" required class="form-control"></select>
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
        let role = '';

        tambah = () => {

            //cek role
            if(role == 2){
                $("#modalTambahUserUnit").modal("show");       
                $("#role_unit").val(role);         
                document.getElementById("formTambahUserUnit").reset();
            } else {
                $("#modalTambahUserBagian").modal("show");       
                $("#role_bagian").val(role);         
                document.getElementById("formTambahUserBagian").reset();
            }
            
        }

        editData = (user_id) => {

            let curData = tmpData.filter((data) => {
                return data.user_id == user_id;                
            })            
                                                  
            if(role == 2){
                
                $("#id_u_e").val(curData[0].user_id); 
                $("#role_unit_e").val(role); 
                $("#nama_u_e").val(curData[0].name);     
                $("#email_u_e").val(curData[0].email); 
                $("#unit_e").val(curData[0].unit_id);

                $("#modalEditUserUnit").modal("show");                                        

            } else if(role == 3){
                
                $("#id_b_e").val(curData[0].user_id); 
                $("#role_bagian_e").val(role); 
                $("#nama_b_e").val(curData[0].name);     
                $("#email_b_e").val(curData[0].email); 
                $("#bagian_e").val(curData[0].bagian_id);

                $("#modalEditUserBagian").modal("show");                                        
            }
                               
                   
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

                    axios.post('/admin/hapus_user', {                                
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

                            loadUser(role);
                            
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

        loadUnit = () => {
            axios.post('/admin/get_unit', {                                
            })
            .then((res) => {                            

                let opt = '<option value="">Pilih Unit</option>';
                if(res.data.length > 0){

                    tmpOpd = res.data;
                    
                    res.data.forEach((data, index) => {
                        opt += `
                            <option value="${data.id}">${data.unit}</option>                    
                        `;
                    })
                    
                    document.getElementById("unit").innerHTML = opt;
                    document.getElementById("unit_e").innerHTML = opt;

                }

            
            }, (error) => {
                console.log(error);
            });
        }

        loadBagian = () => {
            axios.post('/admin/get_bagian', {                                
            })
            .then((res) => {                            

                let opt = '<option value="">Pilih Bagian</option>';
                if(res.data.length > 0){

                    tmpOpd = res.data;
                    
                    res.data.forEach((data, index) => {
                        opt += `
                            <option value="${data.id}">${data.bagian}</option>                    
                        `;
                    })
                    
                    document.getElementById("bagian").innerHTML = opt;
                    document.getElementById("bagian_e").innerHTML = opt;

                }

            
            }, (error) => {
                console.log(error);
            });
        }

        loadUser = (formData) => {

            data = {
                role:formData
            }
            axios({
                method: 'post',
                url: '/admin/data_user',
                data: data,                    
            })
            .then(function (response) {
                
                let isiData = '';
                let thead = '';         
                let tr = '';          

                role = $("#selectRole").val();

                if(role == 2){

                    isiData = 
                    `
                        <h4>Data User Unit</h4>         
                        <button class="btn btn-primary" onclick="tambah()"><i class="fa fa-plus"></i> Tambah</button>
                    `; 

                    thead = `
                        
                        <tr>
                            <th width="10%">No</th>
                            <th>Nama</th>                                 
                            <th>Email</th>
                            <th>Unit</th>    
                            <th>Aksi</th>     
                        </tr>
                        
                    `;

                    if(response.data.length > 0){

                        tmpData = response.data;

                        response.data.forEach((data, index) => {
                            tr += `<tr>
                                <td>${++index}</td>
                                <td>${data.name}</td>
                                <td>${data.email}</td>
                                <td>${data.unit}</td>
                                <td>
                                    <button class="btn btn-primary" onclick='editData(${data.user_id})'>Edit</button>
                                    <button class="btn btn-danger" onclick='hapusData(${data.user_id})'>Hapus</button>
                                </td>
                            </tr>`
                        })

                    }

                    $("#dataUser").show();       
                    $("#dataBagian").hide();  
                    

                    $("#tableUser thead").html(thead);                            
                    $("#tableUser tbody").html(tr);                
                    $('#tableUser').DataTable();   

                } else if(role == 3){

                    isiData = 
                    `
                        <h4>Data User Bagian</h4>         
                        <button class="btn btn-primary" onclick="tambah()"><i class="fa fa-plus"></i> Tambah</button>
                    `; 

                    thead = `
                        
                        <tr>
                            <th width="10%">No</th>
                            <th>Nama</th>                                 
                            <th>Email</th>
                            <th>Bagian</th>    
                            <th>Aksi</th>     
                        </tr>
                        
                    `;

                    if(response.data.length > 0){

                        tmpData = response.data;

                        response.data.forEach((data, index) => {
                            tr += `<tr>
                                <td>${++index}</td>
                                <td>${data.name}</td>
                                <td>${data.email}</td>
                                <td>${data.bagian}</td>
                                <td>
                                    <button class="btn btn-primary" onclick='editData(${data.user_id})'>Edit</button>
                                    <button class="btn btn-danger" onclick='hapusData(${data.user_id})'>Hapus</button>
                                </td>
                            </tr>`
                        })

                    } 

                    $("#dataUser").hide();                                                
                    $("#dataBagian").show();  

                    $("#tableBagian thead").html(thead);                            
                    $("#tableBagian tbody").html(tr);                
                    $('#tableBagian').DataTable();
                }           

                $("#divUser").html(isiData);
                          

            })
            .catch(function (response) {
                //handle error
                console.log(response);
            });
        }

        document.addEventListener('DOMContentLoaded', function() {            

            // loadData();
            loadUnit();
            loadBagian();

            formTampilUser.onsubmit = (e) => {
                
                e.preventDefault();                

                let formData = $("#selectRole").val();  

                loadUser(formData);

            }

            formTambahUserUnit.onsubmit = (e) => {
            
                e.preventDefault();     

                let formData = new FormData(formTambahUserUnit);   

                axios({
                    method: 'post',
                    url: '/admin/tambah_user',
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

                        //cek role
                        if(role == 2){
                            loadUser(role);
                            $("#modalTambahUserUnit").modal("hide");   
                        }
                        
                    } else {
                        const keys = Object.keys(response.data.respon)
                        let data_li = '';
                        for (const key of keys) {
                            data_li += `<li>${response.data.respon[key][0]}</li>`;                            
                        }
                        Swal.fire({                    
                            icon: 'warning',                   
                            title: 'Ada kesalahan',
                            html: `<ul>${data_li}</ul>`,                            
                        })
                    }
                })
                .catch(function (response) {
                    //handle error
                    console.log(response);
                });

            }

            formTambahUserBagian.onsubmit = (e) => {
            
                e.preventDefault();     

                let formData = new FormData(formTambahUserBagian);   

                axios({
                    method: 'post',
                    url: '/admin/tambah_user',
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

                        //cek role
                        if(role == 3){
                            loadUser(role);
                            $("#modalTambahUserBagian").modal("hide");   
                        }
                        
                    } else {
                        const keys = Object.keys(response.data.respon)
                        let data_li = '';
                        for (const key of keys) {
                            data_li += `<li>${response.data.respon[key][0]}</li>`;                            
                        }
                        Swal.fire({                    
                            icon: 'warning',                   
                            title: 'Ada kesalahan',
                            html: `<ul>${data_li}</ul>`,                            
                        })
                    }
                })
                .catch(function (response) {
                    //handle error
                    console.log(response);
                });

            }

            formEditUserUnit.onsubmit = (e) => {
            
                e.preventDefault();     

                let formData = new FormData(formEditUserUnit);   

                axios({
                    method: 'post',
                    url: '/admin/update_user',
                    data: formData,                    
                })
                .then(function (response) {
                    // console.log(response);
                    //handle success                    
                    if(response.data.responCode == 1){
                        Swal.fire({            
                            icon: 'success',                   
                            title: 'Berhasil',                            
                            timer: 2000,                                
                            showConfirmButton: false
                        })

                        //cek role
                        loadUser(role);
                        $("#modalEditUserUnit").modal("hide");   
                        
                    } else {
                        const keys = Object.keys(response.data.respon)
                        let data_li = '';
                        for (const key of keys) {
                            data_li += `<li>${response.data.respon[key][0]}</li>`;                            
                        }
                        Swal.fire({                    
                            icon: 'warning',                   
                            title: 'Ada kesalahan',
                            html: `<ul>${data_li}</ul>`,                            
                        })
                    }
                })
                .catch(function (response) {
                    //handle error
                    console.log(response);
                });

            }

            formEditUserBagian.onsubmit = (e) => {
            
                e.preventDefault();     

                let formData = new FormData(formEditUserBagian);   

                axios({
                    method: 'post',
                    url: '/admin/update_user',
                    data: formData,                    
                })
                .then(function (response) {
                    // console.log(response);
                    //handle success                    
                    if(response.data.responCode == 1){
                        Swal.fire({            
                            icon: 'success',                   
                            title: 'Berhasil',                            
                            timer: 2000,                                
                            showConfirmButton: false
                        })

                        //cek role
                        loadUser(role);
                        $("#modalEditUserBagian").modal("hide");   
                        
                    } else {
                        const keys = Object.keys(response.data.respon)
                        let data_li = '';
                        for (const key of keys) {
                            data_li += `<li>${response.data.respon[key][0]}</li>`;                            
                        }
                        Swal.fire({                    
                            icon: 'warning',                   
                            title: 'Ada kesalahan',
                            html: `<ul>${data_li}</ul>`,                            
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