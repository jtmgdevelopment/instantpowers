// Filename: router.js
define([
  'jquery',
  'underscore',
  'backbone',
  'views/home/main'
], function($, _, Backbone, MainView){
  var AppRouter = Backbone.Router.extend({

    routes: {
		'' : 'index'
    },
	index: function(){
		var menuView = MainView;	
	}
  });



  var initialize = function(){
    var app_router = new AppRouter;
    Backbone.history.start();
  };
  return {
    initialize: initialize
  };



});
