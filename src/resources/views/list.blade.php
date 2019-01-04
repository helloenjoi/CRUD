@extends('backpack::layout') 

@section('header')
<div class="page-bar" aria-label="breadcrumb">
	<ol class="page-breadcrumb">
	  <li class="breadcrumb-item"><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	  <li class="breadcrumb-item"><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	  <li class="breadcrumb-item active" aria-current="page">{{ trans('backpack::crud.list') }}</li>
	</ol>
</div>
@endsection 

@section('content')
<!-- Default portlet -->
<div class="row">
	<!-- THE ACTUAL CONTENT -->
	<div class="col-md-12">
		<div class="portlet light portlet-fit portlet-datatable bordered">
			<div class="portlet-title py-1 my-0 hidden-print {{ $crud->hasAccess('create')?'with-border':'' }}">
				<div class="caption mr-auto">
					<i class="icon-notebook"></i>
					<span class="caption-subject font-green sbold uppercase">{{ $crud->entity_name_plural }}</span>
					<small id="datatable_info_stack">{!! $crud->getSubheading() ?? trans('backpack::crud.all').'<span>'.$crud->entity_name_plural.'</span> '.trans('backpack::crud.in_the_database') !!}.</small>
				</div>
				<div class="actions">
					<div class="btn-group">@include('crud::inc.button_stack', ['stack' => 'top'])</div>
				</div>
			</div>
			
			{{-- Backpack List Filters --}}
			@if ($crud->filtersEnabled())
				@include('crud::inc.filters_navbar')
			@endif

			<div class="portlet-body">

				<table id="crudTable" class="table table-striped table-bordered table-hover display responsive nowrap" cellspacing="0">
					<thead>
						<tr>
						{{-- Table columns --}}
						@foreach ($crud->columns as $column)
						<th
							data-orderable="{{ var_export($column['orderable'], true) }}"
							data-priority="{{ $column['priority'] }}"
							data-visible-in-modal="{{ (isset($column['visibleInModal']) && $column['visibleInModal'] == false) ? 'false' : 'true' }}"
							data-visible="{{ !isset($column['visibleInTable']) ? 'true' : (($column['visibleInTable'] == false) ? 'false' : 'true') }}"
							data-visible-in-export="{{ (isset($column['visibleInExport']) && $column['visibleInExport'] == false) ? 'false' : 'true' }}"
							>
							{!! $column['label'] !!}
						</th>
						@endforeach

						@if ( $crud->buttons->where('stack', 'line')->count() )
						<th data-orderable="false" data-priority="{{ $crud->getActionsColumnPriority() }}" data-visible-in-export="false">{{ trans('backpack::crud.actions') }}</th>
						@endif
						</tr>
					</thead>
					<tbody>
					</tbody>
					<tfoot>
						<tr>
							{{-- Table columns --}}
							@foreach ($crud->columns as $column)
								<th>{!! $column['label'] !!}</th>
							@endforeach
			
							@if ( $crud->buttons->where('stack', 'line')->count() )
								<th>{{ trans('backpack::crud.actions') }}</th>
							@endif
						</tr>
					</tfoot>
				</table>

				@if ( $crud->buttons->where('stack', 'bottom')->count() )
				<div id="bottom_buttons" class="hidden-print">
				  @include('crud::inc.button_stack', ['stack' => 'bottom'])
	  
				  <div id="datatable_button_stack" class="pull-right text-right hidden-xs"></div>
				</div>
				@endif
	  
			  </div><!-- /.box-body -->
	  
			</div><!-- /.box -->
	</div>

</div>

@endsection 

@section('after_styles')
<!-- DATA TABLES -->
<link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap4.min.css">

<link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/crud.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/form.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/list.css') }}">

<!-- CRUD LIST CONTENT - crud_list_styles stack -->
@stack('crud_list_styles') 
@endsection

@section('after_scripts') 
@include('crud::inc.datatables_logic')

<script src="{{ asset('vendor/backpack/crud/js/crud.js') }}"></script>
<script src="{{ asset('vendor/backpack/crud/js/form.js') }}"></script>
<script src="{{ asset('vendor/backpack/crud/js/list.js') }}"></script>

<!-- CRUD LIST CONTENT - crud_list_scripts stack -->
@stack('crud_list_scripts') 
@endsection
