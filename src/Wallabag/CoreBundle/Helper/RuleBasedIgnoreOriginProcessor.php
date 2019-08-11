<?php

namespace Wallabag\CoreBundle\Helper;

use Psr\Log\LoggerInterface;
use RulerZ\RulerZ;

class RuleBasedIgnoreOriginProcessor
{
    protected $rulerz;
    protected $logger;

    public function __construct(RulerZ $rulerz, LoggerInterface $logger)
    {
        $this->rulerz = $rulerz;
        $this->logger = $logger;
    }

    public function process($url, $userRules)
    {
        $rules = $userRules;

        $parsed_url = parse_url($url);
        // We add the former url as a new key _all for pattern matching
        $parsed_url['_all'] = $url;

        foreach ($rules as $rule) {
            if ($this->rulerz->satisfies($parsed_url, $rule->getRule())) {
                $this->logger->info('Origin url matching ignore rule.', [
                    'rule' => $rule->getRule(),
                ]);

                return true;
            }
        }
    }
}
