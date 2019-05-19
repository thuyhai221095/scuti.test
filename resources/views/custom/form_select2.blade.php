<div class="form-group" style="width: 100%">
	<select class="select2 form-control"  onchange="{{ @$onchange }}"  style="width: 100%" name="{{ $name }}">
 	    <option value="" >All</option>
 	    @if(isset($items) && $items != '')
	    @foreach ($items as $item)
	        <option value="{{ $item['value'] }}" {{ ($item['value'] == $value) ? "selected" : "" }}>{{ $item['name'] }}</option>
	    @endforeach
	    @endif
	</select>
</div>