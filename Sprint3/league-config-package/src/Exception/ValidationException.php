<?php

declare(strict_types=1);

/*
 * This file is part of the league/config package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\Config\Exception;

use Nette\Schema\ValidationException as NetteException;

final class ValidationException extends InvalidConfigurationException
{
        /** @var string[] */
public function __construct(NetteException $inneerException){
    parent::__construct($inneerException->getMessage(), (int) $inneerException->getCode(), $inneerException);
    $this->messages = $inneerException->getMessages();
}
  /**
     * @return string[]
     */
    public function getMessages():array
    {
        return  $this->messages;
    }
}