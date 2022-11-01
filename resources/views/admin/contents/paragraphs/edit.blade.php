@extends('admin.layouts.app')

@section('title',trans_choice('labels.models.content',2))

@push('css')
    <link rel="stylesheet" href="{{asset('assets/admin/app-assets/vendors/css/forms/select/select2.min.css')}}">
@endpush

@section('content')

    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">{{__('messages.static.create')}}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin.dashboard')}}">{{__('labels.fields.dashboard')}}</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin.contents.index')}}"> {{__('messages.static.list',['name'=> trans_choice('labels.models.content',2)])}}</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin.contents.show',$paragraph->content_id)}}"> {{__('messages.static.list',['name'=> trans_choice('labels.models.paragraph',2)])}}</a>
                                    </li>

                                    <li class="breadcrumb-item active">
                                        {{__('messages.static.edit')}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <div class="row" id="table-head">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <button title="{{__('messages.static.back')}}" onclick="document.location = '{{url()->previous()}}'" type="button" class="btn btn-icon btn-outline-info">
                                    <i data-feather='arrow-right'></i>
                                </button>

                            </div>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">{{__('messages.static.create')}}</h4>
                                    </div>
                                    <div class="card-body" id="app">
                                        <form class="form form-horizontal" method="post" action="{{route('admin.paragraphs.update',['content_id' => $paragraph->content_id,'paragraph_id' => $paragraph->id])}}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">

                                                <div class="col-12 mb-2" >
                                                    @foreach(getLangs() as $lang => $config)
                                                        <div class="form-group">
                                                            <label>{{__('labels.fields.start_from')}} ({{$lang}}) : </label>
                                                            <input type="text" name="start_from[{{$lang}}]" value="{{old("start_from.$lang",$paragraph->translate('start_from',$lang,false))}}" class="form-control @error('start_from.'.$lang) is-invalid @enderror">
                                                            @error('start_from.'.$lang)
                                                            <div class="invalid-feedback">{{$message}}</div>
                                                            @enderror
                                                        </div>
                                                    @endforeach

                                                    @foreach(getLangs() as $lang => $config)
                                                        <div class="form-group">
                                                            <label>{{__('labels.fields.end_at')}} ({{$lang}}) : </label>
                                                            <input type="text" name="end_at[{{$lang}}]" value="{{old("end_at.$lang",$paragraph->translate('end_at',$lang,false))}}" class="form-control @error('end_at.'.$lang) is-invalid @enderror">
                                                            @error('end_at.'.$lang)
                                                            <div class="invalid-feedback">{{$message}}</div>
                                                            @enderror
                                                        </div>
                                                    @endforeach

                                                </div>

                                                <div class="col-sm-9 offset-sm-3 mt-2">
                                                    <button type="submit" class="btn btn-primary mr-1">{{__('messages.static.save')}}</button>
                                                    <button type="reset" class="btn btn-outline-secondary">{{__('messages.static.reset')}}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="{{asset('assets/admin/app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
    <script>
        $('.select2').select2()
    </script>
@endpush
