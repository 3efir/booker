App.directive('header', function() {
  return {
    restrict: 'AE',
    replace: false,
    templateUrl: '/~user8/booker/index/header/',
	async: true
  };
});
App.directive('leftmenu', function() {
  return {
    restrict: 'AE',
    replace: false,
    templateUrl: '/~user8/booker/index/leftMenu/',
	async: true
  };
});
App.directive('rightmenu', function() {
  return {
    restrict: 'AE',
    replace: false,
    templateUrl: '/~user8/booker/admin/rightMenu/',
	async: true
  };
});