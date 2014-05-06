var app = angular.module('app', []);

app.config( function ($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

function TableCtrl($http, $scope)
{
    $scope.getTable = function() 
    {
        $http.get(currentUrl + '/plans/products/get').success(function(data){
            $scope.products = data;
        });
    }
    
    $scope.getIncluded = function() 
    {
        $http.get(currentUrl + '/plans/products/included').success(function(data){
            $scope.productsPlans = data;
        });
    }

    $scope.getTable();

    if ($('#SortableTable').length) {
        $scope.getIncluded();
    }
}

app.filter('split', function() {
    return function(input, delimiter) {
        var delimiter = delimiter || ',';
        var array = [];
        var arrayNoEmpty = []; 
        
        array = input.split(delimiter);
     
        for (i = 0; i <= array.length; i++)
        {
            if (array[i])
            {
                arrayNoEmpty[i] = array[i]; 
            } 
        } 
        return arrayNoEmpty;
    } 
  });

app.controller('Ctrl',function($scope) {
  $scope.val = 0.00;
  $scope.val2 = 0.00;
  
}).directive('decimalPlaces',function(){
    return {
        link:function(scope,ele,attrs){
            ele.bind('keypress',function(e){
                var newVal=$(this).val()+(e.charCode!==0?String.fromCharCode(e.charCode):'');

                if($(this).val().search(/(.*)\.[0-9][0-9]/)===0 && newVal.length>$(this).val().length){
                    e.preventDefault();
                }
            });
        }
    };
}).directive('decimalsPlaces',function(){
    return {
        link:function(scope,ele,attrs){
            ele.bind('keypress',function(e){

                var newVal2=$(this).val()+(e.charCode!==0?String.fromCharCode(e.charCode):'');
                if($(this).val().search(/(.*)\.[0-9][0-9]/)===0 && newVal2.length>$(this).val().length){
                    e.preventDefault();
                }
            });
        }
    };
});