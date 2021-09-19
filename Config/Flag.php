<?php
/**
 * This file is part of Zepgram\ZeroDowntimeDeployment\Config
 *
 * @package    Zepgram\ZeroDowntimeDeployment
 * @file       Flag.php
 * @date       19 09 2021 17:40
 *
 * @author     Benjamin Calef <zepgram@gmail.com>
 * @copyright  2021 Zepgram Copyright (c) (https://github.com/zepgram)
 * @license    MIT License
 */

declare(strict_types=1);

namespace Zepgram\ZeroDowntimeDeployment\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\State;

class Flag
{
    /**
     * @var string
     */
    public const ZERO_DOWNTIME_IS_ALWAYS_ENABLED = 'dev/zero_downtime_deployment/is_always_enabled';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var State
     */
    private $state;

    /**
     * @var bool
     */
    private $flagRegistry;

    /**
     * Config constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        State $state
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->state = $state;
    }

    /**
     * Is Zero Downtime Enabled
     *
     * @return bool
     */
    public function isZeroDowntimeEnabled()
    {
        if ($this->flagRegistry === null) {
            $this->flagRegistry = $this->scopeConfig->isSetFlag(self::ZERO_DOWNTIME_IS_ALWAYS_ENABLED)
                || $this->state->getMode() === State::MODE_PRODUCTION;
        }

        return $this->flagRegistry;
    }
}
