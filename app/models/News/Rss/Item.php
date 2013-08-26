<?php namespace News\Rss;

use DateTime;

class Item {

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $link;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var DateTime
     */
    protected $pubDate;

    /**
     * @var string
     */
    protected $mediaContent;

    /**
     * @var string
     */
    protected $mediaPlayer;

    /**
     * @param $title
     * @param $link
     * @param $description
     * @param $pubDate
     * @param string $mediaContent
     * @param string $mediaPlayer
     */
    public function __construct( $title, $link, $description, $pubDate, $mediaContent = '', $mediaPlayer = '' )
    {
        $this->title = $title;
        $this->link  = $link;
        $this->description = $description;
        $this->pubDate = $pubDate;
        $this->mediaContent = $mediaContent;
        $this->mediaPlayer = $mediaPlayer;
    }

    /**
     * @param $item
     * @return Item
     */
    public static function makeFromXml( $item )
    {
        return new static($item->title, $item->link, $item->description, new DateTime($item->pubDate), $item->mediaContent, $item->mediaPlayer);
    }

    /**
     * @return \DateTime
     */
    public function getPubDate()
    {
        return $this->pubDate;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getMediaContent()
    {
        return $this->mediaContent;
    }

    /**
     * @return string
     */
    public function getMediaPlayer()
    {
        return $this->mediaPlayer;
    }
}