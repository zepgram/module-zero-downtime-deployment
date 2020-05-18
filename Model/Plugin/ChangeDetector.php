<?php
/**
 * This file is part of Zepgram\ZeroDowntimeDeployment\Model\Plugin
 *
 * @package    Zepgram\ZeroDowntimeDeployment
 * @file       ChangeDetector.php
 * @date       18 05 2020 17:25
 *
 * @author     Benjamin Calef <zepgram@gmail.com>
 * @copyright  2020 Zepgram Copyright (c) (https://github.com/zepgram)
 * @license    MIT License
 */

declare(strict_types=1);

namespace Zepgram\ZeroDowntimeDeployment\Model\Plugin;

use Magento\Deploy\Model\DeploymentConfig\ChangeDetector as MagentoChangeDetector;
use Magento\Deploy\Model\DeploymentConfig\DataCollector;
use Magento\Deploy\Model\DeploymentConfig\Hash;
use Magento\Deploy\Model\DeploymentConfig\Hash\Generator as HashGenerator;
use Magento\Framework\App\State;

/**
 * Class ChangeDetector
 * Disable change detection in configuration.
 */
class ChangeDetector extends MagentoChangeDetector
{
    /** @var State */
    private $state;

    /**
     * ChangeDetector constructor.
     * @param Hash $configHash
     * @param HashGenerator $hashGenerator
     * @param DataCollector $dataConfigCollector
     * @param State $state
     */
    public function __construct(
        Hash $configHash,
        HashGenerator $hashGenerator,
        DataCollector $dataConfigCollector,
        State $state
    ) {
        $this->state = $state;
        parent::__construct($configHash, $hashGenerator, $dataConfigCollector);
    }

    /**
     * @param null $sectionName
     * @return bool
     */
    public function hasChanges($sectionName = null)
    {
        if ($this->state->getMode() === State::MODE_PRODUCTION) {
            return false;
        }

        return parent::hasChanges($sectionName);
    }
}
