<?php

class DSTVUrls
{
    // @todo - Move to Config
    
    
    public static function getPackages()
    {
        return 'http://guide.dstv.com/api/bouquet?countryCode=&productId=&language=EN';
    }
    
    
    public static function getChangesInGenre($genre)
    {
        return 'http://guide.dstv.com/api/channel/fetchChannelsByGenresInBouquet?bouquetId=c35aaecd-5dd1-480b-ae24-357e600a0e4d&genre='.urlencode($genre);
    }
    
    
}