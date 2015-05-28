<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 08.04.15
 * Time: 23:33
 */

namespace Acme\CoreBundle\Twig;


use Twig_Environment;
use Twig_NodeVisitorInterface;

class Morphy extends \Twig_Extension{

    protected $rootDir;
    public function __construct($rootDir)
    {
        $this->rootDir = $rootDir;
    }
    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array An array of filters
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('declension', array($this, 'decl')),
        );
    }

    public function decl($str,$index = 1)
    {
        $dir = $this->rootDir . '/dicts/utf-8/';
        $lang = 'ru_ru';
        $opts = array(
            'storage' => PHPMORPHY_STORAGE_FILE,
        );
        try {
            $morphy = new \phpMorphy($dir, $lang, $opts);
            $forms = $morphy->getAllForms(mb_strtoupper($str,$morphy->getEncoding()));
            $grammems = $morphy->getGramInfoMergeForms(mb_strtoupper($str,$morphy->getEncoding()));

            if(is_array($forms) && isset($forms[$index])){
                $word = $forms[$index];
                if($index == 2 && isset($grammems[0]['grammems'])){
                    if(in_array('МР',$grammems[0]['grammems'])){
                        return $str;
                    }
                }
                return $this->mbUcfirst($word);
            }
            return $str;
        } catch (\Exception $e) {
            return $str;
        }
    }

    private function mbUcfirst($str,$encoding='UTF-8')
    {
        if (!function_exists('mb_ucfirst') && extension_loaded('mbstring'))
        {

            preg_match('/^(.{1})(.+)/u',$str,$mathes);
            if(isset($mathes[1]) && isset($mathes[2])){

                return mb_strtoupper($mathes[1],$encoding).mb_strtolower($mathes[2],$encoding);
            }
            return $str;
        } else {
            return mb_ucfirst($str,$encoding);
        }
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'declension';
    }


}