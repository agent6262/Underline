<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2015 Tyler Bucher
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Underline\Module;

/**
 * Class ConfigModule, used by the internal library, but can also be extended for extra use.
 * @package Underline\Module
 */
class ConfigModule implements IModule {

    /**
     * @var bool Should the library log any api issues.
     */
    private $logApiIssues = false;

    /**
     * @var string The api log file.
     */
    private $ApiLogFile = 'api.log';

    /**
     * @var string The name of the php session.
     */
    private $sessionName = 'underline';

    /**
     * @var string The name of the php default name space index in the SESSION var.
     */
    private $sessionDefaultNamespace = 'underline';

    /**
     * @var string|int The default time for which a cookie should expire.
     */
    private $cookieDefaultExpireTime = '604800';

    /**
     * @var string The default path for the cookie.
     */
    private $cookieDefaultPath = '/';

    /**
     * @var string The default sub domain for the cookie.
     */
    private $cookieDefaultSubDomain = "";

    /**
     * @var bool The default ssl state for the cookie.
     */
    private $cookieDefaultSsl = true;

    /**
     * @var bool The default http state for the cookie.
     */
    private $cookieDefaultHttp = true;

    /**
     * @var string|int The time to set the cookie expired.
     */
    private $cookieDefaultRemoveTime = '3600';

    /**
     * Initialize all required properties and functions for the Module.
     *
     * @param array $args A list if arguments if needed.
     *
     * @throws \Exception if file exists but can not be read.
     */
    public function init(array $args = null): void {
        if (!file_exists($args[0])) {
            $configFile = fopen($args[0], 'w');
            fwrite($configFile, json_encode($this->exportConfigurationArray()));
            fclose($configFile);
        } else if (is_readable($args[0])) {
            $configFile = fopen($args[0], 'r');
            $this->initConfigValues(json_decode(fread($configFile, filesize($args[0])), true));
            fclose($configFile);
        } else {
            throw new \Exception('Can not open file for reading.');
        }
    }

    /**
     * @return array of config values currently set.
     */
    public function exportConfigurationArray(): array {
        $exportArray = array();
        foreach (get_object_vars($this) as $key => $value) {
            $exportArray[$key] = $value;
        }
        return $exportArray;
    }

    /**
     * @param array $configValues array of config values to set.
     */
    public function initConfigValues(array $configValues): void {
        foreach (get_object_vars($this) as $key => $value) {
            $this->{$key} = $configValues[$key];
        }
    }

    /**
     * @return bool Should the library log any api issues.
     */
    public function isLogApiIssues(): bool {
        return $this->logApiIssues;
    }

    /**
     * @param bool $logApiIssues True if the library should log api issues false otherwise.
     */
    public function setLogApiIssues(bool $logApiIssues): void {
        $this->logApiIssues = $logApiIssues;
    }

    /**
     * @return string The api log file.
     */
    public function getApiLogFile(): string {
        return $this->ApiLogFile;
    }

    /**
     * @param string $ApiLogFile The api log file.
     */
    public function setApiLogFile(string $ApiLogFile): void {
        $this->ApiLogFile = $ApiLogFile;
    }

    /**
     * @return string The name of the php session.
     */
    public function getSessionName(): string {
        return $this->sessionName;
    }

    /**
     * @param string $sessionName The name of the php session.
     */
    public function setSessionName(string $sessionName): void {
        $this->sessionName = $sessionName;
    }

    /**
     * @return string The name of the php default name space index in the SESSION var.
     */
    public function getSessionDefaultNamespace(): string {
        return $this->sessionDefaultNamespace;
    }

    /**
     * @param string $sessionDefaultNamespace The name of the php default name space index in the SESSION var.
     */
    public function setSessionDefaultNamespace(string $sessionDefaultNamespace): void {
        $this->sessionDefaultNamespace = $sessionDefaultNamespace;
    }

    /**
     * @return int The default time for which a cookie should expire.
     */
    public function getCookieDefaultExpireTime(): int {
        return $this->cookieDefaultExpireTime;
    }

    /**
     * @param int $cookieDefaultExpireTime The default time for which a cookie should expire.
     */
    public function setCookieDefaultExpireTime(int $cookieDefaultExpireTime): void {
        $this->cookieDefaultExpireTime = $cookieDefaultExpireTime;
    }

    /**
     * @return string The default path for the cookie.
     */
    public function getCookieDefaultPath(): string {
        return $this->cookieDefaultPath;
    }

    /**
     * @param string $cookieDefaultPath The default path for the cookie.
     */
    public function setCookieDefaultPath(string $cookieDefaultPath): void {
        $this->cookieDefaultPath = $cookieDefaultPath;
    }

    /**
     * @return string The default sub domain for the cookie.
     */
    public function getCookieDefaultSubDomain(): string {
        return $this->cookieDefaultSubDomain;
    }

    /**
     * @param string $cookieDefaultSubDomain The default sub domain for the cookie.
     */
    public function setCookieDefaultSubDomain(string $cookieDefaultSubDomain): void {
        $this->cookieDefaultSubDomain = $cookieDefaultSubDomain;
    }

    /**
     * @return bool The default ssl state for the cookie.
     */
    public function getCookieDefaultSsl(): bool {
        return $this->cookieDefaultSsl;
    }

    /**
     * @param bool $cookieDefaultSsl The default ssl state for the cookie.
     */
    public function setCookieDefaultSsl(bool $cookieDefaultSsl): void {
        $this->cookieDefaultSsl = $cookieDefaultSsl;
    }

    /**
     * @return bool The default http state for the cookie.
     */
    public function getCookieDefaultHttp(): bool {
        return $this->cookieDefaultHttp;
    }

    /**
     * @param bool $cookieDefaultHttp The default http state for the cookie.
     */
    public function setCookieDefaultHttp(bool $cookieDefaultHttp): void {
        $this->cookieDefaultHttp = $cookieDefaultHttp;
    }

    /**
     * @return int The time to set the cookie expired.
     */
    public function getCookieDefaultRemoveTime(): int {
        return $this->cookieDefaultRemoveTime;
    }

    /**
     * @param int|string $cookieDefaultRemoveTime The time to set the cookie expired.
     */
    public function setCookieDefaultRemoveTime($cookieDefaultRemoveTime): void {
        $this->cookieDefaultRemoveTime = is_string($cookieDefaultRemoveTime) ?
            strtotime($cookieDefaultRemoveTime) : $cookieDefaultRemoveTime;
    }
}