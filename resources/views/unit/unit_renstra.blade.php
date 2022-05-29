@extends('layouts.master')
@section('title', 'Renstra')

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
</style>
    
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Master Renstra</h1>            
        </div>
        <div class="section-body">                        
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <h4>Data Renstra</h4>
                        </div>
                        <div class="card-body">           
                            <form method="POST" id="formTampil">
                                <div class="form-group">
                                    <div class="col-sm-12 col-md-6">
                                        <select id="selectPeriode" name="periode"  class="form-control" required>
                                            <option value="">Pilih Periode</option>   
                                            @foreach ($periodes as $periode)
                                                <option value="{{ $periode->id }}">{{ $periode->tahun_mulai }}-{{ $periode->tahun_selesai }}</option>
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
                                <button style="display: none" class="btn btn-primary mb-2" id="btnBuatRenstra" onclick="btnBuatRenstra()">Buat Renstra</button>
                                <table class="custom-table" id="table">
                                    <thead>
                                        <th>No</th>
                                        <th>Periode Renstra</th>
                                        <th>Tahun Tersimpan</th>
                                        <th>Status</th>                                                                                                                                                                 
                                        <th>Aksi</th>     
                                    </thead>   
                                    <tbody id="tableData">
                                        
                                    </tbody>                         
                                </table>                                
                            </div>                                                
                        </div>
                    </div>
                </div>
            </div>      
            
            <div class="row" id="lihatRenstra" style="display: none">                                
                <div class="col-12 col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Renstra yang sudah diinput</h4>
                        </div>
                        <div class="card-body" id="tabRenstra">
                            
                        </div>
                    </div>
                </div>
            </div>     
        </div>       
    </section>
    
    
    {{-- modal komentar sub kegiatan --}}
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
        let tmpPeriode = '';   
        let tmpTahun = '';   
        let tmpPerTahun = '';   
        let domain = '{{ asset('assets/file/') }}/'; 
                     
        loadData = (periode) => {
                        
            axios.post('/unit/data_renstra', {                                
                periode
            })
            .then((res) => {                            
                
                let data_tr = '';
                
                if(res.data.length > 0){

                    tmpData = res.data;

                    document.getElementById("btnBuatRenstra").style.display = "none";                    

                    res.data.forEach((data, index) => {
                        data_tr += `<tr>
                            <td class="text-center">${++index}</td>
                            <td class="text-center"><a href="javascript:void(0)" onclick="detailRenstra()">${data.periode}</a></td>   
                            <td class="text-center">
                                ${data.tahun}
                            </td>           
                            <td class="text-center">
                                ${data.status}                             
                            </td>
                            <td class="text-center">
                                <button class="btn btn-primary" onclick="lihatRenstra(${data.id})">Lihat</button>   
                                ${(() => {
                                    if(data.status_renstra_id == 1 || data.status_renstra_id == 4){
                                        return `
                                            <button class="btn btn-success" onclick="ajukan(${data.id})">Kirim Pengajuan</button>                                            
                                        `;
                                    } else if(data.status_renstra_id == 2){
                                        return `<button class="btn btn-danger" onclick="batalPengajuan(${data.id})">Batal Pengajuan</button>`;
                                    } else if(data.status_renstra_id == 10){
                                        return `<button class="btn btn-primary" onclick="review(${data.id})">Review</button>`;
                                    } else{
                                        return ``;
                                    }                                    
                                })()}                     
                                                                        
                            </td>                
                        </tr>`
                    })
                    
                } else {
                    Swal.fire({                    
                        icon: 'warning',                   
                        title: 'Data Kosong',
                        timer: 1000,                                
                        showConfirmButton: false
                    })
                    

                    document.getElementById("btnBuatRenstra").style.display = "block";

                }

                document.getElementById("tableData").innerHTML = data_tr;

            }, (error) => {
                console.log(error);
            });
        }

        btnBuatRenstra = () => {

            tmpPeriode = $("#selectPeriode").val();

            if(tmpPeriode == ''){
                Swal.fire({                    
                    icon: 'warning',                   
                    title: 'Ada kesalahan',
                    text: 'Periode belum dipilih',                            
                })
            } else {               

                let url = '{{ route('buat_renstra') }}?periode='+tmpPeriode;

                window.location.replace(url);

            }

        }

        detailRenstra = () => {

            tmpPeriode = $("#selectPeriode").val();

            if(tmpPeriode == ''){
                Swal.fire({                    
                    icon: 'warning',                   
                    title: 'Ada kesalahan',
                    text: 'Periode belum dipilih',                            
                })
            } else {               

                let url = '{{ route('buat_renstra') }}?periode='+tmpPeriode;

                window.open(url);

            }
        }

        ajukan = (id) => {
            Swal.fire({
                title: "Yakin ajukan Renstra?",            
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal"
            }).then((result) => {
                
                if(result.value){

                    axios.post('/unit/ajukan_renstra', {                                
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

                        loadData(tmpPeriode);
                            
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

        batalPengajuan = (id) => {
            Swal.fire({
                title: "Yakin batal pengajuan Renstra?",            
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal"
            }).then((result) => {
                
                if(result.value){

                    axios.post('/unit/batal_ajukan_renstra', {                                
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

                        loadData(tmpPeriode);
                            
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
        
        lihatRenstra = (id) => {

            let curData = tmpData.filter((data) => {
                return data.id = id;
            });

            let tahun = curData[0].tahun.split(',').map(el => el.trim());

            let li = '';
            let dataTab = '';

            let titleTab = `<ul class="nav nav-tabs" role="tablist">
            ${(() => {
                tahun.forEach(el => {
                    li += `<li class="nav-item">
                                <a class="nav-link" onclick="loadRenstra(${el})" id="tab${el}" data-toggle="tab" href="#c${el}" role="tab" aria-controls="home" aria-selected="true">${el}</a>
                            </li>`;
                })

                return li;
            })()}           
            </ul>
            <div class="tab-content tab-bordered" id="tabContent">
                ${(() => {
                    tahun.forEach(el => {
                        dataTab += ` <div class="tab-pane fade show" id="c${el}" role="tabpanel"              aria-labelledby="home-tab2">
                                <table class="custom-table">
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
                                            <th rowspan="2">Aksi</th>     
                                        </tr>
                                        <tr>
                                            <th>KAK</th>
                                            <th>RAB</th>
                                            <th>Pendukung</th>
                                        </tr>
                                    </thead>   
                                    <tbody id="tbody${el}">
                                        
                                    </tbody>                         
                                </table>  
                            </div>`;
                        })

                    return dataTab;
                })()}                                           
            </div> `;
            

            document.getElementById("tabRenstra").innerHTML = titleTab;
            document.getElementById("lihatRenstra").style.display = "block";
        }

        loadRenstra = (tahun) => {
                        
            axios.post('/unit/data_rka', {                                
                tahun
            })
            .then((res) => {                            
                
                let data_tr = '';
                if(res.data.length > 0){

                    tmpPertahun = res.data;

                    res.data.forEach((data, index) => {
                        data_tr += `
                            <tr id="${data.kode}" >
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
                                            <button class="btn ${kakLabel} btn-custom" ${data.kak == 1 ? '' : 'disabled' } title="KAK"  onclick="bukaFile(${data.id}, 'subKomponen', 'Kak')"><i class="fa fa-file-pdf"></i></button>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn ${rabLabel} btn-custom" ${data.rab == 1 ? '' : 'disabled' } title="RAB"  onclick="bukaFile(${data.id}, 'subKomponen', 'Rab')"><i class="fa fa-file-pdf"></i></button>
           
                                        </td>
                                        <td class="text-center">
                                            <button class="btn ${pendukungLabel} btn-custom" ${data.pendukung == 1 ? '' : 'disabled' } title="Pendukung"  onclick="bukaFile(${data.id}, 'subKomponen', 'Pendukung')"><i class="fa fa-file-pdf"></i></button>                                       
                                        </td>
                                        ` 
                                    } else if(data.level == 'detail') {

                                        let kakLabel = data.kak == 1 ? 'btn-primary' : 'btn-danger';
                                        let rabLabel = data.rab == 1 ? 'btn-primary' : 'btn-danger';
                                        let pendukungLabel = data.pendukung == 1 ? 'btn-primary' : 'btn-danger';

                                        return `
                                        <td class="text-center">
                                            <button class="btn ${kakLabel} btn-custom" ${data.kak == 1 ? '' : 'disabled' } title="KAK"  onclick="bukaFile(${data.id}, 'detail', 'Kak')"><i class="fa fa-file-pdf"></i></button>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn ${rabLabel} btn-custom" ${data.rab == 1 ? '' : 'disabled' } title="RAB"  onclick="bukaFile(${data.id}, 'detail', 'Rab')"><i class="fa fa-file-pdf"></i></button>
           
                                        </td>
                                        <td class="text-center">
                                            <button class="btn ${pendukungLabel} btn-custom" ${data.pendukung == 1 ? '' : 'disabled' } title="Pendukung"  onclick="bukaFile(${data.id}, 'detail', 'Pendukung')"><i class="fa fa-file-pdf"></i></button>                                       
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
                                                <button class="btn ${commentLabel} btn-custom" ${data.comment == 1 ? '' : 'disabled' } title="Komentar"  onclick="comment(${data.id})"><i class="fa fa-comment"></i></button>
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
                    
                } else {
                    Swal.fire({                    
                        icon: 'warning',                   
                        title: 'Data Kosong',
                        timer: 1000,                                
                        showConfirmButton: false
                    })
                }

                document.getElementById(`tbody${tahun}`).innerHTML = data_tr;

            }, (error) => {
                console.log(error);
            });
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
        
        
        document.addEventListener('DOMContentLoaded', function() {        
                    
            formTampil.onsubmit = (e) => {
                
                e.preventDefault();            

                tmpPeriode = $("#selectPeriode").val();

                loadData(tmpPeriode);

            }           
          
        }, false);     
         
    </script>
@endpush