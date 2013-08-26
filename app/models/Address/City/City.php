<?php namespace Address\City;

use Eloquent;

class City extends Eloquent {

	// protected $connection = 'sqlite';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cities';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	/**
	 * The attributes that can't be mass assigned
	 *
	 * @var array
	 */
    protected $guarded = array('id');

    /**
     * Whether or not to softDelete
     *
     * @var bool
     */
    protected $softDelete = false;


    /**
     * Get current name for this city
     *
     * @return string
     */
    public function getName( $arabic = true )
    {
        if($arabic)
            
            return trim($this->arabic) ? $this->arabic : $this->english;

        return trim($this->english) ? $this->english : $this->arabic;
    }


    /**
     * Check if this is region
     *
     * @return bool
     */
    public function isRegion()
    {
        return $this->parent_id == $this->getCity()->id;
    }

    /**
     * Check if this is city
     *
     * @return bool
     */
    public function isCity()
    {
        return $this->parent_id == $this->getCountry()->id;
    }

    /**
     * Check if this is country
     *
     * @return bool
     */
    public function isCountry()
    {
        return $this->parent_id == 1;
    }

    /**
     * Get city for this city
     *
     * @return City
     */
    public function getCity()
    {
        $country_id = $this->getCountry()->id;

        $city = $this;

        $levels = 0;

        while($city && $city->parent_id != $country_id && $levels < 5)
        {
            $city = $city->getParent();

            $levels++;
        }

        return $city;
    }

    /**
     * Get country for this city
     *
     * @return City
     */
    public function getCountry()
    {
        $country = $this;

        $levels = -1;

        do{
            $country = $country->getParent();

            $levels++;

        } while($country && $country->parent_id != 1 && $levels < 5);

        return $country;
    }

    /**
     * Get parent for this city
     *
     * @return City
     */
    public function getParent()
    {
        return $this->where('id', $this->parent_id)->first();
    }

    /**
     * Get children for this city
     *
     * @return Collection
     */
    public function children()
    {
    	return $this->where('parent_id', $this->id)->orderBy('arabic', 'ASC')->get();
    }

    /**
     * Get root cities 
     *
     * @return Collection
     */
    public static function root()
    {
    	return static::where('parent_id', 1)->where('id', '>', 1)->orderBy('arabic', 'ASC')->get();
    }

    /**
     * Get root cities 
     *
     * @return Collection
     */
    public static function level( $num )
    {
    	$cities = static::root();

    	for ($i=0; $i < $num; $i++)
    	{
    		$new = array();

    		foreach ($cities as $city)
    		{
    			$new = $city->children()->merge( $new );
    		}

    		$cities = $new;
    	}

    	return $cities;
    }


    /**
     * Has many relationship with users.
     *
     * @return void
     */
    public function users()
    {
        return $this->hasMany( 'Membership\User\User' );
    }
}