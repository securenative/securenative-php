<?php

use SecureNative\sdk\Agent;
use SecureNative\sdk\SecureNative;
use PHPUnit\Framework\TestCase;
use SecureNative\sdk\SecureNativeOptions;

final class AgentTest extends TestCase
{
    const TEST_API_KEY = 'sample_key';
    /**
     * @before
     */
    public static function initSDK()
    {
        SecureNative::init(TEST_API_KEY, new SecureNativeOptions());
    }

    public function testApiKeyException()
    {
        $this->assertEquals($this->t1(),1 );
        Agent::changeClassMethod([$this, 't1'],[$this, 't2'] );
        $this->assertEquals($this->t1(),2 );
    }

    public function testGetDependencies(){
        $dep = Agent::getDependencies("../composer.json");
        $this->assertTrue(strpos($dep, 'php')==1);
    }

    public function t1(){
        return 1;
    }

    public function t2(){
        return 2;
    }


}
