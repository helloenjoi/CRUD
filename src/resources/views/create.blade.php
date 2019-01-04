@extends('backpack::layout')

@section('header')
<div class="page-bar" aria-label="breadcrumb">
	<ol class="page-breadcrumb">
	  <li class="breadcrumb-item"><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	  <li class="breadcrumb-item"><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	  <li class="breadcrumb-item active" aria-current="page">{{ trans('backpack::crud.add') }}</li>
	</ol>
</div>
@endsection


@section('content')
<div class="row">
    <!-- THE ACTUAL CONTENT -->
	<div class="col-md-6 col-md-offset-1">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-plus font-dark"></i>
					<span class="caption-subject font-green sbold uppercase">{{ trans('backpack::crud.add_a_new') }} {{ $crud->entity_name }}</span>
				</div>
				<div class="actions">
					<div class="btn-group btn-group-devided">
						@if ($crud->hasAccess('list'))
							<a href="{{ starts_with(URL::previous(), url($crud->route)) ? URL::previous() : url($crud->route) }}" class="btn btn-transparent green-jungle btn-circle btn-sm hidden-print">
							<i class="fa fa-arrow-left fa-fw"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a>
						@endif
					</div>
				</div>
			</div>
			<div class="{{ $crud->getCreateContentClass() }}">
				<!-- Default box -->

				@include('crud::inc.grouped_errors')

				<form class="form-horizontal" method="post"
					action="{{ url($crud->route) }}"
						@if ($crud->hasUploadFields('create'))
						enctype="multipart/form-data"
						@endif
						>
						{!! csrf_field() !!}
					<div class="form-body">

						<div class="row display-flex-wrap">
							<!-- load the view from the application if it exists, otherwise load the one in the package -->
							@if(view()->exists('vendor.backpack.crud.form_content'))
								@include('vendor.backpack.crud.form_content', [ 'fields' => $crud->getFields('create'), 'action' => 'create' ])
							@else
								@include('crud::form_content', [ 'fields' => $crud->getFields('create'), 'action' => 'create' ])
							@endif
						</div><!-- /.box-body -->
						<div class="form-actions right">

							@include('crud::inc.form_save_buttons')

						</div><!-- /.box-footer-->

					</div><!-- /.box -->
				</form>
			</div>
		</div>
	</div>
</div>

@endsection
