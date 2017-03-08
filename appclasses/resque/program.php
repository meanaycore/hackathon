<?php
/**
 * Created by PhpStorm.
 * User: tohir.solomons
 * Date: 2017/03/07
 * Time: 10:35 AM
 */

use SlimRunner\AppConfig as AppConfig;

class ResqueProgramParser extends ResqueHackathon
{

    public function perform()
    {
        Logger::log(print_r($this->args, true), __FILE__, __LINE__, __METHOD__);


        $packages   = $this->db->loadModel('Packages');
        $channels   = $this->db->loadModel('Channels');
        $genre      = $this->db->loadModel('Genres');
        $programs      = $this->db->loadModel('Programs');


        $premiumId = $packages->getPremiumId();


        $url = DSTVUrls::getProgramInGenre($premiumId, $this->args['genre'], $this->args['date']);

        Logger::log($url, __FILE__, __LINE__, __METHOD__);

        $content = CurlCaller::call('get', $url);

        if (!empty($content)) {

            $content = json_decode($content, TRUE);

            foreach ($content as $key =>  $schedule)
            {
                Logger::log($key, __FILE__, __LINE__, __METHOD__);

                // @todo - Check Channel Exists

                $dom = new \DOMDocument('1.0');


                $dom->loadHTML($schedule);

                $anchors = $dom->getElementsByTagName('li');

                foreach ($anchors as $element)
                {
                    $parts = $this->extractTitleTime($dom->saveHTML($element));

                    if (empty($parts['title'])) {
                        //Logger::log('** Missing Title', __FILE__, __LINE__, __METHOD__);
                        //Logger::log($dom->saveHTML($element), __FILE__, __LINE__, __METHOD__);
                    } else {

                        $data = [
                            'programid'    => $element->getAttribute('schedule-id'),
                            'title'        => $parts['title'],
                            'starttime'    => $parts['starttime'],
                            'program_date' => $this->args['date'],
                            'channel_tag'  => $key,
                        ];

                        //hasProgramme($progId, $date, $time, $channel)
                        $existingProgram = $programs->hasProgramme($data['programid'], $data['program_date'], $data['starttime'], $data['channel_tag']);

                        if ($existingProgram === FALSE) {
                            $programs->add($data);
                        } else {
                            Logger::log('** Duplicate', __FILE__, __LINE__, __METHOD__);
                            Logger::log($element->getAttribute('schedule-id'), __FILE__, __LINE__, __METHOD__);
                            Logger::log($parts['title'], __FILE__, __LINE__, __METHOD__);
                        }


                        Resque::enqueue(AppConfig::get('redis', 'queue'), 'Resque_ProgramInfo', ['programid'=>$data['programid']]);


                        //Logger::log(print_r($data, true), __FILE__, __LINE__, __METHOD__);
                    }
                }
            }


        }

    }

    private function extractTitleTime($string)
    {
        $fragment = $dom = new \DOMDocument('1.0');

        $fragment->loadHTML($string);

        $p = $fragment->getElementsByTagName('p');

        $response = [
            'title' => '',
            'starttime' => '',
        ];

        foreach ($p as $element)
        {
            switch ($element->getAttribute('class'))
            {
                case 'event-time':
                    $response['starttime'] = trim(strip_tags($dom->saveHTML($element)));
                    break;
                case 'event-title':
                    $response['title'] = strip_tags($dom->saveHTML($element));
                    break;
            }
        }

        return $response;
    }

}