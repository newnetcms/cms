@extends('core::admin.master')

@section('meta_title', __('cms::page.index.page_title'))

@section('page_title', __('cms::page.index.page_title'))

@section('page_subtitle', __('cms::page.index.page_subtitle'))

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">{{ trans('dashboard::message.index.breadcrumb') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('cms::page.index.breadcrumb') }}</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 font-weight-600 mb-0">
                        {{ __('cms::page.index.page_title') }}
                    </h6>
                </div>
                <div class="text-right">
                    <div class="actions">
                        @admincan('cms.admin.page.create')
                            <a href="{{ route('cms.admin.page.create') }}" class="action-item">
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
                @input(['item' => null, 'name' => 'name', 'label' => __('cms::page.name'), 'value' => request('name')])

                <button type="submit" class="btn btn-primary mr-1">
                    {{ __('core::button.search') }}
                </button>
                <a href="{{ route('cms.admin.page.index') }}" class="btn btn-danger">
                    {{ __('core::button.cancel') }}
                </a>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-bordered dt-responsive nowrap bootstrap4-styling">
                    <thead>
                    <tr>
                        <th nowrap>#</th>
                        <th nowrap>{{ __('cms::page.name') }}</th>
                        <th nowrap>{{ __('cms::page.is_active') }}</th>
                        <th nowrap>{{ __('cms::page.page_layout') }}</th>
                        <th nowrap>{{ __('cms::page.author') }}</th>
                        <th nowrap>{{ __('cms::page.created_at') }}</th>
                        <th nowrap>@translatableHeader</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td nowrap>{{ $loop->index + $items->firstItem() }}</td>
                            <td style="min-width: 250px;">
                                <a href="{{ route('cms.admin.page.edit', $item->id) }}">
                                    {{ trim(str_pad('', $item->depth * 3, '-')) }}
                                    {{ $item->name }}
                                </a>
                                <a href="{{ $item->url }}" target="_blank" title="{{ __('core::button.view') }}">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </td>
                            <td nowrap>
                                @if($item->is_active)
                                    <i class="fas fa-check text-success"></i>
                                @endif
                            </td>
                            <td nowrap>{{ get_page_layout_label($item->page_layout) }}</td>
                            <td nowrap>{{ object_get($item->author, 'name') }}</td>
                            <td nowrap>{{ $item->created_at }}</td>
                            <td nowrap>
                                @translatableStatus(['editUrl' => route('cms.admin.page.edit', $item->id)])
                            </td>
                            <td nowrap class="text-right">
                                @admincan('cms.admin.page.create')
                                    <a href="{{ route('cms.admin.page.create', ['id' => $item->id, 'parent_id' => $item->id]) }}" class="btn btn-primary-soft btn-sm mr-1">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                @endadmincan

                                @admincan('cms.admin.page.edit')
                                    <a href="{{ route('cms.admin.page.move-up', $item->id) }}" class="btn btn-info-soft btn-sm mr-1">
                                        <i class="fas fa-chevron-up"></i>
                                    </a>
                                @endadmincan

                                @admincan('cms.admin.page.edit')
                                    <a href="{{ route('cms.admin.page.move-down', $item->id) }}" class="btn btn-info-soft btn-sm mr-1">
                                        <i class="fas fa-chevron-down"></i>
                                    </a>
                                @endadmincan

                                @admincan('cms.admin.page.edit')
                                    <a href="{{ route('cms.admin.page.edit', $item->id) }}" class="btn btn-success-soft btn-sm mr-1">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                @endadmincan

                                @admincan('cms.admin.page.destroy')
                                    <table-button-delete url-delete="{{ route('cms.admin.page.destroy', $item->id) }}"></table-button-delete>
                                @endadmincan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {!! $items->appends(Request::all())->render() !!}
        </div>
    </div>
@stop
