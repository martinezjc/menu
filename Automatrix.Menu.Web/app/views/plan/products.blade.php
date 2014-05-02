@extends("layouts.admin") 

@section("scripts")
    {{ HTML::script('scripts/planproducts.js'); }}
    {{ HTML::script('js/angular.min.js'); }}
    {{ HTML::script('js/angular.js'); }}
@stop

@section('toolbar')

@stop

@section('content')

@if (!empty($currentUser->DealerId))
  <a class="btn btn-success" href="new-product" id="addProduct"><i class="fa fa-plus"></i> Add Product</a>
  <a class="btn btn-success" id="generalSettings" href="general-settings"><i class="fa fa-gears"></i> General Settings</a>
@else
    @if ($currentUser->Administrator == 1) 
        <a class="btn btn-success" id="generalSettings" href="company-settings"><i class="fa fa-building-o"></i> Companies</a>
        <a class="btn btn-success" id="generalSettings" href="dealer-settings"><i class="fa fa-angle-double-right"></i> Dealers</a>
    @endif
@endif

<div id="angulardiv" ng-app="app" ng-controller="TableCtrl">

<div class="col-md-9">
<!-- Angularjs products table --> 
<table class="table table-striped" id="productsTable" >
  <thead>
    <tr>
      <th>#</th>
      <th>Company</th>
      <th>Product Name</th>
      <th>Bullets Points</th>
      <th>Cost</th>
      <th>Selling Price</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <tr ng-repeat="productItem in products">
      <td ng-switch="productItem.Added">
        <span ng-switch-when="0"><input type="checkbox" id="<% productItem.ProductId %>" name="productRef<% productItem.ProductId %>" class="m"></span>
        <span ng-switch-when="1"><input type="checkbox" id="<% productItem.ProductId %>" checked name="productRef<% productItem.ProductId %>" class="m"></span>
      </td>
      <td><% productItem.CompanyName %></td>
      <td>
        <a href="edit-product?ProductId=<% productItem.ProductId %>" name="<% productItem.ProductId %>" class="modify"><span title="Edit Product"><% productItem.ProductName %><i class="fa fa-pencil-square-o"></i></span></a><br/>
        <% productItem.ProductName %>
      </td>
      <td>
        <span ng-if="productItem.ProductDescription !== ''"><% productItem.ProductDescription %></span><br/>
        <ul>
          <li ng-repeat="bullet in productItem.Bullets | split"><% bullet %></li>
        </ul>
      </td>
      <td align="left" ng-switch="productItem.UsingWebService">
        <span ng-switch-when="0">$<% productItem.Cost | number:2 %></span>
        <span ng-switch-when="1">Auto</span>
      </td>
      <td align="left" ng-switch="productItem.UsingWebService">
        <span ng-switch-when="0">$<% productItem.SellingPrice | number:2 %></span>
        <span ng-switch-when="1">Auto</span>
      </td>
      <td ng-switch="productItem.Added"><span ng-switch-when="0"><button type="button" class="btn btn-danger" value="<% productItem.ProductId %>" >Delete</button></td>
    </tr>
  </tbody>
</table>
<!-- Ends Angular products table -->
</div>

<div id="SortableTable" class="col-md-3 space" >
  <div class="tables2">
    <div class="gantry-width-block">                    
      <ul class="rt-pricing-table2">
        <li class="rt-table-title-premium">Premium</li>             
        <div class="sortable bodyTable">
          <li class="sortableList" ng-repeat="productItem in productsPlans" id="<% productItem.id %>"> 
            <div class="product-header-container-settings">
              <div class="title-product"><% productItem.ProductName %></div>
              <div class="price-product" ng-switch="productItem.UsingWebService">
               <span ng-switch-when="1">Auto</span>
               <span ng-switch-when="0">$<% productItem.Cost | number:2 %></span>
             </div>
             <div class="displayname-product"><% productItem.ProductDescription %></div>
           </div>
           <span ng-repeat="bullet in productItem.Bullets | split">
             <span class="square">&#x25a0; </span> <span class="bulletDetail"><% bullet %>
           </span><br>
         </span>
       </li>
     </div>
   </ul>
 </div>
</div>
</div>


</div>

@stop