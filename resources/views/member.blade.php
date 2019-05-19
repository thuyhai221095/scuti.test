@extends('app')
@section('html_title')
	Member
@endsection
@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
			<h1 class="page-title txt-color-blueDark">
				<i class="fa fa-table fa-fw "></i> 
					Member 
				<span> >
					List
				</span>
			</h1>
		</div>
	</div>
	<div class="well">
        <a class="btn btn-primary" ng-click="openModal('#member')">
            Add New
        </a>
	</div>
	
	<section id="widget-grid" class="">
		<div class="row">
			<article class="col-lg-12">
				@box_open('Member List')
					<div>
						<div class="widget-body no-padding">
							<?php
							$columns = [
								[
									"data" => 'name',
									"title" => 'Name',
									'name' => 'name',
									'hasFilter' => true,
									'orderable'=> false,
									'width' => 120
								],
								[
									"data" => 'infomation',
									"title" => 'Infomation',
									'name' => 'infomation',
									'hasFilter' => false,
								],
								[
									"data" => 'phone',
									"title" => 'Phone',
									'name' => 'phone',
									'hasFilter' => true,
								],
								[
									"data" => 'date_of_birth',
									"title" => 'Date of birth',
									'name' => 'date_of_birth',
									'hasFilter' => true,
									'filterType' => 'date',
									'width' => 120
								],
								[
									"data" => 'position',
									"title" => 'Position',
									'name' => 'position',
									'items' => App\Models\TblMember::getPosition(),
									'filterType' => 'dropdown',
									'hasFilter' => true,
								],
								[
									'data' => 'action',
									'title' => 'Action',
									'hasFilter' => false,
									'orderable'=> true,
									'width' => 150
								],
	
							];
	
							?>
							@include("custom.table_data", [
								"url" =>  url('ajax/member'),
								"table_id" => 'table_member',
								"method" => "GET",
								"hasExtra" => false,
								"columns" => $columns
							])
						</div>
					</div>
				@box_close
			</article>
		</div>
	</section>
	@include('layouts.modal.member')
@endsection

@push('angularjs')
	@include('layouts.angularjs.member')
	<script>
		function openMember(id) {
			angular.element(document.body).scope().openMember(id);
		}

		function deleteMember(id) {
			angular.element(document.body).scope().deleteMember(id);
		}
	</script>
@endpush
