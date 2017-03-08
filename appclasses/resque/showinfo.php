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

        $programInfo = $this->db->loadModel('ProgramInfo');
        $showInfo = $this->db->loadModel('ShowInfo');

        $currentProgram = $programInfo->getByProgrammeId($this->args['programid']);

        //Logger::log(print_r($currentProgram, true), __FILE__, __LINE__, __METHOD__);

        if (empty($currentProgram)) {
            return;
        }

        $show = $showInfo->getByTitle($currentProgram['title']);

        // Ignore if we have content
        if (!empty($show)) {
            return;
        }

        $queryParams = [
            't' => $currentProgram['title'],
            'plot' => 'full',
            'tomatoes' => 'true',
        ];

        $url = 'http://www.omdbapi.com/?'.http_build_query($queryParams);

        Logger::log($url, __FILE__, __LINE__, __METHOD__);

        $content = CurlCaller::call('get', $url);

        if (empty($content)) {
            Logger::log('No Curl Content', __FILE__, __LINE__, __METHOD__);
            return ;
        }

        $content = json_decode($content, true);

        if ($content['Response'] == 'False') {
            Logger::log('No Content Found', __FILE__, __LINE__, __METHOD__);

            $data = [
                    'imdb_id' => $currentProgram['title'],
                    'title' => $currentProgram['title'],
                    'shorturl' => Utils::cleanUrl($currentProgram['title']),
                ];
            $showInfo->add($data);

            return;
        }

        Logger::log(print_r($content, true), __FILE__, __LINE__, __METHOD__);

        $data = [
            'title'         => $this->getArrayValue($content, 'Title'),
            'shorturl'      => Utils::cleanUrl($this->getArrayValue($content, 'Title')),
            'description'   => $this->getArrayValue($content, 'Plot'),
            //'tvdbdesc'      => $this->getArrayValue($content, 'Title'),
            'showtype'      => $this->getArrayValue($content, 'Type'),
            'showimage'     => $this->getArrayValue($content, 'Poster'),
            'website'       => $this->getArrayValue($content, 'Website'),
            'imdb_id'       => $this->getArrayValue($content, 'imdbID'),
            'imdb_rating'   => $this->getArrayValue($content, 'imdbRating'),
            'tomato_rating' => $this->getArrayValue($content, 'tomatoRating'),
        ];


        Logger::log(print_r($data, true), __FILE__, __LINE__, __METHOD__);

        $showInfo->add($data);

        sleep(1);
    }

}