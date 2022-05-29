@extends('layouts.master')
@section('title', 'Kegiatan')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Program dan Kegiatan</h1>            
        </div>
        <div class="container mt-4">
            <div class="row">
                <div class="col">
                    <div class="form-group float-right d-flex">
                    <label class="mr-3 mt-2">Tanggal</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fas fa-calendar"></i>
                        </div>
                        </div>
                        <input type="text" class="form-control">
                    </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header">
                        <h3>Program dan Kegiatan</h3>
                        </div>
                        <form action="">
                            <div class="card-body">
                                <div class="form-group row mb-4">
                                <label class="col-form-label col-12 col-md-3 col-lg-3">Kode</label>
                                <div class="col-sm-12 col-md-9">
                                    <input type="text" class="form-control">
                                </div>
                                </div>
                                <div class="form-group row mb-4">
                                <label class="col-form-label col-12 col-md-3 col-lg-3">Program / Kegiatan</label>
                                <div class="col-sm-12 col-md-9">
                                    <input type="text" class="form-control">
                                </div>
                                </div>
                                <div class="form-group row mb-4">
                                <label class="col-form-label col-12 col-md-3 col-lg-3">Indikator Kegiatan</label>
                                <div class="col-sm-12 col-md-9">
                                    <textarea class="form-control" id="" rows="4" style="height: 150px;">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Harum autem obcaecati beatae adipisci incidunt optio, quidem excepturi, commodi perspiciatis sit odit eum dignissimos. Illum consequatur molestiae tempore amet, itaque voluptatem!</textarea>
                                </div>
                                </div>
                                <div class="form-group row mb-4">
                                <label class="col-form-label col-12 col-md-3 col-lg-3">Target</label>
                                <div class="col-sm-12 col-md-9">
                                    <input type="text" class="form-control">
                                </div>
                                </div>
                                <a href="#" class="btn btn-icon icon-left btn-success float-right mb-4"><i class="far fa-save"></i> Simpan</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5>Lokasi</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <h4>Advanced Table</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                                <thead>
                                <tr class="text-center">
                                    <th>
                                    <div class="custom-checkbox custom-control">
                                        <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                                        <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                    </div>
                                    </th>
                                    <th>Task Name</th>
                                    <th>Progress</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="text-center">
                                    <td>
                                    <div class="custom-checkbox custom-control">
                                        <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-1">
                                        <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                    </div>
                                    </td>
                                    <td>Palembang</td>
                                    <td>Sumatera Selatan</td>
                                </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>        
@endsection
    
@push('page-script')
    <script>
        console.log('tes');
    </script>
@endpush