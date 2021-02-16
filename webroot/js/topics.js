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
   * Initialize
   *
   * @return {void}
   */
  $scope.initBlocks = function(blocks, topicFramesBlock) {
    $scope.blocks = blocks;
    $scope.topicFramesBlock = topicFramesBlock['topicFramesBlock'];
  };

  /**
   * Initialize
   *
   * @return {void}
   */
  $scope.optionBlocks = function() {
    var pluginKey = $scope.topicFramesBlock.pluginKey + $scope.topicFramesBlock.roomId;

    if (angular.isDefined($scope.blocks[pluginKey])) {
      if (angular.isDefined($scope.blocks[pluginKey][$scope.blockKey])) {
        var blockKey = $scope.topicFramesBlock.blockKey;
      } else {
        var blockKey = null;
        angular.forEach($scope.blocks[pluginKey], function(value, key) {
          if (! blockKey) {
            blockKey = key;
          }
        });
      }

      $scope.topicFramesBlock.blockKey = $scope.blocks[pluginKey][blockKey];
      return $scope.blocks[pluginKey];
    } else {
      return null;
    }
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
    ['$scope', '$http', '$location', '$window', 'NC3_URL',
      function($scope, $http, $location, $window, NC3_URL) {

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
        $scope.link = function($event) {
          $location.hash(
              'page:' + ($scope.paging['page']) + '&' + 'frame_id:' + $scope.params['frame_id']
          );
          $window.location.href = $event.currentTarget.href;
          $event.preventDefault();
        };

        /**
         * URLからデータ取得
         *
         * @return {void}
         */
        $scope.more = function(startPage, currentPage) {
          var url = '/topics/topics/index';
          if (! currentPage) {
            currentPage = ($scope.paging['page'] + 1);
          }
          if (! startPage) {
            startPage = currentPage;
          }
          angular.forEach($scope.named, function(value, key) {
            if (key === 'page' || key === 'startPage') {
            } else {
              url = url + '/' + key + ':' + value;
            }
          });
          url = url + '/page:' + currentPage;
          url = url + '/startPage:' + startPage;

          $http.get(NC3_URL + url + '.json', {params: $scope.params})
              .then(function(response) {
                var data = response.data;
                $scope.paging = data['paging'];
                angular.forEach(data['topics'], function(value) {
                  $scope.topics.push(value);
                });
              },
              function(response) {
              });
        };

        /**
         * hashChange
         *
         * @return {void}
         */
        $scope.hashChange = function() {
          $($window).bind('hashchange', function() {
            var page = $window.location.href.match('page:([0-9]+)');
            var frameId = $window.location.href.match('frame_id:([0-9]+)');
            if (page && frameId && frameId[1] == $scope.params['frame_id']) {
              $scope.more(2, page[1]);
              try {
                var element = $('#topic-frame-' + $scope.params['frame_id']);
                var pos = element.offset().top;
                $window.scrollTo(0, pos - 200);
              } catch (err) {
              }
            }
          }).trigger('hashchange');
        };

      }]);
