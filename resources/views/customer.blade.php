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
                        @isset($message)
                        <h4>  {{$message}} </h4>
                        @endisset
                        <div class="card">
                            <div class="card-header"><strong>
                                @isset($companyname)
                                {{$companyname}}
                                @endisset Müşteri Kayıt Sistemi</strong>
                             </div>
                            <div class="card-body">
                                <form method="POST" action="{{ url('customer') }}">
                                    @csrf
                                    <div class="form-group">
                                    <label class="text-muted">TC KİMLİK NUMARASI</label>
                                    <input type="text" class="form-control" name="tc" placeholder="TC KIMLIK NUMARASI GIRINIZ"> 
                                    </div>
                                    <div class="form-group">
                                    <label class="text-muted">ADINIZ</label>
                                    <input type="text" class="form-control" name="name" placeholder="ADINIZI GIRINIZ"> 
                                    </div>
                                    <div class="form-group">
                                        <label class="text-muted" >SOYADINIZ</label>
                                        <input type="text" class="form-control" name="surname" placeholder="SOYADINIZI GIRINIZ"> 
                                    </div>
                                    <div class="form-group">
                                        <label class="text-muted" for="exampleInputPassword1">DOGUM YILINIZ</label>
                                        <input class="form-control" name="birthyear" type="number" min="{{(date('Y')-120)}}" max="{{date('Y')}}" step="1" /> 
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