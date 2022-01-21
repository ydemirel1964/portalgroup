@extends('layouts.app')
@section('css')
<link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection
@section('js')
    
@endsection
@section('content')
<div id="content" class="flex">
    <div class="center">
        <div class="page-content page-container" id="page-content">
            <div class="padding">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header"><strong>Sisteminize Giriş Yapınız</strong></div>
                            <div class="card-body">
                                <form method="POST" action="{{ url('login') }}">
                                    @csrf
                                    <div class="form-group">
                                    <label class="text-muted" for="exampleInputEmail1">Kullanıcı Adınız</label>
                                    <input type="text" class="form-control" name="user_name" placeholder="Kullanıcı Adı Giriniz"> 
                                    </div>
                                    <div class="form-group">
                                    <label class="text-muted" for="exampleInputPassword1">Parolanız</label>
                                    <input type="password" class="form-control" name="password" placeholder="Şifre Giriniz"> 
                                    </div>
                                    <button type="submit" class="btn btn-primary">Giriş</button>
                                </form>
                            </div>
                        </div>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection