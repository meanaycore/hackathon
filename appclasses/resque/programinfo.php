<?php
/**
 * Created by PhpStorm.
 * User: tohir.solomons
 * Date: 2017/03/07
 * Time: 10:35 AM
 */

class Resque_ProgramInfo extends ResqueHackathon
{

    public function perform()
    {
        Logger::log(print_r($this->args, true), __FILE__, __LINE__, __METHOD__);


        $url = DSTVUrls::getProgramInfo($this->args['programid']);

        Logger::log($url, __FILE__, __LINE__, __METHOD__);


        $content = CurlCaller::call('get', $url);

        if (!empty($content)) {

            $dom = new \DOMDocument('1.0');
            $dom->loadHTML($content);

            Logger::log($this->getTitle($dom), __FILE__, __LINE__, __METHOD__);
            Logger::log(print_r($this->getSeriesInfo($dom), TRUE), __FILE__, __LINE__, __METHOD__);

            var_dump($this->getSeriesInfo($dom));
        }

    }

    private function getTitle($dom)
    {
        $anchors = $dom->getElementsByTagName('h2');
        foreach ($anchors as $element)
        {

            $title = strip_tags($dom->saveHTML($element));
        }

        return $title;
    }

    private function getSeriesInfo($dom)
    {
        $response = [
            'season_id' => '',
            'episode_id' => '',
            'description' => '',
        ];

        $anchors = $dom->getElementsByTagName('p');
        foreach ($anchors as $element) {
            $subject = $dom->saveHTML($element);

            if (preg_match('/<img class/i', $subject)) {
                continue;
            }

            if (preg_match('/class="synop_info_cast/i', $subject)) {
                continue;
            }

            $response['description'] = strip_tags($dom->saveHTML($element));

            if (preg_match('%\'S(?P<season>\d+)/E(?P<episode>\d+)%', $subject, $regs)) {
                $response['season_id'] = $regs['season'];
                $response['episode_id'] = $regs['episode'];
            }
        }

        return $response;
    }

}