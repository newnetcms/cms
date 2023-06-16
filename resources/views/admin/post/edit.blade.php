@extends('core::admin.master')

@section('meta_title', __('cms::post.edit.page_title'))

@section('page_title', __('cms::post.edit.page_title'))

@section('page_subtitle', __('cms::post.edit.page_subtitle'))

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">{{ trans('dashboard::message.index.breadcrumb') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cms.admin.post.index') }}">{{ trans('cms::post.index.breadcrumb') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('cms::post.edit.breadcrumb') }}</li>
        </ol>
    </nav>
@stop

@section('content')
    <form action="{{ route('cms.admin.post.update', $item->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0">
                            {{ __('cms::post.edit.page_title') }}
                        </h6>
                    </div>
                    <div class="text-right">
                        <div class="btn-group">
                            <button class="btn btn-success" type="submit">{{ __('core::button.save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('cms::admin.post._fields', ['item' => $item])
            </div>
            <div class="card-footer text-right">
                <div class="btn-group">
                    <button class="btn btn-success" type="submit">{{ __('core::button.save') }}</button>
                </div>
            </div>
        </div>
    </form>
@stop
