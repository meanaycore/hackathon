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
    
    protected function redirect_get()
    {
        $this->redirect('/year/2000?redirect');
    }
    

    
}
