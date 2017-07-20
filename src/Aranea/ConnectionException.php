<?php
/**
 * Aranea: Web client
 * Copyright (c) NewClass (http://newclass.pl)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the file LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) NewClass (http://newclass.pl)
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Aranea;


use Exception;
use Throwable;

class ConnectionException extends Exception
{

    public function __construct()
    {
        parent::__construct(sprintf('Connection fatal error.'));
    }
}