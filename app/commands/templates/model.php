<?php

return '<?php namespace ' .$namespace . ';

use Eloquent;

class ' .$class. ' extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = \'' . $table . '\';

	/**
	 * The attributes excluded from the model\'s JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array(\'id\');

	/**
	 * The attributes that can\'t be mass assigned
	 *
	 * @var array
	 */
    protected $guarded = array(\'id\');

    /**
     * Whether or not to softDelete
     *
     * @var bool
     */
    protected $softDelete = false;

}';