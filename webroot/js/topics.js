/**
 * @fileoverview Topics Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * TopicsController Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, NetCommonsWysiwyg)} Controller
 */
NetCommonsApp.controller('TopicsController', ['$scope', function($scope) {

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
