var app=angular.module('app',[]).controller('Ctrl',function($scope) {
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