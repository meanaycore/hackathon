<?php

class DSTVUrls
{
    // @todo - Move to Config
    
    
    public static function getPackages()
    {
        return 'http://guide.dstv.com/api/bouquet?countryCode=&productId=&language=EN';
    }
    
    
    public static function getChannelsInGenre($premiumId, $genre)
    {
        return 'http://guide.dstv.com/api/channel/fetchChannelsByGenresInBouquet?bouquetId='.$premiumId.'&genre='.urlencode($genre);
    }

    public static function getProgramInGenre($premiumId, $genre, $date)
    {
        return 'http://guide.dstv.com/api/gridview/page?bouquetId='.$premiumId.'&genre='.urlencode($genre).'&date='.$date;
    }

    public static function getProgramInfo($programId)
    {
        return 'http://guide.dstv.com/popup/'.$programId;
    }

}