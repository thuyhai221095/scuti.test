<script>
	myApp.controller("myController", function ($scope, $http, $compile) {
		$scope.update = false;
		$scope.project_id = null;
		$scope.project = {};
		$scope.addRole = {};
		$scope.updateRole = {};
		$scope.errors = {};
		$scope.openModal = function(element) {
			$scope.update = false;
			$scope.errors = {};
			$scope.project = {};
			$(element).modal('show');
		}

        /*start project*/
        $scope.addProject =function() {
			showLoading();
			$http({
				method: 'POST',
				url: '{{ url('ajax/project') }}',
				data: {
					'name' : $scope.project.name,
					'infomation' : $scope.project.infomation,
					'deadline' : $scope.project.deadline,
					'type' : $scope.project.type,
					'status' : $scope.project.status,
				}
			}).then(function (response) {
				if (response.data.errors) {
                    $scope.errors = response.data.errors;
                    toastr.error('Error');
                } else {
                	$('#table_project').DataTable().ajax.reload();
                	$("#project_data").modal('hide');
                	$scope.project = {};
                	toastr.success(response.data.msg);
				}
            	hideLoading();
			}, function (xhr) {
				console.log('error');
			});
		} 

		$scope.updateProject  = function(id) {
			showLoading();
			$http({
				method: 'PUT',
				url: '{{ url('ajax/project') }}'+ '/' + id,
				data: {
					'name' : $scope.project.name,
					'infomation' : $scope.project.infomation,
					'deadline' : $scope.project.deadline,
					'type' : $scope.project.type,
					'status' : $scope.project.status,
				}
			}).then(function (response) {
				if (response.data.errors) {
                    $scope.errors = response.data.errors;
                    toastr.error('Error');
                } else {
                	$('#table_project').DataTable().ajax.reload();
                	$("#project_data").modal('hide');
                	$scope.project = {};
                	toastr.success(response.data.msg);
				}
            	hideLoading();
			}, function (xhr) {
				console.log('error');
			});
		}

		$scope.deleteProject =  function(id) {
			var result = confirm('Are you sure ?');
            if (result) {
            	$http({
					method: 'DELETE',
					url: '{{ url('ajax/project/') }}' + '/' + id,
				}).then(function (response) {
					$('#table_project').DataTable().ajax.reload();
					toastr.success(response.data.msg);
				}, function (xhr) {
					console.log('error');
				});
            }
		}

		$scope.openProject =  function(id) {
			$scope.errors = {};
			$http({
				method: 'GET',
				url: '{{ url('ajax/project') }}' + '/' + id,
			}).then(function (response) {
				$scope.update = id;
				$scope.project = response.data;
				$('#project_data').modal('show');
			}, function (xhr) {
				console.log('error');
			});
		}

		$scope.detailProject =  function(id) {
			$http({
				method: 'GET',
				url: '{{ url('ajax/detailProject') }}' + '/' + id,
			}).then(function (response) {
				$scope.listMemberOfProject = response.data;
				$('#detailProject').modal('show');
			}, function (xhr) {
				console.log('error');
			});
		}

        $scope.actionProject = function () {
            console.log('update', $scope.update);
            if ($scope.update != false) {
            	$scope.updateProject($scope.update);
            } else {
            	$scope.addProject();
            } 
        };

        $scope.openMemberProject =  function(id) {
			$http({
				method: 'GET',
				url: '{{ url('ajax/user_role') }}' + '/' + id,
			}).then(function (response) {
				$scope.listmember = response.data;
				$scope.errors = {};
				$scope.project_id = id;
				$('#addMemberProject').modal('show');
			}, function (xhr) {
				console.log('error');
			});
		}

        $scope.addMemberProject =  function(id) {
			$http({
				method: 'POST',
				url: '{{ url('ajax/user_role') }}',
				data: {
					'project_id' : $scope.project_id,
					'member_id' : $scope.addRole.member,
					'role' : $scope.addRole.role
				}
			}).then(function (response) {
				if (response.data.errors) {
                    $scope.errors = response.data.errors;
                    toastr.error('Error');
                } else {
                	$('#table_project').DataTable().ajax.reload();
                	$("#addMemberProject").modal('hide');
                	$scope.addRole = {};
                	toastr.success(response.data.msg);
				}
			}, function (xhr) {
				console.log('error');
			});
		}
		
		$scope.openUpdateRole =  function(role_id, role_name) {
			$scope.errors = {};
			$scope.updateRole.role = role_name;
			$scope.role_id = role_id;
			$('#updateMemberProject').modal('show');
		}

		$scope.updateUserRole =  function() {
			$http({
				method: 'PUT',
				url: '{{ url('ajax/user_role') }}' + '/' + $scope.role_id,
				data: {
					'role' : $scope.updateRole.role
				}
			}).then(function (response) {
				if (response.data.errors) {
                    $scope.errors = response.data.errors;
                    toastr.error('Error');
                } else {
                	$scope.listMemberOfProject = response.data.data;
                	$("#updateMemberProject").modal('hide');
                	$scope.updateRole = {};
                	toastr.success(response.data.msg);

				}
			}, function (xhr) {
				console.log('error');
			});
		}

		$scope.deleteUserRole =  function(id) {
			var result = confirm('Are you sure ??');
            if (result) {
				$http({
					method: 'DELETE',
					url: '{{ url('ajax/user_role') }}' + '/' + id
				}).then(function (response) {
					if (response.data.errors) {
	                    $scope.errors = response.data.errors;
	                    toastr.error('Error');
	                } else {
	                	$('#table_project').DataTable().ajax.reload();
	                	$scope.listMemberOfProject = response.data.data;
	                	toastr.success(response.data.msg);
					}
				}, function (xhr) {
					console.log('error');
				});
			}
		}
        /*end project*/
	});
	myApp.directive('ngFiles', ['$parse', function ($parse) {
        function file_links(scope, element, attrs) {
            var onChange = $parse(attrs.ngFiles);
            element.on('change', function (event) {
                onChange(scope, {$files: event.target.files});
            });
        }
        return {
            link: file_links
        }
    }]);
	
</script>