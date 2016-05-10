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
    console.log($event);
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
        $scope.frameId = data['frameId'];
        $scope.urlParams = data['urlParams'];
        $scope.paginator = data['paginator'];
      };

      /**
       * URLからデータ取得
       *
       * @return {void}
       */
      $scope.more = function() {
        var url = '/topics/topics/index';
        angular.forEach($scope.urlParams, function(value, key) {
          url = url + '/' + key + ':' + value;
        });
        url = url + '/page:' + ($scope.paginator['page'] + 1);

        $http.get($scope.baseUrl + url + '.json', {params: {frame_id: $scope.frameId}})
          .success(function(data) {
              $scope.paginator = data['paginator'];
              angular.forEach(data['topics'], function(value) {
                $scope.topics.push(value);
              });
            })
          .error(function(data) {
            });
      };

    }]);
