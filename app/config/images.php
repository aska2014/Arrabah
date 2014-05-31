<?php

use ImageConfig as IC;

return array(

	'user' => array(
		'profile' => array(

            IC::make('users/normal/user{user}.jpg'),

			IC::make('users/122x122/user{user}.jpg')->manipulate(function($image)
			{
				$image->grab(145, 145);
			})
		),

		'gallery' => array(

            IC::make('users/gallery{gallery}/normal/user{user}.jpg'),

			IC::make('user/gallery{gallery}/113x94/user{user}.jpg')->manipulate(function($image)
			{
				$image->grab(113, 94);
			}),
		)
	),




	'job' => array(
		'main' => array(

            IC::make('jobs/normal/job{job}.jpg'),

			IC::make('jobs/113x94/job{job}.jpg')->manipulate(function($image)
			{
				$image->grab(113, 94);
			})
		)
	),




	'event' => array(
		'main' => array(

			IC::make('events/main/normal/event{event}.jpg'),

			IC::make('events/main/113x94/event{event}.jpg')->manipulate(function($image)
			{
				$image->grab(113, 94);
			}),
		),
	),


	'gallery' => array(

		'image' => array(

			IC::make('galleries/gallery{gallery}/normal/image{image}.jpg'),

			IC::make('galleries/gallery{gallery}/113x94/image{image}.jpg')->manipulate(function($image)
			{
				$image->grab(145, 145);
			}),
		)

	),



	'banner' => array(

		'home' => array(

			IC::make('banners/banner{banner}.jpg')->manipulate(function($image)
			{
				$image->resize(120, null, true);
			}),
		)

	),


	'defaults' => array(
		'gallery' => array('image' => 'defaults/gallery.png'),
	)
);