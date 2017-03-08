<?php
/**
 * Created by PhpStorm.
 * User: tohir.solomons
 * Date: 2017/03/07
 * Time: 10:35 AM
 */

use SlimRunner\AppConfig as AppConfig;

class Resque_OpenMovieDatabase extends ResqueHackathon
{

    public function perform()
    {
        Logger::log(print_r($this->args, true), __FILE__, __LINE__, __METHOD__);

        $programInfo = $this->db->loadModel('ProgramInfo');

        $currentProgram = $programInfo->getByProgrammeId($this->args['programid']);


        if (empty($currentProgram)) {
            return ;
        }

        $queryParams = [
            't' => $currentProgram['title'],
            'plot' => 'full',
            'tomatoes' => 'true',
        ];

        if (!empty($currentProgram['season_id'])) {
            $queryParams['season'] = $currentProgram['season_id'];
        }

        if (!empty($currentProgram['episode_id'])) {
            $queryParams['episode'] = $currentProgram['episode_id'];
        }

        $url = 'http://www.omdbapi.com/?'.http_build_query($queryParams);

        Logger::log($url, __FILE__, __LINE__, __METHOD__);

        $content = CurlCaller::call('get', $url);

        if (empty($content)) {
            return ;
        }

        $content = json_decode($content, true);

        if ($content['Response'] == 'False') {
            return;
        }

        $description = '';

        if (!empty($content['Title'])) {
            $description .= $content['Title'];
        }

        if ($description != '') {
            $description .= ' - ';
        }

        $data = [
            'description' => $description.$content['Plot'],
            'programtype' => $content['Type'],
            'programimage' => $content['Poster'],
            'imdb_rating' => $content['imdbRating'],
            'imdb_id' => $content['imdbID'],
        ];

        $programInfo->update($currentProgram['id'], $data);


    }


}