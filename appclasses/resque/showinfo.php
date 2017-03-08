<?php
/**
 * Created by PhpStorm.
 * User: tohir.solomons
 * Date: 2017/03/07
 * Time: 10:35 AM
 */

use SlimRunner\AppConfig as AppConfig;

class ResqueShowInfo extends ResqueHackathon
{

    public function perform()
    {
        Logger::log(print_r($this->args, true), __FILE__, __LINE__, __METHOD__);

        $showInfo = $this->db->loadModel('ShowInfo');

        $title = $this->args['title'];
        $season = $this->args['season'];

        $show = $showInfo->getByInternalTitle($title);

        // Ignore if we have content
        if (!empty($show)) {
            return;
        }

        $queryParams = [
            't' => $title,
            'plot' => 'full',
            'tomatoes' => 'true',
        ];

        if (!empty($season)) {
            $queryParams['type'] = 'series';
        }

        $url = 'http://www.omdbapi.com/?'.http_build_query($queryParams);

        Logger::log($url, __FILE__, __LINE__, __METHOD__);

        $content = CurlCaller::call('get', $url);

        if (empty($content)) {
            Logger::log('No Curl Content', __FILE__, __LINE__, __METHOD__);
            return ;
        }

        $content = json_decode($content, true);

        $shortUrl = Utils::cleanUrl($this->getArrayValue($content, 'Title'));

        // Cater for blank shorturl
        if (empty($shortUrl)) {
            $shortUrl = md5($title);
        }


        if ($content['Response'] == 'False') {
            Logger::log('No Content Found', __FILE__, __LINE__, __METHOD__);

            $data = [
                    //'imdb_id' =>$title,
                    'internaltitle' =>$title,
                    'title' => $title,
                    'shorturl' => $shortUrl,
                ];
            $showInfo->add($data);

            return;
        }

        Logger::log(print_r($content, true), __FILE__, __LINE__, __METHOD__);

        $data = [
            'title'         => $this->getArrayValue($content, 'Title'),
            'internaltitle' => $title,
            'shorturl'      => $shortUrl,
            'description'   => $this->getArrayValue($content, 'Plot'),
            //'tvdbdesc'      => $this->getArrayValue($content, 'Title'),
            'showtype'      => $this->getArrayValue($content, 'Type'),
            'showimage'     => $this->getArrayValue($content, 'Poster'),
            'website'       => $this->getArrayValue($content, 'Website'),
            'imdb_id'       => $this->getArrayValue($content, 'imdbID'),
            'imdb_rating'   => $this->getArrayValue($content, 'imdbRating'),
            'tomato_rating' => $this->getArrayValue($content, 'tomatoRating'),
            'genre'         => $this->convertToPiped($this->getArrayValue($content, 'Genre')),
            'director'      => $this->getArrayValue($content, 'Director'),
            'actors'        => $this->convertToPiped($this->getArrayValue($content, 'Actors')),
            'awards'        => $this->getArrayValue($content, 'Awards'),
        ];


        Logger::log(print_r($data, true), __FILE__, __LINE__, __METHOD__);

        $showInfo->add($data);

        sleep(1);
    }



}