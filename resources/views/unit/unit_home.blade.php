@extends('layouts.master')
@section('title', 'Dashboard')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>            
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow">                        
                        <div class="card-body">
                            <h3>Selamat Datang, {{ Auth::user()->name }}</h3>
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