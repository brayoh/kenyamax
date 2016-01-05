<?php
	require 'vendor/autoload.php';
	require 'vendor/RedBean/rb.php';

	// register Slim auto-loader
	\Slim\Slim::registerAutoloader();

	// set up database connection
	R::setup('mysql:host=localhost;dbname=kenyamax_movies','root','');
	R::freeze(true);
	$key = "$2y$10$5ebdde1aedb51ab740332uwVI2O";
	$app = new \Slim\Slim();

	$app->get('/imax/', function() use($app) {
		$movies = R::find('Imax','ORDER BY id DESC');
		$q = R::exportAll($movies);
		$splited = function($x){

   	          	$start = microtime(true);
                
                $movies = [];
                foreach ($x as $key => $value) {

                        $days = explode(",", $value['days']);
                        $time = explode(",", $value['time_showing']);
                        
                        $time = str_replace("(", "", $time);
                        $time = str_replace(")", "", $time);
                        
                        $time_showing = array_combine($days, $time);   
                        $movie_group = array(

                                      'title' =>$value['movie_title'],
                                      'year' => $value['year'],
                                      'genre' => $value['genre'],
                                      'synopsis' => $value['synopsis'],
                                      'actors' => $value['actors'],
                                      'imdb rating' => $value['imdb_rating'],
                                      'imdb votes' => $value['imdb_votes'],
                                      'poster' => $value['poster'],
                                      'time showing' => $time_showing

                                  
                          );
                        array_push($movies, $movie_group);  
                     
                };
               // $app->response()->header('Content-Type', 'application/json');
	    		//
	    		 header("Content-type: application/json");
	    		 echo json_encode(array("Imax Movies"=>$movies));
         };
    	$splited(R::exportAll($movies));
	});
	$app->get('/anga_sky/', function() use($app) {
		$movies = R::find('anga_sky','ORDER BY id DESC');
		$q = R::exportAll($movies);
		$splited = function($x){

   	          	$start = microtime(true);
                
                $movies = [];
                foreach ($x as $key => $value) {

                        $days = explode(",", $value['days']);
                        $time = explode(",", $value['time_showing']);
                        
                        $time = str_replace("(", "", $time);
                        $time = str_replace(")", "", $time);
                        
                        $time_showing = array_combine($days, $time);   
                        $movie_group = array(

                                      'title' =>$value['movie_title'],
                                      'year' => $value['year'],
                                      'genre' => $value['genre'],
                                      'synopsis' => $value['synopsis'],
                                      'actors' => $value['actors'],
                                      'imdb rating' => $value['imdb_rating'],
                                      'imdb votes' => $value['imdb_votes'],
                                      'poster' => $value['poster'],
                                      'time showing' => $time_showing

                                  
                          );
                        array_push($movies, $movie_group);  
                     
                };
               // $app->response()->header('Content-Type', 'application/json');
	    		//
	    		 header("Content-type: application/json");
	    		 echo json_encode(array("Anga Sky Movies"=>$movies));
         };
    	$splited(R::exportAll($movies));
	});
	
 	$app->response()->header('Content-Type', 'application/json');
 	$memoize = function($func)
	{
	    return function() use ($func)
	    {
	        static $cache = [];

	        $args = func_get_args();
	        $key = md5(serialize($args));

	        if ( ! isset($cache[$key])) {
	            $cache[$key] = call_user_func_array($func, $args);
	        }

	        return $cache[$key];
	    };
	};
	if(array_key_exists("key", $_GET) && $_GET['key'] === $key) {
		
			$memoize($app->run());
		
	}
	else{
		require "404.html";
	}
?>
