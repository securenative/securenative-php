<?php

namespace SecureNative\sdk;

abstract class EventTypes
{
  const LOG_IN = "sn.user.login";

  const LOG_IN_CHALLENGE = "sn.user.login.challenge";
  
  const LOG_IN_FAILURE = "sn.user.login.failure";
  
  const LOG_OUT = "sn.user.logout";
  
  const SIGN_UP = "sn.user.signup";
  
  const AUTH_CHALLENGE = "sn.user.auth.challenge";
  
  const AUTH_CHALLENGE_SUCCESS = "sn.user.auth.challenge.success";
  
  const AUTH_CHALLENGE_FAILURE = "sn.user.auth.challenge.failure";
  
  const TWO_FACTOR_DISABLE = "sn.user.2fa.disable";
  
  const EMAIL_UPDATE = "sn.user.email.update";
  
  const PASSWORD_RESET = "sn.user.password.reset";
  
  const PASSWORD_RESET_SUCCESS = "sn.user.password.reset.success";
  
  const PASSWORD_UPDATE = "sn.user.password.update";
  
  const PASSWORD_RESET_FAILURE = "sn.user.password.reset.failure";
  
  const USER_INVITE = "sn.user.invite";
  
  const ROLE_UPDATE = "sn.user.role.update";
  
  const PROFILE_UPDATE = "sn.user.profile.update";
  
  const PAGE_VIEW = "sn.user.page.view";
  
  const VERIFY = "sn.verify";
  
  const RISK = "sn.risk";
}
