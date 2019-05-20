@extends('app')
@section('html_title')
	Project
@endsection
@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
			<h1 class="page-title txt-color-blueDark">
				<i class="fa fa-table fa-fw "></i> 
					Project 
				<span> > 
					List
				</span>
			</h1>
		</div>
	</div>

    <div class="well">
        <a class="btn btn-primary" ng-click="openModal('#project_data')">
            Add New
        </a>
	</div>
	
	<section id="widget-grid" class="">
		<div class="row">
			<article class="col-lg-12">
				@box_open('Project List')
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
									'orderable'=> false,
								],
								[
									"data" => 'contacts',
									"title" => 'Contacts',
									'name' => 'contacts',
									'hasFilter' => false,
									'orderable'=> false,
									'width' => 150
								],
								[
									"data" => 'type',
									"title" => 'Type',
									'name' => 'type',
									'items' => App\Models\TblProject::getType(),
									'filterType' => 'dropdown',
									'hasFilter' => true,
								],
								[
									"data" => 'status',
									"title" => 'Status',
									'name' => 'status',
									'items' => App\Models\TblProject::getStatus(),
									'filterType' => 'dropdown',
									'hasFilter' => true,
								],
								[
									"data" => 'deadline',
									"title" => 'Deadline',
									'name' => 'deadline',
									'hasFilter' => true,
									'filterType' => 'date',
									'width' => 120
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
								"url" =>  url('ajax/project'),
								"table_id" => 'table_project',
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
	@include('layouts.modal.project')
@endsection

@push('angularjs')
	@include('layouts.angularjs.project')
	<script>
		function openProject(id) {
			angular.element(document.body).scope().openProject(id);
		}

		function openMemberProject(id) {
			angular.element(document.body).scope().openMemberProject(id);
		}

		function detailProject(id) {
			angular.element(document.body).scope().detailProject(id);
		}

		function deleteProject(id) {
			angular.element(document.body).scope().deleteProject(id);
		}
	</script>
@endpush