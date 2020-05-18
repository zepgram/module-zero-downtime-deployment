<?php
/**
 * This file is part of Zepgram\ZeroDowntimeDeployment\Plugin
 *
 * @package    Zepgram\ZeroDowntimeDeployment
 * @file       DbStatusvalidator.php
 * @date       18 05 2020 17:28
 *
 * @author     Benjamin Calef <zepgram@gmail.com>
 * @copyright  2020 Zepgram Copyright (c) (https://github.com/zepgram)
 * @license    MIT License
 */

declare(strict_types=1);

namespace Zepgram\ZeroDowntimeDeployment\Plugin;

use Magento\Framework\App\FrontController;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\State;
use Magento\Framework\Cache\FrontendInterface as FrontendCacheInterface;
use Magento\Framework\Module\Plugin\DbStatusValidator as MagentoDbStatusValidator;

/**
 * Class DbStatusValidator
 * Disable change detection in module version.
 */
class DbStatusValidator
{
    /** @var FrontendCacheInterface */
    private $cache;

    /** @var State */
    private $state;

    /**
     * DbStatusValidator constructor.
     * @param FrontendCacheInterface $cache
     * @param State $state
     */
    public function __construct(
        FrontendCacheInterface $cache,
        State $state
    ) {
        $this->cache = $cache;
        $this->state = $state;
    }

    /**
     * @param MagentoDbStatusValidator $subject
     * @param FrontController $frontController
     * @param RequestInterface $request
     */
    public function beforeBeforeDispatch(
        MagentoDbStatusValidator $subject,
        FrontController $frontController,
        RequestInterface $request
    ) {
        if ($this->state->getMode() === State::MODE_PRODUCTION) {
            $this->cache->save('true', 'db_is_up_to_date');
        }
    }
}
