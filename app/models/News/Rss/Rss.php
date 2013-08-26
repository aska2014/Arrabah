<?php namespace News\Rss;

use Cookie;
use DOMDocument;

class Rss {

    const SECRET_KEY = 'CrweasdADS';

    /**
     * @var string
     */
    private $rssUrl;

    /**
     * @param $rssUrl
     */
    public function __construct( $rssUrl )
    {
        $this->rssUrl = $rssUrl;
    }

    /**
     * @return string
     */
    public function getRssUrl()
    {
        return $this->rssUrl;
    }

    /**
     * @return \SimpleXMLElement[]
     */
    public function loadItems()
    {
        if (($response_xml_data = file_get_contents($this->getRssUrl()))===false){
            echo "Error fetching XML\n";
        } else {
            libxml_use_internal_errors(true);

            file_put_contents(__DIR__ . '/kareem.test', $response_xml_data);

            $data = simplexml_load_string($response_xml_data);
            if (!$data) {
                echo "Error loading XML\n";
                foreach(libxml_get_errors() as $error) {
                    echo "\t", $error->message;
                }
            } else {
                print_r($data);
            }
        }
//        return $xml->item;
    }

    /**
     * @return Item|null
     */
    public function getLatest()
    {
        $items = $this->loadItems();

        $latestItem = Item::makeFromXml($items[0]);

        // If he already seen the last news then return null
        if($this->hasSeen($latestItem)) {
            return null;
        }

        // Return the latest item.
        return $latestItem;
    }

    private function hasSeen( Item $item )
    {
        $firstDate = date_format($item->getPubDate(), 'Ymd');
        $secondDate = date_format($this->getCookiePubDate(), 'Ymd');

        return $firstDate == $secondDate;
    }

    /**
     * @param Item $item
     */
    private function setSeen( Item $item )
    {
        $this->setCookiePubDate($item->getPubDate());
    }

    /**
     * @return mixed
     */
    private function getCookiePubDate()
    {
        return Cookie::get(self::SECRET_KEY);
    }

    /**
     * @param $date
     */
    private function setCookiePubDate( $date )
    {
        Cookie::forever(self::SECRET_KEY, $date);
    }
}