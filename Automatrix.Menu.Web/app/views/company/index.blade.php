@extends("layouts.admin") 

@section("scripts")
    {{ HTML::script('scripts/company.js'); }}
@stop

@section('toolbar')

<div class="row">
	<div class="col-md-9">
		<a class="btn btn-success" data-dismiss="modal" id="newCompanyDialog" data-toggle="modal" href="#company-dialog">
            <i class="fa fa-file-o"></i>Add new company
        </a>
	</div>
	<div class="col-md-3"></div>
</div>
@stop

@section('content')
<div class="row">
	<div class="col-md-10">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Company Name</th>
					<th>URL</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($companies as $company)
				<tr>
					<td></td>
					<td>{{ $company->CompanyName }}</td>
					<td>{{ $company->URL }}</td>
					<td style="width: 10%">
                        <a href="#" class="btn btn-warning" onclick="javascript:showCompany({{ $company->id }})"><i class="fa fa-pencil-square-o"></i>Modify</a>
                    </td>
					<td style="width: 10%">
                        <a href="#" class="btn btn-danger" id="deleteCompany" onClick="deleteCompany({{ $company->id }});"><i class="fa fa-trash-o"></i> Delete</a>
                    </td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<div class="col-md-2"></div>

    <!-- Modal for new company -->
	<div class="modal fade" id="company-dialog" tabindex="-1" role="dialog" aria-labelledby="dialog-title" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="dialog-title">Company</h4>
				</div>
				<div class="modal-body row-fluid">
					<div class="span6">
						<div class="form-group">
							<label for="Company">Company Name</label> 
                            <input type="hidden" name="CompanyId" id="CompanyId" />
                            <input type="text" name="CompanyName" id="CompanyName" class="form-control" style="width: 40%" required />
						</div>
						<div class="form-group">
							<label for="URL">URL</label> 
                            <input type="text" name="URL" id="URL" class="form-control" style="width: 40%" required />
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
					<button type="button" class="btn btn-primary" onclick="javascript:saveCompany();">Save</button>
				</div>
			</div>
		</div>
	</div>
    
	<!-- ends modal for new company -->
</div>
@stop