<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::group(['prefix' => 'admin','middleware'=>'auth'], function () {
	//Index Route//
	Route::get('/',[
			'uses' => 'HomeController@index',
			'as'   => 'admin.home',
	]);	

	//Verify Email//
	Route::get('/verifyemail', 'HomeController@index');

	//Images Routes//
	Route::resource('images', 'ImagesController');
		Route::delete('/images/destroyImage/{type}/{id}',[
			'uses' => 'ImagesController@destroyImage',
			'as' => 'admin.image.destroyImage',
		]);
	//Tag Routes//
	Route::resource('tags', 'TagsController');
		Route::get('tags/{id}/destroy',[
			'uses' => 'TagsController@destroy',
			'as'   => 'admin.tags.destroy',
		]);
	//Navbar routes //
	Route::resource('navbars', 'NavbarController');	
		Route::get('navbars/{id}/destroy',[
			'uses' => 'NavbarController@destroy',
			'as'   => 'admin.navbars.destroy',
		]);
	//Sidebar routes //
	Route::resource('sidebars', 'SidebarController');	
		Route::get('sidebars/{id}/destroy',[
			'uses' => 'SidebarController@destroy',
			'as'   => 'admin.sidebars.destroy',
		]);
	//Footer routes //
	Route::resource('footers', 'FooterController');	
		Route::get('footers/{id}/destroy',[
			'uses' => 'FooterController@destroy',
			'as'   => 'admin.footers.destroy',
		]);
	//Posts Routes//
	Route::get('posts/all',[
			'uses' => 'PostsController@all',
			'as'   => 'admin.posts.all',
	]);
	Route::resource('posts', 'PostsController');
	Route::get('posts/{id}/destroy',[
		'uses' => 'PostsController@destroy',
		'as'   => 'admin.posts.destroy',
	]);
	Route::get('posts/{id}/approve',[
		'uses' => 'PostsController@approve',
		'as'   => 'admin.posts.approve',
	]);
	Route::get('posts/{id}/suspend',[
		'uses' => 'PostsController@suspend',
		'as'   => 'admin.posts.suspend',
	]);
	Route::get('posts/{id}/user',[
		'uses' => 'PostsController@getUserPosts',
		'as'   => 'admin.posts.user',
	]);
	//Ebooks Routes//	
	Route::get('ebooks/all',[
			'uses' => 'EbooksController@all',
			'as'   => 'admin.ebooks.all',
	]);
	Route::resource('ebooks', 'EbooksController');
	Route::get('ebooks/{id}/destroy',[
		'uses' => 'EbooksController@destroy',
		'as'   => 'admin.ebooks.destroy',
	]);
	Route::get('ebooks/{id}/approve',[
		'uses' => 'EbooksController@approve',
		'as'   => 'admin.ebooks.approve',
	]);
	Route::get('ebooks/{id}/suspend',[
		'uses' => 'EbooksController@suspend',
		'as'   => 'admin.ebooks.suspend',
	]);
	Route::get('ebooks/{id}/user',[
		'uses' => 'EbooksController@getUserPosts',
		'as'   => 'admin.ebooks.user',
	]);
	//Photos Routes//
	Route::get('photos/all',[
			'uses' => 'PhotosController@all',
			'as'   => 'admin.photos.all',
	]);
	Route::resource('photos', 'PhotosController');
	Route::get('photos/{id}/destroy',[
		'uses' => 'PhotosController@destroy',
		'as'   => 'admin.photos.destroy',
	]);
	Route::get('photos/{id}/approve',[
		'uses' => 'PhotosController@approve',
		'as'   => 'admin.photos.approve',
	]);
	Route::get('photos/{id}/suspend',[
		'uses' => 'PhotosController@suspend',
		'as'   => 'admin.photos.suspend',
	]);
	Route::get('photos/{id}/user',[
		'uses' => 'PhotosController@getUserPosts',
		'as'   => 'admin.photos.user',
	]);
	//Videos Routes//
	Route::get('videos/all',[
		'uses' => 'VideosController@all',
		'as'   => 'admin.videposts.all',
	]);
	Route::resource('videos', 'VideosController');
	Route::get('videos/{id}/destroy',[
		'uses' => 'VideosController@destroy',
		'as'   => 'admin.videos.destroy',
	]);

	Route::get('videos/{id}/approve',[
		'uses' => 'VideosController@approve',
		'as'   => 'admin.videos.approve',
	]);
	Route::get('videos/{id}/suspend',[
		'uses' => 'VideosController@suspend',
		'as'   => 'admin.videos.suspend',
	]);
	Route::get('videos/{id}/user',[
		'uses' => 'VideosController@getUserPosts',
		'as'   => 'admin.videos.user',
	]);
	
	//Users Routes//
	Route::resource('users', 'UsersController');
		Route::get('users/{id}/destroy',[
			'uses' => 'UsersController@destroy',
			'as'   => 'admin.users.destroy',
		]);
	//Category Routes//
	Route::resource('categories', 'CategoriesController');
		Route::get('categories/{id}/destroy',[
			'uses' => 'CategoriesController@destroy',
			'as'   => 'admin.categories.destroy',
		]);
	//SubCategory Routes//
	Route::resource('subcategories', 'SubcategoriesController');
		Route::get('subcategories/{id}/destroy',[
			'uses' => 'SubcategoriesController@destroy',
			'as'   => 'admin.subcategories.destroy',
		]);
	//Tag Routes //
	Route::resource('tags', 'TagsController');
		Route::get('tags/{id}/destroy',[
			'uses' => 'TagsController@destroy',
			'as'   => 'admin.tags.destroy',
		]);
	//Advertisement Routes //
	Route::resource('advs', 'AdvsController');
		Route::get('advs/{id}/destroy',[
			'uses' => 'AdvsController@destroy',
			'as'   => 'admin.advs.destroy',
		]);
	Route::get('advs/{id}/approve',[
		'uses' => 'AdvsController@approve',
		'as'   => 'admin.advs.approve',
	]);
	Route::get('advs/{id}/suspend',[
		'uses' => 'AdvsController@suspend',
		'as'   => 'admin.advs.suspend',
	]);
});


