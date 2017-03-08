<?php

use \SlimRunner\AppConfig as AppConfig;

class AppRun extends \SlimRunner\SlimRunner
{
    protected function init()
    {
        $this->template->setTemplateDir(APPLICATION_PATH.'/templates/');
        
        Resque::setBackend(AppConfig::get('redis', 'server'));
        Logger::setLogFile(APPLICATION_PATH.'/cache/logfile.log');
        
        $this->setPageTemplate(AppConfig::get('templates', 'page'));
        $this->setLayoutTemplate(AppConfig::get('templates', 'layout'));

        $this->db = new AppDB(AppConfig::get('database', 'server'), AppConfig::get('database', 'dbname'), AppConfig::get('database', 'dbuser'), AppConfig::get('database', 'dbpass'));
        
        $this->template->persistTemplateVar('persistedVar', 'I go on every page');
        $this->template->persistTemplateVar('pageTitle', '*** CHANGE ME ***');

        $this->registerRoutes(array(
            array('/',              FALSE,      'home',     'get'),
            //array('/year/:year',    FALSE,      'year',         'get', array('year' => '\d+')),
            //array('/redirect',      FALSE,      'redirect'),
            //array('/calendar/:programid',      FALSE,      'calendar'),
            array('/programname',      FALSE,      'programname'),


            array('/channels',              FALSE,      'channels'),
            array('/channels/:channel',     FALSE,      'channelinfo'),

            array('/series',              FALSE,      'series'),
            array('/series/:channel',     FALSE,      'seriesinfo'),
            array('/series/:show/ical',     FALSE,      'showcalendar'),

            array('/movie',              FALSE,      'movies'),
            array('/movie/:channel',     FALSE,      'seriesinfo'),
            array('/movie/:show/ical',     FALSE,      'showcalendar'),

        ));
    }

    
    protected function home_get()
    {
        $packages = $this->db->loadModel('Packages');

        return $this->template->loadTemplate('content/home.tpl', array('packages'=>$packages->getAll()));

    }
    
    protected function year_get($year)
    {
        return $this->template->loadTemplate('content/year.tpl', array('year'=>$year));
    }

    protected function calendar_get($programid)
    {
        $this->setLayoutTemplate(null);
        $this->setLayoutTemplate(null);

        return $this->template->loadTemplate('content/year.tpl', array('year'=>$programid));
    }


    protected function redirect_get()
    {
        $this->redirect('/year/2000?redirect');
    }

    protected function programname_get()
    {
        // Sample URL : http://hackathon.dev/programname?title=Cold%20Case%20Files
        
        var_dump($this->db->getProgramSchedule($this->getValue('title', 'Misfit Garage')));
    }

    protected function channels_get()
    {
        $channelObj = $this->db->loadModel('Channels');

        $this->template->persistTemplateVar('pageTitle', 'Channels List');

        return $this->template->loadTemplate('content/channels.tpl', array('channels'=>$channelObj->getListChannels()));
    }

    protected function channelinfo_get($channel)
    {
        $channelObj = $this->db->loadModel('Channels');
        $programsObj = $this->db->loadModel('Programs');

        $channelInfo = $channelObj->getByChannelTag($channel);

        if (empty($channelInfo)) {
            return $this->redirect('/channels');
        }

        $this->template->persistTemplateVar('pageTitle', $channelInfo['channelname']);

        $date = $this->getValue('date', date('Y-m-d'));

        // @todo Validate Date

        $schedule = $programsObj->getSchedule($channel, $date);

        $nextDay = date('Y-m-d', strtotime($date .' +1 day'));
        $prevDay = date('Y-m-d', strtotime($date .' -1 day'));


        return $this->template->loadTemplate('content/channelinfo.tpl', array('channel'=>$channelInfo, 'schedule'=>$schedule, 'nextDay'=>$nextDay, 'prevDay'=>$prevDay, 'date'=>date("j F, Y", strtotime($date))));
    }

    protected function series_get()
    {

    }

    protected function seriesinfo_get($shortUrl)
    {
        $showInfoObj = $this->db->loadModel('ShowInfo');

        $show = $showInfoObj->getByShortUrl($shortUrl);

        if (empty($show)) {
            return $this->showPageNotFound();
        }

        $this->template->persistTemplateVar('pageTitle', $show['title']);


        $programsObj = $this->db->loadModel('Programs');

        $schedule = $programsObj->getScheduleForShow($show['internaltitle']);


        return $this->template->loadTemplate('content/showinfo.tpl', array('show'=>$show, 'schedule'=>$schedule));
    }

    protected function movies_get()
    {

    }

    protected function moviesinfo_get($shortUrl)
    {
        return $this->seriesinfo_get($shortUrl);
    }

    protected function showPageNotFound()
    {
        $this->template->persistTemplateVar('pageTitle', 'Page Not Found');
        return 'Page Not Found';
    }

    protected function showcalendar_get($shortUrl)
    {
        $this->setPageTemplate(null);
        $this->setLayoutTemplate(null);

        $showInfoObj = $this->db->loadModel('ShowInfo');

        $show = $showInfoObj->getByShortUrl($shortUrl);

        if (empty($show)) {
            return $this->showPageNotFound();
        }

        $programsObj = $this->db->loadModel('Programs');

        $schedule = $programsObj->getScheduleForShow($show['internaltitle']);

        $vCalendar = new \Eluceo\iCal\Component\Calendar($show['title']);

        foreach($schedule as $item) {

            $vEvent = new \Eluceo\iCal\Component\Event();

            $title = $item['title'];

            if (!empty($item['season_id'])) {
                $title .= ' - Season '.$item['season_id'];
            }

            if (!empty($item['episode_id'])) {
                $title .= ' - Episode '.$item['episode_id'];
            }

            $vEvent
                ->setDtStart(new \DateTime($item['program_date'].' '.$item['starttime']))
                ->setDtEnd(new \DateTime($item['program_date'].' '.$item['endtime']))
                ->setSummary($title)
                ->setDescription($item['description']);

            $vCalendar->addComponent($vEvent);
        }




        header('Content-Type: text/calendar; charset=utf-8');
        //header('Content-Disposition: attachment; filename="cal.ics"');


        return  $vCalendar->render();
    }
    
}
