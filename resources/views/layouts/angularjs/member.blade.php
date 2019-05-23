<script>
    myApp.controller("myController", function ($scope, $http, $compile) {
        var formData;
        var _this = this;
        $scope.update = false;
        $scope.member = {};
        $scope.errors = {};
        $scope.openModal = function(element) {
            $scope.update = false;
            formData = new FormData();
            $scope.errors = {};
            $scope.member = {};
            $('#avatar').val('');
            $(element).modal('show');
        }
        /*start member*/
        
        $scope.addMember =function() {
            showLoading();
            if ($scope.member.name != undefined) {
                formData.set('name', $scope.member.name);
            }
            if ($scope.member.infomation != undefined) {
                formData.set('infomation', $scope.member.infomation);
            }
            if ($scope.member.phone != undefined) {
                formData.set('phone', $scope.member.phone);
            }
            if ($scope.member.date_of_birth != undefined) {
                formData.set('date_of_birth', $scope.member.date_of_birth);
            }
            if ($scope.member.position != undefined) {
                formData.set('position', $scope.member.position);
            }
            var request = {
                method: 'POST',
                url: '{{asset('ajax/member')}}',
                data: formData,
                headers: {
                    'Content-Type': undefined
                }
            };
            $http(request)
            .then(function success(response) {
                if (response.data.errors) {
                    $scope.errors = response.data.errors;
                    toastr.error('Error');
                } else {
                    $('#table_member').DataTable().ajax.reload();
                    $("#member").modal('hide');
                    $scope.member = {};
                    toastr.success(response.data.msg);
                }
                hideLoading();
            }, function error(e) {
               console.log('err')
            });
        }

        $scope.updateMember =function() {
            showLoading();
            if ($scope.member.name != undefined) {
                formData.set('name', $scope.member.name);
            }
            if ($scope.member.infomation != undefined) {
                formData.set('infomation', $scope.member.infomation);
            }
            if ($scope.member.phone != undefined) {
                formData.set('phone', $scope.member.phone);
            }
            if ($scope.member.date_of_birth != undefined) {
                formData.set('date_of_birth', $scope.member.date_of_birth);
            }
            if ($scope.member.position != undefined) {
                formData.set('position', $scope.member.position);
            }
            var request = {
                method: 'POST',
                url: '{{asset('ajax/updateMember')}}' + '/' + $scope.update,
                data: formData,
                headers: {
                    'Content-Type': undefined
                }
            };

            $http(request)
                .then(function success(response) {
                    if (response.data.errors) {
                        $scope.errors = response.data.errors;
                        toastr.error('Error');
                    } else {
                        $('#table_member').DataTable().ajax.reload();
                        $("#member").modal('hide');
                        toastr.success(response.data.msg);
                        $scope.member = {};
                    }
                    hideLoading();
                }, function error(e) {
                   console.log('err')
                });
        }

        $scope.openMember =  function(id) {
            $scope.errors = {};
            $('#avatar').val('');
            formData = new FormData();
            $http({
                method: 'GET',
                url: '{{ url('ajax/member') }}' + '/' + id,
            }).then(function (response) {
                $scope.update = id;
                $scope.member = response.data;
                $('#member').modal('show');
            }, function (xhr) {
                console.log('error');
            });
        }

        $scope.deleteMember =  function(id) {
            var result = confirm('Are you sure');
            if (result) {
                $http({
                    method: 'DELETE',
                    url: '{{ url('ajax/member/') }}' + '/' + id,
                }).then(function (response) {
                    $('#table_member').DataTable().ajax.reload();
                    toastr.success(response.data.msg);
                }, function (xhr) {
                    console.log('error');
                });
            }
        }
        
        $scope.actionMember = function () {
            console.log('update', $scope.update);
            if ($scope.update != false) {
                console.log('update');
                $scope.updateMember($scope.update);
            } else {
                console.log('add');
                $scope.addMember();
            } 
        };
        /*end member*/

        // set file
        $scope.setTheFiles = function ($files) {
            angular.forEach($files, function (value, key) {
                formData.append('avatar', value);
            });
        };
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