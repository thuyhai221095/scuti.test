<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<!-- AnngularJS -->
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/es5-shim/4.5.8/es5-shim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.2/moment.js"></script>
<script src="{{ asset('/DataTables/datatables.js') }}"></script>
<script src="{{ asset('js/datatable-responsive/datatables.responsive.min.js') }}"></script>
<script src="{{ asset('bower_components/air-datepicker/dist/js/datepicker.min.js') }}"></script>
<script src="{{ asset('bower_components/air-datepicker/dist/js/i18n/datepicker.en.js') }}"></script>
<!-- toastr -->
<script src="{{ url('js/toastr.min.js') }}"></script>
@stack("script")
<script type="text/javascript">
	
	var myApp = angular.module("myApp", []);
	
	// date-picker
	myApp.directive('datePicker', function(){
		return{
			restrict: 'A',
			require: 'ngModel',
			link: function(scope, elm, attr, ctrl){

		        // Format date on load
		        ctrl.$formatters.unshift(function(value) {
		        	if(value && moment(value).isValid()){
		        		return moment(new Date(value)).format('MM/DD/YYYY');
		        	}
		        	return value;
		        })
		        
		        //Disable Calendar
		        scope.$watch(attr.ngDisabled, function (newVal) {
		        	if(newVal === true)
		        		$(elm).datepicker("disable");
		        	else
		        		$(elm).datepicker("enable");
		        });
		        
		        // Datepicker Settings
		        elm.datepicker({
		        	autoSize: true,
		        	changeYear: true,
		        	changeMonth: true,
		        	dateFormat: attr["dateformat"] || 'mm/dd/yy',
		        	showOn: 'button',
		        	buttonText: '<i class="glyphicon glyphicon-calendar"></i>',
		        	onSelect: function (valu) {
		        		scope.$apply(function () {
		        			ctrl.$setViewValue(valu);
		        		});
		        		elm.focus();
		        	},

		        	beforeShow: function(){
		        		debugger;
		        		if(attr["minDate"] != null)
		        			$(elm).datepicker('option', 'minDate', attr["minDate"]);

		        		if(attr["maxDate"] != null )
		        			$(elm).datepicker('option', 'maxDate', attr["maxDate"]);
		        	},
		        });
		    }
		}
	});
</script>
@stack('angularjs')
