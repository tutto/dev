<?php

namespace Tutto\SecurityBundle\Service;

use \Symfony\Bundle\FrameworkBundle\Translation\Translator as BaseTranslator;

/**
 * Class Translator
 * @package Tutto\SecurityBundle\Service
 */
class Translator extends BaseTranslator {
    /**
     * @param string $id
     * @param array $parameters
     * @param null $domain
     * @param null $locale
     * @return string
     */
    public function trans($id, array $parameters = array(), $domain = null, $locale = null) {
        if(preg_match('/.*:.*$/D', $id)) {
            $parts = explode(':', $id);
            if(count($parts) > 1) {
                $id = $parts[1];
                if($domain === null) {
                    $domain = $parts[0];
                }
            }
        }

        return parent::trans($id, $parameters, $domain, $locale);
    }
} 