@extends('main')
@section('button')
<div class="container">
	<div class="row">
		<div class="col-md-2 col-md-offset-5">
				<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">New Migration</button>

				<!-- Modal -->
				<div id="myModal" class="modal fade" role="dialog">
					<div class="modal-dialog">

					<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Modal Header</h4>
							</div>
								<div class="modal-body">
								<form id="migration-form-submit">
									<input type="text" name="folder" placeholder="Folder Name">
									<input type="text" name="name" placeholder="Migration Name">
									<input type="submit" value="Save">
								</form>
								</div>
							<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>

					</div>
				</div>
		</div>
	</div>
</div>

@stop

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">


				@if(count($migrations)>0)

						@foreach($migrations as $migration)

						<div class="modal-content" style="width: 550px">
							<div class="modal-header">

							<h4 class="modal-title">{{ $migration->name }}</h4>
							</div>
								<div class="modal-body">
									@if(count($migration->fields)==0)
										<p>There is no Columns yet</p>
									@else
									<ol>
										@foreach($migration->fields as $field)
											<li>{{ "Column name" .$field->name." with type of".$field->type }}
													<form class='pull-right' method="post" action="/migration/remove/{{$field->id}}">
													<input type="hidden" name="_method" value="delete">
														<button>Remove</button>
													</form>
											  </li>
										@endforeach
									</ol>
									@endif
								</div>
							<div >
								<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="{{ '#newColumns'.$migration->id}}">New Columns</button>

								<!-- Modal -->
								<div id="{{ 'newColumns'.$migration->id}}" class="modal fade" role="dialog">
								<div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
								<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title pull-right">Add Columns</h4>
								</div>
								<div class="modal-body">
								<form id="{{ 'migration-column-submit'.$migration->id}}">
								<div >
								<input type="hidden" name="model_id" value="{{ $migration->id }} ">
									<select name="type">
										 <option value="increments">INCREMENTS</option>
							              <option value="bigIncrements">BIG INCREMENTS</option>
							              <option value="timestamps">TIME STAMPS</option>
							              <option value="softDeletes">SOFT DELETES</option>
							              <option value="rememberToken">REMEMBER TOKEN</option>
							              <option disabled="disabled">-</option>
							              <option value="string" selected="selected">STRING (VARCHAR)</option>
							              <option value="text">TEXT</option>
							              <option disabled="disabled">-</option>
							              <option value="tinyInteger">TINY INTEGER</option>
							              <option value="smallInteger">SMALL INTEGER</option>
							              <option value="mediumInteger">MEDIUM INTEGER</option>
							              <option value="integer">INTEGER</option>
							              <option value="bigInteger">BIG INTEGER</option>
							              <option disabled="disabled">-</option>
							              <option value="float">FLOAT</option>
							              <option value="decimal">DECIMAL</option>
							              <option value="boolean">BOOLEAN</option>
							              <option disabled="disabled">-</option>
							              <option value="enum">ENUM</option>
							              <option disabled="disabled">-</option>
							              <option value="date">DATE</option>
							              <option value="datetime">DATETIME</option>
							              <option value="time">TIME</option>
							              <option value="timestamp">TIMESTAMP</option>
							              <option disabled="disabled">-</option>
							              <option value="binary">BINARY</option>
									</select>
		<input type="text" name="name" placeholder="Enter Field Name"><br>
		<input type="checkbox" name='un_index'> Unsgined index <br>
		<input type="text" name="rel_table" placeholder="Enter Relationship Table name">
		<input type="text" name="rel_on" placeholder="Enter Relationship Table Column name">
	</div>
								<input type="submit" value="Save">
								</form>
								</div>
								<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
								</div>

								</div>
								</div>
							</div>
						</div>

			<script>
			$(function(){
				   $("{{ '#migration-column-submit'.$migration->id}}").on('submit', function(e){
        e.preventDefault();
        console.log($("{{ '#migration-column-submit'.$migration->id}}").serialize());
        $.ajax({
            url: '/migration/columns', //this is the submit URL
            type: 'POST', //or POST
            data: $("{{ '#migration-column-submit'.$migration->id}}").serialize(),
            success: function(data){
                 alert('successfully submitted')
                 location.reload();

            }
        });
    });
    });
			</script>


						@endforeach
				@else
					<p>There is no Migration Created </p>

				@endif
		</div>
	</div>
</div>


@stop
