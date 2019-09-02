<?php

namespace SecureNative\sdk;

class VerifyResult
{
  public $riskLevel = RiskLevels::LOW;
  public $score = 0;
  public $triggers  = array();

  public function __construct($riskLevel = RiskLevels::LOW, $score = 0, $triggers = array())
  {
    $this->riskLevel = $riskLevel;
    $this->score = $score;
    $this->triggers = $triggers;
  }  
}
