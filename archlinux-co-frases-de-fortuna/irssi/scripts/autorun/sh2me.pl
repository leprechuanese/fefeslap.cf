#!/usr/bin/perl
 
use Irssi;
 
sub cmd_sh2me {
  $cmd = shift;
 
  if ($cmd) {
    $out = `$cmd`;
 
    Irssi::active_win()->command("/me $out");
    return 0;
  }
}
 
Irssi::command_bind('sh2me', 'cmd_sh2me');