//WEB ROUTES
	Route::get('/activated',[
				'uses' => 'Auth\AuthController@showActivatedForm',
				'as'   => 'auth.activated',
	]);


	//Comments Route//
	Route::post('comment/{type}/{post_id}/{user_id?}/',[
			'uses' => 'CommentsController@store',
			'as'   => 'add.comments',
	]);	

	//Points
	Route::post('/points/addShare/{type}/{id}/{shares}',[
		'uses' => 'PointsController@addShare',
		'as'   => 'front.points.addshare',
	]);
	Route::post('/points/addComment/{type}/{id}/{comments}',[
		'uses' => 'PointsController@addComment',
		'as'   => 'front.points.addcomment',
	]);
	Route::post('/points/addLike/{type}/{id}/{likes}',[
		'uses' => 'PointsController@addLike',
		'as'   => 'front.points.addlike',
	]);
	Route::get('/points/getUserPoints/{userid}/{from?}/{to?}',[
		'uses' => 'PointsController@getUserPoints',
		'as'   => 'front.points.getUserPoints',
	]);

	Route::get('/points/getfacebookstats/{url}',[
		'uses'=> 'PointsController@getFacebooks',
		'as' => 'front.points.getfacebooks',
	]);

	//Front Posts 
	Route::get('/posts/{id}/{share?}',[
	'uses' => 'PostsController@show',
	'as'   => 'front.posts.index',
	]);	
	Route::post('posts/addView/{id}',[
		'uses' => 'PostsController@addView',
		'as'   => 'admin.posts.addview',
	]);
	Route::post('/posts/addShare/{id}/{shares}',[
	'uses' => 'PostsController@addShare',
	'as'   => 'front.posts.share',
	]);

	//Front Category 
	Route::get('/categories/{id}/{share?}',[
	'uses' => 'CategoriesController@show',
	'as'   => 'front.categories.show',
	]);
	//Front Category 
	Route::get('/subcategories/{id}/{share?}',[
	'uses' => 'SubcategoriesController@show',
	'as'   => 'front.subcategories.show',
	]);

	//Front Photos
	Route::post('photos/addView/{id}',[
		'uses' => 'PhotosController@addView',
		'as'   => 'admin.ebook.addview',
	]);
	Route::get('/photos/allphotos',[
	'uses' => 'PhotosController@showAll',
	'as'   => 'front.photos.index',
	]);
	Route::get('/photos/{id}/{share?}',[
	'uses' => 'PhotosController@show',
	'as'   => 'front.photos.index',
	]);
	//Front Videos
	Route::post('videos/addView/{id}',[
		'uses' => 'VideosController@addView',
		'as'   => 'admin.videos.addview',
	]);
	Route::get('/videos/allvideos',[
	'uses' => 'VideosController@showAll',
	'as'   => 'front.videos.index',
	]);

	Route::get('/videos/{id}/{share?}',[
	'uses' => 'VideosController@show',
	'as'   => 'front.videos.show',
	]);
	//Front Ebooks
	Route::post('ebooks/addView/{id}',[
		'uses' => 'EbooksController@addView',
		'as'   => 'admin.ebook.addview',
	]);
	Route::get('/ebooks/allebooks',[
	'uses' => 'EbooksController@showAll',
	'as'   => 'front.ebooks.index',
	]);

	Route::get('/ebooks/{id}/{share?}',[
	'uses' => 'EbooksController@show',
	'as'   => 'front.ebooks.show',
	]);
	
	Route::get('/',[
	'uses' => 'FrontPageController@index',
	'as'   => 'front.index',
	]);
	//Newsletters		
	Route::post('/newsletters/subscribe/{email}/{categoryid}',[
		'uses' => 'NewslettersController@subscribe',
		'as'   => 'front.newsletters.subscribe',
	]);		
	Route::post('/newsletters/unsubscribe/{email}/{categoryid}',[
		'uses' => 'NewslettersController@unsubscribe',
		'as'   => 'front.newsletters.unsubscribe',
	]);
	
	Route::get('/newsletters/isSubscriber/{email?}/{categoryid?}',[
		'uses' => 'NewslettersController@isSubscriber',
		'as'   => 'front.newsletters.isSubscriber',
	]);
	//End Newsletters
	Route::get('posts', [ 'as' => 'posts', 'uses' => 'FrontPageController@posts' ]);
	//Login and Register
	Route::auth();
	Route::get('user/activation/{token}', 'Auth\AuthController@activateUser')->name('user.activate');
	Route::get('auth/facebook', 'SocialAuth2Controller@redirectToProvider');

	Route::get('auth/facebook/callback', 'SocialAuth2Controller@handleProviderCallback');
	Route::get('auth/twitter', 'SocialAuth2Controller@redirectToProvider2');
	Route::get('auth/twitter/callback', 'SocialAuth2Controller@twitterCallback');


Route::auth();
