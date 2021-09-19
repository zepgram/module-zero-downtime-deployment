<?php
/**
 * This file is part of Zepgram\ZeroDowntimeDeployment\Model
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

namespace Zepgram\ZeroDowntimeDeployment\Model;

use Magento\Deploy\Model\DeploymentConfig\ChangeDetector as MagentoChangeDetector;
use Magento\Deploy\Model\DeploymentConfig\DataCollector;
use Magento\Deploy\Model\DeploymentConfig\Hash;
use Magento\Deploy\Model\DeploymentConfig\Hash\Generator as HashGenerator;
use Zepgram\ZeroDowntimeDeployment\Config\Flag;

/**
 * Class ChangeDetector
 * Disable change detection in configuration.
 */
class ChangeDetector extends MagentoChangeDetector
{
    /**
     * @var Flag
     */
    private $flag;

    /**
     * ChangeDetector constructor.
     * @param Hash $configHash
     * @param HashGenerator $hashGenerator
     * @param DataCollector $dataConfigCollector
     * @param Flag $flag
     */
    public function __construct(
        Hash $configHash,
        HashGenerator $hashGenerator,
        DataCollector $dataConfigCollector,
        Flag $flag
    ) {
        $this->flag = $flag;
        parent::__construct($configHash, $hashGenerator, $dataConfigCollector);
    }

    /**
     * @param null $sectionName
     * @return bool
     */
    public function hasChanges($sectionName = null)
    {
        if ($this->flag->isZeroDowntimeEnabled()) {
            return false;
        }

        return parent::hasChanges($sectionName);
    }
}
