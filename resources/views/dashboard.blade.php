@extends('layouts.app')

@section('title', 'Dashboard - SmartLib')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang di SmartLib')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('content')
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Selamat Datang, {{ auth()->user()->nama ?? auth()->user()->name }}!</h4>
                </div>
                <div class="card-body">
                    <p>Anda sedang menggunakan sistem perpustakaan SmartLib.</p>

                    @if (auth()->user()->hasRole('super_admin'))
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Anda login sebagai <strong>Super Administrator</strong>.
                            <a href="{{ route('superadmin.dashboard') }}" class="alert-link">Klik di sini untuk ke dashboard
                                Super Admin</a>
                        </div>
                    @elseif(auth()->user()->hasRole('admin'))
                        <div class="alert alert-success">
                            <i class="bi bi-info-circle me-2"></i>
                            Anda login sebagai <strong>Administrator</strong>.
                            <a href="{{ route('admin.dashboard') }}" class="alert-link">Klik di sini untuk ke dashboard
                                Admin</a>
                        </div>
                    @elseif(auth()->user()->hasRole('siswa'))
                        <div class="alert alert-primary">
                            <i class="bi bi-info-circle me-2"></i>
                            Anda login sebagai <strong>Siswa</strong>.
                            <a href="{{ route('siswa.dashboard') }}" class="alert-link">Klik di sini untuk ke dashboard
                                Siswa</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
