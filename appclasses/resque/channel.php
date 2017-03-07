<?php
/**
 * Created by PhpStorm.
 * User: tohir.solomons
 * Date: 2017/03/07
 * Time: 10:35 AM
 */

class Resque_ChannelParser extends ResqueHackathon
{

    public function perform()
    {
        Logger::log(print_r($this->args, true), __FILE__, __LINE__, __METHOD__);


        $packages   = $this->db->loadModel('Packages');
        $channels   = $this->db->loadModel('Channels');
        $genre      = $this->db->loadModel('Genres');


        $premiumId = $packages->getPremiumId();

        $genreInfo = $genre->getByName($this->args['genre']);


        Logger::log($premiumId, __FILE__, __LINE__, __METHOD__);

        $url = DSTVUrls::getChannelsInGenre($premiumId, $this->args['genre']);

        Logger::log($url, __FILE__, __LINE__, __METHOD__);

        $content = CurlCaller::call('get', $url);

        if (!empty($content)) {
            $content = json_decode($content, TRUE);

            foreach ($content['items'] as $item)
            {
                //Logger::log($item, __FILE__, __LINE__, __METHOD__);

                $channelInfo = $channels->getByChannelTag($item['channelTag']);

                if (empty($channelInfo)) {
                    $channels->add([
                        'channelid' => $item['id'],
                        'channelname' => $item['channelName'],
                        'channelnumber' => $item['channelNumber'],
                        'channeltag' => $item['channelTag'],
                        'channellogo' => $item['channelLogoPaths']['XLARGE'],
                        'channelurl' => $item['channelUrl'],
                        'description' => $item['description'],
                        'genre_id' => $genreInfo['id'],
                        'active' => 'Y', // Hardcode for now
                    ]);
                }
            }
        }

    }

}