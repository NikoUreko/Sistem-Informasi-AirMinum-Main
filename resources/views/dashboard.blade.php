@extends('layouts.app')

@section('title')
Dashboard | HIPPAM Admin
@endsection

@section('content')
<style>
    .center-top {
        display: flex;
        flex-direction: column; 
        justify-content: center;
        align-items: center; 
        text-align: center;
        height: 50vh; 
        padding-top: 20px; 
        font-size: 24px;
    }

    .center-content {
        text-align: center; 
        font-size: 24px;
    }
</style>

<div class="center-top">
    <h1>Welcome to Dashboard</h1>
    <p>Anda telah berhasil login sebagai {{ session('user_id') }}</p>
</div>
<div class="center-content">
    <h2>Selamat Datang di Sistem Administrasi Tagihan Air</h2>
    <p>Meningkatkan Efisiensi dan Transparansi dalam Pengelolaan Tagihan Air.</p>
</div>
@endsection
