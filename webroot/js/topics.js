/**
 * @fileoverview Topics Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * TopicsController Javascript
 *
 * @param {string} Controller name
 * @param {function($scope)} Controller
 */
NetCommonsApp.controller('TopicSettingsController', ['$scope', function($scope) {

  /**
   * Initialize
   *
   * @return {void}
   */
  $scope.initialize = function(topics) {
    $scope.topics = angular.copy(topics);
  };

  /**
   * Radio click
   *
   * @return {void}
   */
  $scope.checked = function($event) {
    return Number($event.target.checked);
  };

  /**
   * Radio click
   *
   * @return {void}
   */
  $scope.selected = function($event) {
    if (! $event) {
      return;
    }
    return Number($event.target.value);
  };

}]);


/**
 * TopicsController Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, $http)} Controller
 */
NetCommonsApp.controller('TopicsController',
    ['$scope', '$http', '$location', function($scope, $http, $location) {

      /**
       * 新着データ
       */
      $scope.topics = [];

      /**
       * Initialize
       *
       * @return {void}
       */
      $scope.initialize = function(data) {
        $scope.named = data['named'];
        $scope.paging = data['paging'];
        $scope.params = data['params'];
      };

      /**
       * URLからデータ取得
       *
       * @return {void}
       */
      $scope.more = function() {
        var url = '/topics/topics/index';
        angular.forEach($scope.named, function(value, key) {
          url = url + '/' + key + ':' + value;
        });
        url = url + '/page:' + ($scope.paging['page'] + 1);

        $http.get($scope.baseUrl + url + '.json', {params: $scope.params})
          .success(function(data) {
              $scope.paging = data['paging'];
              angular.forEach(data['topics'], function(value) {
                $scope.topics.push(value);
              });
            })
          .error(function(data) {
            });
      };

    }]);
