@extends('core::admin.master')

@section('meta_title', __('cms::post.index.page_title'))

@section('page_title', __('cms::post.index.page_title'))

@section('page_subtitle', __('cms::post.index.page_subtitle'))

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">{{ trans('dashboard::message.index.breadcrumb') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('cms::post.index.breadcrumb') }}</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 font-weight-600 mb-0">
                        {{ __('cms::post.index.page_title') }}
                    </h6>
                </div>
                <div class="text-right">
                    <div class="actions">
                        @admincan('cms.admin.post.create')
                            <a href="{{ route('cms.admin.post.create') }}" class="action-item">
                                <i class="fa fa-plus"></i>
                                {{ __('core::button.add') }}
                            </a>
                        @endadmincan
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form class="form-inline newnet-table-search">
                @input(['item' => null, 'name' => 'name', 'label' => __('cms::post.name'), 'value' => request('name')])
                @selecth(['item' => null, 'name' => 'categories', 'label' => __('cms::post.category'), 'multiple' => true, 'value' => request('categories'), 'options' => get_category_parent_options()])

                <button type="submit" class="btn btn-primary mr-1">
                    {{ __('core::button.search') }}
                </button>
                <a href="{{ route('cms.admin.post.index') }}" class="btn btn-danger">
                    {{ __('core::button.cancel') }}
                </a>
            </form>

            <table class="table table-striped table-bordered dt-responsive nowrap bootstrap4-styling">
                <thead>
                <tr>
                    <th>{{ __('#') }}</th>
                    <th>{{ __('cms::post.name') }}</th>
                    <th>{{ __('cms::post.category') }}</th>
                    <th>{{ __('cms::post.is_active') }}</th>
                    <th>{{ __('cms::post.is_sticky') }}</th>
                    <th>{{ __('cms::post.author') }}</th>
                    <th>{{ __('cms::post.created_at') }}</th>
                    <th>@translatableHeader</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $loop->index + $items->firstItem() }}</td>
                        <td>
                            @if($item->name)
                                <a href="{{ route('cms.admin.post.edit', $item->id) }}">
                                    {{ $item->name }}
                                </a>
                                <a href="{{ $item->url }}" target="_blank" title="{{ __('core::button.view') }}">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            @else
                                <a href="{{ route('cms.admin.post.edit', $item->id) }}">
                                    <span class="nn-no-translation">[{{ __('No Translation') }}]</span>
                                </a>
                            @endif
                        </td>
                        <td>{{ $item->categories->implode('name', ',') }}</td>
                        <td>
                            @if($item->is_active)
                                <i class="fas fa-check text-success"></i>
                            @endif
                        </td>
                        <td>
                            @if($item->is_sticky)
                                <i class="fas fa-check text-success"></i>
                            @endif
                        </td>
                        <td>{{ object_get($item->author, 'name') }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            @translatableStatus(['editUrl' => route('cms.admin.post.edit', $item->id)])
                        </td>
                        <td class="text-right">
                            @admincan('cms.admin.post.edit')
                                <a href="{{ route('cms.admin.post.edit', $item->id) }}" class="btn btn-success-soft btn-sm mr-1">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            @endadmincan

                            @admincan('cms.admin.post.destroy')
                                <table-button-delete url-delete="{{ route('cms.admin.post.destroy', $item->id) }}"></table-button-delete>
                            @endadmincan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {!! $items->appends(Request::all())->render() !!}
        </div>
    </div>
@stop
