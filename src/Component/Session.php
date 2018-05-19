<?php
/*
 * This file is part of the Gubug package.
 *
 * (c) A Qahar Mudzakkir <qaharmdz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gubug\Component;

use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBagInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;

/**
 * Handling HTTP session
 *
 * @author Mudzakkir <qaharmdz@gmail.com>
 */
class Session extends HttpFoundation\Session\Session
{
    public function __construct(SessionStorageInterface $storage = null, AttributeBagInterface $attributes = null, FlashBagInterface $flashes = null)
    {
        parent::__construct($storage, $attributes, $flashes);
    }

    public function setOptions(array $options)
    {
        if ($this->storage instanceof NativeSessionStorage) {
            $this->storage->setOptions($options);
        }
    }

    /**
     * Message automatically removed once retrieved
     *
     * @return HttpFoundation\Session\Flash\Flashbag
     */
    public function flash()
    {
        return $this->getFlashBag();
    }

    /**
     * Set entire flashbag messages
     *
     * @param string       $type
     * @param string|array $message
     */
    public function setFlash($type, $message)
    {
        $this->flash()->set($type, $message);
    }

    public function addFlash($type, $message)
    {
        $this->flash()->add($type, $message);
    }

    public function getFlash($type, array $default = [])
    {
        return $this->flash()->get($type, $default);
    }

    public function hasFlash($type)
    {
        return $this->flash()->has($type);
    }
}
