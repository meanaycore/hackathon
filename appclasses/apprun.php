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
            array('/year/:year',    FALSE,      'year',         'get', array('year' => '\d+')),
            array('/redirect',      FALSE,      'redirect'),
            array('/calendar/:programid',      FALSE,      'calendar'),
            array('/programname',      FALSE,      'programname'),


            array('/channels',              FALSE,      'channels'),
            array('/channels/:channel',     FALSE,      'channelinfo'),

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

        return $this->template->loadTemplate('content/channelinfo.tpl', array('channel'=>$channelInfo, 'schedule'=>$schedule));
    }
    

    
}
