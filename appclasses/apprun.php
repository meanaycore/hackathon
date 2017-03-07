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
        
        $this->template->persistTemplateVar('persistedVar', 'I go on every page');
        
        $this->registerRoutes(array(
            array('/',              FALSE,  'home', 'get|post|put|delete|patch'),
            array('/year/:year',    'akhona',      'year', 'get', array('year' => '\d+')),
            array('/redirect',      FALSE,      'redirect'),
            array('/checkemail',     FALSE,      'checkemail'),
            
            array('/api/email',     'api',      'Api::email', 'post'),
        ));
    }
    
    protected function accesscheck_api()
    {
        $this->setIsAjaxResponse();
    }

    
    protected function home_get() {return 'home_get';}
    protected function home_post() {return 'home_post';}
    protected function home_put() {
        
        echo $this->inputValue('hello');
        
        return 'home_put';
    }
    protected function home_delete() {return 'home_delete';}
    protected function home_patch() {return 'home_patch';}
    
    protected function year_get($year)
    {
        return $this->template->loadTemplate('content/year.tpl', array('year'=>$year));
    }
    
    protected function redirect_get()
    {
        $this->redirect('/year/2000?redirect');
    }
    

    
}
